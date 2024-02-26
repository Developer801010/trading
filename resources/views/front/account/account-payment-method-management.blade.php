@extends('layouts.front-master')
@section('title', 'My Account')

@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/form-validation.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/extensions/ext-component-sweet-alerts.css') }}">
    <style>
        .btn-payment{
            margin-top: 15px;
        }

        .payment-tooltip{
            position: absolute;
            z-index: 1;
            width: 200px;
            color: #000;
            font-size: 16px;
            background-color: #fff;
            border-radius: 20px;
            padding: 20px !important;
            box-shadow: rgba(100,100,111,.2) 0px 7px 29px 0px;
            border-radius: 20px;
            top: 0;
            left: 100px;
        }
    </style>
@endsection


@section('content')
    <!-- MAIN -->
    <main class="main-wrapper">
        <div class="main-feed">
            <div class="container-lg">
                <div class="row">
                    <div class="col-lg-3">
                        @include('layouts.front-dashboard-sidebar')
                    </div>
                    <div class="col-lg-9">
                        <div class="tab-card">
                            <div class="tab-card-header">Payment Method</div>
                            <div class="tab-card-body">
                                @include('layouts.error')
                                <div class="row g-3">
                                    @if(isset($paymentMethods) && !empty($paymentMethods))
                                        @foreach ($paymentMethods as $paymentMethod)
                                            <div class="col-md-6 col-lg-12 col-xl-6">
                                                <div class="add-card">
                                                    <div class="card-head">
                                                        <div class="card-holder-name">John</div>
                                                        <div>
                                                            <label class="radio-button-container">
                                                                <input type="radio" name="radio" value="Primary" hidden @if ($defaultPaymentMethod && $paymentMethod->id === $defaultPaymentMethod->id) checked @endif>
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="about-card">
                                                        {{-- <div class="card-img"><img src="images/mastercard.png"></div> --}}
                                                        <div class="card-detail">
                                                            <h6>{{$paymentMethod->card->brand}} ending in {{$paymentMethod->card->last4}}</h6>
                                                            <span>Card expires at {{sprintf('%02d/%02d', $paymentMethod->card->exp_month, $paymentMethod->card->exp_year % 100)}}</span>
                                                        </div>
                                                        <div class="card-delete-btn ms-auto">
                                                            <form method="post" class="btn_payment_delete_form" action="{{ route('front.account-delete-card', ['id'=>$paymentMethod->id]) }}">
                                                                @csrf
                                                                @method('delete')
                                                                <button type="submit" class="btn btn-dang px-3">Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                        <div class="add-card">
                                            <div class="add-card-detail">
                                                <div class="card-txt">
                                                    <h4>Add Card</h4>
                                                    <span>Add your payment card</span>
                                                </div>
                                                <div>
                                                    <a class="btn btn-grn" data-bs-toggle="modal" data-bs-target="#Addcard">Add Card</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="overlay" style="display: none;"></div>

                <div id="loadingSpinner" style="display: none;">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Please wait while we add a new card...
                </div>
            </div>
        </div>
    </main>
    <!-- MAIN -->
@endsection


