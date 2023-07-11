<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Paypal\SubscriptionPlan;
use Illuminate\Http\Request;

class PlanManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = Plan::all();
        return view('admin.plans.index', compact('datas'));
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
        //
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
        $plan = Plan::findorFail($id);
        $plan->name = $request->name;
        $plan->stripe_plan = $request->stripe_plan;
        $plan->paypal_plan = $request->paypal_plan;
        $plan->price = $request->price;

        $plan->save();
        
        return redirect()->route('plans.index')
                        ->with('flash_success','Plan updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    /**
     * create PayPal Plan
     */
    public function createPlanPaypal(Request $request)
    {
        $plan_name = $request->plan_name;
        $plan_description = $request->plan_description;
        $plan_frequency = $request->plan_frequency;
        $plan_frequency_interval = $request->plan_frequency_interval;
        $plan_price = $request->plan_price;

        $plan = new SubscriptionPlan();
        $plan->create($plan_name, $plan_description, $plan_frequency, $plan_frequency_interval, $plan_price);

        return redirect()->back()->with('flash_success', 'Plan created successfully');
    }

    /**
     * List plan for PayPal
     */
    public function listPlanPaypal()
    {    
        $plan = new SubscriptionPlan();
        $plans = $plan->listPlan();

        return view('admin.plans.list-paypal-plan', compact('plans'));
    }

    /**
     * Show plan detail for PayPal
     */
    public function showPlanPaypal($id) 
    {
        $plan = new SubscriptionPlan();
        $plan = $plan->planDetail($id);
        
        return view('admin.plans.show-paypal-plan', compact('plan'));
    }

   
    /**
     * Activate the plan for PayPal
     */
    public function activatePlanPaypal($id)
    {
        $plan = new SubscriptionPlan();
        $plan->activate($id);

        return redirect()->route('admin.list-plan-paypal')->with('flash_success', 'Successfully activated!');
    }

    /**
     * Delete the plan
     */
    public function deletePlanPaypal($id)
    {
        $plan = new SubscriptionPlan();
        $plan->deletePlan($id);

        return redirect()->route('admin.list-plan-paypal')->with('flash_success', 'Successfully deleted!');
    }
        
}
