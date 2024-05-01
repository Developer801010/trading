<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Settings;

class SettingsController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $getData = Settings::whereNotNull('portfolio_size')->first();
        return view('admin.setting.index')->with('getData',$getData);
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validated = $this->validate($request, [
			'portfolio_size' => 'required',	
			'start_date' => 'required'
		]);

        if(!$validated) {
			return back()->with('flash_error', 'Please fill all requried fields');
		}

        // Update the setting's data Check avalable 
        $setDate = Settings::whereNotNull('portfolio_size')->first();
        if(!$setDate){
            // Save the setting's data
            $setDate = new Settings;
        }
        
        $setDate->portfolio_size = str_replace(',','',$request->portfolio_size);
        $setDate->date = $request->start_date;
        if($setDate->save()){
            // Redirect the user to the dashboard or profile page
            return redirect()->back()->with('flash_success', 'Your setting has been Save.');
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
}
