@extends('layouts.frontmaster')
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
    }

    .error{
        color:red;
    }
</style>
@endsection


@section('content')
    <div class="container">
        <form method="post" action="{{ route('front.payment.process') }}" id="payment-form">
            @csrf
            <section class="checkout-section">
                <h1 class="text-center checkout-title">{{$subscription_type}} Checkout ($<span class="price">{{$price}}</span>/<span class="period">{{$units}}</span> )</h1>
              
                <input type="hidden" name="stripe_plan_id" id="stripe_plan_id" 
                value="@if ($units == 'mo') {{$month_plan}} @elseif ($units == 'qu') {{$quarter_plan}}  @elseif($units == 'yr' ) {{$year_plan}} @endif" />

                <input type="hidden" name="price" id="price" value="{{$price}}" />

                <input type="hidden" name="period" id="period" value="{{$units}}" />
                
                @include('layouts.error')

                <div class="row">
                    <div class="col-md-7">
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
                            <img src="{{asset('assets/image/powered_stripe.png')}}" class="img_stripe" />
                        </div>
                       
    
                        <div class="terms rule">
                            <input type="checkbox" id="terms" />
                            <label for="terms">I understand TradeInSync uses a swing trading strategy, and that results typically require three months or more due to the length of time positions are held. I also understand that the rate of alerts will fluctuate based on market conditions, where TradeinSync will always focus on quality, as opposed to quantity, of alerts.
                            </label>
                        </div>
    
                        <div class="conditions rule">
                            <input type="checkbox" id="conditions" />
                            <label for="conditions">By clicking Subscribe, you agree to the <a href="#">Terms/Conditions</a> and acknowledge reading the Privacy Policy. Products renew automatically until canceled and the payment method is saved for future purchases and subscription renewal.</label>
                        </div>
                        @if (count($activeSubscription) > 0)
                            <a class="btn btn_payment" >You already subscribed.</a>
                        @else
                            <button type="submit" id="card-button" class="btn btn_payment" data-secret="{{ $intent->client_secret }}">Pay with Credit/Debit Card</button>
                        @endif
                        
    
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-4">
                        <div class="memberships monthly-membership">
                            <div class="membership_radio">
                                <i class="fa-regular fa-circle-question"></i>
                                <input type="radio" name="membership" id="month" value="month">
                                <label for="month">$147.00 Monthly Membership</label>
                            </div>
                            <img src="{{ asset('assets/image/paypal.png') }}" class="membership_save_img" />
                        </div>
                        <div class="memberships quarterly-membership">
                            <div class="membership_radio">
                                <i class="fa-regular fa-circle-question"></i>
                                <input type="radio" name="membership" id="quartely" value="quartely">
                                <label for="quartely">$387.00 Quarterly Membership</label>
                            </div>
                            <img src="{{ asset('assets/image/paypal.png') }}" class="membership_save_img"  />
                        </div>
                        <div class="memberships yearly-membership">
                            <div class="membership_radio flex-wrap membership_most_popular">
                                <i class="fa-regular fa-circle-question"></i>
                                <span class="text-uppercase">most popular</span>
                                <input type="radio" name="membership" id="yearly" value="yearly">
                                <label for="yearly">$787.00 Annual Membership</label>
                            </div>
                            <img src="{{ asset('assets/image/paypal.png') }}" class="membership_save_img"  />
                        </div>
                        <div class="text-center">
                            <img src="{{ asset('assets/image/secure-checkout.png') }}" />
                            <img src="{{ asset('assets/image/protected-by.png') }}" />
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
    var btn_payment = $('.btn_payment');
    var memberships = $('.memberships');

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
            }else{
                stripe_option.prop('checked', false);
                paypal_option.prop('checked', true);
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

    var month_plan = '{{$month_plan}}';
    var quarter_plan = '{{$quarter_plan}}';
    var year_plan = '{{$year_plan}}';    
    var stripe_plan_id = $('#stripe_plan_id');

    memberships.click(function(){
        var membership_type = 'monthly';

        if ($(this).hasClass('monthly-membership')){
            updateCheckoutAttributes(147, 'mo');
            clearMembershipClass();
            $('.monthly-membership').addClass('membership_active');
            stripe_plan_id.val(month_plan);
        }else if ($(this).hasClass('quarterly-membership')){
            updateCheckoutAttributes(387, 'qu');
            clearMembershipClass();
            $('.quarterly-membership').addClass('membership_active');    
            stripe_plan_id.val(quarter_plan);        
        }else if ($(this).hasClass('yearly-membership')){
            updateCheckoutAttributes(787, 'yr');
            clearMembershipClass();
            $('.yearly-membership').addClass('membership_active');            
            stripe_plan_id.val(year_plan);
        }

    })

    function updateCheckoutAttributes(price, period){
        //for the title
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