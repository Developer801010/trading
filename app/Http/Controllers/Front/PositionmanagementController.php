<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Trade;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;

class PositionManagementController extends Controller
{
    public function mainFeed()
    {
        return view('front.trades.main-feed');
    }
    
    public function openStockTrades(Request $request)
    {
        $query = Trade::with('tradeDetail')    
            ->where('trade_type', 'stock')
            ->whereNull('exit_price')->whereNull('exit_date');  //open trade

             // Handle search query
            $search = $request->input('search');
            if (!empty($search)) {
                $query->where('trade_symbol', 'like', '%' . $search . '%');
            }

            // Fetch the paginated results
            $trades = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('front.trades.open-stock-trades', compact('trades'));
    }

    public function closedStockTrades()
    {
        $trades = Trade::with('tradeDetail')
            ->where('trade_type', 'stock')
            ->whereNotNull('exit_price')->whereNotNull('exit_date')
            ->orderBy('created_at','desc')->paginate(10);

        return view('front.trades.closed-stock-trades', compact('trades'));
    }

    public function openOptionsTrades(Request $request)
    {
        $query = Trade::with('tradeDetail')    
            ->where('trade_type', 'option')
            ->whereNull('exit_price')->whereNull('exit_date');  //open trade

             // Handle search query
            $search = $request->input('search');
            if (!empty($search)) {
                $query->where('trade_symbol', 'like', '%' . $search . '%');
            }

            // Fetch the paginated results
            $trades = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('front.trades.open-options-trades', compact('trades'));
    }

    public function closedOptionsTrades()
    {
        $trades = Trade::with('tradeDetail')
        ->where('trade_type', 'option')
        ->whereNotNull('exit_price')->whereNotNull('exit_date')
        ->orderBy('created_at','desc')->paginate(10);

        return view('front.trades.closed-options-trades', compact('trades'));
    }

    public function tradeDetail($id)
    {
        
    }
}
