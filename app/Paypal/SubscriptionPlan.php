<?php

namespace App\Paypal;

use Exception;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;
use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Common\PayPalModel;

class SubscriptionPlan extends Paypal
{
    public function create($plan_name, $plan_description, $plan_frequency, $plan_frequency_interval, $plan_price)
    {
        // Set up plan details
        $plan = $this->plan($plan_name, $plan_description);
       
        // Set up billing cycles
        $paymentDefinition = $this->paymentDefinition($plan_frequency, $plan_frequency_interval, $plan_price);    
       
        // $chargeModel = new ChargeModel();
        // $chargeModel->setType('SHIPPING')
        //     ->setAmount(new Currency(array('value' => 10, 'currency' => 'USD')));
           
        // Set up merchant preferences
        $merchantPreferences = $this->merchantPreferences();

        // Associate payment definition and merchant preferences with the plan
        $plan->setPaymentDefinitions(array($paymentDefinition));
        $plan->setMerchantPreferences($merchantPreferences);
               

        try {
            $output = $plan->create($this->apiContext);
        } catch (Exception $ex) {
            dd($ex->getMessage());
            exit(1);
        } 
    }

    protected function plan($plan_name, $plan_description): Plan
    {
        $plan = new Plan();
        $plan->setName($plan_name)
        ->setDescription($plan_description)
        ->setType('fixed');

        return $plan;
    }

    protected function paymentDefinition($plan_frequency, $plan_frequency_interval, $plan_price): PaymentDefinition
    {
        $paymentDefinition = new PaymentDefinition();
        $paymentDefinition->setName('Recurring Payments')
            ->setType('REGULAR')
            ->setFrequency($plan_frequency)
            ->setFrequencyInterval($plan_frequency_interval)
            ->setCycles('998')
            ->setAmount(new Currency(['value' => $plan_price, 'currency' => 'USD']));

        return $paymentDefinition;
    }

    protected function merchantPreferences(): MerchantPreferences
    {
        $merchantPreferences = new MerchantPreferences();
        
        $merchantPreferences->setReturnUrl(config('services.paypal.url.executeAgreement.success'))
            ->setCancelUrl(config('services.paypal.url.executeAgreement.failure'))
            ->setAutoBillAmount("yes")
            ->setInitialFailAmountAction("CONTINUE")
            ->setMaxFailAttempts("0");
            // ->setSetupFee(new Currency(array('value' => 1, 'currency' => 'USD')));

        return $merchantPreferences;
    }

    public function listPlan()
    {
        $params = [
            'page_size' => 10,
            'status' => 'ALL'
        ];
        $planList = Plan::all($params, $this->apiContext);

        return $planList;
    }

    public function planDetail($id) 
    {
        $plan = Plan::get($id, $this->apiContext);
        return $plan;
    }

     /**
     * Activate Plan for PayPal
     */
    public function activate($id)
    {
        $createdPlan = $this->planDetail($id);
        $patch = new Patch();

        $value = new PayPalModel('{
            "state":"ACTIVE"
            }');

        $patch->setOp('replace')
            ->setPath('/')
            ->setValue($value);
        $patchRequest = new PatchRequest();
        $patchRequest->addPatch($patch);

        $createdPlan->update($patchRequest, $this->apiContext);

        $plan = Plan::get($createdPlan->getId(), $this->apiContext);

        return $plan;
    }

    /**
     * Delete Plan
     */

     public function deletePlan($id)
     {
        $createdPlan = $this->planDetail($id);
        $createdPlan->delete($this->apiContext);

        return $createdPlan;
     }
}