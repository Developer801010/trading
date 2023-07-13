<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Trade;

class TradeAlertController extends Controller
{

    public function __construct() 
    {
        $this->middleware('permission:trade-list|trade-create|trade-edit|trade-delete', ['only' => ['index','store']]);
        $this->middleware('permission:trade-create', ['only' => ['create','store']]);
        $this->middleware('permission:trade-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:trade-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $parentTrades = Trade::with('tradeDetail')->get();

        return view('admin.trade_alert.index', compact('parentTrades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.trade_alert.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
