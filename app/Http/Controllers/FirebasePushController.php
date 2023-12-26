<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\Messaging\CloudMessage;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Throwable;

class FirebasePushController extends Controller
{
    protected $notification;

    public function __construct()
    {
        $this->notification = Firebase::messaging();
    }

    public function setToken(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'fcm_token' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $token = $request->input('fcm_token');
            $user = auth()->guard('sanctum')->user();
            $user->fcm_token = $token;
            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'Successfully Updated FCM Token'
            ], 200);

        }catch(Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function removeToken(Request $request)
    {
        try{
            $user = auth()->guard('sanctum')->user();
            $user->fcm_token = null;
            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'Successfully Removed FCM Token'
            ], 200);
        }catch(Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function notificationToAllMobiles($data)
    {
        
        $title = $data['title'];
        $body =  $data['body']['first_title'].
        ' ' .  $data['body']['trade_entry_date'] .
        ' ' . $data['body']['trade_entry_price'] .
        ' ' . $data['body']['position_size'] .
        ' ' . $data['body']['stop_price'] .
        ' ' . $data['body']['target_price'] .        
        ' ' . $data['body']['visit'];

        $users = User::whereNotNull('fcm_token')->get()->all();
        
        foreach($users as $user){
            $message = CloudMessage::fromArray([
                'token' => $user->fcm_token,
                'notification' => [                 
                    // 'title' => $title,
                    // 'body' => $body
                    'title' => 'test title',
                    'body' => 'test body'
                ],
                
                 'apns' => [
                         'payload' => [
                             'aps' => [
                                 'sound' => 'default',
                                 "content-available" => 1
                             ],
                         ],
                     ],
            ]);
            dd($message);
            try{
                $res = $this->notification->send($message);
                dd($res);
            } catch(Throwable $th){
                return response()->json([
                    'status' => false,
                    'message' => $th->getMessage(),
                ], 500);
            }

        }
    }
}
