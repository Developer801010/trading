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
            @include('layouts.front-dashboard-header')
    
            @include('layouts.front-email-verify')
        </section>
        <section class="account-section">
            <div class="row">
                <div class="col-md-3">
                    @include('layouts.front-dashboard-sidebar')
                </div>
                <div class="col-md-9">
                    <h2 class="heading pb-3 pt-3">Profile Details</h2>
                    @include('layouts.error')
                    
                    @if ($member_date)
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="last_name" class="form-label">Member Since: </label> {{ \Carbon\Carbon::parse($member_date)->format('F j, Y h:i A')}}
                            </div>
                        </div>    
                    @endif
                    
                    <form method="post" action="{{route('front.account.store')}}" class="accountForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" value="{{auth()->user()->first_name}}" autofocus>
                            </div>
            
                            <div class="col-md-4 mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" value="{{auth()->user()->last_name}}">
                            </div>
            
                            <div class="col-md-4 mb-3">
                                <label for="last_name" class="form-label">Username</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{auth()->user()->name}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <div class="input-group">
                                    <input type="text" class="form-control phone-number-mask @if($mobileVerifiedStatus !== null) is-valid @else is-invalid @endif"
                                    id="phone" name="phone" value="{{auth()->user()->mobile_number}}">                                    
                                    @if($mobileVerifiedStatus !== null)                                        
                                        <div class="valid-feedback phone_verified_alarm">Verified.</div>
                                    @else
                                        <button class="btn btn-outline-primary waves-effect" id="btn_mobile_verification" type="button">Verify</button>
                                        <div class="invalid-feedback phone_verified_alarm">It's unverified. You have to verify it to get the notificaiton through the mobile.</div>
                                    @endif
                                </div>
                            </div>     
                            @if($mobileVerifiedStatus == null) 
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Verification Code</label>
                                    <input type="text" class="form-control" id="phone-verification-code" name="phone-verification-code" value="">
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
    <script src="{{ asset('app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
    <script>
        var accountForm = $('.accountForm');
        var btn_mobile_verification = $('#btn_mobile_verification')
        //   // User Form Validation
        if (accountForm.length) {
            accountForm.validate({
                errorClass: 'error',
                rules: {
                    'first_name': {
                        required: true
                    },
                    'last_name': {
                        required: true,
                    },
                    'name': {
                        required: true
                    },
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

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        btn_mobile_verification.on('click', function(){
            let phone = $('#phone').val();
            var countdownSeconds = 60;
            var countdownInterval;

            if(phone === ''){
                Swal.fire({
                    title: 'Error!',
                    text: ' Please insert Phone number!',
                    icon: 'error',
                    customClass: {
                    confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false
                });
            }else{
                $.ajax({
                    url: "{{ route('front.account.send-verification-code') }}",
                    type: "POST",                    
                    data: {phone: phone},
                    dataType: "json",
                    success: function (response) {
                        $(this).prop('disabled', true); // Disable the button on click
                            countdownInterval = setInterval(function() {
                            countdownSeconds--;
                            btn_mobile_verification.text('Countdown: ' + countdownSeconds + 's');

                            if (countdownSeconds <= 0) {
                                clearInterval(countdownInterval);
                                btn_mobile_verification.prop('disabled', false); // Enable the button
                                btn_mobile_verification.text('Verify');
                                countdownSeconds = 60;
                            }
                        }, 1000);

                        Swal.fire({
                            title: 'Good job!',
                            text: 'Please check your Phone',
                            icon: 'success',
                            customClass: {
                            confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false
                        });
                    },           
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            }
        })

        $('#phone-verification-code').keyup(function (e) { 
            let phone_code = $(this).val()
            let codeLength = phone_code.length;
            if(codeLength >=6 ){
                console.log(phone_code);
                $.ajax({
                    url: "{{ route('front.account.verify-phone-code') }}",
                    type: "POST",                    
                    data: {phone_code: phone_code},
                    dataType: "json",
                    success: function (response) {
                        if(response.status == 'success'){
                            Swal.fire({
                                title: 'Good job!',
                                text: 'The phone number is verified',
                                icon: 'success',
                                customClass: {
                                confirmButton: 'btn btn-primary'
                                },
                                buttonsStyling: false
                            });

                            $("#phone").removeClass('is-invalid').addClass('is-valid')
                            $('.phone_verified_alarm').removeClass('invalid-feedback').addClass('valid-feedback').text('Verified');
                        }else{
                            Swal.fire({
                                title: 'Error!',
                                text: ' Please insert Phone number!',
                                icon: 'error',
                                customClass: {
                                confirmButton: 'btn btn-primary'
                                },
                                buttonsStyling: false
                            });
                        }
                        
                    },           
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            }
        });
    </script>
@endsection