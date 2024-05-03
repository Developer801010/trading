<?php

namespace App\Http\Controllers\Backend;

use Exception;
use App\Models\User;
use App\Models\Trade;
use Illuminate\Http\Request;
use App\Mail\MessageAlertMail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;

class MessageController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $messages = Trade::where('trade_type', 'message')->orderBy('created_at','desc')->paginate(10);
        return view('admin.message.index', compact('messages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
		$validated = $this->validate($request, [
			'message_title' => 'required',	
			'quill_html' => 'required'
		]);

		if(!$validated) {
			return back()->with('flash_error', 'Please fill all requried fields');
		}
		
        $trade_type = 'message';
        $trade_description = $request->quill_html;

		// Extract base64 encoded image data from Quill content
		$pattern = '/data:image\/(.*?);base64,([^\'"]*)/';
	
		$trade_description = preg_replace_callback($pattern, function ($match) {
			$extension = $match[1]; // Get image extension
			$base64Image = $match[2]; // Get base64 image data
			$imageData = base64_decode($base64Image); // Decode base64 data

			 // Generate a unique identifier for the image name
			$uniqueIdentifier = uniqid();

			// Combine unique identifier and current timestamp for the image name
			$imageName = 'image_' . $uniqueIdentifier.'_'. time() . '.' . $extension;
			$imagePath = public_path('uploads/trade/' . $imageName);
			file_put_contents($imagePath, $imageData);

			// Replace base64 encoded image with URL
			$imageUrl = asset('uploads/trade/' . $imageName);

			return $imageUrl;
		}, $trade_description);

		try{
			$tradeObj = new Trade();
			$tradeObj->trade_type = $trade_type;
			$tradeObj->trade_title = $request->message_title;
			$tradeObj->trade_symbol = '-';
			$tradeObj->trade_direction = '-';
			$tradeObj->entry_price = 0.00;
			$tradeObj->stop_price = 0.00;
			$tradeObj->entry_date = date('Y-m-d');
			$tradeObj->position_size = 0.00;
			$tradeObj->trade_description = $trade_description;
			$tradeObj->save();

			$activeSubscribers = User::whereHas('subscriptions', function ($query) {
				$query->where('ends_at', '>', now())
						->orWhereNull('ends_at');
			})->get();

			$data['title'] = 'TradeInsync - ' . $tradeObj->trade_title;
			$data['first_title'] = $tradeObj->trade_title;
			$data['message'] = $tradeObj->trade_description;
			$data['date_added'] = date('m/d/Y');

			foreach($activeSubscribers as $subscriber){
				Mail::to($subscriber->email)->queue(new MessageAlertMail($data));
			}

			Artisan::call('queue:work --stop-when-empty');
			
			return redirect()->route('messages.index')->with('flash_success', 'Message was created successfully!')->withInput();

		}catch(Exception $ex){
			return back()->withErrors($ex->getMessage())->withInput();
		}
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $trade_type = 'message';
        $trade_description = $request->quill_html;

		// Extract base64 encoded image data from Quill content
		$pattern = '/data:image\/(.*?);base64,([^\'"]*)/';
	
		$trade_description = preg_replace_callback($pattern, function ($match) {
			$extension = $match[1]; // Get image extension
			$base64Image = $match[2]; // Get base64 image data
			$imageData = base64_decode($base64Image); // Decode base64 data

			 // Generate a unique identifier for the image name
			$uniqueIdentifier = uniqid();

			// Combine unique identifier and current timestamp for the image name
			$imageName = 'image_' . $uniqueIdentifier.'_'. time() . '.' . $extension;
			$imagePath = public_path('uploads/trade/' . $imageName);
			file_put_contents($imagePath, $imageData);

			// Replace base64 encoded image with URL
			$imageUrl = asset('uploads/trade/' . $imageName);

			return $imageUrl;
		}, $trade_description);

		try{
			$tradeObj = Trade::find($id);
			$tradeObj->trade_type = $trade_type;
			$tradeObj->trade_title = $request->message_title;
			$tradeObj->trade_symbol = '-';
			$tradeObj->trade_direction = '-';
			$tradeObj->entry_price = 0.00;
			$tradeObj->stop_price = 0.00;
			$tradeObj->entry_date = date('Y-m-d');
			$tradeObj->position_size = 0.00;
			$tradeObj->trade_description = $trade_description;
			$tradeObj->save();

			$activeSubscribers = User::whereHas('subscriptions', function ($query) {
				$query->where('ends_at', '>', now())
						->orWhereNull('ends_at');
			})->get();

			$data['title'] = 'TradeInsync - ' . $tradeObj->trade_title;
			$data['first_title'] = $tradeObj->trade_title;
			$data['message'] = $tradeObj->trade_description;
			$data['date_added'] = date('m/d/Y');

			foreach($activeSubscribers as $subscriber){
				Mail::to($subscriber->email)->queue(new MessageAlertMail($data));
			}

			Artisan::call('queue:work --stop-when-empty');
			
			return redirect()->route('messages.index')->with('flash_success', 'Message was updated successfully!')->withInput();

		}catch(Exception $ex){
			return back()->withErrors($ex->getMessage())->withInput();
		}
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
		Trade::destroy($id);
        return redirect()->route('messages.index')->with('flash_success','Message was deleted successfully');
    }

}


