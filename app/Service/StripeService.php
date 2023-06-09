<?php
namespace App\Service;

use Stripe\Stripe;

class StripeService{

    
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.publish_key'));
        Stripe::setApiKey(config('services.stripe.secret_key'));
    }

    
}