@extends('layouts.front-master')
@section('title', 'Notification Setup')

@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/toastr.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/form-validation.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/extensions/ext-component-sweet-alerts.css') }}">
@endsection


@section('content')
    <div class="container">
        <section class="dashboard-section">        
    
            {{-- @include('layouts.front-email-verify') --}}
        </section>
        <section class="account-section">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <h2 class="heading pb-3 pt-3 text-uppercase text-center">Notificaiton Setup</h2>
                    @include('layouts.error')
                    
                    <h4 class="text-uppercase text-center mb-3">SMS notification</h4>
                    <p>If you opt-in, SMS notifications will be sent to the number provided below. You can opt out at any by replying to any message with “CANCEL” or unsubscribing through this form. Carrier rates may apply.</p>
                    
                    <form method="post" action="{{route('front.account.send-verification-code')}}" id="SMSForm">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="phone" class="form-label">Your Mobile Number:</label>
                                <div class="input-group">                                    
                                    <input type="text" class="form-control phone-number-mask"
                                    id="phone" name="phone" value="{{auth()->user()->mobile_number}}">               
                                    <span class="phone-error error d-none">This field is required.</span>      

                                    <input type="hidden" value="{{$mobileVerifiedStatus}}" name="mobileVerifiedStatus" id="mobileVerifiedStatus">                                   
                                    <input type="hidden" value="{{$mobileNotificationSetting}}" name="mobileNotificationSetting" id="mobileNotificationSetting">                                   
                                </div>
                            </div>     
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button class="btn @if($mobileNotificationSetting == 1) btn-danger @else btn-sub @endif text-uppercase btn_subscribe">
                                    @if($mobileNotificationSetting == 1) Unsubscribe @else Subscribe @endif
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>           
        </section>

        <div class="modal fade" id="verificationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Verification</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="phone" class="form-label">Verification Code</label>
                    <input type="text" class="form-control" id="phone-verification-code" name="phone-verification-code" value="">            
                    <span class="text-danger account_display_name verification_text">The Code was send to your phone number.  it will be available for 60s</span>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
    </div>    
@endsection




@section('page-script')
    <script src="{{ asset('app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/forms/cleave/cleave.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/forms/cleave/addons/cleave-phone.us.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
    <script>
        var SMSForm = $('#SMSForm');
        var isValid = true;
        var btn_subscribe = $('.btn_subscribe');
        //   // User Form Validation

        phoneMask = $('.phone-number-mask');
        if (phoneMask.length) {
            new Cleave(phoneMask, {
                phone: true,
                phoneRegionCode: 'US'
            });
        }

        $(document).ready(function() {
            var countdownSeconds = 60;
            var countdownInterval;
            var mobileVerifiedStatus = $("#mobileVerifiedStatus").val();
            var mobileNotificationSetting = $("#mobileNotificationSetting").val();
            SMSForm.submit(function(e) {               

                e.preventDefault(); // Prevent the form from submitting normally
                var data = {
                    _token: window.csrfToken,
                    mobileVerifiedStatus: mobileVerifiedStatus,
                    mobileNotificationSetting: mobileNotificationSetting,
                    phone: $('#phone').val()
                }

                btn_subscribe.prop('disabled', true);

                if($('#phone').val() == ''){
                    isValid = false;
                    $('#phone').addClass('error');
                    $('.phone-error').removeClass('d-none');
                }else{
                    $('#phone').removeClass('error');
                }


                // Perform AJAX request to process the form
                if(isValid)
                {
                    if(mobileNotificationSetting == 1)
                    {
                         //if mobile notificaiton was set, it will unsubscribe.  
                         Swal.fire({
                            title: 'Are you sure?',
                            text: "You won't be able to get the notfication!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, confirm it!',
                            customClass: {
                                confirmButton: 'btn btn-primary',
                                cancelButton: 'btn btn-outline-danger ms-1'
                            },
                            buttonsStyling: false
                        }).then(function (result) {
                            if (result.value) {
                                $.ajax({
                                    url: "{{route('front.account.send-verification-code')}}",
                                    type: 'POST',
                                    data: data,
                                    success: function(response) {   
                                        if(response.status == 'success'){
                                            Swal.fire({
                                                title: 'Good job!',
                                                text: response.msg,
                                                icon: 'success',
                                                customClass: {
                                                    confirmButton: 'btn btn-primary'
                                                },
                                                buttonsStyling: false
                                            });

                                            setTimeout(() => {
                                                location.reload();
                                            }, 2000);
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        // Handle error
                                    }
                                });
                            }else{
                                btn_subscribe.prop('disabled', false);
                            }
                        });
                    }else{
                        $.ajax({
                            url: $(this).attr('action'),
                            type: $(this).attr('method'),
                            data: data,
                            success: function(response) {   
                                btn_subscribe.prop('disabled', false);
                                if(mobileVerifiedStatus == 'no'){
                                    // Open the modal box
                                    openModal();
                                    countdownInterval = setInterval(function() {
                                        countdownSeconds--;
                                        $('.verification_text').text('The Code was sent to your phone number.  it will be available for : ' + countdownSeconds + 's');

                                        if (countdownSeconds <= 0) {
                                            clearInterval(countdownInterval);
                                            $('.verification_text').text('');
                                            countdownSeconds = 60;
                                            closeModal();
                                            btn_subscribe.prop('disabled', false);
                                        }
                                    }, 1000);                                 
                                }else{
                                    //if mobile is already verified
                                    Swal.fire({
                                        title: 'Good job!',
                                        text: response.msg,
                                        icon: 'success',
                                        customClass: {
                                            confirmButton: 'btn btn-primary'
                                        },
                                        buttonsStyling: false
                                    });

                                    setTimeout(() => {
                                        location.reload();
                                    }, 2000);
                                }                 
                            },
                            error: function(xhr, status, error) {
                                // Handle error
                            }
                        });
                    }
                    
                   
                    
                }else{
                    btn_subscribe.prop('disabled', false);
                }
            }); 
        });

        function openModal()
        {
            $('#verificationModal').modal('show');
        }

        function closeModal()
        {
            $('#verificationModal').modal('hide');
        }

        $('#phone-verification-code').keyup(function (e) { 
            let phone_code = $(this).val()
            let codeLength = phone_code.length;
            if(codeLength >=6 )
            {
                var data = {
                    phone_code: phone_code,
                    _token: window.csrfToken
                }
                $.ajax({
                    url: "{{ route('front.account.verify-phone-code') }}",
                    type: "POST",                    
                    data: data,
                    dataType: "json",
                    success: function (response) {                        
                        if(response.status == 'success'){
                            closeModal();
                            Swal.fire({
                                title: 'Good job!',
                                text: response.msg,
                                icon: 'success',
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                },
                                buttonsStyling: false
                            });
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        }else{
                            Swal.fire({
                                title: 'Error!',
                                text: response.msg,
                                icon: 'error',
                                customClass: {
                                confirmButton: 'btn btn-primary'
                                },
                                buttonsStyling: false
                            });
                        }
                        btn_subscribe.prop('disabled', false);
                    },           
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            }
        });
    </script>
@endsection