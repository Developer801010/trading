<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\RateLimiter;
use Twilio\Rest\Client;

class SendTwilioSMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $to;
    protected $message;
    
    /**
     * Create a new job instance.
     */
    public function __construct($to, $message)
    {
        $this->to = $to;
        $this->message = $message;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {

        // Perform rate limiting to send 1 SMS per second        
        $twilio = new Client(config('services.twilio.account_id'), config('services.twilio.auth_token'));

        $twilio->messages->create(
            $this->to,
            [
                'from' => config('services.twilio.phone_number'),
                'body' => $this->message,
            ]
        );
        
    }
}
