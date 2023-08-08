@extends('layouts.front-master')
@section('title', 'Checkout')

@section('page-style')
<style>
    .input-group-text{
        padding: 0;
    }
</style>
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/plugins/forms/form-validation.css')}}">
@endsection


@section('content')
    <div class="container">        
        <section class="checkout-section">
            <h1 class="text-center checkout-title ">
                <span class="subscription_type_title">
                    {{$subscription_type}}</span> Checkout 
                    ($<span class="price">{{$price}}</span>/<span class="period">{{$units}}</span> )
            </h1>
            <div class="row">
                <div class="col-md-12">
                    <p> Returning customer?
                        <a class="text-danger" data-bs-toggle="collapse" href="#LoginForm" role="button" aria-expanded="false" aria-controls="LoginForm">
                            Click here to login
                        </a>
                    </p>
                    <div class="collapse {{ old('isLoginFormExpanded') ? 'show' : '' }}" id="LoginForm">
                        <div class="card card-body">
                            <p>If you have shopped with us before, please enter your details below. If you are a new customer, please proceed to the Billing section.</p>
                            
                            <form class="auth-login-form mt-2" action="{{ route('login') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-5  mb-3">
                                        <label for="login-email" class="form-label">Email</label>
                                        <input type="email" class="form-control"
                                                            id="email" placeholder="Email" name="email"
                                                            value="{{ old('email') }}" required autofocus>
                                    </div>
                        
                                    <div class="col-md-5  mb-3">
                                        <div class="d-flex justify-content-between">
                                            <label class="form-label" for="login-password">Password</label>
                                            <a href="{{ url('/password/reset') }}">
                                                <small>Forgot Password?</small>
                                            </a>
                                        </div>
                                        <div class="input-group input-group-merge form-password-toggle">
                                            <input type="password" class="form-control form-control-merge" required
                                                id="password" name="password" 
                                                aria-describedby="login-password" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-auto">
                                        <input type="hidden" name="isLoginFormExpanded" value="{{ old('isLoginFormExpanded') ? 'true' : 'false' }}">
                                        <button class="btn btn-primary w-100">Sign in</button>
                                    </div>
                                </div>
                            </form>    
                            
                        </div>
                    </div>

                </div>
            </div>
            <form method="post" action="{{ route('front.payment.process') }}" id="payment-form">
                @csrf
                
                <input type="hidden" name="stripe_plan_id" id="stripe_plan_id" 
                value="@if ($units == 'mo') {{$month_plan['stripe_plan']}} @elseif ($units == 'qu') {{$quarter_plan['stripe_plan']}}  @elseif($units == 'yr' ) {{$year_plan['stripe_plan']}} @endif" />

                <input type="hidden" name="paypal_plan_id" id="paypal_plan_id" 
                value="@if ($units == 'mo') {{$month_plan['paypal_plan']}} @elseif ($units == 'qu') {{$quarter_plan['paypal_plan']}}  @elseif($units == 'yr' ) {{$year_plan['paypal_plan']}} @endif" />

                <input type="hidden" name="price" id="price" value="{{$price}}" />

                <input type="hidden" name="period" id="period" value="{{$units}}" />
                
                @include('layouts.error')

                <div class="row">
                    <div class="col-md-8">
                        <div class="account-box white-box">
                            <h4 class="checkout-subtitle">Creae an account</h4>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="email">First Name</label>
                                    <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name" value="{{old('first_name')}}" />
                                    <span class="first-name-error error d-none">This field is required.</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="email">Last Name</label>
                                    <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name" value="{{old('last_name')}}" />
                                    <span class="last-name-error error d-none">This field is required.</span>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Email Address" value="{{old('email')}}" />
                                    <span class="email-error error d-none">This field is required.</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="mobile_number">Mobile number</label>
                                    <input type="text" name="mobile_number" id="mobile_number" class="form-control mobile-number-mask" placeholder="Mobile Number" value="{{old('mobile_number')}}" />
                                    <span class="mobile-number-error error d-none">This field is required.</span>
                                </div>     

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="password">Password</label>
                                    <div class="input-group input-group-merge form-password-toggle">
                                        <input type="password" name="password" id="password" class="form-control"  value="{{old('password')}}"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                    </div>
                                    <span class="password-error error d-none">This field is required.</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="confirm-password">Confirm Password</label>
                                    <div class="input-group input-group-merge form-password-toggle">
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" 
                                        value="{{old('password_confirmation')}}"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                    </div>
                                    <span class="password-confirmation-error error d-none">This field is required.</span>
                                </div>               
                            </div>
                        </div>
                        <div class="checkout-box white-box">
                            <h4 class="checkout-subtitle">Easy checkout with Stripe or PayPal. All major credit cards accepted.</h4>
                            <div class="payment-options">
                                <div class="stripe-option payment-option payment_active">
                                    <div class="payment_radio">
                                        <input type="radio" name="payment_option" id="stripe" value="stripe" checked>
                                        <label for="stripe">Credit / Debit Cards(Stripe)</label>
                                    </div>
                                    <img class="payment-image stripe-image" src="{{asset('assets/image/stripe.png')}}" />
                                </div>
        
                                <div class="paypal-option payment-option">
                                    <div class="payment_radio">
                                        <input type="radio" name="payment_option" id="paypal" value="paypal">
                                        <label for="paypal">PayPal</label>
                                    </div>
                                    <img class="payment-image paypal-image" src="{{asset('assets/image/paypal.png')}}" />                            
                                </div>
                            </div>
                            <div class="stripe_payment">
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-1">
                                        <label class="form-label" for="addCardNumber">Card Number</label>
                                        <div class="input-group input-group-merge">
                                            <input id="card-number" name="card-number" class="form-control credit-card-mask" type="text" placeholder="1356 3215 6548 7898" 
                                            aria-describedby="addCard" data-msg="Please enter your credit card number" value="{{old('card-number')}}" />
                                            <span class="input-group-text cursor-pointer p-25" id="addCard">
                                                <span class="card-type"></span>
                                            </span>
                                        </div>
                                        <span class="error card-error d-none">This field is required.</span>
                                    </div>

                                    <div class="col-12 col-md-3 mb-1">
                                        <label class="form-label" for="addCardCvv">CVC</label>
                                        <input type="text" id="card-cvc" name="card-cvc" class="form-control cvv-code-mask"  value="{{old('card-cvc')}}"  maxlength="4" placeholder="654" />
                                        <span class="error card-cvc-error d-none">This field is required.</span>
                                    </div>

                                    <div class="col-12 col-md-3 mb-1">
                                        <label class="form-label" for="addCardExpiryDate">Exp. Date</label>
                                        <input type="text" id="card-expire-date" name="card-expire-date" class="form-control expiry-date-mask"  value="{{old('card-expire-date')}}" placeholder="MM/YY" />
                                        <span class="error card-exp-error d-none">This field is required.</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <span class="payment-errors" style="color: red;margin-top:10px;"></span>
                                    </div>
                                </div>

                            </div>
                            
                            <button type="submit" id="card-button" class="btn btn_payment">Pay with Credit/Debit Card</button>
                            <div class="img_payment_section">
                                <img src="{{asset('assets/image/cards-stripe.png')}}" class="img_stripe img_payment" />
                                <img src="{{asset('assets/image/cards-paypal.png')}}" class="img_paypal img_payment d-none" />
                            </div>
        
                            <div class="terms rule">
                                <input type="checkbox" id="terms"  />
                                <label for="terms">I understand that my personal data will be used to process this order, support my experience throughout this website, and for other purposes described in our <a href="#">privacy policy</a>.
                                </label>
                            </div>

                            <div class="conditions rule">
                                <input type="checkbox" id="conditions" />
                                <label for="conditions">By joining, I agree to these <a href="#">Terms/Conditions</a></label>
                            </div>
                        </div>
                        

                    </div>
                    <div class="col-md-4">
                        <div class="monthly-member-section member-section">
                            <div class="memberships monthly-membership">
                                <div class="membership_radio">
                                    <img class="info-icon active-icon" src="{{asset('assets/image/infoicon-blue.svg')}}" />
                                    <img class="info-icon inactive-icon" src="{{asset('assets/image/infoicon-grey.svg')}}" />
                                    <input type="radio" name="membership" id="month" value="month">
                                    <label for="month">$147.00 Monthly Membership</label>
                                </div>                           
                            </div>
                            @component('components.tooltip')
                                
                            @endcomponent
                        </div>
                        <div class="quarterly-member-section member-section">
                            <div class="memberships quarterly-membership">
                                <div class="membership_radio">
                                    <img class="info-icon active-icon" src="{{asset('assets/image/infoicon-blue.svg')}}" />
                                    <img class="info-icon inactive-icon" src="{{asset('assets/image/infoicon-grey.svg')}}" />
                                    <input type="radio" name="membership" id="quartely" value="quartely">
                                    <label for="quartely">$387.00 Quarterly Membership</label>
                                </div>
                                <div class="save_price_img">
                                    <span class="save-price">Save <br> <strong>$366</strong></span>
                                    <img src="{{ asset('assets/image/offer-icon1-01.svg') }}" class="membership_save_img"  />
                                </div>
                            </div>
                            @component('components.tooltip')
                                
                            @endcomponent
                        </div>
                        <div class="yearly-member-section member-section">
                            <div class="yearly-member-section member-section">
                                <div class="memberships yearly-membership">
                                    <div class="membership_radio flex-wrap membership_most_popular">
                                        <img class="info-icon active-icon" src="{{asset('assets/image/infoicon-blue.svg')}}" />
                                        <img class="info-icon inactive-icon" src="{{asset('assets/image/infoicon-grey.svg')}}" />
                                        <span class="text-uppercase">most popular</span>
                                        <input type="radio" name="membership" id="yearly" value="yearly">
                                        <label for="yearly" class="yearly-text">$787.00 Annual Membership</label>
                                    </div>
                                    <div class="save_price_img">
                                        <span class="save-price  text-white">Save <br> <strong>$977</strong></span>
                                        <img src="{{ asset('assets/image/offer-icon2-01.svg') }}" class="membership_save_img"  />
                                    </div>
                                </div>
                            <div class="text-center secureimg-section">
                                <img src="{{ asset('assets/image/secure-checkout.png') }}" />
                                <p class="protected-text">Protected by</p>
                                <img src="{{ asset('assets/image/card.png') }}" class="card-img" />
                            </div>
                            @component('components.tooltip')
                                
                            @endcomponent
                        </div>
                    </div>
                </div>                
            </form>
            <div id="overlay" style="display: none;"></div>

            <div id="loadingSpinner" style="display: none;">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Please wait while we process your order...
            </div>
        </section>
    </div>
       
  
    
