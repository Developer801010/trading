@extends('layouts.front-master')
@section('title', 'Notification')

@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/toastr.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/form-validation.css') }}">
@endsection


@section('content')
    <div class="container">
        <section class="dashboard-section">        
            @include('layouts.front-dashboard-header')
            @include('layouts.front-email-verify')
           
        </section>
        <section class="account-section">
            <div class="row">
                <div class="col-md-3">
                    @include('layouts.front-dashboard-sidebar')
                </div>
                <div class="col-md-9">
                    <h2 class="heading pb-3 pt-3">Membership</h2>
                    
                    @if ($member_date)
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="last_name" class="form-label">Member Since: </label> 
                                {{ $member_date }}
                            </div>
                            <div class="col-md-12">
                                <label for="last_name" class="form-label">Account will cancel on </label> 
                                {{ $account_cancel_date }}
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Membership level:</label> {{ $membership_level }}
                            </div>
                            <div class="col-md-12">
                                <a href="#" class="btn_member_cancel">Membership cancel</a>
                            </div>
                        </div>    

                        <div class="table-responsive">
                            <table class="list-table table">
                                <thead class="table-light">
                                    <tr>
                                        <th>Order#</th=>                        
                                        <th>Order Date</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                        <th>Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order_datas as $data)
                                        <tr>
                                            <td>{{ $data->id }}</td>
                                            <td>{{ \Carbon\Carbon::parse($data->created_at)->format('F j, Y') }}</td>
                                            <td>{{ $data->name }}</td>
                                            <td>${{ getPlanPrice(getPaymentType( $data->name )) }}</td>
                                            <td>{{ getPaymentType( $data->name ) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>    

                    @else
                        <p>There isn't activated subscription</p>
                    @endif
                </div>
            </div>
           
        </section>
    </div>    
@endsection


@section('page-script')
    <script src="{{ asset('app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
    <script>
       
    </script>
@endsection