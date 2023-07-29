<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\Welcome;
use App\Models\Plan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Laravel\Cashier\Subscription;

class FrontController extends Controller
{
     /**
     * Frontend page
     */
    public function homepage()
    {
        return view('front.homepage');
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
