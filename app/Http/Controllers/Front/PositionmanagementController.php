<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PositionManagementController extends Controller
{
    public function mainFeed()
    {
        return view('front.trades.main-feed');
    }
    
    public function openStockTrades()
    {
        return view('front.trades.open-stock-trades');
    }

    public function closedStockTrades()
    {
        return view('front.trades.closed-stock-trades');
    }

    public function openOptionsTrades()
    {
        return view('front.trades.open-options-trades');
    }

    public function closedOptionsTrades()
    {
        return view('front.trades.closed-options-trades');
    }
}
