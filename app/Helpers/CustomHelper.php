<?php

//Generate Random String

use App\Models\Plan;
use Laravel\Cashier\Subscription;

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

//Print Date Format by Y-m-d
function dateFormat($date,$format)
{
    return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format($format);    
}

//
function getPaymentType($letter)
{
    $words = explode(" ", $letter);
    $wordCount = count($words);
    $middleIndex = (int) ($wordCount / 2);
    $middleWord = $words[$middleIndex];

    return $middleWord;
}

function getPlanPrice($planName)
{
    return Plan::where('name', $planName)->value('price');
}

function getSubscriptionTitle($stripe_id)
{
    return Subscription::where('user_id', auth()->user()->id)
        ->where('stripe_id', $stripe_id)->value('name');
}

function getSubscriptionType($interval, $interval_count)
{
   
}

function getMiddleWord($string) {
    $words = explode(' ', $string);
    $wordCount = count($words);
    
    if($wordCount % 2 == 0) {
        // If there's an even number of words, return the earlier of the two middle words.
        // If you want the latter, change the index to $wordCount/2.
        return $words[($wordCount/2)-1];
    } else {
        return $words[floor($wordCount/2)];
    }
}

function check_image($url)
{
	if($url ?? false) {
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_exec($ch);
		$info = curl_getinfo($ch);
		if ($info["http_code"] != 200)
			return false;
		else
			return true;
	}

	return false;
}