@endsection


@section('page-script')
<script src="{{asset('app-assets/vendors/js/forms/cleave/cleave.min.js')}}"></script>
<script src="{{asset('app-assets/vendors/js/forms/cleave/addons/cleave-phone.us.js')}}"></script>
<script src="{{asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js')}}"></script>
<script>
    var stripe_payment = $('.stripe_payment');
    var payment_option = $('.payment-option');
    var stripe_option = $('#stripe');
    var paypal_option = $('#paypal');
    var img_stripe = $('.img_stripe');
    var img_paypal = $('.img_paypal');
    var btn_payment = $('.btn_payment');
    var memberships = $('.memberships');
    var member_section = $('.member-section');
    var monthly_membership = $('.monthly-membership');
    var quarterly_membership = $('.quarterly-membership');
    var yearly_membership = $('.yearly-membership');   
    var phoneMask = $('.mobile-number-mask');
    var creditCard = $('.credit-card-mask');
    var expiryDateMask = $('.expiry-date-mask');
    var cvvMask = $('.cvv-code-mask');
    var assetsPath = '{{ asset("assets") }}';

    var month_plan_stripe = '{{$month_plan['stripe_plan']}}';
    var month_plan_paypal = '{{$month_plan['paypal_plan']}}';

    var quarter_plan_stripe = '{{$quarter_plan['stripe_plan']}}';
    var quarter_plan_paypal = '{{$quarter_plan['paypal_plan']}}';

    var year_plan_stripe = '{{$year_plan['stripe_plan']}}';    
    var year_plan_paypal = '{{$year_plan['paypal_plan']}}';    

    var stripe_plan_id = $('#stripe_plan_id');
    var paypal_plan_id = $('#paypal_plan_id');


    member_section.hover(function () {
            $(this).find('.tooltip-text').removeClass('invisible');
        }, function () {
            $(this).find('.tooltip-text').addClass('invisible');
        }
    );

    $(document).ready(function () {
        var subscription_type_title = $('.subscription_type_title').text().toLowerCase().trim();  
        if(subscription_type_title == 'monthly'){
            activeMonthlyIcon();
        }else if(subscription_type_title == 'quarterly'){
            activeQuareterlyIcon();
        }else if(subscription_type_title == 'yearly'){
            activeYearlyIcon();
        }
    });

    function activeYearlyIcon()
    {
        monthly_membership.find('.active-icon').addClass('d-none');
        monthly_membership.find('.inactive-icon').removeClass('d-none');
        quarterly_membership.find('.active-icon').addClass('d-none');
        quarterly_membership.find('.inactive-icon').removeClass('d-none');
        yearly_membership.find('.active-icon').removeClass('d-none');
        yearly_membership.find('.inactive-icon').addClass('d-none');
    }

    function activeMonthlyIcon()
    {
        monthly_membership.find('.active-icon').removeClass('d-none');
        monthly_membership.find('.inactive-icon').addClass('d-none');
        quarterly_membership.find('.active-icon').addClass('d-none');
        quarterly_membership.find('.inactive-icon').removeClass('d-none');
        yearly_membership.find('.active-icon').addClass('d-none');
        yearly_membership.find('.inactive-icon').removeClass('d-none');
    }

    function activeQuareterlyIcon()
    {
        monthly_membership.find('.active-icon').addClass('d-none');
        monthly_membership.find('.inactive-icon').removeClass('d-none');
        quarterly_membership.find('.active-icon').removeClass('d-none');
        quarterly_membership.find('.inactive-icon').addClass('d-none');
        yearly_membership.find('.active-icon').addClass('d-none');
        yearly_membership.find('.inactive-icon').removeClass('d-none');
    }

    payment_option.click(function(){
        if (!$(this).hasClass('payment_active')){
            //remove payment-active class
            payment_option.removeClass('payment_active');
           
           //Add class again
           $(this).addClass('payment_active');

            //remove radion button
            if($(this).hasClass('stripe-option')){
                stripe_option.prop('checked', true);
                paypal_option.prop('checked', false);
                img_stripe.removeClass('d-none');
                img_paypal.addClass('d-none');
            }else{
                stripe_option.prop('checked', false);
                paypal_option.prop('checked', true);
                img_stripe.addClass('d-none');
                img_paypal.removeClass('d-none');
            }            
        }

        var paymentOption = $('input[name="payment_option"]:checked').val();

        if(paymentOption == 'paypal'){
            stripe_payment.addClass('d-none');
            btn_payment.text('Pay with PayPal');
        }else{
            stripe_payment.removeClass('d-none');
            btn_payment.text('Pay with Credit/Debit Card');
        }
    })

    //get period 
    var period = $('#period').val();
    if(period == 'mo'){
        $('.monthly-membership').addClass('membership_active');
    }else if(period == 'qu'){
        $('.quarterly-membership').addClass('membership_active');
    }else if(period == 'yr'){
        $('.yearly-membership').addClass('membership_active');
    }

   

    //if right side bar is clicking... 
    memberships.click(function(){
        var membership_type = 'monthly';

        if ($(this).hasClass('monthly-membership'))
        {
            updateCheckoutAttributes('monthly', 147, 'mo');
            clearMembershipClass();
            $('.monthly-membership').addClass('membership_active');
            stripe_plan_id.val(month_plan_stripe);
            paypal_plan_id.val(month_plan_paypal);
            activeMonthlyIcon();
        }
        else if ($(this).hasClass('quarterly-membership'))
        {
            updateCheckoutAttributes('quarterly', 387, 'qu');
            clearMembershipClass();
            $('.quarterly-membership').addClass('membership_active');    
            stripe_plan_id.val(quarter_plan_stripe);    
            paypal_plan_id.val(quarter_plan_paypal);    
            activeQuareterlyIcon();
        }
        else if ($(this).hasClass('yearly-membership'))
        {
            updateCheckoutAttributes('yearly',787, 'yr');
            clearMembershipClass();
            $('.yearly-membership').addClass('membership_active');            
            stripe_plan_id.val(year_plan_stripe);
            paypal_plan_id.val(year_plan_paypal);
            activeYearlyIcon();
        }

    })

    function updateCheckoutAttributes(title, price, period){
        //for the title
        $('.subscription_type_title').text(title);
        $('.price').text(price);
        $('.period').text(period);
        //input type's value
        $('#price').val(price);
        $('#period').val(period);
    }

    function clearMembershipClass(){
        $('.memberships').removeClass('membership_active');
    }

    var payment_method;

    //Phone Number
    if (phoneMask.length) {
        new Cleave(phoneMask, {
            phone: true,
            phoneRegionCode: 'US'
        });
    }

    // Credit Card
    if (creditCard.length) {
            creditCard.each(function () {
                new Cleave($(this), {
                    creditCard: true,
                    onCreditCardTypeChanged: function (type) {
                    const elementNodeList = document.querySelectorAll('.card-type');
                        if (type != '' && type != 'unknown') {
                            //! we accept this approach for multiple credit card masking
                            for (let i = 0; i < elementNodeList.length; i++) {
                            elementNodeList[i].innerHTML =
                                '<img src="' + assetsPath + '/image/icons/payments/' + type + '-cc.png" height="24"/>';
                            }
                        } else {
                            for (let i = 0; i < elementNodeList.length; i++) {
                            elementNodeList[i].innerHTML = '';
                            }
                        }
                    }
                });
            });
        }

    // Expiry Date Mask
    if (expiryDateMask.length) {
        new Cleave(expiryDateMask, {
            date: true,
            delimiter: '/',
            datePattern: ['m', 'y']
        });
    }

    // CVV
    if (cvvMask.length) {
        new Cleave(cvvMask, {
            numeral: true,
            numeralPositiveOnly: true
        });
    }
    
    // Handle form submission
    var payment_form = document.getElementById('payment-form');


    payment_form.addEventListener('submit', function(event) {
        event.preventDefault();
                
        var paymentOption = $('input[name="payment_option"]:checked').val();
        var isValid = true;
        var cardButton = $('#card-button');
        var termsChecked = $('#terms').is(':checked');  
        var conditionsChecked = $('#conditions').is(':checked');
        var first_name = $('#payment-form #first_name');
        var last_name = $('#payment-form #last_name');
        var email = $('#payment-form #email');
        var mobile_number = $('#payment-form #mobile_number');
        var password = $('#payment-form #password');
        var password_confirmation = $('#payment-form #password_confirmation');

        if(first_name.val() == ''){
            isValid = false;
            first_name.addClass('error');
            $('.first-name-error').removeClass('d-none');
        }else{
            first_name.removeClass('error');
        }

        if(last_name.val() == ''){
            isValid = false;
            last_name.addClass('error');
            $('.last-name-error').removeClass('d-none');
        }else{
            last_name.removeClass('error');
        }

        if(email.val() == ''){
            isValid = false;
            email.addClass('error');
            $('.email-error').removeClass('d-none');
        }else{
            email.removeClass('error');
        }

        if(mobile_number.val() == ''){
            isValid = false;
            mobile_number.addClass('error');
            $('.mobile-number-error').removeClass('d-none');
        }else{
            mobile_number.removeClass('error');
        }

        if(password.val() == ''){
            isValid = false;
            password.addClass('error');
            $('.password-error').removeClass('d-none');
        }else{
            password.removeClass('error');
        }

        if(password_confirmation.val() == ''){
            isValid = false;
            password_confirmation.addClass('error');
            $('.password-confirmation-error').removeClass('d-none');
        }else{
            password_confirmation.removeClass('error');
        }

        cardButton.prop('disabled', true);
        cardButton.html('Please wait while we process your order...').find('.spinner-border').show();

        if(paymentOption == 'stripe')
        {

            var card_number = $('#card-number');
            var card_cvc = $('#card-cvc');
            var card_date = $('#card-expire-date');
          
            if(card_number.val() == ''){
                isValid = false;
                card_number.addClass('error');
                $('.card-error').removeClass('d-none');
            }else{
                card_number.removeClass('error');
            }

            if(card_cvc.val() == ''){
                isValid = false;
                card_cvc.addClass('error');
                $('.card-cvc-error').removeClass('d-none');
            }else{
                card_cvc.removeClass('error');
            }

            if(card_date.val() == ''){
                isValid = false;
                card_date.addClass('error');
                $('.card-exp-error').removeClass('d-none');
            }else{
                card_date.removeClass('error');
            }
            
            if (!termsChecked) {
                isValid = false;
                $('.terms').addClass('error');
            } else {
                $('.terms').removeClass('error');
            }

            if (!conditionsChecked) {
                isValid = false;
                $('.conditions').addClass('error');
            } else {
                $('.conditions').removeClass('error');
            }

            if(isValid){
                FormHandler();                
                $('#overlay, #loadingSpinner').show();
            }else{
                // $('#overlay, #loadingSpinner').hide();
            }
            

            // Prevent the form from submitting with the default action
            return false;            
        }else{

            if (!termsChecked) {
                isValid = false;
                $('.terms').addClass('error');
            } else {
                $('.terms').removeClass('error');
            }

            if (!conditionsChecked) {
                isValid = false;
                $('.conditions').addClass('error');
            } else {
                $('.conditions').removeClass('error');
            }

            if(isValid){
                FormHandler();
            }else{
                cardButton.prop('disabled', false);
            }
        }
       
    }); 

   
    function FormHandler(){
        var payment_form = document.getElementById('payment-form');
        payment_form.submit();
    }
    
</script>
@endsection