<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\StripeSubscriptionCancelEmail;
use App\Models\Plan;
use App\Models\User;
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

        return view('front.account.notification-setup', 
        compact(
            'mobileVerifiedStatus',
            'mobileNotificationSetting'
        ));
    }
    
    public function sendVerificationCode(Request $request)
    { 
        $recipients = trim($request->input('phone'));
        $mobileVerifiedStatus = trim($request->input('mobileVerifiedStatus'));
        $mobileNotificationSetting = trim($request->input('mobileNotificationSetting'));

        if($mobileNotificationSetting == 1){ //unsubscribe
            $obj = User::findorFail(auth()->user()->id);
            $obj->mobile_notification_setting = 0;  //1:subscription. 0: unsubscription
            $obj->save();
            return response()->json(['msg' => 'It was unsubscribed successfully.' , 'status' => 'success']);
        }else{
            if($mobileVerifiedStatus == 'no'){  //if the mobile isn't verified. 
                $sms_service = new SmsService();
                $verificationCode = $this->generateVerificationCode();
                 // Store the verification code and its expiration time in the session
                Session::put('verification_code', $verificationCode);
                Session::put('verification_code_expires_at', now()->addSeconds(60));
        
                $msg = 'Your verification code is: ' . $verificationCode;
                return $sms_service->sendSMS($msg, '+1'.$recipients);
            }else{
                //if mobile is alredy verified, it unsubscribes 
                $obj = User::findorFail(auth()->user()->id);
                $obj->mobile_notification_setting = 1;  //1:subscription. 0: unsubscription
                $obj->save();
                return response()->json(['msg' => 'It was subscribed successfully.' , 'status' => 'success']);
            }
        }
    }

    public function verifyPhoneCode(Request $request)
    {
        $phone_code = $request->input('phone_code');
        
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
        // Retrieve the user's Stripe customer ID
        $customerId = auth()->user()->stripe_id;
        Stripe::setApiKey(config('services.stripe.secret_key'));
       
        try{
            // Retrieve the subscription history for the customer from Stripe
            $invoices = Invoice::all([
                'customer' => $customerId,
                'limit' => 100, // Maximum allowed by Stripe

            ]);    
            
            $membership_level = Subscription::where('user_id', auth()->user()->id)->value('name');

            return view('front.account.account-membership', 
            compact(
                    'invoices',
                    'membership_level'
                )
            ); 
        }catch(Exception $ex){
            return redirect()->route('front.account-membership')->withErrors($ex->getMessage());
        }
     }

     public function paymentMethodManagement()
     {
        $user = User::find(auth()->user()->id);
        $paymentMethods = $user->paymentMethods();    
        $defaultPaymentMethod = null;
        if ($user->hasPaymentMethod()) {
            $defaultPaymentMethod = $user->defaultPaymentMethod();  
        }     

        return view('front.account.account-payment-method-management', 
            compact(               
                'paymentMethods',
                'defaultPaymentMethod'
            )
        );
     }

     public function addCard(Request $request)
     {  

        try{
            $user = User::find(auth()->user()->id);

            Stripe::setApiKey(config('services.stripe.secret_key'));

            $cardName = $request->input('card-name');
            $cardNumber = $request->input('card-number');
            $cardCVC = $request->input('card-cvc');
            $expDate = $request->input('card-expire-date');
            list($expMonth, $expYear) = explode('/', $expDate);

            $paymentMethod = PaymentMethod::create([
                'type' => 'card',
                'card' => [
                    'number' => $cardNumber, // Replace with the actual card number
                    'exp_month' => $expMonth, // Replace with the actual expiration month
                    'exp_year' => $expYear, // Replace with the actual expiration year
                    'cvc' => $cardCVC
                ],
                'billing_details' => [
                    'name' => $cardName
                ]
            ]); 


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
