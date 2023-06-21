<?php

namespace App\Paypal;

use DateInterval;
use DateTime;
use PayPal\Api\Agreement;
use PayPal\Api\Payer;
use PayPal\Api\Plan;
use PayPal\Api\ShippingAddress;

class PaypalAgreement extends Paypal
{
    public function create($id) 
    {
        return redirect($this->agreement($id));
    }

    protected function agreement($id)
    {
        $agreement = new Agreement();

        $agreement->setName('Subscription Agreement')
            ->setDescription('Monthly Subscription Agreement')
            ->setStartDate($this->getPaypalDate())
            ->setPlan($this->plan($id))
            ->setPayer($this->payer());

        // $agreement->setShippingAddress($this->shippingAddress());

        $agreement = $agreement->create($this->apiContext);

        return $agreement->getApprovalLink();

    }

    protected function plan($id)
    {
        $plan = new Plan();
        return $plan->setId($id);
    }

    protected function payer() 
    {
        $payer = new Payer();
        return $payer->setPaymentMethod('paypal');
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
    }

    protected function getPaypalDate() {
        $df = new DateTime();
        $df->add(new DateInterval('PT30S')); // Add 30 seconds
    
        return $df->format('Y-m-d\TH:i:sO');

        //gmdate("Y-m-d\TH:i:s\Z", strtotime("+1 day"));
    }
}