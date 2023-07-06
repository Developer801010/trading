<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TradeOptionAlert;
use App\Models\TradeStockAlert;

class TradeAlertController extends Controller
{
    //
    public  function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $stock_alerts = TradeStockAlert::all();
        $option_alerts = TradeOptionAlert::all();
        return view('trade_alert.index', compact('stock_alerts', 'option_alerts'));
    }

    public function create()
    {

    }

}
