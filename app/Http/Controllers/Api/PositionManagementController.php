<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Trade;
use App\Models\TradeDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Cashier\Cashier;
use Laravel\Cashier\Subscription;

class PositionManagementController extends Controller
{
    public function mainFeed(Request $request)
    {
        $search = $request->input('search');

        // Define the first query
        $trades = DB::table('trades as t')
        ->leftJoin('trade_details as td', 't.id', '=', 'td.trade_id')
        ->select([
            't.id',
            't.trade_type',
            't.entry_date',
            't.trade_symbol',
            't.trade_direction AS original_trade_direction',
            DB::raw('NULL as child_direction'),
            't.trade_option',
            't.strike_price',
            DB::raw('CASE
                WHEN t.exit_price IS NOT NULL AND t.exit_date IS NOT NULL THEN
                    ((t.entry_price * t.position_size) + COALESCE(SUM(td.entry_price * td.position_size), 0)) /
                    (t.position_size + COALESCE(SUM(td.position_size), 0))
                ELSE
                    t.entry_price
                END AS entry_price'),
            't.stop_price',
            't.target_price',
            DB::raw('CASE
                WHEN t.exit_price IS NOT NULL AND t.exit_date IS NOT NULL THEN
                    (t.position_size + COALESCE(SUM(td.position_size), 0))
                ELSE
                    t.position_size
                END AS position_size'),
            't.exit_price',
            't.exit_date',
            't.trade_description',
            't.chart_image',
            't.close_comment',
            't.close_image',
            't.expiration_date',
            't.created_at',
            't.updated_at'
        ])
        ->groupBy( 't.id', 't.trade_type', 't.entry_date', 't.trade_symbol', 't.trade_direction', 't.trade_option',
       't.strike_price', 't.entry_price', 't.stop_price', 't.target_price', 't.position_size',
        't.exit_price', 't.exit_date', 't.trade_description', 't.chart_image', 't.close_comment',
        't.close_image',  't.expiration_date', 't.created_at', 't.updated_at');

        // Add search condition for trades
        if (!empty($search)) {
            $trades->where('t.trade_symbol', 'LIKE', '%' . $search . '%');
        }

        // Define the second query and join with the trades table
        $tradeDetails = DB::table('trade_details as td')
        ->join('trades as t', 'td.trade_id', '=', 't.id')
        ->select([
            'td.id',
            't.trade_type',
            't.entry_date',
            't.trade_symbol',
            't.trade_direction as original_trade_direction',
            'td.trade_direction as child_direction',
            't.trade_option',
            'td.strike_price',
            'td.entry_price',
            'td.stop_price',
            'td.target_price',
            'td.position_size',
            DB::raw('NULL AS exit_price'),
            DB::raw('NULL AS exit_date'),
            'td.trade_description',
            'td.chart_image',
            DB::raw("'' AS close_comment"),
            DB::raw("'' AS close_image"),
            'td.expiration_date',
            'td.created_at',
            'td.updated_at'
        ])
        ->whereNull('t.exit_price')
        ->whereNull('t.exit_date');

        // Add search condition for tradeDetails
        if (!empty($search)) {
            $tradeDetails->where('t.trade_symbol', 'LIKE', '%' . $search . '%');
        }

        $unionQuery = $trades->union($tradeDetails)->orderBy('updated_at', 'desc');

        // Combine both queries
        // $results = $unionQuery->paginate(10);
        $results = $unionQuery->get()->all();

        //Get Account login info and Billing info
        $billing_data = Subscription::where('user_id', auth()->user()->id)->first();  //dd($results);

        $data = [
            'results' => $results,
            'billing_data' => $billing_data,
        ];

        return response()->json([
            'status' => true,
            'message' => 'get Main Feed Data Succeessfully',
            'data' => $data,
        ], 200);
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
            // $trades = $query->orderBy('created_at', 'desc')->paginate(10);
            $trades = $query->orderBy('created_at', 'desc')->get()->all();

            return response()->json([
                'status' => true,
                'message' => 'get open stock trades Data Succeessfully',
                'data' => $trades,
            ], 200);
    }

    public function closedStockTrades(Request $request)
    {
        $query = DB::table('trades as t')
        ->leftJoin('trade_details as td', 't.id', '=', 'td.trade_id')
        ->select([
            't.id',
            't.trade_type',
            't.trade_symbol',
            't.trade_direction',
            't.entry_date',
            DB::raw('NULL as child_direction'),
            't.trade_option',
            't.strike_price',
            DB::raw('CASE
                WHEN t.exit_price IS NOT NULL AND t.exit_date IS NOT NULL THEN
                    ((t.entry_price * t.position_size) + COALESCE(SUM(td.entry_price * td.position_size), 0)) /
                    (t.position_size + COALESCE(SUM(td.position_size), 0))
                ELSE
                    t.entry_price
                END AS entry_price'),
            't.stop_price',
            't.target_price',
            DB::raw('CASE
                WHEN t.exit_price IS NOT NULL AND t.exit_date IS NOT NULL THEN
                    (t.position_size + COALESCE(SUM(td.position_size), 0))
                ELSE
                    t.position_size
                END AS position_size'),
            't.exit_price',
            't.exit_date',
            't.trade_description',
            't.chart_image',
            't.close_comment',
            't.close_image',
            't.created_at',
            't.updated_at'
        ])
        ->where('trade_type', 'stock')
        ->whereNotNull('exit_price')
        ->whereNotNull('exit_date')
        ->groupBy( 't.id', 't.trade_type', 't.trade_symbol', 't.trade_direction', 't.trade_option',  't.entry_date',
       't.strike_price', 't.entry_price', 't.stop_price', 't.target_price', 't.position_size',
        't.exit_price', 't.exit_date', 't.trade_description', 't.chart_image', 't.close_comment',
        't.close_image', 't.created_at', 't.updated_at');

         // Handle search query
        $search = $request->input('search');
        if (!empty($search)) {
            $query->where('trade_symbol', 'like', '%' . $search . '%');
        }

        // Fetch the paginated results
        // $trades = $query->orderBy('created_at', 'desc')->paginate(10);  //dd($trades);
            $trades = $query->orderBy('created_at', 'desc')->get()->all();

        return response()->json([
            'status' => true,
            'message' => 'get closed stock trades Data Succeessfully',
            'data' => $trades,
        ], 200);
    }

    public function closedStockTradesNoLogged(Request $request)
    {
        $query = DB::table('trades as t')
        ->leftJoin('trade_details as td', 't.id', '=', 'td.trade_id')
        ->select([
            't.id',
            't.trade_type',
            't.trade_symbol',
            't.trade_direction',
            't.entry_date',
            DB::raw('NULL as child_direction'),
            't.trade_option',
            't.strike_price',
            DB::raw('CASE
                WHEN t.exit_price IS NOT NULL AND t.exit_date IS NOT NULL THEN
                    ((t.entry_price * t.position_size) + COALESCE(SUM(td.entry_price * td.position_size), 0)) /
                    (t.position_size + COALESCE(SUM(td.position_size), 0))
                ELSE
                    t.entry_price
                END AS entry_price'),
            't.stop_price',
            't.target_price',
            DB::raw('CASE
                WHEN t.exit_price IS NOT NULL AND t.exit_date IS NOT NULL THEN
                    (t.position_size + COALESCE(SUM(td.position_size), 0))
                ELSE
                    t.position_size
                END AS position_size'),
            't.exit_price',
            't.exit_date',
            't.trade_description',
            't.chart_image',
            't.close_comment',
            't.close_image',
            't.created_at',
            't.updated_at'
        ])
        ->where('trade_type', 'stock')
        ->whereNotNull('exit_price')
        ->whereNotNull('exit_date')
        ->groupBy( 't.id', 't.trade_type', 't.trade_symbol', 't.trade_direction', 't.trade_option',  't.entry_date',
       't.strike_price', 't.entry_price', 't.stop_price', 't.target_price', 't.position_size',
        't.exit_price', 't.exit_date', 't.trade_description', 't.chart_image', 't.close_comment',
        't.close_image', 't.created_at', 't.updated_at');

         // Handle search query
        $search = $request->input('search');
        if (!empty($search)) {
            $query->where('trade_symbol', 'like', '%' . $search . '%');
        }

        // Fetch the paginated results
        // $trades = $query->orderBy('created_at', 'desc')->paginate(10);  //dd($trades);
        $trades = $query->orderBy('created_at', 'desc')->limit(20)->get()->all();

        return response()->json([
            'status' => true,
            'message' => 'get closed stock trades Data Succeessfully',
            'data' => $trades,
        ], 200);
    }

    public function openOptionsTrades(Request $request)
    {
        return Auth()->user();

        $query = Trade::with('tradeDetail')
            ->where('trade_type', 'option')
            ->whereNull('exit_price')->whereNull('exit_date');  //open trade

        // Handle search query
        $search = $request->input('search');
        if (!empty($search)) {
            $query->where('trade_symbol', 'like', '%' . $search . '%');
        }

        // Fetch the paginated results
        // $trades = $query->orderBy('created_at', 'desc')->paginate(10);
        $trades = $query->orderBy('created_at', 'desc')->get()->all();

        return response()->json([
            'status' => true,
            'message' => 'get open option trades Data Succeessfully',
            'data' => $trades,
        ], 200);
    }

    public function closedOptionsTrades(Request $request)
    {
        $query = DB::table('trades as t')
        ->leftJoin('trade_details as td', 't.id', '=', 'td.trade_id')
        ->select([
            't.id',
            't.trade_type',
            't.trade_symbol',
            't.trade_direction',
            't.entry_date',
            DB::raw('NULL as child_direction'),
            't.trade_option',
            't.strike_price',
            DB::raw('CASE
                WHEN t.exit_price IS NOT NULL AND t.exit_date IS NOT NULL THEN
                    ((t.entry_price * t.position_size) + COALESCE(SUM(td.entry_price * td.position_size), 0)) /
                    (t.position_size + COALESCE(SUM(td.position_size), 0))
                ELSE
                    t.entry_price
                END AS entry_price'),
            't.stop_price',
            't.target_price',
            DB::raw('CASE
                WHEN t.exit_price IS NOT NULL AND t.exit_date IS NOT NULL THEN
                    (t.position_size + COALESCE(SUM(td.position_size), 0))
                ELSE
                    t.position_size
                END AS position_size'),
            't.exit_price',
            't.exit_date',
            't.trade_description',
            't.chart_image',
            't.close_comment',
            't.close_image',
            't.created_at',
            't.updated_at'
        ])
        ->where('trade_type', 'option')
        ->whereNotNull('exit_price')
        ->whereNotNull('exit_date')
        ->groupBy( 't.id', 't.trade_type', 't.trade_symbol', 't.trade_direction', 't.trade_option',  't.entry_date',
       't.strike_price', 't.entry_price', 't.stop_price', 't.target_price', 't.position_size',
        't.exit_price', 't.exit_date', 't.trade_description', 't.chart_image', 't.close_comment',
        't.close_image', 't.created_at', 't.updated_at');

         // Handle search query
        $search = $request->input('search');
        if (!empty($search)) {
            $query->where('trade_symbol', 'like', '%' . $search . '%');
        }

        // Fetch the paginated results
        // $trades = $query->orderBy('created_at', 'desc')->paginate(10);
        $trades = $query->orderBy('created_at', 'desc')->get()->all();

        return response()->json([
            'status' => true,
            'message' => 'get closed options trades Data Succeessfully',
            'data' => $trades,
        ], 200);
    }

    public function closedOptionsTradesNoLogged(Request $request)
    {
        $query = DB::table('trades as t')
        ->leftJoin('trade_details as td', 't.id', '=', 'td.trade_id')
        ->select([
            't.id',
            't.trade_type',
            't.trade_symbol',
            't.trade_direction',
            't.entry_date',
            DB::raw('NULL as child_direction'),
            't.trade_option',
            't.strike_price',
            DB::raw('CASE
                WHEN t.exit_price IS NOT NULL AND t.exit_date IS NOT NULL THEN
                    ((t.entry_price * t.position_size) + COALESCE(SUM(td.entry_price * td.position_size), 0)) /
                    (t.position_size + COALESCE(SUM(td.position_size), 0))
                ELSE
                    t.entry_price
                END AS entry_price'),
            't.stop_price',
            't.target_price',
            DB::raw('CASE
                WHEN t.exit_price IS NOT NULL AND t.exit_date IS NOT NULL THEN
                    (t.position_size + COALESCE(SUM(td.position_size), 0))
                ELSE
                    t.position_size
                END AS position_size'),
            't.exit_price',
            't.exit_date',
            't.trade_description',
            't.chart_image',
            't.close_comment',
            't.close_image',
            't.created_at',
            't.updated_at'
        ])
        ->where('trade_type', 'option')
        ->whereNotNull('exit_price')
        ->whereNotNull('exit_date')
        ->groupBy( 't.id', 't.trade_type', 't.trade_symbol', 't.trade_direction', 't.trade_option',  't.entry_date',
       't.strike_price', 't.entry_price', 't.stop_price', 't.target_price', 't.position_size',
        't.exit_price', 't.exit_date', 't.trade_description', 't.chart_image', 't.close_comment',
        't.close_image', 't.created_at', 't.updated_at');

         // Handle search query
        $search = $request->input('search');
        if (!empty($search)) {
            $query->where('trade_symbol', 'like', '%' . $search . '%');
        }

        // Fetch the paginated results
        // $trades = $query->orderBy('created_at', 'desc')->paginate(10);
        $trades = $query->orderBy('created_at', 'desc')->limit(20)->get()->all();


        return response()->json([
            'status' => true,
            'message' => 'get closed options trades Data Succeessfully',
            'data' => $trades,
        ], 200);
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
        //dd($trade->trade->trade_type);
        return view('front.trades.trade-detail', compact('trade', 'type'));
    }
}
