<?php

namespace App\Paypal;

use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;
use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;

class CreatePlan extends Paypal
{
    public function create()
    {
        $plan = new Plan();

        $plan->setName('T-Shirt of the Month Club Plan')
            ->setDescription('Template creation.')
            ->setType('fixed');

        $paymentDefinition = new PaymentDefinition();
        $paymentDefinition->setName('Regular Payments')
            ->setType('REGULAR')
            ->setFrequency('Month')
            ->setFrequencyInterval("2")
            ->setCycles("12")
            ->setAmount(new Currency(array('value' => 100, 'currency' => 'USD')));

    }
}