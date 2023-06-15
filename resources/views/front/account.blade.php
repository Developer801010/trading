@extends('layouts.frontmaster')
@section('title', 'My Account')

@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/toastr.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/form-validation.css') }}">
@endsection


@section('content')
    <div class="container">
        <section class="dashboard-section">        
            @include('layouts.frontdashboardheader')
    
            @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{Session::get('success')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('resent'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (auth()->user()->email_verified_at == null)
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    Please check your inbox or spam folder for email verification.  If you did not receive the email
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                    </form>
                        
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>    
            @endif
        </section>
        <section class="account-section">
            <h2 class="heading pb-3 pt-3">My Account</h2>
            <form method="post" action="{{route('front.account.store')}}" class="accountForm">
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="{{auth()->user()->first_name}}">
                    </div>
    
                    <div class="col-md-4 mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="{{auth()->user()->last_name}}">
                    </div>
    
                    <div class="col-md-4 mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{auth()->user()->mobile_number}}">
                    </div>
    
                    <div class="col-md-4 mb-3">
                        <label for="last_name" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{auth()->user()->email}}">
                    </div>
    
                    <div class="col-md-4 mb-3">
                        <label for="last_name" class="form-label">Username</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{auth()->user()->name}}">
                    </div>
    
                    <div class="col-md-4 mb-3">
                        <label for="last_name" class="form-label">Member Since</label>
                        <input type="text" readonly class="form-control-plaintext" value="{{auth()->user()->created_at}}">
                    </div>
    
                    <div class="col-md-4 mb-3">
                        <label for="last_name" class="form-label">Current password</label>
                        <input type="text" class="form-control" id="last_name" name="last_name">
                    </div>
    
                    <div class="col-md-4 mb-3">
                        <label for="last_name" class="form-label">New Password</label>
                        <input type="text" class="form-control" id="last_name" name="last_name"">
                    </div>
    
                    <div class="col-md-4 mb-3">
                        <label for="last_name" class="form-label">Confirm Password</label>
                        <input type="text" class="form-control" id="last_name" name="last_name">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-primary text-uppercase">
                            Update
                        </button>
                    </div>
                </div>
            </form>
        </section>
    </div>    
@endsection


@section('page-script')
    <script src="{{ asset('app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
    <script>
        var accountForm = $('.accountForm');
        //   // User Form Validation
        if (accountForm.length) {
            accountForm.validate({
            errorClass: 'error',
            rules: {
                'first_name': {
                    required: true
                },
                'email': {
                    required: true,
                    email: true
                },
                'password': {
                    required: true
                },
                'confirm_password': {
                    required: true,
                    equalTo: '#password'
                },
                'roles': {
                    required: true
                }
            }
            });
        }
    </script>
@endsection