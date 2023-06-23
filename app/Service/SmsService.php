<?php

namespace App\Service;
use Twilio\Rest\Client;
use Exception;

class SmsService{
    private $account_sid  = '';
    private $auth_token  = '';
    private $twilio_number   = '';

    public function __construct(){
        $this->account_sid = config('services.twilio.account_id');
        $this->auth_token = env('services.twilio.auth_token');
        $this->twilio_number = env('services.twilio.phone_number');
    }

    public function sendSMS($message, $recipients){
        try{
            $client = new Client($this->account_sid, $this->auth_token);
            $client->messages->create(
                $recipients,
                ['from' => $this->twilio_number, 'body' => $message]
            );
            return response()->json(['message' => 'SMS sent successfully']);
        } catch (Exception $e) {
            // Error occurred
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
?>
