@extends('layouts.front-master')
@section('title', 'My Account')

@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/toastr.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/form-validation.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/extensions/ext-component-sweet-alerts.css') }}">
@endsection


@section('content')
    <div class="container">
        <section class="dashboard-section">        
        </section>
        <section class="account-section">
            <div class="row">
                <div class="col-md-3">
                    @include('layouts.front-dashboard-sidebar')
                </div>
                <div class="col-md-9">
                    <h2 class="heading pb-3 pt-3">Account Detail</h2>
                    @include('layouts.error')
                    
                    <form method="post" action="{{route('front.account.store')}}" class="accountForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="first_name" name="first_name" value="{{auth()->user()->first_name}}" autofocus>
                            </div>
            
                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label">Last Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="last_name" name="last_name" value="{{auth()->user()->last_name}}">
                            </div>
            
                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label">Display Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" value="{{auth()->user()->name}}">
                                <span class="account_display_name">This will be how your name will be displayed in the account section and messaging
                                </span>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label">Email Address</label>
                                <input type="email" class="form-control" disabled id="name" name="name" value="{{auth()->user()->email}}">
                                <span class="account_display_name">This is the email address used for this account. Not editable.</span>
                            </div>
                        </div>
                        
                        <div class="password_box">
                            <div class="row">
                                <h4 class="password_change_title">Password Change</h4>                                
                                <div class="col-md-12 mb-3">
                                    <label for="last_name" class="form-label">Current password <span class="account_display_name">(Leave blank to leave unchanged)</span></label>
                                    <input type="password" id="current_password" name="current_password" class="form-control" value="{{old('current_password')}}" />   
                                    <span class="account_display_name">Your password must be 8 or more characters, at least 1 uppercase and lowercase letter, 1 number, and 1 special character ($#@!%?*-+).</span>                                 
                                </div>                            
                            </div>
    
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="last_name" class="form-label">New Password <span class="account_display_name">(Leave blank to leave unchanged)</span></label>
                                    <input type="password" id="password" name="password" class="form-control" />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="last_name" class="form-label">Confirm Password</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" />
                                </div>
                            </div>                            
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-sub text-uppercase">
                                    Save Changes
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
    <script src="{{ asset('app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
    <script>
        var accountForm = $('.accountForm');
        // User Form Validation
        

    </script>
@endsection