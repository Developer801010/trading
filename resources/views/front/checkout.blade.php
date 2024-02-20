@extends('layouts.front-master')
@section('title', 'Checkout')

@section('page-style')
	<style>
		.input-group-text {
			padding: 0;
		}

		.checkout-title {
			text-transform: uppercase;
			padding-bottom: 30px;
			font-weight: 900;
			color: #0731c5;
		}

		.payment-option {
			border: 2px solid #c9c4c4;
			padding: 15px;
			margin: 15px 0;
			display: flex;
			justify-content: space-between;
			border-radius: 15px;
			cursor: pointer;
		}

		.stripe-image {
			width: 170px;
		}

		.paypal-image {
			width: 80px;
		}

		#stripe,
		#paypal {
			margin-right: 5px;
		}

		.payment_radio {
			display: flex;
			align-items: center;
		}

		.payment_active,
		.membership_active {
			border: 2px solid #0731c5 !important;
			background: lightgray;
		}

		.btn_payment {
			background: #f78d1f;
			border: 1px solid #f78d1f;
			position: relative;
			display: block;
			letter-spacing: 1px;
			padding: 10px 0;
			border-radius: 10px;
			font-size: 23px;
			width: 100%;
			color: white;
			margin-top: 15px;
		}

		.btn_payment:hover {
			color: #f78d1f;
			border: 1px solid #f78d1f;
		}

		.img_payment {
			width: 300px;
		}

		.terms {
			margin-top: 20px;
		}

		.conditions a {
			text-decoration: none;
		}

		.membership_save_img {
			width: 70px;
		}

		.memberships {
			border: 2px solid #c9c4c4;
			padding: 5px 15px;
			margin: 15px 0;
			display: flex;
			justify-content: space-between;
			border-radius: 15px;
			cursor: pointer;
			min-height: 84px;
		}

		.membership_radio {
			display: flex;
			align-items: center;
			cursor: pointer;
		}

		.memberships .membership_radio i {
			margin-right: 10px;
		}

		.memberships .membership_radio input {
			display: none;
		}

		.memberships .membership_radio label {
			font-weight: bold;
			padding-top: 6px;
			font-size: 18px;
			cursor: pointer;
		}

		.memberships .membership_radio span {
			color: #0731c5;
		}

		.membership_most_popular label {
			padding-left: 15px;
		}

		.subscription_price {
			font-size: 50px;
		}

		.position-section {
			padding: 20px 0 70px;
		}

		.sidebar-inner {
			position: relative;
			display: block;
			min-height: 100%;
			background: #F8F8F8;
			padding: 50px 22px 50px;
		}

		.sidebar-inner ul {
			list-style: none;
			margin: 0 0;
			padding-left: 0;
		}

		.sidebar-inner li {
			position: relative;
			border-bottom: 3px solid #ffffff;
			background: #617694;
		}

		.sidebar-inner ul li:hover {
			cursor: pointer;
			background: #627413;
		}

		.sidebar-inner li a {
			position: relative;
			display: block;
			font-size: 18px;
			text-transform: uppercase;
			padding: 9px 20px;
			line-height: 24px;
			color: #ffffff;
			text-decoration: none;
			letter-spacing: 1px;
		}

		.white-box {
			padding: 43px 50px 50px !important;
			border: 2px solid #e5e5e5;
			margin-bottom: 20px;
			border-radius: 5px;
		}

		.checkout-subtitle {
			margin-bottom: 40px;
			color: #0731c5;
		}

		.secureimg-section {
			box-shadow: rgba(100, 100, 111, .2) 0px 7px 29px 0px;
			padding: 30px 10px;
		}

		.secureimg-section .card-img {
			width: 80%;
		}

		.save_price_img {
			position: relative;
			width: 25%;
			text-align: right;
		}

		.save-price {
			font-size: 12px;
			position: absolute;
			top: 14px;
			font-weight: normal;
			text-align: center;
			padding-left: 21px;
			color: #51b36a;
			z-index: 99;
		}

		.info-icon {
			width: 18px;
			margin-right: 8px
		}

		.yearly-text {
			padding: 0 0 0 25px !important;
		}

		.monthly-member-section,
		.quarterly-member-section,
		.yearly-member-section {
			position: relative;
		}

		ul.tooltip-text {
			position: absolute;
			z-index: 1;
			width: 300px;
			color: #000;
			font-size: 16px;
			background-color: #fff;
			border-radius: 20px;
			padding: 20px 30px !important;
			box-shadow: rgba(100, 100, 111, .2) 0px 7px 29px 0px;
			list-style: none;
			border-radius: 20px;
		}

		.tooltip-text i {
			color: #0731c5;
			margin-right: 5px;
		}

		.tooltip-text {
			top: 0;
			left: -320px;
		}

		.tooltip-text li {
			line-height: 23px;
			margin: 15px 0px;
		}

		.img_payment_section {
			padding-top: 20px;
		}

		.password_change_title {
			padding-bottom: 15px;
		}

		#LoginForm {
			margin-bottom: 30px;
		}

		.login-section {
			max-width: 600px;
			margin: 250px auto 100px;
		}

		.login-section .card-body {
			padding: 45px 40px;
		}

		.accountInfoCard {
			padding: 5px 25px;
		}

		.accountInfoCard p {
			margin-bottom: 5px;
		}

		.close-icon {
			position: absolute;
			top: 50%;
			right: 20px;
			transform: translateY(-50%);
			cursor: pointer;
			display: none;
			/* Initially hide the icon */
		}

		@media screen and (max-width: 768px) {
			.subscription-section h1 {
				font-size: 30px;
			}

			.subscription_content h2 {
				padding-top: 30px;
			}

			.subscription_content ul li {
				font-size: 16px;
			}

			.subscription_row {
				display: block;
				padding: 30px 10px;
			}

			.subscription_box {
				margin-bottom: 50px;
			}

			.subscription_box .btn_subscribe {
				font-size: 16px;
			}

			.btn_payment {
				font-size: 16px;
			}

			.stripe-image {
				width: 80px;
			}

			.checkout-title {
				font-size: 22px;
			}

			.checkout-subtitle {
				margin-bottom: 20px;
				text-align: center;
			}
		}

		.rule {
			display: flex;
			align-items: baseline;
			padding-bottom: 15px;
			display: flex;
			align-items: baseline;
			padding-bottom: 15px;
		}

		.rule input {
			margin-right: 10px;
		}

		.rule input {
			margin-right: 10px;
		}
	</style>
	<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/form-validation.css') }}">
