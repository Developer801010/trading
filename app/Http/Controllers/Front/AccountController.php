<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Service\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Cashier\Subscription;

class AccountController extends Controller
{
    public function index()
    {
        $member_date =Subscription::where('user_id', auth()->user()->id)->value('created_at'); 
        $mobileVerifiedStatus = auth()->user()->mobile_verified_at;
        $emailVerifiedStatus = auth()->user()->email_verified_at;

        return view('front.account-profile', 
            compact('member_date', 'mobileVerifiedStatus', 'emailVerifiedStatus'));
    }

    public function store(Request $request)
    {
        $obj = User::findorFail(auth()->user()->id);
        $obj->first_name = $request->first_name;
        $obj->last_name = $request->last_name;
        $obj->name = $request->name;
        if($obj->email !== $request->email){
            $obj->email = $request->email;
            $obj->email_verified_at = null;
        }
        if($obj->mobile_number !== $request->mobile_number){
            $obj->mobile_number = $request->mobile_number;
            $obj->mobile_verified_at = null;
        }
        $obj->save();

        return redirect()->back()->with('flash_success', 'Account information has been updated');
    }
    
    public function phoneVerification(Request $request)
    {
        $recipients = $request->input('phone');

        $obj = new SmsService();
        $message = '456789';
        return $obj->sendSMS($message, $recipients);
    }

    public function changePassword()
    {
        return view('front.account-change-password');    
    }

    public function changePasswordProcess(Request $request)
    {
         // Verify the old password
         $user = Auth::user();
         $isPasswordValid = Hash::check($request->current_password, $user->password);
        
         if (!$isPasswordValid) {
             return redirect()->back()->withErrors(['current_password' => 'The current password is invalid.']);
         }
 
         // Hash the new password
         $hashedPassword = Hash::make($request->new_password);
 
         // Update the user's password
         $user = Auth::user();
         $user->password = $hashedPassword;        
         $user->save();
 
         // Redirect the user to the dashboard or profile page
         return redirect()->back()->with('flash_success', 'Your password has been updated.');
    }

    /**
     * Account notification for email and phone
     */

     public function notification()
     {
        $mobileVerifiedStatus = auth()->user()->mobile_verified_at;
        $emailVerifiedStatus = auth()->user()->email_verified_at;
        return view('front.account-notification', 
            compact('mobileVerifiedStatus', 'emailVerifiedStatus'));
     }
}
