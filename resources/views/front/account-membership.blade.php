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
                        </div>    

                        <div class="table-responsive">
                            <table class="list-table table">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 5%">Order#</th>                        
                                        <th style="width: 12.5%">Order Date</th>
                                        <th style="width: 12.5%">Description</th>
                                        <th style="width: 12.5%">Amount</th>
                                        <th style="width: 12.5%">Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>0</td>
                                        <td>1</td>
                                        <td>2</td>
                                        <td>3</td>
                                        <td>4</td>
                                    </tr>
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