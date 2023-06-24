<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PositionManagementController extends Controller
{
    public function openPosition()
    {
        return view('front.open-position');
    }

    public function closedPosition()
    {
        return view('front.closed-position');
    }

    public function mainFeed()
    {
        return view('front.main-feed');
    }
}
