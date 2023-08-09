<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class TradeAlertController extends Controller
{

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
        $trade_description = $request->trade_description;
        
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

            $trade_mail_title = ucfirst($trade_direction).' '.$trade_symbol.' '.ucfirst($trade_option);

            if($trade_type == 'option'){
                $body_title = strtoupper($trade_direction).' '.$trade_symbol.' '.Carbon::parse($entry_date)->format('dMY').' '
                .$strike_price.' '.ucfirst($trade_option).' @ $'.$entry_price.' or better';
            }else{
                $body_title = strtoupper($trade_direction).' '.$trade_symbol.' '.Carbon::parse($entry_date)->format('dMY').' '
                .$strike_price.' '.ucfirst($trade_option).' @ $'.$entry_price.' or better';
            }
            $url = route('front.trade-detail', [
                'id'=>$tradeObj->id,
                'type'=>'n'
            ]);

            $data = [
                'title' => $trade_mail_title,
                'body' => [
                    'title' => $body_title,
                    'trade_entry_date' => Carbon::parse($entry_date)->format('d/m/Y'),
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
            $msg = $body_title.' '.$url;
            foreach($activeSubscribers as $subscriber)
            {            
                 //if user subscribed for the mobile notification and verified the phone number
                if($subscriber->mobile_notification_setting == 1 && $subscriber->mobile_verified_at !== null)                 
                {
                    $sms_service = new SmsService();
                    $sms_service->sendSMS($msg, $subscriber->mobile_number);
                }
            }

            return redirect()->route('trades.index')->with('flash_success', 'Trade was created successfully!')->withInput();

        }catch(Exception $ex){
            DB::rollBack();
            return back()->withErrors($ex->getMessage());
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
        $addTradeSymbol = $request->addTradeSymbol;
        $addTradeOption = $request->addTradeOption;
        $addTradeStrikePrice = $request->addTradeStrikePrice;
        $addTradeDirection = $request->addTradeDirection;
        $addEntryDate = $request->addEntryDate;
        $addBuyPrice = $request->addBuyPrice;
        $addPositionSize = $request->addPositionSize;
        $addStopPrice = $request->addStopPrice;
        $addTargetPrice = $request->addTargetPrice;
        $addComments = $request->addComments;
       
        DB::beginTransaction();
        try{
            $tradeObj = new TradeDetail();
            $tradeObj->trade_id = $addFormID;
            $tradeObj->trade_direction = 'Add';
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

             $trade_mail_title = $addTradeDirection.' (Add) '.$addTradeSymbol.' '.ucfirst($addTradeOption);
             $body_title = strtoupper($addTradeDirection).' '.$addTradeSymbol.' '.Carbon::parse($addEntryDate)->format('dMY').' '
                 .$addTradeStrikePrice.' '.ucfirst($addTradeOption).' @ $'.$addBuyPrice.' or better'; 
            
            $url = route('front.trade-detail', [
                'id'=>$tradeObj->id,
                'type'=>'a'
            ]);

             $data = [
                 'title' => $trade_mail_title,
                 'body' => [
                     'title' => $body_title,
                     'trade_entry_date' => Carbon::parse($addEntryDate)->format('d/m/Y'),
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
            $mobileNotificationTitle = strtoupper($addTradeDirection).' '.'(Add) '.$addTradeSymbol.' '.Carbon::parse($addEntryDate)->format('dMY').' '
            .$addTradeStrikePrice.' '.ucfirst($addTradeOption).' @ $'.$addBuyPrice.' or better'; 
            $msg = $mobileNotificationTitle.' '.$url;

            foreach($activeSubscribers as $subscriber)
            {            
                 //if user subscribed for the mobile notification and verified the phone number
                if($subscriber->mobile_notification_setting == 1 && $subscriber->mobile_verified_at !== null)                 
                {
                    $sms_service = new SmsService();
                    $sms_service->sendSMS($msg, $subscriber->mobile_number);
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
        $closedComments = $request->closedComments;
        $closeTradeSymbol = $request->closeTradeSymbol;
        $closeTradeDirection = $request->closeTradeDirection;
        $closeTradePositionSize = $request->closeTradePositionSize;
        $closeTradeStrikePrice = $request->closeTradeStrikePrice;
        $closeTradeOption = $request->closeTradeOption;
       
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
                $profits = ($closeTradeEntryPrice - $closeExitPrice) / $closeTradeEntryPrice * 100;  //closeTradeEntryPrice: it's average price.  
             }
             else   // original: Buy Trade
             {
                //Profit % for a buy trade = [[close price- average purchase price]/average purchase price]*100.
                $profits = ($closeExitPrice - $closeTradeEntryPrice) / $closeTradeEntryPrice * 100;  
             }

             $trade_mail_title = 'Close '.$closeTradeSymbol;

             if($closeTradeType == 'option'){
                $body_title = strtoupper($closeTradeDirection).' '.'(Close) '.$closeTradeSymbol.' '.Carbon::parse($closeExitDate)->format('dMY').' '
                .$closeTradeStrikePrice.' '.ucfirst($closeTradeOption).' @ $'.$closeExitPrice.' or better'; 
            }else{
                $body_title = strtoupper($closeTradeDirection).' '.'(Close) '.$closeTradeSymbol; 
            }

             $url = route('front.trade-detail', [
                'id'=>$tradeObj->id,
                'type'=>'c'
            ]);

             $data = [
                 'title' => $trade_mail_title,
                 'body' => [
                     'title' => $body_title,
                     'trade_exit_date' => Carbon::parse($closeExitDate)->format('d/m/Y'),
                     'position_size' => $closeTradePositionSize,
                     'exit_price' => $closeExitPrice,
                     'profits' => round($profits, 1),
                     'trade_direction' => $closeTradeDirection,
                     'comments' => $closedComments,                     
                     'visit' => $url
                 ]
             ];
     
             foreach($activeSubscribers as $subscriber){            
                 Mail::to($subscriber->email)->queue(new TradeCloseAlertMail($data));
             }

            //Bulk trade creation notification to activated users' phone
            $msg = $body_title.' '.$url;

            foreach($activeSubscribers as $subscriber)
            {            
                 //if user subscribed for the mobile notification and verified the phone number
                if($subscriber->mobile_notification_setting == 1 && $subscriber->mobile_verified_at !== null)                 
                {
                    $sms_service = new SmsService();
                    $sms_service->sendSMS($msg, $subscriber->mobile_number);
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
            $query->where('stripe_status', 'active');
        })->get();
        
        return $activeSubscribers;
    }
}


