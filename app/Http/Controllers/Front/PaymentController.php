<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Paypal\PaypalAgreement;
use Exception;
use Illuminate\Http\Request;
use PayPal\Exception\PayPalConnectionException;
use Spatie\Permission\Models\Role;
use Stripe\Stripe;


class PaymentController extends Controller
{
    public function process(Request $request)
    {
        $payment_option = $request->input('payment_option');
        $user = auth()->user();

        if($payment_option == 'stripe')
        {
            try{
                Stripe::setApiKey(config('services.stripe.secret_key'));

                $user->createOrGetStripeCustomer();  

                $paymentMethod = null;
                $paymentMethod = $request->payment_method;

                if($paymentMethod != null) {
                    $paymentMethod = $user->addPaymentMethod($paymentMethod);
                }

                $plan = $request->stripe_plan_id;
            
                $result = $request->user()->newSubscription('default', $plan)
                    ->create($paymentMethod != null ? $paymentMethod->id: '');

                if ($result['stripe_status'] == 'active'){
                    // if status is active, add a subscribe role. 
                    $role = Role::where('name', 'subscriber')->first(); 
                    $user->roles()->attach($role->id);
                }

                return redirect()->route('front.thanks')
                ->with('success','You are subscribed to this plan. You can see real time trade.');

            }catch(Exception $e){            
                return redirect()->back()->withErrors([ 'error' => 'Unable to create subscription due to this issue ' .$e->getMessage()]);          
            }
        }
        else
        {
            try{
                
                $agreement = new PaypalAgreement();
                return $agreement->create($request->paypal_plan_id);

            }catch(PayPalConnectionException $e){            
                return redirect()->back()->withErrors([ 'error' => 'Unable to create subscription due to this issue ' .$e->getMessage()]);          
            }
        }     
       
        
    }

    /**
     * Goto the thanks page.
     */
    public function thanks()
    {
        return view('front.thanks');    
    }

    /**
     * Cancel Stripe subscription
     */
    public function cancelSubscription(Request $request)
    {
        $subscriptionName = $request->subscriptionName;
        if($subscriptionName){
            $user = auth()->user();
            $user->subscription($subscriptionName)->cancel();
        }
    }
    
    public function createAgreement($id)
    {
        $agreement = new PaypalAgreement();
        $agreement->create($id);
    }

    public function executeAgreement($status) 
    {
        dd(request('token'));
        if($status = 'true'){
            $agreement = new PaypalAgreement();
            $agreement->execute(request('token'));

            $user = auth()->user();
            // if status is active, add a subscribe role. 
            $role = Role::where('name', 'subscriber')->first(); 
            $user->roles()->attach($role->id);
            
            return redirect()->route('front.thanks')
            ->with('success','You are subscribed to this plan. You can see real time trade.');

        }else{
            return 'fail';
        }
    }
    
}
