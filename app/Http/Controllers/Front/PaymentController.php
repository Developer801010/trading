<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\User;
use App\Paypal\PaypalAgreement;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Laravel\Cashier\Subscription;
use Laravel\Cashier\SubscriptionItem;
use PayPal\Exception\PayPalConnectionException;
use Spatie\Permission\Models\Role;
use Stripe\Stripe;


class PaymentController extends Controller
{
    public function process(Request $request)
    {
        dd($request->stripeToken);
        // dd($request->all());

        $messages = [
            'password.regex' => 'Your password must be 8 or more characters, at least 1 uppercase and lowercase letter, 1 number, and 1 special character ($#@!%?*-+).',
        ];

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'mobile_number' => 'required',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$#@!%?*-+]).+$/',
            ],
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $firstName = $request->first_name;
        $lastName = $request->last_name;
        $email = $request->email;
        $mobileNumber = $request->mobile_number;
        $password = $request->password;
        $username = strtolower(substr($firstName, 0, 1) . $lastName);
       
        try{
            DB::beginTransaction();

             //the workflow to create an account
             User::create([
                'first_name' => $firstName, 
                'last_name' => $lastName,
                'email' => $email,
                'mobile_number' => $mobileNumber,
                'password' => bcrypt($password),
                'name' => $username               
             ]);


            $payment_option = $request->input('payment_option');

            // if($payment_option == 'stripe')
            // {

            //     Stripe::setApiKey(config('services.stripe.secret_key'));

                // $user->createOrGetStripeCustomer();  

                // $paymentMethod = null;
                // $paymentMethod = $request->payment_method;

                // if($paymentMethod != null) {
                //     $paymentMethod = $user->addPaymentMethod($paymentMethod);
                // }

                // $plan = $request->stripe_plan_id;
                // $membership_level = Plan::where('stripe_plan', $plan)->value('name');
            
                // $result = $request->user()->newSubscription('TlS '.$membership_level. ' Membership', $plan)
                //     ->create($paymentMethod != null ? $paymentMethod->id: '', [
                //         auth()->user()->email
                //     ]);

                // if ($result['stripe_status'] == 'active'){
                //     // if status is active, add a subscribe role. 
                //     $role = Role::where('name', 'subscriber')->first(); 
                //     $user->roles()->attach($role->id);
                // }

                // return redirect()->route('front.thanks')
                // ->with('success','You are subscribed to this plan. You can see real time trade.');
            // }
            // else
            // {
                // $paypal_plan_id = $request->paypal_plan_id;
                // $description = Plan::where('paypal_plan', $paypal_plan_id)->value('name');

                // $agreement = new PaypalAgreement();

                // return $agreement->create($request->paypal_plan_id, $description);
            // }     

            DB::commit();

            // dd(auth()->user()->id);
            
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors([ 'error' => 'Unable to create subscription due to this issue ' .$e->getMessage()]);  
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
    

    public function executeAgreement($status) 
    {
        if($status = 'true'){
            $agreement = new PaypalAgreement();
            $executePayment = $agreement->execute(request('token'));

            $subscriptionId = $executePayment->id;
            $state = $executePayment->state;            
            $description = $executePayment->description;
            $planId = session('planId');

            DB::beginTransaction();

            try{
                
                //save PayPal subscription data into the database 
                $subscription = new Subscription();
                $subscription->user_id = auth()->user()->id;
                $subscription->name = $description;
                $subscription->stripe_id = $subscriptionId;
                $subscription->stripe_status = $state;
                $subscription->stripe_price = $planId;   
                $subscription->quantity = 1;   
                $subscription->save();
           
                //user table update with PayPal status
                $user = User::find(auth()->user()->id);
                $user->pm_type = 'paypal';
                $user->save();
                
                $user = auth()->user();
                // Add a subscribe role. 
                $role = Role::where('name', 'subscriber')->first(); 
                $user->roles()->attach($role->id);
                
                DB::commit();

                return redirect()->route('front.thanks')
                ->with('success','You are subscribed to this plan. You can see real time trade.');                     

            }catch(Exception $ex){

                DB::rollBack();
                return back()->with('error', $ex->getMessage());

            }
           

        }else{
            return redirect()->route('front.checkout')
            ->with('error','There is a problem with your payment.');

        }
    }
    
    public function pauseSubscription($id)
    {
        $agreement = new PaypalAgreement();
        $agreement->pauseSubscription($id);

        return redirect()->back()
        ->with('success','Your subscription was paused.');
    }
}
