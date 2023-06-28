@extends('layouts.front-master')
@section('title', 'Checkout')

@section('page-style')
<style>
    .StripeElement {
        background-color: white;
        padding: 20px 14px;
        border-radius: 4px;
        border: 1px solid #E4E4E4;
    }

    .StripeElement--focus {
        border-color: #00CCFF;
    }

    .StripeElement--invalid {
        border-color: #FF0033;
    }

    .StripeElement--webkit-autofill {
        background-color: #F9F9F9 !important;
    }

    #card-errors{
        color: red;
        word-break: break-word;
    }

    .error{
        color:red;
        word-break: break-word;
    }
</style>
@endsection


@section('content')
    <div class="container">
        <form method="post" action="{{ route('front.payment.process') }}" id="payment-form">
            @csrf
            <section class="checkout-section">
                <h1 class="text-center checkout-title"><span class="subscription_type_title">{{$subscription_type}}</span> Checkout ($<span class="price">{{$price}}</span>/<span class="period">{{$units}}</span> )</h1>
              
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
                                    <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name" aria-label="" />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="email">Last Name</label>
                                    <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name" aria-label="" />
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Email Address" aria-label="john.doe" />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="mobile_number">Mobile number</label>
                                    <input type="text" name="mobile_number" id="mobile_number" class="form-control mobile-number-mask" placeholder="Mobile Number" />
                                </div>     

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="password">Password</label>
                                    <div class="input-group input-group-merge form-password-toggle">
                                        <input type="password" name="password" id="password" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="confirm-password">Confirm Password</label>
                                    <div class="input-group input-group-merge form-password-toggle">
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                    </div>
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
                                <div id="card-element"></div>

                                <div id="card-errors" role="alert"></div>                               
                            </div>
                            {{-- <button type="submit" id="card-button" class="btn btn_payment" data-secret="{{ $intent->client_secret }}">Pay with Credit/Debit Card</button> --}}
                            <button type="submit" id="card-button" class="btn btn_payment">Pay with Credit/Debit Card</button>
                            <div class="img_payment_section">
                                <img src="{{asset('assets/image/cards-stripe.png')}}" class="img_stripe img_payment" />
                                <img src="{{asset('assets/image/cards-paypal.png')}}" class="img_paypal img_payment d-none" />
                            </div>
        
                            <div class="terms rule">
                                <input type="checkbox" id="terms" />
                                <label for="terms">I understand TradeInSync uses a swing trading strategy, and that results typically require three months or more due to the length of time positions are held. I also understand that the rate of alerts will fluctuate based on market conditions, where TradeinSync will always focus on quality, as opposed to quantity, of alerts.
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
            </section>
        </form>
    </div>
       
  
    
@endsection


@section('page-script')
<script src="https://js.stripe.com/v3/"></script>
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

    member_section.hover(function () {
            $(this).find('.tooltip-text').removeClass('invisible');
        }, function () {
            $(this).find('.tooltip-text').addClass('invisible');
        }
    );

    $(document).ready(function () {
        var subscription_type_title = $('.subscription_type_title').text().toLowerCase();
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

    var month_plan_stripe = '{{$month_plan['stripe_plan']}}';
    var month_plan_paypal = '{{$month_plan['paypal_plan']}}';

    var quarter_plan_stripe = '{{$quarter_plan['stripe_plan']}}';
    var quarter_plan_paypal = '{{$quarter_plan['paypal_plan']}}';

    var year_plan_stripe = '{{$year_plan['stripe_plan']}}';    
    var year_plan_paypal = '{{$year_plan['paypal_plan']}}';    

    var stripe_plan_id = $('#stripe_plan_id');
    var paypal_plan_id = $('#paypal_plan_id');

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

    var stripe = Stripe('{{ config('services.stripe.publish_key') }}');

    // Create an instance of Elements
    var elements = stripe.elements();
    const cardButton = document.getElementById('card-button');
    const clientSecret = cardButton.dataset.secret;
    var payment_method;

    // Custom styling can be passed to options when creating an Element.
    // (Note that this demo uses a wider set of styles than the guide below.)
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

    cardButton.addEventListener('click', async (e) => {
        e.preventDefault();

        var paymentOption = $('input[name="payment_option"]:checked').val();

        if(paymentOption == 'stripe'){
                const { setupIntent, error } = await stripe.confirmCardSetup(
                clientSecret, {
                    payment_method: {
                        card: card
                    }
                }
            );
    
            if (error) {
                // Display "error.message" to the user...
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = error.message;
            } else {
                // The card has been verified successfully...                
                stripeTokenHandler(setupIntent.payment_method);
            }
        }else{
            PayPalHandler();
        }
    });
    // Handle form submission
    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        
        var paymentOption = $('input[name="payment_option"]:checked').val();

        if(paymentOption == 'stripe'){
            stripe.createToken(card).then(function(result) {                
                if (result.error) {
                    // Inform the user if there was an error
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    // Send the token to your server
                    stripeTokenHandler(result.token);
                }
            });
        }else{
            PayPalHandler();
        }
       
    }); 


    function stripeTokenHandler(payment_method) {
        // Insert the token ID into the form so it gets submitted to the server
        var form = document.getElementById('payment-form');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'payment_method');
        hiddenInput.setAttribute('value', payment_method);
        form.appendChild(hiddenInput);
        // Submit the form
        form.submit();
    }

    function PayPalHandler(){
        
        var form = document.getElementById('payment-form');
        form.submit();
    }

    
</script>
@endsection