<?php

namespace App\Paypal;

use DateInterval;
use DateTime;
use Exception;
use Illuminate\Support\Facades\Session;
use PayPal\Api\Agreement;
use PayPal\Api\AgreementStateDescriptor;
use PayPal\Api\Payer;
use PayPal\Api\Plan;
use PayPal\Api\ShippingAddress;

class PaypalAgreement extends Paypal
{
    public function create($data, $description) 
    {
        return redirect($this->agreement($data, $description));
    }

    protected function agreement($data, $description)
    {
        $agreement = new Agreement(); 
        
        $agreement->setName('Subscription Agreement')
            ->setDescription('TlS '.$description.' Membership')
            ->setStartDate($this->getPaypalDate())
            ->setPlan($this->plan($data['paypal_plan_id']))
            ->setPayer($this->payer());

        // $agreement->setShippingAddress($this->shippingAddress());

        $agreement = $agreement->create($this->apiContext);

        
        Session::flash('planId', $data['paypal_plan_id']);
        Session::flash('first_name', $data['first_name']);
        Session::flash('last_name', $data['last_name']);
        Session::flash('email', $data['email']);
        Session::flash('mobile_number', $data['mobile_number']);
        Session::flash('password', $data['password']);
        Session::flash('user_name', $data['user_name']);

        return $agreement->getApprovalLink();

    }

    protected function plan($id)
    {
        $plan = new Plan();
        $plan->setId($id);

        return $plan;
    }

    protected function payer() 
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        return $payer;
    }

    protected function shippingAddress()
    {
        $shippingAddress = new ShippingAddress();
        $shippingAddress->setLine1('111 First Street')
            ->setCity('Saratoga')
            ->setState('CA')
            ->setPostalCode('95070')
            ->setCountryCode('US');
        return $shippingAddress;
    }

    public function execute($token)
    {
        $agreement = new Agreement();
        $agreement->execute($token, $this->apiContext);

        return $agreement;
    }

    public function pauseSubscription($subscriptionID)
    {
        try {
            $agreementStateDescriptor = new AgreementStateDescriptor();
            $agreementStateDescriptor->setNote("Suspending the agreement");
    
            $agreement = Agreement::get($subscriptionID, $this->apiContext);
            $agreement->cancel($agreementStateDescriptor, $this->apiContext);
    
            // Retrieve the updated agreement state
            $updatedAgreement = Agreement::get($subscriptionID, $this->apiContext);
            $state = $updatedAgreement->getState();

            dd($state);
            return $state;

        }catch(Exception $ex){
            echo "Error: " . $ex->getMessage();
        }
       
    }

    protected function getPaypalDate() {
        $df = new DateTime();
        $df->add(new DateInterval('PT30S')); // Add 30 seconds
    
        return $df->format('Y-m-d\TH:i:sO');

        //gmdate("Y-m-d\TH:i:s\Z", strtotime("+1 day"));
    }
}