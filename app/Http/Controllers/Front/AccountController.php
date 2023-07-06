<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\User;
use App\Service\SmsService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Laravel\Cashier\Subscription;

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

        return view('front.account.notification-setup', compact(
            'mobileVerifiedStatus'
        ));
    }
    
    public function sendVerificationCode(Request $request)
    { 
        $recipients = trim($request->input('phone'));
        $mobileVerifiedStatus = trim($request->input('mobileVerifiedStatus'));

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
            $obj->mobile_notification_setting = 0;  //1:subscription. 0: unsubscription
            $obj->save();
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
                    return response()->json(['msg' => 'The phone is verified.' , 'status' => 'success']);
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
        $member_date =Subscription::where('user_id', auth()->user()->id)->value('created_at'); 
        
        $member_date = Carbon::parse($member_date)->format('F j, Y h:i A');
        $account_cancel_date = $membership_level = '';

        $payment_type = auth()->user()->pm_type;

        $plan_price = Subscription::where('user_id', auth()->user()->id)
            ->where('stripe_status', 'active')  
            ->value('stripe_price');  

        if($payment_type == 'paypal'){
            $membership_level = Plan::where('paypal_plan', $plan_price)->value('name');
        }else{
            $membership_level = Plan::where('stripe_plan', $plan_price)->value('name'); 
        }
        
        //membership level
        if($membership_level == 'Monthly'){
            $account_cancel_date = Carbon::parse($member_date)->addMonth()->format('F j, Y h:i A');
        }else if($membership_level == 'Quarterly'){
            $account_cancel_date = Carbon::parse($member_date)->addQuarter()->format('F j, Y h:i A');
        }else if ($membership_level == 'Yearly'){
            $account_cancel_date = Carbon::parse($member_date)->addYear()->format('F j, Y h:i A');
        }

        //member order data
        $order_datas = Subscription::where('user_id', auth()->user()->id)
            ->where('stripe_status', 'active')
            ->get();  

        return view('front.account.account-membership', 
            compact(
                'member_date',
                'account_cancel_date',
                'membership_level',
                'order_datas'
                )
            ); 
           
     }
}
