<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\Welcome;
use App\Mail\ContactUsAlertMail;
use App\Models\Plan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Laravel\Cashier\Subscription;
use DB;
use Log;

class FrontController extends Controller
{
     /**
     * Frontend page
     */
    public function homepage()
    {
        $currentDate = \Carbon\Carbon::now();
        $nowDate = \Carbon\Carbon::now();
        $sevenAgoDate = $nowDate->subDays($nowDate->dayOfWeek)->subWeek();

        // \DB::enableQueryLog(); // Enable query log
        $query = DB::table('trades as t')
        ->leftJoin('trade_details as td', 't.id', '=', 'td.trade_id')
        ->select([
            't.id',
            't.trade_type',
            't.trade_symbol',
            't.trade_direction',
            't.entry_date',
			't.current_price',
			't.company_name',
			't.symbol_image',
            DB::raw('NULL as child_direction'),
            't.trade_option',
            't.strike_price',
            DB::raw('CASE
                WHEN t.exit_price IS NOT NULL AND t.exit_date IS NOT NULL THEN
                    ((t.entry_price * t.position_size) + COALESCE(SUM(td.entry_price * td.position_size), 0)) /
                    (t.position_size + COALESCE(SUM(td.position_size), 0))
                ELSE
                    t.entry_price
                END AS entry_price'),
            't.stop_price',
            't.target_price',
            DB::raw('CASE
                WHEN t.exit_price IS NOT NULL AND t.exit_date IS NOT NULL THEN
                    (t.position_size + COALESCE(SUM(td.position_size), 0))
                ELSE
                    t.position_size
                END AS position_size'),
            't.exit_price',
            't.exit_date',
            't.trade_description',
            't.chart_image',
            't.close_comment',
            't.close_image',
            't.created_at',
            't.updated_at'
        ])
        ->where('t.trade_type', 'stock')
        ->whereNotNull('t.exit_price')
        ->whereNotNull('t.exit_date')
        ->groupBy( 't.id', 't.trade_type', 't.trade_symbol', 't.trade_direction', 't.trade_option', 't.entry_date','t.current_price','t.company_name','t.symbol_image',
       't.strike_price', 't.entry_price', 't.stop_price', 't.target_price', 't.position_size',
        't.exit_price', 't.exit_date', 't.trade_description', 't.chart_image', 't.close_comment',
        't.close_image', 't.created_at', 't.updated_at');
        $query->whereBetween('t.exit_date', array($sevenAgoDate,$currentDate));
        $trades = $query->orderBy('t.id', 'DESC')->get();
        // dd(\DB::getQueryLog()); // Show results of log

        return view('front.homepage', compact('trades'));
    }

    public function news()
    {
        return view('front.news');
    }

    public function learn()
    {
        return view('front.learn');
    }

    public function result()
    {
        return view('front.result');
    }

    public function tradingStrategy()
    {
        return view('front.trading-strategy');
    }

    /**
     * Subscription page
     */
    public function subscription(Request $request)
    {

        if($request->user()){
            $activeSubscription = Subscription::where([
                'user_id'=> auth()->user()->id,
                'stripe_status' => 'active'
            ])->get();


            return view('front.subscription', compact('activeSubscription'));
        }else{
            return view('front.subscription');
        }
    }


    /**
     * Check out page
     */
    public function checkout($subscription_type)
    {

        if($subscription_type == 'y'){
            $subscription_type = 'Yearly';
            $price = 787;
            $units = 'yr';
        }else if($subscription_type == 'q'){
            $subscription_type = 'Quarterly';
            $price = 387;
            $units = 'qu';
        }else{
            $subscription_type = 'Monthly';
            $price = 147;
            $units = 'mo';
        }

        // $activeSubscription = Subscription::where([
        //     'user_id'=> auth()->user()->id,
        //     'stripe_status' => 'active'
        // ])->get();

        //Payment Methods For Subscriptions
        // $intent = auth()->user()->createSetupIntent();

        //plan_id
        $month_plan = Plan::where('name', 'Monthly')->first();
        $quarter_plan = Plan::where('name', 'Quarterly')->first();
        $year_plan = Plan::where('name', 'Yearly')->first();

        return view('front.checkout',
            compact('subscription_type',
            'price',
            'units',
            // 'intent',
            'month_plan',
            'quarter_plan',
            'year_plan',
        ));
    }

    /**
     * Terms and Conditions page
     */
    public function terms_conditions()
    {
        return view('front.terms');
    }

    public function contactus_mailsend(Request $request)
    {
        $data = [
            'title' => 'Contact for '.$request->name,
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message
        ];

        try{
            Mail::to('clientservices@trading.com')->send(new ContactUsAlertMail($data));
            return response()->json(['status'=>true,'message'=>'Thank you for contact us']);
        }catch(Exception $ex){
            Log::error($ex->getMessage());
        }
        return response()->json(['status'=>false,'message'=>'Please re-try for contact us']);
    }

    public function emailTest()
    {
        $data = [
            'first_name' => 'first',
            'last_name' => 'last',
            'user_name' => 'username'
        ];

        try{
            Mail::to('kristoffermorris80@gmail.com')->send(new Welcome($data));
        }catch(Exception $ex){
            dd($ex->getMessage());
        }

        dd('sent');
    }

}