@endsection

@section('content')
	<div class="container">
		<section class="checkout-section">
			<h1 class="text-center checkout-title ">
				<span class="subscription_type_title">
					{{ $subscription_type }}</span> Checkout
				($<span class="price">{{ $price }}</span>/<span class="period">{{ $units }}</span> )
			</h1>
			<div class="row">
				<div class="col-md-12">
					<p> Returning customer?
						<a class="text-danger" data-bs-toggle="collapse" href="#LoginForm" role="button" aria-expanded="false"
							aria-controls="LoginForm">
							Click here to login
						</a>
					</p>
					<div class="collapse {{ old('isLoginFormExpanded') ? 'show' : '' }}" id="LoginForm">
						<div class="card card-body">
							<p>If you have shopped with us before, please enter your details below. If you are a new customer, please proceed
								to the Billing section.</p>

							<form class="auth-login-form mt-2" action="{{ route('login') }}" method="POST">
								@csrf
								<div class="row">
									<div class="col-md-5  mb-3">
										<label for="login-email" class="form-label">Email</label>
										<input type="email" class="form-control" id="email" placeholder="Email" name="email"
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
											<input type="password" class="form-control form-control-merge" required id="password" name="password"
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
					value="@if ($units == 'mo') {{ $month_plan['stripe_plan'] }} @elseif ($units == 'qu') {{ $quarter_plan['stripe_plan'] }}  @elseif($units == 'yr') {{ $year_plan['stripe_plan'] }} @endif" />

				<input type="hidden" name="paypal_plan_id" id="paypal_plan_id"
					value="@if ($units == 'mo') {{ $month_plan['paypal_plan'] }} @elseif ($units == 'qu') {{ $quarter_plan['paypal_plan'] }}  @elseif($units == 'yr') {{ $year_plan['paypal_plan'] }} @endif" />

				<input type="hidden" name="price" id="price" value="{{ $price }}" />
				<input type="hidden" name="period" id="period" value="{{ $units }}" />

				@include('layouts.error')

				<div class="row">
					<div class="col-md-8">
						<div class="account-box white-box">
							<h4 class="checkout-subtitle">Create an account</h4>
							<div class="row">
								<div class="col-md-6 mb-3">
									<label class="form-label" for="email">First Name</label>
									<input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name"
										value="{{ old('first_name') }}" />
									<span class="first-name-error error d-none">This field is required.</span>
								</div>
								<div class="col-md-6 mb-3">
									<label class="form-label" for="email">Last Name</label>
									<input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name"
										value="{{ old('last_name') }}" />
									<span class="last-name-error error d-none">This field is required.</span>
								</div>

								<div class="col-md-6 mb-3">
									<label class="form-label" for="email">Email</label>
									<input type="email" name="email" id="email" class="form-control" placeholder="Email Address"
										value="{{ old('email') }}" />
									<span class="email-error error d-none">This field is required.</span>
								</div>
								<div class="col-md-6 mb-3">
									<label class="form-label" for="mobile_number">Mobile number</label>
									<input type="text" name="mobile_number" id="mobile_number" class="form-control mobile-number-mask"
										placeholder="Mobile Number" value="{{ old('mobile_number') }}" />
									<span class="mobile-number-error error d-none">This field is required.</span>
								</div>

								<div class="col-md-6 mb-3">
									<label class="form-label" for="password">Password</label>
									<div class="input-group input-group-merge form-password-toggle">
										<input type="password" name="password" id="password" class="form-control" value="{{ old('password') }}"
											placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
									</div>
									<span class="password-error error d-none">This field is required.</span>
								</div>
								<div class="col-md-6 mb-3">
									<label class="form-label" for="confirm-password">Confirm Password</label>
									<div class="input-group input-group-merge form-password-toggle">
										<input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
											value="{{ old('password_confirmation') }}"
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
									<img class="payment-image stripe-image" src="{{ asset('assets/images/stripe.png') }}" />
								</div>

								<div class="paypal-option payment-option">
									<div class="payment_radio">
										<input type="radio" name="payment_option" id="paypal" value="paypal">
										<label for="paypal">PayPal</label>
									</div>
									<img class="payment-image paypal-image" src="{{ asset('assets/images/paypal.png') }}" />
								</div>
							</div>
							<div class="stripe_payment">								
								<div id="card-element"></div>

								<div id="card-errors" role="alert"></div>
							
							</div>

							<button type="submit" id="card-button" class="btn btn_payment">Pay with Credit/Debit Card</button>
							<div class="img_payment_section">
								<img src="{{ asset('assets/images/cards-stripe.png') }}" class="img_stripe img_payment" />
								<img src="{{ asset('assets/images/cards-paypal.png') }}" class="img_paypal img_payment d-none" />
							</div>

							<div class="terms rule">
								<input type="checkbox" id="terms" />
								<label for="terms">I understand that my personal data will be used to process this order, support my
									experience throughout this website, and for other purposes described in our <a href="#">privacy
										policy</a>.
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
									<img class="info-icon active-icon" src="{{ asset('assets/images/infoicon-blue.svg') }}" />
									<img class="info-icon inactive-icon" src="{{ asset('assets/images/infoicon-grey.svg') }}" />
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
									<img class="info-icon active-icon" src="{{ asset('assets/images/infoicon-blue.svg') }}" />
									<img class="info-icon inactive-icon" src="{{ asset('assets/images/infoicon-grey.svg') }}" />
									<input type="radio" name="membership" id="quartely" value="quartely">
									<label for="quartely">$387.00 Quarterly Membership</label>
								</div>
								<div class="save_price_img">
									<span class="save-price">Save <br> <strong>$366</strong></span>
									<img src="{{ asset('assets/images/offer-icon1-01.svg') }}" class="membership_save_img" />
								</div>
							</div>
							@component('components.tooltip')
							@endcomponent
						</div>
						<div class="yearly-member-section member-section">
							<div class="yearly-member-section member-section">
								<div class="memberships yearly-membership">
									<div class="membership_radio flex-wrap membership_most_popular">
										<img class="info-icon active-icon" src="{{ asset('assets/images/infoicon-blue.svg') }}" />
										<img class="info-icon inactive-icon" src="{{ asset('assets/images/infoicon-grey.svg') }}" />
										<span class="text-uppercase">most popular</span>
										<input type="radio" name="membership" id="yearly" value="yearly">
										<label for="yearly" class="yearly-text">$787.00 Annual Membership</label>
									</div>
									<div class="save_price_img">
										<span class="save-price  text-white">Save <br> <strong>$977</strong></span>
										<img src="{{ asset('assets/images/offer-icon2-01.svg') }}" class="membership_save_img" />
									</div>
								</div>
								<div class="text-center secureimg-section">
									<img src="{{ asset('assets/images/secure-checkout.png') }}" />
									<p class="protected-text">Protected by</p>
									<img src="{{ asset('assets/images/card.png') }}" class="card-img" />
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
	<script src="https://js.stripe.com/v3/"></script>
	<script src="{{ asset('app-assets/vendors/js/forms/cleave/cleave.min.js') }}"></script>
	<script src="{{ asset('app-assets/vendors/js/forms/cleave/addons/cleave-phone.us.js') }}"></script>
	<script src="{{ asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
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
		var assetsPath = '{{ asset('assets') }}';

		var month_plan_stripe = '{{ $month_plan['stripe_plan'] }}';
		var month_plan_paypal = '{{ $month_plan['paypal_plan'] }}';

		var quarter_plan_stripe = '{{ $quarter_plan['stripe_plan'] }}';
		var quarter_plan_paypal = '{{ $quarter_plan['paypal_plan'] }}';

		var year_plan_stripe = '{{ $year_plan['stripe_plan'] }}';
		var year_plan_paypal = '{{ $year_plan['paypal_plan'] }}';

		var stripe_plan_id = $('#stripe_plan_id');
		var paypal_plan_id = $('#paypal_plan_id');


		member_section.hover(function() {
			$(this).find('.tooltip-text').removeClass('invisible');
		}, function() {
			$(this).find('.tooltip-text').addClass('invisible');
		});

		$(document).ready(function() {
			var subscription_type_title = $('.subscription_type_title').text().toLowerCase().trim();
			if (subscription_type_title == 'monthly') {
				activeMonthlyIcon();
			} else if (subscription_type_title == 'quarterly') {
				activeQuarterIcon();
			} else if (subscription_type_title == 'yearly') {
				activeYearlyIcon();
			}
		});

		function activeYearlyIcon() {
			monthly_membership.find('.active-icon').addClass('d-none');
			monthly_membership.find('.inactive-icon').removeClass('d-none');
			quarterly_membership.find('.active-icon').addClass('d-none');
			quarterly_membership.find('.inactive-icon').removeClass('d-none');
			yearly_membership.find('.active-icon').removeClass('d-none');
			yearly_membership.find('.inactive-icon').addClass('d-none');
		}

		function activeMonthlyIcon() {
			monthly_membership.find('.active-icon').removeClass('d-none');
			monthly_membership.find('.inactive-icon').addClass('d-none');
			quarterly_membership.find('.active-icon').addClass('d-none');
			quarterly_membership.find('.inactive-icon').removeClass('d-none');
			yearly_membership.find('.active-icon').addClass('d-none');
			yearly_membership.find('.inactive-icon').removeClass('d-none');
		}

		function activeQuarterIcon() {
			monthly_membership.find('.active-icon').addClass('d-none');
			monthly_membership.find('.inactive-icon').removeClass('d-none');
			quarterly_membership.find('.active-icon').removeClass('d-none');
			quarterly_membership.find('.inactive-icon').addClass('d-none');
			yearly_membership.find('.active-icon').addClass('d-none');
			yearly_membership.find('.inactive-icon').removeClass('d-none');
		}

		payment_option.click(function() {
			if (!$(this).hasClass('payment_active')) {
				//remove payment-active class
				payment_option.removeClass('payment_active');

				//Add class again
				$(this).addClass('payment_active');

				//remove radio button
				if ($(this).hasClass('stripe-option')) {
					stripe_option.prop('checked', true);
					paypal_option.prop('checked', false);
					img_stripe.removeClass('d-none');
					img_paypal.addClass('d-none');
				} else {
					stripe_option.prop('checked', false);
					paypal_option.prop('checked', true);
					img_stripe.addClass('d-none');
					img_paypal.removeClass('d-none');
				}
			}

			var paymentOption = $('input[name="payment_option"]:checked').val();

			if (paymentOption == 'paypal') {
				stripe_payment.addClass('d-none');
				btn_payment.text('Pay with PayPal');
			} else {
				stripe_payment.removeClass('d-none');
				btn_payment.text('Pay with Credit/Debit Card');
			}
		})

		//get period 
		var period = $('#period').val();
		if (period == 'mo') {
			$('.monthly-membership').addClass('membership_active');
		} else if (period == 'qu') {
			$('.quarterly-membership').addClass('membership_active');
		} else if (period == 'yr') {
			$('.yearly-membership').addClass('membership_active');
		}



		//if right side bar is clicking... 
		memberships.click(function() {
			var membership_type = 'monthly';

			if ($(this).hasClass('monthly-membership')) {
				updateCheckoutAttributes('monthly', 147, 'mo');
				clearMembershipClass();
				$('.monthly-membership').addClass('membership_active');
				stripe_plan_id.val(month_plan_stripe);
				paypal_plan_id.val(month_plan_paypal);
				activeMonthlyIcon();
			} else if ($(this).hasClass('quarterly-membership')) {
				updateCheckoutAttributes('quarterly', 387, 'qu');
				clearMembershipClass();
				$('.quarterly-membership').addClass('membership_active');
				stripe_plan_id.val(quarter_plan_stripe);
				paypal_plan_id.val(quarter_plan_paypal);
				activeQuarterIcon();
			} else if ($(this).hasClass('yearly-membership')) {
				updateCheckoutAttributes('yearly', 787, 'yr');
				clearMembershipClass();
				$('.yearly-membership').addClass('membership_active');
				stripe_plan_id.val(year_plan_stripe);
				paypal_plan_id.val(year_plan_paypal);
				activeYearlyIcon();
			}

		})

		function updateCheckoutAttributes(title, price, period) {
			//for the title
			$('.subscription_type_title').text(title);
			$('.price').text(price);
			$('.period').text(period);
			//input type's value
			$('#price').val(price);
			$('#period').val(period);
		}

		function clearMembershipClass() {
			$('.memberships').removeClass('membership_active');
		}

		var payment_method;
		var stripe = Stripe('{{ config('services.stripe.publish_key') }}');

		// Create an instance of Elements
		var elements = stripe.elements();
		const cardButton = document.getElementById('card-button');

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


		//Phone Number
		if (phoneMask.length) {
			new Cleave(phoneMask, {
				phone: true,
				phoneRegionCode: 'US'
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

			if (first_name.val() == '') {
				isValid = false;
				first_name.addClass('error');
				$('.first-name-error').removeClass('d-none');
			} else {
				first_name.removeClass('error');
			}

			if (last_name.val() == '') {
				isValid = false;
				last_name.addClass('error');
				$('.last-name-error').removeClass('d-none');
			} else {
				last_name.removeClass('error');
			}

			if (email.val() == '') {
				isValid = false;
				email.addClass('error');
				$('.email-error').removeClass('d-none');
			} else {
				email.removeClass('error');
			}

			if (mobile_number.val() == '') {
				isValid = false;
				mobile_number.addClass('error');
				$('.mobile-number-error').removeClass('d-none');
			} else {
				mobile_number.removeClass('error');
			}

			if (password.val() == '') {
				isValid = false;
				password.addClass('error');
				$('.password-error').removeClass('d-none');
			} else {
				password.removeClass('error');
			}

			if (password_confirmation.val() == '') {
				isValid = false;
				password_confirmation.addClass('error');
				$('.password-confirmation-error').removeClass('d-none');
			} else {
				password_confirmation.removeClass('error');
			}

			if (paymentOption == 'stripe') {

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

				if (isValid) {

					stripe.createToken(card).then(function(result) {
						
						if (result.error) {
							// Display an error message to the user.
							var errorElement = document.getElementById('card-errors');
							errorElement.textContent = result.error.message;
						} else {
							// You can now use the Payment Method ID on your server to make a payment.
							console.log(result.token.id);
							stripeTokenHandler(result.token.id); 
							// Send the Payment Method ID to your server for further processing.
							$('#overlay, #loadingSpinner').show();
						}
					});
				} else {
					// $('#overlay, #loadingSpinner').hide();
					console.log('isValid false');
				}


				// Prevent the form from submitting with the default action
				return false;
			} else {

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

				if (isValid) {
					PayPalHandler();
					$('#overlay, #loadingSpinner').show();
				} else {
					// cardButton.prop('disabled', false);
				}
			}

		});

		function stripeTokenHandler(token) {
			// Insert the token ID into the form so it gets submitted to the server
			console.log("stripe-token:"+token);
			var payment_form = document.getElementById('payment-form');
			var hiddenInput = document.createElement('input');
			hiddenInput.setAttribute('type', 'hidden');
			hiddenInput.setAttribute('name', 'token');
			hiddenInput.setAttribute('value', token);
			payment_form.appendChild(hiddenInput);
			// Submit the form
			payment_form.submit();
		}

		function PayPalHandler() {
			var payment_form = document.getElementById('payment-form');
			payment_form.submit();
		}
	</script>
@endsection
