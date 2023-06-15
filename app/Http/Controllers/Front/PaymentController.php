<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Service\StripeService;
use Exception;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function process(Request $request)
    {
        $stripeObj = new StripeService();    
        $payment_option = $request->input('payment_option');

        try{
            $user = auth()->user();
            Stripe::setApiKey(config('services.stripe.secret_key'));

            // $user->createOrGetStripeCustomer();  

            // $paymentMethod = null;
            // $paymentMethod = $request->payment_method;

            // if($paymentMethod != null) {
            //     $paymentMethod = $user->addPaymentMethod($paymentMethod);
            // }

            // $plan = $request->stripe_plan_id;
           
            // $result = $request->user()->newSubscription('default', $plan)
            //     ->create($paymentMethod != null ? $paymentMethod->id: '');

            // if ($result['stripe_status'] == 'active'){
            //     // if status is active, add a subscribe role. 
            //     $role = Role::where('name', 'subscriber')->first(); 
            //     $user->roles()->attach($role->id);
            // }

            return redirect()->route('front.thanks')
                ->with('success','You are subscribed to this plan. You can see real time trade.');
            
        }catch(Exception $e){            
            return redirect()->back()->withErrors([ 'error' => 'Unable to create subscription due to this issue ' .$e->getMessage()]);          
        }

        
    }

    public function thanks()
    {
        return view('front.thanks');    
    }
}
