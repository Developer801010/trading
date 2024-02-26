<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Models\User;
use App\Models\Trade;
use App\Mail\MessageAlertMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;

class APIMessageManagementController extends Controller
{
    public function messageIndex()
    {
		
        $data = Trade::where('trade_type', 'message')->orderBy('created_at','desc')->paginate(10);
        return response()->json([
            'status' => true,
            'message' => 'Get Message Data Successfully',
            'data' => $data,
        ], 200);  
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function messageStore(Request $request)
    {
		$validator = Validator::make($request->all(), [
			'message_title' => 'required',	
			'quill_html' => 'required'
		]);  

		if ($validator->fails()) {
			return response()->json([
                'status' => false,
                'message' => 'Please fill all required fields',                
            ], 422);		
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
			
            return response()->json([
                'status' => true,
                'message' => 'Message was created successfully!',
                'data' => $data,
            ], 200);			

		}catch(Exception $ex){
            return response()->json([
                'status' => false,
                'message' => $ex->getMessage()
            ], 422);			
		}
    }

    /**
     * Update the specified resource in storage.
     */
    public function messageUpdate(Request $request, string $id)
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
			
            return response()->json([
                'status' => true,
                'message' => 'Message was updated successfully!',
                'data' => $data,
            ], 200);

		}catch(Exception $ex){
            return response()->json([
                'status' => false,
                'message' => $ex->getMessage()
            ], 422);	
		}
    }

    /**
     * Remove the specified resource from storage.
     */
    public function messageDestroy(Request $request)
    {
		$id = $request->input('id');
		Trade::destroy($id);
        return response()->json([
            'status' => true,
            'message' => 'Message was deleted successfully',
        ], 200);

    }

}
