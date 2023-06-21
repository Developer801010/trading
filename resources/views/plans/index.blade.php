@extends('layouts.master')

@section('title', 'Plan Management')

@section('page-style')
@endsection


@section('content')
<div class="card">
    <div class="table-responsive">
        <table class="plan-list-table table">
            <thead class="table-light">
                <tr>
                    <th></th>                        
                    <th>Name</th>
                    <th>Stripe Plan</th>
                    <th>PayPal Plan</th>
                    <th>Price($)</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datas as $key => $data)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td class="name_{{$data->id}}">{{ $data->name }}</td>
                        <td class="stripe_plan_{{$data->id}}">{{ $data->stripe_plan }}</td>
                        <td class="paypal_plan_{{$data->id}}">{{ $data->paypal_plan }}</td>
                        <td class="price_{{$data->id}}">{{ $data->price }}</td>
                        <td>                           
                            <a class="btn btn-primary mr-1 btn_edit" data-id = {{$data->id}}>Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

 <!-- Modal to add new user starts-->
 <div class="modal fade" id="plan-modals" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-plan">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-5 px-sm-5 pt-50">                
                <div class="text-center mb-2">
                    <h1 class="mb-1">Edit Plan</h1>                    
                </div>
                
                <form id="planForm" action="{{ route('plans.update', ['plan' => '__id__']) }}" class="edit-plan row gy-1 pt-75" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="col-12 col-md-6">                        
                        <label class="form-label" for="name">name</label>
                        <input type="text" class="form-control name" id="name" placeholder="" name="name" />
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="email">Stripe Plan</label>
                        <input type="text" id="stripe_plan" class="form-control" placeholder="" name="stripe_plan" />
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label" for="email">PayPal Plan</label>
                        <input type="text" id="paypal_plan" class="form-control" name="paypal_plan" />
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label" for="email">Price</label>
                        <input type="text" id="price" class="form-control date-mask" name="price" />
                    </div>
 
                    <div class="col-12 text-center mt-2 pt-50">
                        <button type="submit" class="btn btn-primary me-1">Update</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                            Discard
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal to add new user Ends-->
@endsection

@section('page-script')

<script>
  $('.btn_edit').click(function (e) { 
    $('#plan-modals').modal('show');
    let id = $(this).data('id');

    var planFormAction = $('#planForm').attr('action').replace('__id__', id);
    $('#planForm').attr('action', planFormAction);
    
    $("#name").val($('.name_'+id).text());
    $("#stripe_plan").val($('.stripe_plan_'+id).text());
    $("#paypal_plan").val($('.paypal_plan_'+id).text());
    $("#price").val($('.price_'+id).text());
  });
</script>
@endsection