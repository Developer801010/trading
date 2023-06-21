@extends('layouts.master')

@section('title', 'Plan Management')

@section('page-style')
@endsection


@section('content')
<div class="card">
    <div class="table-responsive">
        <table class="paypal-plan-list-table table">
            <thead class="table-light">
                <tr>
                    <th></th>                        
                    <th>ID</th>
                    <th>State</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($plans->plans as $key => $data)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>@if($data->state == 'ACTIVE'){{ $data->id }}@endif</td>
                        <td>
                            @if($data->state == 'ACTIVE')
                                <span class="text-success">{{ $data->state }}</span>
                            @elseif ($data->state == 'CREATED')
                                <span class="text-primary">{{ $data->state }}</span>
                            @endif
                        </td>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->description }}</td>
                        <td>                           
                            <a class="btn btn-primary mr-1" href="{{ route('admin.show-plan-paypal', ['id' => $data->id]) }}">Show</a>
                            @if($data->state !== 'ACTIVE')
                                <a class="btn btn-success mr-1" href="{{ route('admin.activate-plan-paypal', ['id' => $data->id]) }}">Activate</a>
                            @endif
                            {!! Form::open(['method' => 'DELETE', 'class' => 'delete_form', 'route' => ['admin.delete-plan-paypal', $data->id],'style'=>'display:inline']) !!}
                                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="billing-modals" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-5 px-sm-5 pt-50">                
                <div class="text-center mb-2">
                    <h1 class="mb-1">Add New Billing Plan</h1>                    
                </div>
                
                <form action="{{ route('admin.create-plan-paypal') }}" class="add-new-billing-plan row gy-1 pt-75" method="POST">
                    @csrf
                    <div class="col-12 col-md-6">                        
                        <label class="form-label" for="plan_name">Plan Name</label>
                        <input type="text" class="form-control plan_name" id="plan_name" placeholder="" name="plan_name" />
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="plan_description">Plan Description</label>
                        <input type="text" id="plan_description" class="form-control" placeholder="" name="plan_description" />
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label" for="plan_frequency">Frequency</label>
                        <select class="form-control" id="plan_frequency" name="plan_frequency">
                            <option value="Day">Day</option>
                            <option value="Week">Week</option>
                            <option value="Month">Month</option>
                            <option value="Year">Year</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label" for="plan_frequency_interval">Frequency Interval</label>
                        <input type="number" id="plan_frequency_interval" class="form-control" name="plan_frequency_interval" value="1" />
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label" for="plan_price">Price</label>
                        <input type="number" id="plan_price" class="form-control" name="plan_price" />
                    </div>

                    <div class="col-12 text-center mt-2 pt-50">
                        <button type="submit" class="btn btn-primary me-1">Save</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                            Discard
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal to add new plan Ends-->
@endsection

@section('page-script')

<script>
  
</script>
@endsection