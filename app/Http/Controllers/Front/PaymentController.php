<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\StripeSubscriptionCancelEmail;
use App\Mail\Welcome;
use App\Models\Plan;
use App\Models\User;
use App\Paypal\PaypalAgreement;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Laravel\Cashier\Subscription;
use Laravel\Cashier\SubscriptionItem;
use PayPal\Exception\PayPalConnectionException;
use Spatie\Permission\Models\Role;
use Stripe\Exception\CardException;
use Stripe\PaymentMethod;
use Stripe\Stripe;

use function PHPSTORM_META\type;

class PaymentController extends Controller
{
    public function process(Request $request)
    {
        
        // User validation
        $messages = [
            'password.regex' => 'Your password must be 8 or more characters, at least 1 uppercase and lowercase letter, 1 number, and 1 special character ($#@!%?*-+).',
            'email.unique' => 'This email address is in use. Maybe you already have an account? <a href="http://portal.tradeinsync.com/password/reset">Need password help?</a>',
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

         //Get the payment option
         $payment_option = $request->input('payment_option');
       
         // Start the database transaction
        DB::beginTransaction();

        try{
            if($payment_option == 'stripe')
            {
                //the workflow to create an account
                $user = User::create([
                    'first_name' => $firstName, 
                    'last_name' => $lastName,
                    'email' => $email,
                    'mobile_number' => trim($mobileNumber),
                    'password' => bcrypt($password),
                    'name' => $username               
                ]);

                Stripe::setApiKey(config('services.stripe.secret_key'));

                 //card validation and get the payment method
                // $cardNumber = $request->input('card-number');
                // $expDate = $request->input('card-expire-date');
                // list($expMonth, $expYear) = explode('/', $expDate);
                // $cvc = $request->input('card-cvc');

                // $paymentMethod = PaymentMethod::create([
                //     'type' => 'card',
                //     'card' => [
                //         'number' => $cardNumber,
                //         'exp_month' => $expMonth,
                //         'exp_year' => $expYear,
                //         'cvc' => $cvc,
                //     ],
                // ]);  

                $paymentMethod = PaymentMethod::create([
                    'type' => 'card',
                    'card' => [
                        'token' => $request->token,
                    ],
                ]);  

                $user->createOrGetStripeCustomer();  

                if($paymentMethod != null) {
                    $paymentMethod = $user->addPaymentMethod($paymentMethod);
                }

                $plan = $request->stripe_plan_id;
                $membership_level = Plan::where('stripe_plan', $plan)->value('name');
            
                $result = $user->newSubscription('TlS '.$membership_level. ' Membership', $plan)
                    ->create($paymentMethod != null ? $paymentMethod->id: '', [
                        $user->email
                    ]);

                if ($result['stripe_status'] == 'active'){
                    // if status is active, add a subscribe role. 
                    $role = Role::where('name', 'subscriber')->first(); 
                    $user->roles()->attach($role->id);
                }

                // Commit the database transaction
                DB::commit();

                // Authenticate the user
                Auth::attempt(['email' => $email, 'password' => $password]);

                //Welcome Email
                $data = [
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'user_name' => $username
                ];
                Mail::to($email)->queue(new Welcome($data));

                return redirect()->route('front.main-feed')->with('success', 'Subscription successful! You are now logged in.');
                // return redirect()->route('front.thanks')->with('success','You can see the trade alert page real time');
            }
            else
            {
                $paypal_plan_id = $request->paypal_plan_id;
                $description = Plan::where('paypal_plan', $paypal_plan_id)->value('name');

                $data = [
                    'paypal_plan_id' => $paypal_plan_id,
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $email,
                    'mobile_number' => $mobileNumber,
                    'password' => $password,
                    'user_name' => $username                    
                ];
               
                $agreement = new PaypalAgreement();
                return $agreement->create($data, $description);
            }    

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
        $membership_level = $request->membership_level;
        $cancelAt = $request->cancelAt;
        $user = auth()->user();  
        $subscription = $user->subscription($membership_level);   

        if($subscription){
            try{
                $subscription->cancel();

                //Subscription cancel Email
                $data = [
                    'first_name' => auth()->user()->first_name,
                    'last_name' => auth()->user()->last_name,
                    'cancel_at' => $cancelAt,
                ];
        
                Mail::to(auth()->user()->email)->queue(new StripeSubscriptionCancelEmail($data));

                return redirect()->back()->with('flash_success', 'Subscription cancelation requested successfully.');
            }catch(Exception $ex){
                return redirect()->back()->with('error', $ex->getMessage());
            }            
        } else {
            return redirect()->back()->with('error', 'No active subscription found.');
        }
    }
    

    public function executeAgreement($status) 
    {  
        if($status == 'true')
        { 
            $agreement = new PaypalAgreement();
            $executePayment = $agreement->execute(request('token'));
            
            $subscriptionId = $executePayment->id;
            $state = $executePayment->state;            
            $description = $executePayment->description;
            $planId = session('planId');

            DB::beginTransaction();

            try{

                $user = User::create([
                    'first_name' => session('first_name'), 
                    'last_name' => session('last_name'),
                    'email' => session('email'),
                    'mobile_number' => session('mobile_number'),
                    'password' => bcrypt(session('password')),
                    'name' => session('user_name')     
                ]);
                
                //save PayPal subscription data into the database 
                $subscription = new Subscription();
                $subscription->user_id = $user->id;
                $subscription->name = $description;
                $subscription->stripe_id = $subscriptionId;
                $subscription->stripe_status = $state;
                $subscription->stripe_price = $planId;   
                $subscription->quantity = 1;   
                $subscription->save();
           
                //user table update with PayPal status
                $user = User::find($user->id);
                $user->pm_type = 'paypal';
                $user->stripe_id = $subscriptionId;
                $user->save();
                
                // Add a subscribe role. 
                $role = Role::where('name', 'subscriber')->first(); 
                $user->roles()->attach($role->id);
                
                DB::commit();

                Auth::attempt(['email' => session('email'), 'password' => session('password')]);

                //Welcome Email
                $data = [
                    'first_name' => session('first_name'),
                    'last_name' => session('last_name'),
                    'user_name' => session('user_name')
                ];
                Mail::to(session('email'))->queue(new Welcome($data));

                return redirect()->route('front.main-feed')->with('success', 'Subscription successful! You are now logged in.');

            }catch(Exception $ex){

                DB::rollBack();
                return redirect()->route('front.checkout', ['subscription_type' => 'm'])
                ->withErrors([ 'error' => 'Unable to create subscription due to this issue'.$ex->getMessage() ]);        
            }

        }
        else 
        {
            return redirect()->route('front.checkout', ['subscription_type' => 'm']);
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
