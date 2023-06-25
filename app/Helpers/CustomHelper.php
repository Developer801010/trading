<?php

//Generate Random String

use App\Models\Plan;

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