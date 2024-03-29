<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ApiPasswordResetToken;
use App\Models\User;
use App\Notifications\ApiPasswordResetNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;
use Throwable;
use Stripe\Stripe;
use App\Paypal\PaypalAgreement;
use Stripe\PaymentMethod;
use App\Models\Plan;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;
use App\Mail\Welcome;

class AuthenticateController extends Controller
{

    /**
     * Authenticates Login User
     * @param Request $request
     * @return Response User
     */
    public function login(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
                'device_name' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors(),
                ], 422);
            }

            //Check email
            $user = User::where('email',$request->email)->first();

            //Check password
            if(!$user || !Hash::check($request->password, $user->password)){
                return response()->json([
                    'status' => false,
                    'message' => 'The provided credentials are incorrect.',
                ], 401);
            }

            $token = $user->createToken($request->device_name)->plainTextToken;

            $response = [
                'user' => $user,                
                'token' => $token
            ];

            return response()->json([
                'status' => true,
                'message' => 'Login Successful',
                'data' => $response,
            ], 200);

        }catch(Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function unauthorized(Request $request){
        return response()->json([
            'status' => false,
            'message' => 'Unverified user. please login first',
        ], 401);
    }

    public function changePassword(Request $request){
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|max:45|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$#@!%?*-+]).+$/',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = auth()->guard('sanctum')->user();
        if (Hash::check($request->current_password, $user->password)) {
            $user->password = Hash::make($request->new_password);

            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'Password changed successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Current password is incorrect'
            ], 422);
        }
    }

    /**
     * Authenticates Register User
     * @param Request request
     * @return Response token and user information
     */

    public function register(Request $request)
    {
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
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $firstName = $request->first_name;
        $lastName = $request->last_name;
        $email = $request->email;
        $mobile_number = $request->mobile_number;
        $password = $request->password;
        $username = $firstName.$lastName;
        $count = 1;

        //check if the username already exists: if it does, increment the count
        while (User::where('name', $username)->exists()){
            $username = $username.$count;
            $count++;
        }

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
                    'mobile_number' => trim($mobile_number),
                    'password' => bcrypt($password),
                    'name' => $username               
                ]);

                Stripe::setApiKey(config('services.stripe.secret_key'));

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
                Artisan::call('queue:work --stop-when-empty');

                $token = $user->createToken('myAppToken')->plainTextToken;

                $response = [
                    'user' => $user,
                    'token' => $token
                ];
                // Your success logic here
                return response()->json([
                    'message' => 'Registration successful',
                    'data' => $response,
                ], 200);                    
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
                    'mobile_number' => $mobile_number,
                    'password' => $password,
                    'user_name' => $username                    
                ];
            
                $agreement = new PaypalAgreement();
                return response()->json([
                    'message' => 'Registration successful',
                    'data' => $agreement->create($data, $description)
                ], 200);     
            }    

        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' =>  $exception->getMessage(),               
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->bearerToken();
        $user = auth()->guard('sanctum')->user();
        $personalAccessToken = PersonalAccessToken::findToken($token);

        try{
            if ($personalAccessToken){
                if(
                    $user->id == $personalAccessToken->tokenable_id
                    && get_class($user) == $personalAccessToken->tokenable_type
                ){
                    $personalAccessToken->delete();
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid or expired token, please login again',
                ], 422);
            }

        }catch(Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }


        return [
            'message' => 'Logged out',
            'personalAccessToken' => $personalAccessToken,
        ];
    }

    // This route takes in the 6 alpha-numeric code received from the email. ensure that it is valid code
    public function validatePasswordResetToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password_reset_code' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $password_reset_code = $request->password_reset_code;
        $resetToken = ApiPasswordResetToken::where([
            ['token_signature', hash('md5', $password_reset_code)],
            ['token_type', ApiPasswordResetToken::$PASSWORD_RESET_TOKEN]
        ])->first();

        if ($resetToken == null || $resetToken->count() <= 0 ){
            return response()->json([
                'status' => false,
                'message' => 'Invalid password reset code provided',
            ], 422);
        }

        if(Carbon::now()->greaterThan($resetToken->expires_at)){
            return response()->json([
                'status' => false,
                'message' => 'The password reset code given has expired',
            ], 422);
        }

        $reset_token = $resetToken->getResetIdentifierCode($resetToken->user_id);

        return response()->json([
            'status' => true,
            'token' => $reset_token
        ]);

        if($reset_token){
            $reset_token->update([
                'expires_at' => Carbon::now()
            ]);

            return response()->json([
                'status' => true,
                'token' => $reset_token
            ]);

        }else{
            return response()->json([
                'status' => false,
                'message' => 'There is an error while validating the password reset code'
            ]);
        }
    }

    //This route takes in an email. validates the email exists, and sends 6 alphanumeric code to the email of the user user.
    public function sendPasswordResetToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email|'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        do {
            $obj = new ApiPasswordResetToken();
            $token = $obj->getResetCode();
            $signature = hash('md5', $token);
            $exists = ApiPasswordResetToken::where([
                'user_id' => $user->id,
                'token_signature' => $signature
            ])->exists();
        } while($exists);

        try {
            $user->notify(new ApiPasswordResetNotification($token));

            $obj->user_id = $user->id;
            $obj->token_signature = $signature;
            $obj->expires_at = Carbon::now()->addMinutes(30);
            $obj->save();

            return response()->json([
                'status' => true,
                'message' => 'Password reset token has been sent to your email, please enter the password reset page to rest your password.'
            ],200);

        }catch(Throwable $th) {
            return response()->json([
                'status' => false,
                $th->getMessage()
            ], 500);
        }
    }

    //This route takes the new password and confirmation password, and resets the password.
    public function setNewAccountPassword(Request $request)
    {
        $messages = [
            'password.regex' => 'Your password must be 8 or more characters, at least 1 uppercase and lowercase letter, 1 number, and 1 special character ($#@!%?*-+).',
        ];

        $validator = Validator::make($request->all(), [
            'password_token' => 'required|string',
            'password' =>  'required|string|min:8|max:45|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$#@!%?*-+]).+$/',
        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $verifyToken = ApiPasswordResetToken::where([
            'token_signature' => hash('md5', $request->password_token)
        ])->get();

        if($verifyToken == null || $verifyToken->count() <= 0 ){
            return response()->json([
                'status' => false,
                'message' => 'Invalid token for resetting password'
            ], 422);
        }

        $user_id = $verifyToken[0]->user_id;
        $userInfo = User::where('id', $user_id)->first();

        if($userInfo == null || $userInfo->count() <= 0){
            return response()->json([
                'status' => false,
                'message' => 'Token does not correspond to any existing user.'
            ], 422);
        } else if (Carbon::now()->greaterThan($verifyToken[0]->expires_at)){
            return response()->json([
                'status' => false,
                'message' => 'The reset password token has expired. Please try again.'
            ], 422);
        }

        $userObj = User::findOrFail($user_id);
        $userObj->password = Hash::make($request->password);
        $userObj->update();

        $verifyToken[0]->update([
            'expires_at' => Carbon::now()
        ]);

        return response()->json([
            'status' => true,
            'message' => 'The password is updated successfully.',
            'user' => $userObj
        ]);
    }

}
