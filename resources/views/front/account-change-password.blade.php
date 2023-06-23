@extends('layouts.front-master')
@section('title', 'Password')

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
                    <h2 class="heading pb-3 pt-3">Password</h2>
                    @include('layouts.error')
                    
                    <form method="post" action="{{route('front.account-change-password-process')}}" class="changePasswordForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-5 mb-3">
                                <label for="last_name" class="form-label">Current password</label>
                                <input type="password" id="current_password" name="current_password" class="form-control" autofocus />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5 mb-3">
                                <label for="last_name" class="form-label">New Password</label>
                                <input type="password" id="new_password" name="new_password" class="form-control" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5 mb-3">
                                <label for="last_name" class="form-label">Confirm Password</label>
                                <input type="password" id="confirm_password" name="confirm_password" class="form-control" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-sub text-uppercase">
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
           
        </section>
    </div>    
@endsection


@section('page-script')
    <script src="{{ asset('app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
    <script>
        var changePasswordForm = $('.changePasswordForm');
        //   // User Form Validation
        if (changePasswordForm.length) {
            changePasswordForm.validate({
                errorClass: 'error',
                rules: {
                    'current_password': {
                        required: true
                    },
                    'new_password': {
                        required: true
                    },
                    'confirm_password': {
                        required: true,
                        equalTo: '#new_password'
                    },
                   
                }
            });
        }

    </script>
@endsection