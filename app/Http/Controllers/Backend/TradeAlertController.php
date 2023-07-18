<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Trade;
use App\Models\TradeDetail;
use Exception;
use Illuminate\Support\Facades\DB;

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
        $parentTrades = Trade::with('tradeDetail')->orderBy('created_at','desc')->paginate(10);

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
        $trade_type = $request->trade_type;
        $trade_symbol = $request->trade_symbol;
        $trade_option = $request->trade_option;
        $trade_direction = $request->trade_direction;
        $expiration_date = $request->expiration_date;
        $strike_price = $request->strike_price;
        $stop_price = $request->stop_price;
        $target_price = $request->target_price;
        $entry_price = $request->entry_price;
        $entry_date = $request->entry_date;
        $position_size = $request->position_size;
        $trade_description = $request->trade_description;
        
        DB::beginTransaction();
        try{

            $tradeObj = new Trade();
            $tradeObj->trade_type = $trade_type;
            $tradeObj->trade_symbol = $trade_symbol;            
            $tradeObj->trade_direction = $trade_direction;
            $tradeObj->stop_price = $stop_price;
            $tradeObj->target_price = $target_price;
            $tradeObj->entry_date = $entry_date;
            $tradeObj->entry_price = $entry_price;
            $tradeObj->position_size = $position_size;
            $tradeObj->trade_description = $trade_description;

            if($trade_type == 'option'){
                $tradeObj->trade_option = $trade_option;    
                $tradeObj->expiration_date = $expiration_date;
                $tradeObj->strike_price = $strike_price;
            }

            if($request->hasFile('image')){
                $request->validate([
                    'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
        
                $imageName = time().'.'.$request->image->extension();    
                $request->image->move(public_path('uploads/trade'), $imageName);

                $tradeObj->chart_image = 'uploads/trade/' . $imageName;
            }

            $tradeObj->save();
            DB::commit();

            return back()->with('flash_success', 'Trade was created successfully!')->withInput();
        }catch(Exception $ex){
            DB::rollBack();
            return back()->withErrors($ex->getMessage());
        }


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

    public function tradeAdd(Request $request) 
    {
        $addFormID = $request->addFormID;
        $addEntryDate = $request->addEntryDate;
        $addBuyPrice = $request->addBuyPrice;
        $addPositionSize = $request->addPositionSize;
        $addStopPrice = $request->addStopPrice;
        $addTargetPrice = $request->addTargetPrice;
        $addComments = $request->addComments;
       
        DB::beginTransaction();
        try{
            $tradeObj = new TradeDetail();
            $tradeObj->trade_id = $addFormID;
            $tradeObj->entry_date = $addEntryDate;
            $tradeObj->entry_price = $addBuyPrice;            
            $tradeObj->position_size = $addPositionSize;
            $tradeObj->stop_price = $addStopPrice;
            $tradeObj->target_price = $addTargetPrice;
            $tradeObj->trade_description = $addComments;
       
            // if($trade_type == 'option'){
            //     $tradeObj->trade_option = $trade_option;    
            //     $tradeObj->expiration_date = $expiration_date;
            //     $tradeObj->strike_price = $strike_price;
            // }

            if($request->hasFile('addImage')){
                $imageName = time().'.'.$request->addImage->extension();    
                $request->addImage->move(public_path('uploads/trade'), $imageName);

                $tradeObj->chart_image = 'uploads/trade/' . $imageName;
            }

            $tradeObj->save();
            DB::commit();

            return back()->with('flash_success', 'Trade was added successfully!')->withInput();
        }catch(Exception $ex){
            DB::rollBack();
            return back()->withErrors($ex->getMessage());
        }
    }


    public function tradeClose(Request $request) 
    {
        $closeFormID = $request->closeFormID;
        $addEntryDate = $request->addEntryDate;
        $addBuyPrice = $request->addBuyPrice;
        $addPositionSize = $request->addPositionSize;
        $addStopPrice = $request->addStopPrice;
        $addTargetPrice = $request->addTargetPrice;
        $addComments = $request->addComments;
       
        DB::beginTransaction();
        try{
            $tradeObj = new TradeDetail();
            $tradeObj->trade_id = $closeFormID;
            $tradeObj->entry_date = $addEntryDate;
            $tradeObj->entry_price = $addBuyPrice;            
            $tradeObj->position_size = $addPositionSize;
            $tradeObj->stop_price = $addStopPrice;
            $tradeObj->target_price = $addTargetPrice;
            $tradeObj->trade_description = $addComments;
       
            // if($trade_type == 'option'){
            //     $tradeObj->trade_option = $trade_option;    
            //     $tradeObj->expiration_date = $expiration_date;
            //     $tradeObj->strike_price = $strike_price;
            // }

            if($request->hasFile('addImage')){
                $imageName = time().'.'.$request->addImage->extension();    
                $request->addImage->move(public_path('uploads/trade'), $imageName);

                $tradeObj->chart_image = 'uploads/trade/' . $imageName;
            }

            $tradeObj->save();
            DB::commit();

            return back()->with('flash_success', 'Trade was added successfully!')->withInput();
        }catch(Exception $ex){
            DB::rollBack();
            return back()->withErrors($ex->getMessage());
        }
    }
}


