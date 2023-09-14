<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Jobs\SendTwilioSMS;
use App\Mail\StripeSubscriptionCancelEmail;
use App\Models\Plan;
use App\Models\User;
use App\Paypal\PaypalAgreement;
use App\Service\SmsService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Laravel\Cashier\Subscription;
use Stripe\Invoice;
use Stripe\PaymentMethod;
use Stripe\Stripe;
use Stripe\Subscription as StripeSubscription;

class AccountController extends Controller
{
    public function index()
    {
        $member_date =Subscription::where('user_id', auth()->user()->id)->value('created_at'); 
        $mobileVerifiedStatus = auth()->user()->mobile_verified_at;
        $emailVerifiedStatus = auth()->user()->email_verified_at;

        return view('front.account.account-profile', 
            compact('member_date', 'mobileVerifiedStatus', 'emailVerifiedStatus'));
    }

    public function store(Request $request)
    {
        $obj = User::findorFail(auth()->user()->id);
        $obj->first_name = $request->first_name;
        $obj->last_name = $request->last_name;
        $obj->name = $request->name;

        if($request->current_password !== null){

            $messages = [
                'password.regex' => 'Your password must be 8 or more characters, at least 1 uppercase and lowercase letter, 1 number, and 1 special character ($#@!%?*-+).',
            ];

            $validator = Validator::make($request->all(), [
                'current_password' => 'required',
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
            
            // Verify the old password
            $user = Auth::user();
            $isPasswordValid = Hash::check($request->current_password, $user->password);

            if (!$isPasswordValid) {
                return redirect()->back()->withErrors(['current_password' => 'The current password is invalid.']);
            }

            // Hash the new password
            $hashedPassword = Hash::make($request->password);

            // Update the user's password
            $user = Auth::user();
            $user->password = $hashedPassword;        
            $user->save();
        }
        

        $obj->save();

        return redirect()->back()->with('flash_success', 'Account information has been updated');
    }

    public function notificationSetup()
    {
        if (auth()->user()->mobile_verified_at == null){  //mobile isn't verified
            $mobileVerifiedStatus = 'no';
        }else{
            $mobileVerifiedStatus = 'yes';
        }

        $mobileNotificationSetting = auth()->user()->mobile_notification_setting;
        if ($mobileNotificationSetting == null)
            $mobileNotificationSetting = 0;

        return view('front.account.notification-setup', 
        compact(
            'mobileVerifiedStatus',
            'mobileNotificationSetting'
        ));
    }
    
    public function sendVerificationCode(Request $request)
    { 
        $recipients = str_replace(' ', '', $request->input('phone'));
        $mobileVerifiedStatus = trim($request->input('mobileVerifiedStatus'));
        $mobileNotificationSetting = trim($request->input('mobileNotificationSetting'));

        if($mobileNotificationSetting == 1){ //unsubscribe
            $obj = User::findorFail(auth()->user()->id);
            $obj->mobile_notification_setting = 0;  //1:subscription. 0: unsubscription
            $obj->save();
            return response()->json(['msg' => 'It was unsubscribed successfully.']);
        }else{
            if($mobileVerifiedStatus == 'no'){  //if the mobile isn't verified. 
                 //check the duplication if the mobile notification is 0
                $mobileUsageCount = User::where('mobile_number', 'like', "%{$recipients}%")->count();
                if($mobileUsageCount>=1){
                    return response()->json(['error' => 'Phone number is already used!'], 400);
                }
                
                $verificationCode = $this->generateVerificationCode();
                 // Store the verification code and its expiration time in the session
                Session::put('verification_code', $verificationCode);
                Session::put('verification_code_expires_at', now()->addSeconds(60));
                Session::put('mobile_number', $recipients);

                $msg = 'Your verification code is: ' . $verificationCode;
                SendTwilioSMS::dispatch('+1'.$recipients, $msg);

            }else{
                //if mobile is alredy verified, it unsubscribes 
                $obj = User::findorFail(auth()->user()->id);
                $obj->mobile_notification_setting = 1;  //1:subscription. 0: unsubscription
                $obj->save();
                return response()->json(['msg' => 'It was subscribed successfully.']);
            }
        }
    }

    public function verifyPhoneCode(Request $request)
    {
        $phone_code = $request->input('phone_code');
        $mobile_number = session('mobile_number');
        
        $verificationCode = Session::get('verification_code');
        $expirationTime = Session::get('verification_code_expires_at');

        $obj = User::findorFail(auth()->user()->id);
        if ($obj->mobile_verified_at == null) //if phone isn't verified
        {  
            if (Carbon::now()->greaterThan($expirationTime)) {
                return response()->json(['msg' => 'Time is expired', 'status' => 'error']);
            }else{
                if($phone_code == $verificationCode){
                    $obj->mobile_verified_at = Carbon::now();
                    $obj->mobile_notification_setting = 1; //set mobile setting 1
                    $obj->mobile_number = $mobile_number;
                    $obj->save();
                    return response()->json(['msg' => 'You can get the mobile notification.' , 'status' => 'success']);
                }else{
                    return response()->json(['msg' => 'The code is wrong.' , 'status' => 'error']);
                }
            }
        }
    }

    private function generateVerificationCode()
    {
        // Generate a random 6-digit verification code
        return mt_rand(100000, 999999);
    }

    /**
     * Account notification for email and phone
     */

     public function membership()
     {
        
        //get Payment type 
        $paymentType = auth()->user()->pm_type;   

        if($paymentType == 'paypal'){

            $agreement = new PaypalAgreement();
            $subscription_id = Subscription::where('user_id', auth()->user()->id)->value('stripe_id');  
            // $subscription_id = '';
            $invoices = $agreement->getSubscriptionHistory($subscription_id);  //dd($invoices);
            $subscriptionStatus = $agreement->getSubscriptionStatus($subscription_id);
            $agreementDetails  = $agreement->getAgreementDetails($subscription_id);  
            //dd($agreementDetails);
            
            $membership_level = Subscription::where('user_id', auth()->user()->id)->value('name'); //dd($membership_level);

            return view('front.account.account-membership', 
            compact(
                    'paymentType',
                    'membership_level',
                    'invoices',
                    'subscription_id',
                    'subscriptionStatus',
                    'agreementDetails'
                )
            ); 
        }else{
             // Retrieve the user's Stripe customer ID
            $customerId = auth()->user()->stripe_id;  
            Stripe::setApiKey(config('services.stripe.secret_key'));
        
            try{
                // Retrieve the subscription history for the customer from Stripe
                if ($customerId !== null){
                    $subscriptions = StripeSubscription::all([
                        'customer' => $customerId,
                    ]);    //dd($subscriptions);

                    $invoices = Invoice::all([
                        'customer' => $customerId,
                        'limit' => 100, // Maximum allowed by Stripe
                    ]);     //dd($invoices);

                    $membership_level = Subscription::where('user_id', auth()->user()->id)->value('name');
                    // dd(auth()->user()->subscription($membership_level)->onGracePeriod());  //cancel_at + false: Grace period false. cancelat + true: still active
                    // if (auth()->user()->subscription($membership_level)->onGracePeriod()) {
                    //     dd(1);
                    // }
                    // dd($invoices->data);
                    return view('front.account.account-membership', 
                    compact(
                            'paymentType',
                            'invoices',
                            'subscriptions',
                            'membership_level'
                        )
                    ); 
                }
            }catch(Exception $ex){
                return redirect()->route('front.account-membership')->withErrors($ex->getMessage());
            }
        }
       

           
     }

     public function paymentMethodManagement()
     {
        $user = User::find(auth()->user()->id);
        $paymentMethods = $user->paymentMethods();  
        $paymentMethodCount =   count($paymentMethods);

        $defaultPaymentMethod = null;
        if ($user->hasPaymentMethod()) {
            $defaultPaymentMethod = $user->defaultPaymentMethod();  
        }     
        
        return view('front.account.account-payment-method-management', 
            compact(               
                'paymentMethods',
                'defaultPaymentMethod',
                'paymentMethodCount'
            )
        );
     }

     public function addCard(Request $request)
     {  

        try{
            $user = User::find(auth()->user()->id);
            $token =  $request->token;

            Stripe::setApiKey(config('services.stripe.secret_key'));

            // Create a PaymentMethod
            $paymentMethod = PaymentMethod::create([
                'type' => 'card',
                'card' => [
                    'token' => $token
                ]
            ]);  

            // dd($paymentMethod);
            $user->addPaymentMethod($paymentMethod);

            $user->updateDefaultPaymentMethod($paymentMethod);

            $user->pm_type = $paymentMethod['card']['brand'];
            $user->pm_last_four = $paymentMethod['card']['last4'];
            $user->save();

            return redirect()->back()->with('flash_success', 'Payment method is updated successfully!');

        }catch(Exception $ex){
            return redirect()->back()->withInput()->withErrors($ex->getMessage());
        }
       
     }
    

     public function deleteCard(Request $request, $id)
     {
        $user = USer::find(auth()->user()->id);
        $paymentMethods = $user->paymentMethods();  
        $paymentMethodCount =   count($paymentMethods);
        
        if($paymentMethodCount == 1){
            //if there is only one payment method. 
            return redirect()->back()->withInput()->withErrors('That payment method cannot be deleted because it is linked to an automatic subscription. Please add a payment method, before trying again.');
            
        }else{
            try{

                // Check if the payment method to be deleted is the default payment method
                $paymentMethod = $user->findPaymentMethod($id);
                $isDefaultPaymentMethod = $user->defaultPaymentMethod()->id === $id;
    
                // Delete the payment method
                $user->deletePaymentMethod($id);
    
                // Update default payment method if the deleted method was the default
                if ($isDefaultPaymentMethod && $user->hasPaymentMethod()) {
                    $newDefaultPaymentMethod = $user->paymentMethods()->first();
                    $user->updateDefaultPaymentMethod($newDefaultPaymentMethod->id);
                }
    
                return redirect()->back()->with('flash_success', 'Payment method is deleted successfully');
            }catch(Exception $ex){
                return redirect()->back()->with('error', $ex->getMessage());
            }
        }
        
     }
}