@section('page-script')
<!-- ADD CARD MODAL -->
<div class="modal fade msg-modal" id="Addcard" tabindex="-1" aria-labelledby="AddcardLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <form id="payment-form" action="{{ route('front.account-add-card') }}" method="POST" class="usr-form payment-form">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="AddcardLabel">Add New Card</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="card-element"></div>
                    <div id="card-errors" role="alert"></div>
                    {{-- <div class="mb-3">
                        <label class="mb-2">Card Holder Name</label>
                        <input class="form-control"name="card-holders-name" placeholder="Name on card">
                    </div>
                    <div class="mb-3">
                        <label class="mb-2">Card Number</label>
                        <input class="form-control" name="card-number" placeholder="Enter Card Number">
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="mb-2">Expiry Date</label>
                                <input class="form-control" name="expiry-date" placeholder="MM/YY">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="mb-2">CVV</label>
                                <input class="form-control" name="cvc" placeholder="CVV">
                            </div>
                        </div>
                    </div> --}}

                    <!-- <div class="card-js" id="example"></div> -->
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="isPaymentFormExpanded" value="{{ old('isPaymentFormExpanded') ? 'true' : 'false' }}">
                    <button class="btn btn-gray px-4 py-2 fs-14 fw-semibold">Cancel</button>
                    <button class="btn btn-grn px-4 py-2 fs-14 fw-semibold">Add payment method</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ADD CARD MODAL -->
    <script src="https://js.stripe.com/v3/"></script>
    {{-- <script src="{{ asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script> --}}
    <script src="{{asset('app-assets/vendors/js/forms/cleave/cleave.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/forms/cleave/addons/cleave-phone.us.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
    <script src="{{ asset('app-assets/js/scripts/extensions/ext-component-sweet-alerts.js') }}"></script>
    <script>
        var paymentForm = $('.payment-form');
        // var accountForm = $('.accountForm');
        // var creditCard = $('.credit-card-mask');
        // var expiryDateMask = $('.expiry-date-mask');
        // var cvvMask = $('.cvv-code-mask');
        // var assetsPath = '{{ asset("assets") }}';
        var stripe = Stripe('{{ config('services.stripe.publish_key') }}');

    // Create an instance of Elements
        var elements = stripe.elements();
        var style = {
            base: {
                color: '#242424',
                lineHeight: '24px',
                fontFamily: '"Lato", sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                color: '#D4D4D4'
                }
            },
            invalid: {
                color: '#FF0033',
                iconColor: '#FF0033'
            }
        };
        // Create an instance of the card Element
        var card = elements.create('card', {
            style: style,
            hidePostalCode: true
        });

        // Add an instance of the card Element into the `card-element` <div>
        card.mount('#card-element');

        // Handle real-time validation errors from the card Element.
        card.addEventListener('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        paymentForm.submit(function(event) {
            event.preventDefault();
            stripe.createToken(card).then(function(result) {
                if (result.error) {
                // Display an error message to the user.
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;

                } else {
                    // You can now use the Payment Method ID on your server to make a payment.
                    stripeTokenHandler(result.token.id);
                    $('#overlay, #loadingSpinner').show();
                }
            });
        });

        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var payment_form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'token');
            hiddenInput.setAttribute('value', token);
            payment_form.appendChild(hiddenInput);
            // Submit the form
            payment_form.submit();
        }

        // User Form Validation
        // Credit Card
        // if (creditCard.length) {
        //     creditCard.each(function () {
        //         new Cleave($(this), {
        //             creditCard: true,
        //             onCreditCardTypeChanged: function (type) {
        //             const elementNodeList = document.querySelectorAll('.card-type');
        //                 if (type != '' && type != 'unknown') {
        //                     //! we accept this approach for multiple credit card masking
        //                     for (let i = 0; i < elementNodeList.length; i++) {
        //                     elementNodeList[i].innerHTML =
        //                         '<img src="' + assetsPath + '/image/icons/payments/' + type + '-cc.png" height="24"/>';
        //                     }
        //                 } else {
        //                     for (let i = 0; i < elementNodeList.length; i++) {
        //                         elementNodeList[i].innerHTML = '';
        //                     }
        //                 }
        //             }
        //         });
        //     });
        // }

        // Expiry Date Mask
        // if (expiryDateMask.length) {
        //     new Cleave(expiryDateMask, {
        //         date: true,
        //         delimiter: '/',
        //         datePattern: ['m', 'Y']
        //     });
        // }

        // CVV
        // if (cvvMask.length) {
        //     new Cleave(cvvMask, {
        //         numeral: true,
        //         numeralPositiveOnly: true
        //     });
        // }



        // $.validator.addMethod('expiryDate', function(value, element) {
        //     // Get the current date
        //     var currentDate = new Date();

        //     // Split the expiration date into month and year
        //     var expiryDate = value.split('/');
        //     var expiryMonth = parseInt(expiryDate[0], 10);
        //     var expiryYear = parseInt(expiryDate[1], 10);


        //     // Compare the expiry date with the current date
        //     if (expiryYear > currentDate.getFullYear()) {
        //         return true;
        //     } else if (expiryYear === currentDate.getFullYear() && expiryMonth >= currentDate.getMonth() + 1) {
        //         return true;
        //     } else {
        //         return false;
        //     }
        // }, 'Card expiration date must be in the future.');

        // Add the custom validation rule to the validator
        // $.validator.addClassRules('expiry-validation', {
        //     expiryDate: true
        // });


        // if(paymentForm.length){
        //     paymentForm.validate({
        //         errorClass: 'error',
        //         rules: {
        //             'card-name': {
        //                 required: true
        //             },
        //             'card-number': {
        //                 required: true,
        //             },
        //             'card-cvc': {
        //                 required: true,
        //                 maxlength: 5
        //             },
        //             'card-expire-date': {
        //                 required:true,
        //                 expiryDate: true
        //             }
        //         },
        //         messages: {
        //             'card-expire-date': {
        //                 expiryDate: 'Card expiration date must be in the future.'
        //             }
        //         },
        //         submitHandler: function(form) {
        //             $('.btn-payment').prop('disabled', true);
        //             form.submit(); // Submit the form
        //         }
        //     });
        // }

    </script>
@endsection
