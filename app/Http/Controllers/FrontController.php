<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontController extends Controller
{
    /**
     * Frontend page
     */
    public function homepage()
    {
        return view('homepage');
    }

    /**
     * Subscription page
     */
    public function subscription()
    {
        return view('subscription');
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

        return view('checkout', compact('subscription_type', 'price', 'units'));
    }

    /**
     * Terms and Conditions page
     */
    public function terms_conditions()
    {
        return view('terms');
    }


    public function process(Request $request)
    {
        dd($request->all());
        
    }
}
