@extends('layouts.master')

@section('title', 'Plan Edit')

@section('page-style')
@endsection

@section('content')
<section>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Plan Editing</h4>
                </div>

                <div class="card-body">                    
                   <form>                    
                        <div class="row">
                            <div class="col-md-12">
                                @include('layouts.error')
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="name">ID</label>
                                    <input type="text" class="form-control-plaintext" value="{{ $plan->id }}" />
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="email">State</label>
                                    <input type="text" class="form-control-plaintext @if($plan->state == 'ACTIVE') text-success  @else text-primary @endif" value="{{ $plan->state }}" />
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="email">name</label>
                                    <input type="text" class="form-control-plaintext" value="{{ $plan->name }}" />
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="email">Description</label>
                                    <input type="text" class="form-control-plaintext" value="{{ $plan->description }}" />
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="email">type</label>
                                    <input type="text" class="form-control-plaintext" value="{{ $plan->type }}" />
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="email">Payment Definitions Type</label>
                                    <input type="text" class="form-control-plaintext" value="{{ $plan->payment_definitions[0]->type }}" />
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="email">Payment Definitions Frequency</label>
                                    <input type="text" class="form-control-plaintext" value="{{ $plan->payment_definitions[0]->frequency }}" />
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="email">Amount</label>
                                    <input type="text" class="form-control-plaintext" value="{{ $plan->payment_definitions[0]->amount->value }}" />
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="email">Currency</label>
                                    <input type="text" class="form-control-plaintext" value="{{ $plan->payment_definitions[0]->amount->currency }}" />
                                </div>
                            </div>

                            <div class="col-12 mt-2">
                                <button type="submit" class="btn btn-primary me-1 waves-effect waves-float waves-light">Save</button>
                                @if($plan->state !== 'ACTIVE')
                                    <a class="btn btn-success me-1" href="{{ route('admin.activate-plan-paypal', ['id' => $plan->id]) }}">Activate</a>
                                @endif
                                <a href="{{ route('admin.list-plan-paypal') }}" class="btn btn-outline-secondary waves-effect">Back</a>
                            </div>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('page-script')

<script>
   
</script>
@endsection