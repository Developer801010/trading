<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\SendTwilioSMS;
use App\Mail\TradeAddAlertMail;
use App\Mail\TradeCloseAlertMail;
use App\Mail\TradeCreationAlertMail;
use App\Models\Trade;
use App\Models\TradeDetail;
use App\Models\User;
use App\Service\SmsService;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Laravel\Cashier\Subscription;

class TradeAlertController extends Controller
{

    public $tradeinSyncText = 'TradeInSync ';
    public function __construct() 
    {
        $this->middleware('permission:trade-list|trade-create|trade-edit|trade-delete', ['only' => ['index','store']]);
        $this->middleware('permission:trade-create', ['only' => ['create','store']]);
        $this->middleware('permission:trade-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:trade-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $parentTrades = Trade::with('tradeDetail')
            ->whereNull('exit_price')->whereNull('exit_date')  //open trade
            ->orderBy('created_at','desc')->paginate(10);

        return view('admin.trade_alert.index', compact('parentTrades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.trade_alert.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $trade_type = $request->trade_type;
        $trade_symbol = $request->trade_symbol;
        $trade_option = $request->trade_option;
        $trade_direction = $request->trade_direction;
        $expiration_date = $request->expiration_date;
        $strike_price = $request->strike_price;
        $stop_price = $request->stop_price;
        $target_price = $request->target_price;
        $entry_price = $request->entry_price;
        $entry_date = $request->entry_date;
        $position_size = $request->position_size;
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

        //duplication issue
        //for stock.  by the trade symbol
        if($trade_type == 'stock'){
            $tradeCount = Trade::where([
                'trade_type' => 'stock',
                'trade_symbol' => $trade_symbol
            ])
            ->whereNull('exit_price')
            ->whereNull('exit_date')
            ->count();

            $msg = 'Symbol already exists';
        }else{
            //for option by the whole content 
            $tradeCount = Trade::where([
                'trade_type' => 'option',
                'trade_symbol' => $trade_symbol,
                'expiration_date' => $expiration_date,
                'trade_option' => $trade_option,
                'strike_price' => $strike_price
            ])
            ->whereNull('exit_price')
            ->whereNull('exit_date')
            ->count();

            $msg = 'Contract already exists';
       
        }
        // dd($tradeCount);
        if($tradeCount > 0)
            return back()->withErrors($msg)->withInput();

        DB::beginTransaction();
        try{

            $tradeObj = new Trade();
            $tradeObj->trade_type = $trade_type;
            $tradeObj->trade_symbol = $trade_symbol;            
            $tradeObj->trade_direction = $trade_direction;
            $tradeObj->stop_price = $stop_price;
            $tradeObj->target_price = $target_price;
            $tradeObj->entry_date = $entry_date;
            $tradeObj->entry_price = $entry_price;
            $tradeObj->position_size = $position_size;
            $tradeObj->trade_description = $trade_description;

            if($trade_type == 'option'){
                $tradeObj->trade_option = $trade_option;    
                $tradeObj->expiration_date = $expiration_date;
                $tradeObj->strike_price = $strike_price;
            }

            if($request->hasFile('image')){
                $request->validate([
                    'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
        
                $imageName = time().'.'.$request->image->extension();    
                $request->image->move(public_path('uploads/trade'), $imageName);

                $tradeObj->chart_image = 'uploads/trade/' . $imageName;
            }

            $tradeObj->save();
            DB::commit();

            //Bulk trade creation email to activated users's email
            $activeSubscribers = $this->getActiveSubscriptionUsers();            

            if($trade_type == 'option'){
                $trade_mail_title = $this->tradeinSyncText.ucfirst($trade_type).' '.'Alert';

                $sms_msg = $this->tradeinSyncText.ucfirst($trade_type).' '.'Alert - New Trade '.strtoupper($trade_direction). ' '.strtoupper($trade_symbol).' '.Carbon::parse($entry_date)->format('ymd').ucfirst(substr($trade_option,0,1)).$strike_price;

                $body_first_title = ucfirst($trade_type).' '.'Alert - New Trade '.strtoupper($trade_direction). ' '.strtoupper($trade_symbol).' '.Carbon::parse($entry_date)->format('ymd').ucfirst(substr($trade_option,0,1)).$strike_price;

                $body_title = strtoupper($trade_direction).' '.strtoupper($trade_symbol).' '.Carbon::parse($entry_date)->format('M d, Y').' $'.number_format($strike_price, 0).' '.ucfirst($trade_option).'@$'.$entry_price.' or better';
            }else{
                $trade_mail_title = $this->tradeinSyncText.ucfirst($trade_type).' '.'Alert';

                $sms_msg = $this->tradeinSyncText.ucfirst($trade_type).' '.'Alert - New Trade '.strtoupper($trade_direction). ' '.strtoupper($trade_symbol);

                $body_first_title = ucfirst($trade_type).' '.'Alert - New Trade '.strtoupper($trade_direction). ' '.strtoupper($trade_symbol);

                $body_title = strtoupper($trade_direction).' '.strtoupper($trade_symbol);
            }
            $url = route('front.trade-detail', [
                'id'=>$tradeObj->id,
                'type'=>'n'
            ]);

            $data = [
                'title' => $trade_mail_title,
                'body' => [
                    'first_title' => $body_first_title,
                    'title' => $body_title,
                    'trade_entry_date' => Carbon::parse($entry_date)->format('m/d/Y'),
                    'trade_entry_price' => $entry_price,
                    'position_size' => $position_size,
                    'stop_price' => $stop_price,
                    'target_price' => $target_price,
                    'comments' => $trade_description,
                    'visit' =>  $url              
                ]
            ];
    
            foreach($activeSubscribers as $subscriber){            
                Mail::to($subscriber->email)->queue(new TradeCreationAlertMail($data));
            }
            
            //Bulk trade creation notification to activated users' phone
            $msg = $sms_msg.' '.$url;
            foreach($activeSubscribers as $subscriber)
            {            
                 //if user subscribed for the mobile notification and verified the phone number
                if($subscriber->mobile_notification_setting == 1 && $subscriber->mobile_verified_at !== null)                 
                {
                    SendTwilioSMS::dispatch($subscriber->mobile_number, $msg);
                }
            }

            return redirect()->route('trades.index')->with('flash_success', 'Trade was created successfully!')->withInput();

        }catch(Exception $ex){
            DB::rollBack();
            return back()->withErrors($ex->getMessage())->withInput();
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function tradeAdd(Request $request) 
    {
        $addFormID = $request->addFormID;
        $addTradeType = $request->addTradeType;
        $addTradeSymbol = $request->addTradeSymbol;
        $addTradeOption = $request->addTradeOption;
        $addTradeStrikePrice = $request->addTradeStrikePrice;
        $addTradeDirection = $request->addTradeDirection;
        $addEntryDate = $request->addEntryDate;
        $addBuyPrice = $request->addBuyPrice;
        $addPositionSize = $request->addPositionSize;
        $addStopPrice = $request->addStopPrice;
        $addTargetPrice = $request->addTargetPrice;
        $addComments = $request->quill_add_html;

        // Extract base64 encoded image data from Quill content
        $pattern = '/data:image\/(.*?);base64,([^\'"]*)/';

        $addComments = preg_replace_callback($pattern, function ($match) {
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
        }, $addComments);
       
        DB::beginTransaction();
        try{
            $tradeObj = new TradeDetail();
            $tradeObj->trade_id = $addFormID;
            $tradeObj->trade_direction = 'Add';
            $tradeObj->strike_price = $addTradeStrikePrice;
            $tradeObj->entry_date = $addEntryDate;
            $tradeObj->entry_price = $addBuyPrice;            
            $tradeObj->position_size = $addPositionSize;
            $tradeObj->stop_price = $addStopPrice;
            $tradeObj->target_price = $addTargetPrice;
            $tradeObj->trade_description = $addComments;
       
            // if($trade_type == 'option'){
            //     $tradeObj->trade_option = $trade_option;    
            //     $tradeObj->expiration_date = $expiration_date;
            //     $tradeObj->strike_price = $strike_price;
            // }

            if($request->hasFile('addImage')){
                $imageName = time().'.'.$request->addImage->extension();    
                $request->addImage->move(public_path('uploads/trade'), $imageName);

                $tradeObj->chart_image = 'uploads/trade/' . $imageName;
            }

            $tradeObj->save();
            DB::commit();

             //Bulk Trade add email to activated users 
            $activeSubscribers = $this->getActiveSubscriptionUsers();
            
            if($addTradeType == 'option'){
                $trade_mail_title = $this->tradeinSyncText.$addTradeType.' Alert';

                $sms_title = $this->tradeinSyncText.$addTradeType.' Alert - '.strtoupper($addTradeDirection). ' '.strtoupper($addTradeSymbol).' '.Carbon::parse($addEntryDate)
                ->format('ymd').ucfirst(substr($addTradeOption,0,1)).$addTradeStrikePrice.' (Add)';

                $body_first_title = ucfirst($addTradeType).' Alert - '.strtoupper($addTradeDirection). ' '.strtoupper($addTradeSymbol).' '.Carbon::parse($addEntryDate)
                ->format('ymd').ucfirst(substr($addTradeOption,0,1)).$addTradeStrikePrice.' (Add)';

                $body_title = strtoupper($addTradeDirection).' '.strtoupper($addTradeSymbol).' (Add) @ $ '.$addBuyPrice.' or better'; 

            }else{
                $trade_mail_title = $this->tradeinSyncText.$addTradeType.' Alert';

                $sms_title = $this->tradeinSyncText.$addTradeType.' Alert - '.strtoupper($addTradeDirection). ' '.strtoupper($addTradeSymbol).' '. '(Add)';

                $body_first_title = ucfirst($addTradeType).' Alert - '.strtoupper($addTradeDirection). ' '.strtoupper($addTradeSymbol).' '. '(Add)';

                $body_title = strtoupper($addTradeDirection).' '.strtoupper($addTradeSymbol). ' (Add) @ $'.$addBuyPrice.' or better'; 
            }

            $url = route('front.trade-detail', [
                'id'=>$tradeObj->id,
                'type'=>'a'
            ]);

             $data = [
                 'title' => $trade_mail_title,
                 'body' => [
                    'first_title' => $body_first_title,
                     'title' => $body_title,
                     'trade_entry_date' => Carbon::parse($addEntryDate)->format('m/d/Y'),
                     'trade_entry_price' => $addBuyPrice,
                     'position_size' => $addPositionSize,
                     'stop_price' => $addStopPrice,
                     'target_price' => $addTargetPrice,
                     'comments' => $addComments,
                     'visit' => $url
                 ]
             ];
     
             foreach($activeSubscribers as $subscriber){            
                 Mail::to($subscriber->email)->queue(new TradeAddAlertMail($data));
             }

            //Bulk trade creation notification to activated users' phone
            $msg = $sms_title.' '.$url;

            foreach($activeSubscribers as $subscriber)
            {            
                 //if user subscribed for the mobile notification and verified the phone number
                if($subscriber->mobile_notification_setting == 1 && $subscriber->mobile_verified_at !== null)                 
                {
                    SendTwilioSMS::dispatch($subscriber->mobile_number, $msg);
                }
            }

            return back()->with('flash_success', 'Trade was added successfully!')->withInput();
        }catch(Exception $ex){
            DB::rollBack();
            return back()->withErrors($ex->getMessage());
        }
    }


    public function tradeClose(Request $request) 
    {
        $closeFormID = $request->closeFormID;
        $closeTradeType = $request->closeTradeType;
        $closeExitDate = $request->closeExitDate;
        $closeExitPrice = (float)$request->closeExitPrice;
        $closeTradeEntryPrice = (float)str_replace(['$', '(', ')'], '', $request->closeTradeEntryPrice);
        $closedComments = $request->quill_close_html;
        $closeTradeSymbol = $request->closeTradeSymbol;
        $closeTradeDirection = $request->closeTradeDirection;
        $closeTradePositionSize = $request->closeTradePositionSize;
        $closeTradeStrikePrice = $request->closeTradeStrikePrice;
        $closeTradeOption = $request->closeTradeOption;

         // Extract base64 encoded image data from Quill content
         $pattern = '/data:image\/(.*?);base64,([^\'"]*)/';

         $closedComments = preg_replace_callback($pattern, function ($match) {
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
         }, $closedComments);
       
        DB::beginTransaction();
        try{
            $tradeObj = Trade::findorFail($closeFormID);
            $tradeObj->exit_date = $closeExitDate;
            $tradeObj->exit_price = $closeExitPrice;
            $tradeObj->close_comment = $closedComments;
       
            if($request->hasFile('closeImage')){
                $imageName = time().'.'.$request->closeImage->extension();    
                $request->closeImage->move(public_path('uploads/trade'), $imageName);

                $tradeObj->close_image = 'uploads/trade/' . $imageName;
            }

            $tradeObj->save();
            DB::commit();

             //Bulk Trade add email to activated users 
             $activeSubscribers = $this->getActiveSubscriptionUsers();    

             //converted Closed trade Direction from frontend 
             if($closeTradeDirection == 'buy')  
             {
                 //original: Sell Trade  [average sell price – buy price]/average sell price]*100.
                 if ($closeTradeEntryPrice != 0) 
                    $profits = ($closeTradeEntryPrice - $closeExitPrice) / $closeTradeEntryPrice * 100;  //closeTradeEntryPrice: it's average price.  
                 else
                    $profits = 0;
                 
             }
             else   // original: Buy Trade
             {
                //Profit % for a buy trade = [[close price- average purchase price]/average purchase price]*100.
                if ($closeTradeEntryPrice != 0) 
                    $profits = ($closeExitPrice - $closeTradeEntryPrice) / $closeTradeEntryPrice * 100;  
                else
                    $profits = 0;
             }

             if($closeTradeDirection == 'buy')  $closeTradeDirection = 'cover';

             if($closeTradeType == 'option')
             {  
                $trade_mail_title = $this->tradeinSyncText.$closeTradeType.' Alert';

                $sms_title = $this->tradeinSyncText.$closeTradeType.' Alert - '.strtoupper($closeTradeDirection). ' To Close '.$closeTradeSymbol.' ';

                $body_first_title = ucfirst($closeTradeType).' Alert - '.strtoupper($closeTradeDirection). ' To Close '.$closeTradeSymbol.' ';

                $body_title = strtoupper($closeTradeDirection).' '.strtoupper($closeTradeSymbol).' '.Carbon::parse($closeExitDate)->format('M d, Y').' $'
                .$closeTradeStrikePrice.' '.ucfirst($closeTradeOption).' @ $'.$closeExitPrice.' or better'; 
            }else{
                $trade_mail_title = $this->tradeinSyncText.$closeTradeType.' Alert';

                $sms_title = $this->tradeinSyncText.$closeTradeType.' Alert - '.strtoupper($closeTradeDirection). ' To Close '.strtoupper($closeTradeSymbol).' ';

                $body_first_title = ucfirst($closeTradeType).' Alert - '.strtoupper($closeTradeDirection). ' To Close '.strtoupper($closeTradeSymbol).' ';

                $body_title = strtoupper($closeTradeDirection).' '.strtoupper($closeTradeSymbol); 
            }

             $url = route('front.trade-detail', [
                'id'=>$tradeObj->id,
                'type'=>'c'
            ]);

             $data = [
                 'title' => $trade_mail_title,
                 'body' => [
                    'first_title' => $body_first_title,
                     'title' => $body_title,
                     'trade_exit_date' => Carbon::parse($closeExitDate)->format('m/d/Y'),
                     'position_size' => $closeTradePositionSize,
                     'exit_price' => number_format($closeExitPrice, 2),
                     'profits' => number_format($profits, 2),
                     'trade_direction' => $closeTradeDirection,
                     'comments' => $closedComments,                     
                     'visit' => $url
                 ]
             ];
     
             foreach($activeSubscribers as $subscriber){            
                 Mail::to($subscriber->email)->queue(new TradeCloseAlertMail($data));
             }

            //Bulk trade creation notification to activated users' phone
            $msg = $sms_title.' '.$url;

            foreach($activeSubscribers as $subscriber)
            {            
                 //if user subscribed for the mobile notification and verified the phone number
                if($subscriber->mobile_notification_setting == 1 && $subscriber->mobile_verified_at !== null)                 
                {
                    SendTwilioSMS::dispatch($subscriber->mobile_number, $msg);
                }
            }

            return back()->with('flash_success', 'Trade was closed successfully!')->withInput();
        }catch(Exception $ex){
            DB::rollBack();
            return back()->withErrors($ex->getMessage());
        }
    }

    private function getActiveSubscriptionUsers()
    {
        
        $activeSubscribers = User::whereHas('subscriptions', function ($query) {
            $query->where('ends_at', '>', now())
                    ->orWhereNull('ends_at'); 
        })->get();
        
        return $activeSubscribers;
    }
}


