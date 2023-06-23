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
                    <h2 class="heading pb-3 pt-3">Notification</h2>
                    
                    <form method="post" action="{{route('front.account.store')}}" class="notifyForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <div class="input-group">
                                    <input type="text" class="form-control phone-number-mask @if($mobileVerifiedStatus !== null) is-valid @else is-invalid @endif"
                                    id="phone" name="phone" value="{{auth()->user()->mobile_number}}">                                    
                                    @if($mobileVerifiedStatus !== null)                                        
                                        <div class="valid-feedback">Verified.</div>
                                    @else
                                        <button class="btn btn-outline-primary waves-effect" id="btn_mobile_verification" type="button">Verify</button>
                                        <div class="invalid-feedback">It's unverified. You have to verify it to get the notificaiton through the mobile.</div>
                                    @endif
                                </div>
                            </div>     
                            @if($mobileVerifiedStatus == null) 
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Verification Code</label>
                                    <input type="text" class="form-control" id="phone" name="phone" value="">
                                </div>   
                            @endif                                     
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label">Email</label>
                                <input type="email" class="form-control @if($emailVerifiedStatus !== null) is-valid @else is-invalid @endif" 
                                id="email" name="email" value="{{auth()->user()->email}}">
                                @if($emailVerifiedStatus !== null)
                                    <div class="valid-feedback">Verified.</div>
                                 @else
                                    <div class="invalid-feedback">Unverified.</div>
                                 @endif
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
    <script src="{{ asset('app-assets/vendors/js/forms/cleave/cleave.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/forms/cleave/addons/cleave-phone.us.js') }}"></script>
    <script>
        var notifyForm = $('.notifyForm');
        //   // User Form Validation
        if (notifyForm.length) {
            notifyForm.validate({
                errorClass: 'error',
                rules: {
                    'phone': {
                        required: true
                    },
                    'email': {
                        required: true,
                        email: true
                    }
                }
            });
        }

        phoneMask = $('.phone-number-mask');
        if (phoneMask.length) {
            new Cleave(phoneMask, {
                phone: true,
                phoneRegionCode: 'US'
            });
        }
    </script>
@endsection