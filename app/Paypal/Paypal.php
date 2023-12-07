<?php
namespace App\Paypal;

use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

class Paypal
{

    protected $apiContext;

    public function __construct()
    {
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                config('services.paypal.client_id'),     // ClientID
                config('services.paypal.client_secret')  // ClientSecret
            )
        );

        $this->apiContext->setConfig([
            'mode'                   => env('PAYPAL_MODE', 'sandbox'), 
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled'         => true,
            'log.FileName'           => storage_path('logs/paypal.log'),
            'log.LogLevel'           => 'ERROR',
        ]);
    }
}
