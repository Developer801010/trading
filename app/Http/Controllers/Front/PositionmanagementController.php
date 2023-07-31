<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Trade;
use App\Models\TradeDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Cashier\Cashier;

class PositionManagementController extends Controller
{
    public function mainFeed()
    {
        // Define the first query
        $trades = DB::table('trades as t')
        ->select([
            't.id',
            't.trade_type',
            't.trade_symbol',
            't.trade_direction',
            't.trade_option',
            't.strike_price',
            't.entry_price',
            't.stop_price',
            't.target_price',
            't.exit_price',
            't.exit_date',
            't.position_size',
            't.trade_description',
            't.chart_image',
            't.close_comment',
            't.close_image',
            't.created_at',
            't.updated_at'
        ]);

        // Define the second query and join with the trades table
        $tradeDetails = DB::table('trade_details as td')
        ->join('trades as t', 'td.trade_id', '=', 't.id')
        ->select([
            'td.id',
            't.trade_type',            
            't.trade_symbol',
            'td.trade_direction',
            't.trade_option',
            'td.strike_price',
            'td.entry_price',
            'td.stop_price',
            'td.target_price',
            't.exit_price',
            't.exit_date',
            'td.position_size',
            'td.trade_description',
            'td.chart_image',
             DB::raw("'' as close_comment"),
             DB::raw("'' as close_image"),
            'td.created_at',
            'td.updated_at'
        ]);

        $unionQuery = $trades->union($tradeDetails)->orderBy('updated_at', 'desc');

        // Combine both queries
        $results = $unionQuery->paginate(10);

        return view('front.trades.main-feed', compact('results'));
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

    public function closedStockTrades(Request $request)
    {
        $query = Trade::with('tradeDetail')    
        ->where('trade_type', 'stock')
        ->whereNotNull('exit_price')->whereNotNull('exit_date');  //open trade

         // Handle search query
        $search = $request->input('search');
        if (!empty($search)) {
            $query->where('trade_symbol', 'like', '%' . $search . '%');
        }

        // Fetch the paginated results
        $trades = $query->orderBy('created_at', 'desc')->paginate(10);

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

    public function closedOptionsTrades(Request $request)
    {
        $query = Trade::with('tradeDetail')    
        ->where('trade_type', 'option')
        ->whereNotNull('exit_price')->whereNotNull('exit_date');  //open trade

         // Handle search query
        $search = $request->input('search');
        if (!empty($search)) {
            $query->where('trade_symbol', 'like', '%' . $search . '%');
        }

        // Fetch the paginated results
        $trades = $query->orderBy('created_at', 'desc')->paginate(10);

        $trades = Trade::with('tradeDetail')
        ->where('trade_type', 'option')
        ->whereNotNull('exit_price')->whereNotNull('exit_date')
        ->orderBy('created_at','desc')->paginate(10);

        return view('front.trades.closed-options-trades', compact('trades'));
    }

    public function tradeDetail($id, $type)
    {
        if($type == 'n') {
            //trade creation alert
            $trade = Trade::where('id', $id)->first();
        }else if ($type == 'a'){
            //trade add alert
            $trade = TradeDetail::with('trade')->where('id', $id)->first();
        }else if ($type == 'c'){
            //trade close alert
            $trade = Trade::with('tradeDetail')->where('id', $id)->first();
        }
        
        return view('front.trades.trade-detail', compact('trade', 'type'));
    }
}
