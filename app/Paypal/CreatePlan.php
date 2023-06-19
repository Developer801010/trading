<?php

namespace App\Paypal;

use Exception;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;
use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use ResultPrinter;

class CreatePlan extends Paypal
{
    public function create()
    {
        // Set up plan details
        $plan = $this->plan();
       
        // Set up billing cycles
        $paymentDefinition = $this->paymentDefinition();    
       
        $chargeModel = new ChargeModel();
        $chargeModel->setType('SHIPPING')
            ->setAmount(new Currency(array('value' => 10, 'currency' => 'USD')));
           
        // Set up merchant preferences
        $merchantPreferences = $this->merchantPreferences();

        // Associate payment definition and merchant preferences with the plan
        $plan->setPaymentDefinitions(array($paymentDefinition));
        $plan->setMerchantPreferences($merchantPreferences);
               
        $request = clone $plan;

        try {
            $output = $plan->create($this->apiContext);
        } catch (Exception $ex) {
            ResultPrinter::printError("Created Plan", "Plan", null, $request, $ex);
            exit(1);
        }

        ResultPrinter::printResult("Created Plan", "Plan", $output->getId(), $request, $output);

        dd($output);
        
    }

    protected function plan()
    {
        $plan = new Plan();
        $plan->setName('Trade Plan')
        ->setDescription('Monthly subscription for Trade Plan')
        ->setType('fixed');

        return $plan;
    }

    protected function paymentDefinition()
    {
        $paymentDefinition = new PaymentDefinition();
        $paymentDefinition->setName('Regular Payments')
            ->setType('REGULAR')
            ->setFrequency('Month')
            ->setFrequencyInterval("1")
            ->setCycles("0")
            ->setAmount(new Currency(['value' => '100', 'currency' => 'USD']));

        return $paymentDefinition;
    }

    protected function merchantPreferences()
    {
        $merchantPreferences = new MerchantPreferences();
        
        $merchantPreferences->setReturnUrl(config('services.paypal.url.executeAgreement.success'))
            ->setCancelUrl(config('services.paypal.url.executeAgreement.failure'))
            ->setAutoBillAmount("yes")
            ->setInitialFailAmountAction("CONTINUE")
            ->setMaxFailAttempts("0")
            ->setSetupFee(new Currency(array('value' => 1, 'currency' => 'USD')));

        return $merchantPreferences;
    }

     // public function listPlan()
    // {
    //     $params = array('page_size' => 10);
    //     $planList = Plan::all($params, $this->apiContext);

    //     return $planList;
    // }
}