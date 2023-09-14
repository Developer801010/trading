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
                    
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Method</th>
                                <th>Expires</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($paymentMethods !== null)
                                @foreach ($paymentMethods as $paymentMethod)
                                    <tr>
                                        <td class="align-middle">{{$paymentMethod->card->brand}} ending in {{$paymentMethod->card->last4}}</td>
                                        <td class="align-middle">{{sprintf('%02d/%02d', $paymentMethod->card->exp_month, $paymentMethod->card->exp_year % 100)}}</td>
                                        <td style="position: relative;">
                                            <form method="post" class="btn_payment_delete_form"  style="display: inline;"
                                            action = "{{ route('front.account-delete-card', ['id'=>$paymentMethod->id]) }}">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger btn_payment_delete">
                                                    Delete
                                                </button>                                                
                                            </form>
                                            @if ($defaultPaymentMethod && $paymentMethod->id === $defaultPaymentMethod->id)
                                                <span class="text-primary">(Default)</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach                                
                            @else
                                <tr class="text-center">
                                    <td colspan="3">There is no available payment method</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <p>                       
                        <a class="text-danger" data-bs-toggle="collapse" href="#PaymentForm" role="button" aria-expanded="false" aria-controls="PaymentForm">
                            Add payment method
                        </a>
                    </p>

                    <div class="collapse {{ old('isPaymentFormExpanded') ? 'show' : '' }}" id="PaymentForm">
                        <div class="card card-body">
                            
                            <form class="payment-form mt-2" id="payment-form" action="{{ route('front.account-add-card') }}" method="POST">
                                {{ csrf_field() }}
                                <div id="card-element"></div>
                                <div id="card-errors" role="alert"></div>

                                {{-- <div class="row mb-2">
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label" for="addCardCvv">Nmae on Card</label>
                                        <input type="text" id="card-name" name="card-name" class="form-control" value="{{ old('card-name', '') }}" placeholder="John" />
                                    </div>

                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label" for="addCardNumber">Card Number</label>                                        
                                        <input id="card-number" name="card-number" class="form-control credit-card-mask" type="text" placeholder="1356 3215 6548 7898" 
                                        aria-describedby="addCard" value="{{old('card-number')}}" />
                                    </div>

                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label" for="addCardCvv">CVC</label>
                                        <input type="text" id="card-cvc" name="card-cvc" class="form-control cvv-code-mask"  value="{{old('card-cvc')}}"  placeholder="123" />
                                    </div>

                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label" for="addCardExpiryDate">Exp. Date</label>
                                        <input type="text" id="card-expire-date" name="card-expire-date" class="form-control expiry-date-mask"  value="{{old('card-expire-date')}}" placeholder="MM/YYYY" />
                                    </div>
                                </div> --}}
                                <div class="row">
                                    <div class="col-auto">
                                        <input type="hidden" name="isPaymentFormExpanded" value="{{ old('isPaymentFormExpanded') ? 'true' : 'false' }}">
                                        <button class="btn btn-danger w-100 text-uppercase btn-payment">Add payment method</button>
                                    </div>
                                </div>
                            </form>    
                        </div>
                    </div>
                </div>
            </div>
            <div id="overlay" style="display: none;"></div>

            <div id="loadingSpinner" style="display: none;">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Please wait while we add a new card...
            </div>
        </section>
    </div>    
@endsection


@section('page-script')
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