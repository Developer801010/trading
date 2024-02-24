@extends('layouts.front-master')
@section('title', 'Checkout')

@section('page-style')
	{{-- <style>
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
		}ay: flex;
			align-items: baseline;
			padding-bottom: 15px;
		}

		.rule input {
			margin-right: 10px;
		}

		.rule input {
			margin-right: 10px;
		}
	</style> --}}
    <style>
        /* INTL NUM SELECT */
        .iti.iti--allow-dropdown {width: 100%;}
        .iti__country-list {border: none;border-radius: 4px;box-shadow: 0px 0px 50px 0px rgba(82, 63, 105, 0.15);}
        .iti__country-list::-webkit-scrollbar {width: 4px;background: transparent;}
        .iti__country-list::-webkit-scrollbar-thumb {border-radius: 10px;background: #e1e1e1;}
        .iti__country.iti__highlight {background-color: #0D6EFD;color: #FFF;}
        .iti__country.iti__highlight .iti__dial-code {color: #FFF;}
        /* INTL NUM SELECT */
        .phone-txt{font-size: 14px; position:absolute; left: 10px; right: 0;}
        @media(max-width:991px){
            .phone-txt{position: unset}
        }
    </style>
	<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/form-validation.css') }}">
@endsection

@section('content')
	<!-- REGISTER -->
    <section class="auth-register">
        <form method="post" action="{{ route('front.payment.process') }}" id="payment-form">
            @csrf
            <div class="container-lg">
                <h1 class="title"> <span class="subscription_type_title">{{ $subscription_type }}</span> Checkout (<span id="plan-price">$<span class="price">{{ $price }}</span>/ <span class="period">{{ $units }}</span></span>)</h1>
                <input type="hidden" name="stripe_plan_id" id="stripe_plan_id" value="@if ($units == 'mo') {{ $month_plan['stripe_plan'] }} @elseif ($units == 'qu') {{ $quarter_plan['stripe_plan'] }}  @elseif($units == 'yr') {{ $year_plan['stripe_plan'] }} @endif" />
                <input type="hidden" name="paypal_plan_id" id="paypal_plan_id" value="@if ($units == 'mo') {{ $month_plan['paypal_plan'] }} @elseif ($units == 'qu') {{ $quarter_plan['paypal_plan'] }}  @elseif($units == 'yr') {{ $year_plan['paypal_plan'] }} @endif" />
                <input type="hidden" name="price" id="price" value="{{ $price }}" />
                <input type="hidden" name="period" id="period" value="{{ $units }}" />
                @include('layouts.error')
                <div class="row checkout-row g-3 g-lg-4">
                    <div class="col-12 col-md-7 col-lg-7">
                        <div class="card mb-4">
                            <div class="card-header">Create an account</div>
                            <div class="card-body">
                                <div class="row g-3 mb-4">
                                    <div class="col-lg-6">
                                        <label>First Name :</label>
                                        <input type="text" name="first_name" id="first-name" class="form-control" value="{{ old('first_name') }}">
                                        <span class="first-name-error error d-none">This field is required.</span>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Last Name :</label>
                                        <input type="text" name="last_name" id="last-name" class="form-control" value="{{ old('last_name') }}">
                                        <span class="last-name-error error d-none">This field is required.</span>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Email Address :</label>
                                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
                                        <span class="email-error error d-none">This field is required.</span>
										<span class="email-error-invelid error d-none">This email address not a valid.</span>
                                    </div>
                                    <div class="col-lg-6 position-relative">
                                        <label>Phone Number :</label>
                                        <div class="form-group">
                                            <input type="text" name="mobile_number" id="mobile-number" class="form-control mobile-number-mask w-100"
                                            value="{{ old('mobile_number') }}">
                                        </div>
                                        <span class="mobile-number-error error d-none">This field is required.</span>
                                        <span class="phone-txt">Where Text Message (SMS) Alerts Will Be Sent (optional)</span>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Password :</label>
                                        {{-- <input type="password" name="password" id="password" class="form-control" value="{{ old('password') }}"> --}}
                                        <div class="input-box position-relative with-icon">
                                            <input name="password" type="password" class="form-control" id="password1" value="">
                                            <button type="button" class="input-group-text bg-transparent border-0 p-0 pe-1 position-absolute end-0 top-50 translate-middle toggle-passwords-btn">
                                                <div class="icon password-show-icon" style="">
                                                    <svg width="15" height="28" viewBox="0 0 41 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M40.9333 14.062C40.9333 14.062 33.4083 0.266113 20.8666 0.266113C8.32491 0.266113 0.799896 14.062 0.799896 14.062C0.799896 14.062 8.32491 27.8578 20.8666 27.8578C33.4083 27.8578 40.9333 14.062 40.9333 14.062ZM3.74218 14.062C4.95499 12.2187 6.34995 10.5019 7.90602 8.93744C11.1342 5.70419 15.5489 2.77445 20.8666 2.77445C26.1843 2.77445 30.5964 5.70419 33.8297 8.93744C35.3858 10.5019 36.7807 12.2187 37.9935 14.062C37.848 14.2802 37.6875 14.521 37.5044 14.7844C36.6641 15.9884 35.4225 17.5937 33.8297 19.1865C30.5964 22.4198 26.1818 25.3495 20.8666 25.3495C15.5489 25.3495 11.1368 22.4198 7.90351 19.1865C6.34745 17.6221 4.95501 15.9053 3.74218 14.062Z" fill="black"></path>
                                                        <path d="M20.8666 7.79117C19.2035 7.79117 17.6085 8.45185 16.4324 9.62786C15.2564 10.8039 14.5958 12.3989 14.5958 14.062C14.5958 15.7252 15.2564 17.3202 16.4324 18.4962C17.6085 19.6722 19.2035 20.3329 20.8666 20.3329C22.5297 20.3329 24.1247 19.6722 25.3008 18.4962C26.4768 17.3202 27.1374 15.7252 27.1374 14.062C27.1374 12.3989 26.4768 10.8039 25.3008 9.62786C24.1247 8.45185 22.5297 7.79117 20.8666 7.79117ZM12.0874 14.062C12.0874 11.7336 13.0124 9.50062 14.6588 7.8542C16.3052 6.20778 18.5382 5.28284 20.8666 5.28284C23.195 5.28284 25.428 6.20778 27.0744 7.8542C28.7208 9.50062 29.6458 11.7336 29.6458 14.062C29.6458 16.3904 28.7208 18.6234 27.0744 20.2698C25.428 21.9163 23.195 22.8412 20.8666 22.8412C18.5382 22.8412 16.3052 21.9163 14.6588 20.2698C13.0124 18.6234 12.0874 16.3904 12.0874 14.062Z" fill="black"></path>
                                                    </svg>
                                                </div>
                                                <div class="icon password-hide-icon" style="display: none;">
                                                    <svg width="15" height="32" viewBox="0 0 41 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M33.5756 24.184C37.8423 20.3763 40.2001 16.062 40.2001 16.062C40.2001 16.062 32.6751 2.26611 20.1334 2.26611C17.7244 2.27441 15.3426 2.77637 13.1351 3.74102L15.0666 5.67494C16.6905 5.08336 18.405 4.77866 20.1334 4.77445C25.4511 4.77445 29.8632 7.70419 33.0965 10.9374C34.6525 12.5019 36.0475 14.2187 37.2603 16.062C37.1148 16.2802 36.9543 16.521 36.7712 16.7844C35.9309 17.9884 34.6893 19.5937 33.0965 21.1865C32.6826 21.6004 32.2512 22.0092 31.7997 22.4056L33.5756 24.184Z" fill="black"></path>
                                                        <path d="M28.4034 19.0118C28.9631 17.4462 29.0668 15.7538 28.7023 14.1316C28.3378 12.5094 27.5202 11.024 26.3445 9.84834C25.1688 8.67267 23.6835 7.85502 22.0612 7.49053C20.439 7.12604 18.7467 7.2297 17.1811 7.78945L19.2454 9.85381C20.2094 9.71584 21.1923 9.80426 22.1162 10.1121C23.04 10.4199 23.8795 10.9387 24.5681 11.6272C25.2567 12.3158 25.7754 13.1553 26.0833 14.0792C26.3911 15.0031 26.4795 15.9859 26.3415 16.9499L28.4034 19.0118ZM21.0213 22.2701L23.0832 24.3319C21.5176 24.8917 19.8252 24.9953 18.203 24.6309C16.5808 24.2664 15.0955 23.4487 13.9198 22.273C12.7441 21.0974 11.9265 19.612 11.562 17.9898C11.1975 16.3676 11.3011 14.6752 11.8609 13.1096L13.9253 15.174C13.7873 16.138 13.8757 17.1208 14.1835 18.0447C14.4913 18.9686 15.0101 19.8081 15.6987 20.4967C16.3873 21.1852 17.2267 21.704 18.1506 22.0118C19.0745 22.3196 20.0574 22.4081 21.0213 22.2701Z" fill="black"></path>
                                                        <path d="M8.46963 9.71591C8.01813 10.1172 7.58418 10.5236 7.17031 10.9375C5.61425 12.5019 4.2193 14.2187 3.00647 16.062L3.49559 16.7844C4.33589 17.9884 5.57751 19.5937 7.17031 21.1865C10.4036 24.4198 14.8182 27.3495 20.1334 27.3495C21.9294 27.3495 23.62 27.0159 25.2002 26.4465L27.1317 28.383C24.9242 29.3475 22.5424 29.8495 20.1334 29.8579C7.59171 29.8579 0.0666962 16.062 0.0666962 16.062C0.0666962 16.062 2.42203 11.7452 6.69122 7.94L8.46712 9.71842L8.46963 9.71591ZM34.2955 32L4.19542 1.89993L5.97132 0.124023L36.0714 30.2241L34.2955 32Z" fill="black"></path>
                                                    </svg>
                                                </div>
                                            </button>
                                        </div>
                                        <span class="password1-error error d-none">This field is required.</span>

                                    </div>
                                    {{-- <div class="col-lg-6">
                                        <label>Confirm Password</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                                        value="{{ old('password_confirmation') }}">
                                        <span class="password-confirmation-error error d-none">This field is required.</span>
                                    </div> --}}
                                </div>
                                <p class="mb-0">Already you have an account? <a href="{{ url('/login') }}" class="auth-link">Login</a></p>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header card-title-2">Easy checkout with Stripe or PayPal All major credit cards accepted.</div>
                            <div class="card-body">
                                <div class="payment-method mb-4">
                                    <div class="position-relative">
                                        <input type="radio" class="btn-check" name="payment_option" id="card"  value="stripe" checked>
                                        <label class="payment-method-radio btn shadow-none" for="card">
                                            <div class="d-flex gap-2 align-items-center">
                                                <span class="checkmark-radio"></span>
                                                <span>Credit / Debit Cards(Stripe)</span>
                                            </div>
                                            <div class="radio-img">
                                                <img src="{{ asset('assets/images/cards.png') }}" class="img-fluid">
                                            </div>
                                        </label>
                                    </div>
                                    <div class="position-relative">
                                        <input type="radio" class="btn-check" name="payment_option" id="paypal"  value="paypal">
                                        <label class="payment-method-radio btn shadow-none" for="paypal">
                                            <div class="d-flex gap-2 align-items-center">
                                                <span class="checkmark-radio"></span>
                                                <span>Paypal</span>
                                            </div>
                                            <div class="radio-img">
                                                <img src="{{ asset('assets/images/paypal.png') }}" class="img-fluid">
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div id="stripe" class="desc card-details">
                                    <div class="mb-3">
                                        <label>Card Number</label>
                                        <div id="card-number-element" class="form-control"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-sm-6">
                                            <div class="mb-3">
                                                <label>Expiration Date</label>
                                                <div class="payment-input-group">
                                                    <div class="form-control" id="card-expiry-element" placeholder="MM/YY"></div>
                                                    {{-- <span class="text-muted"> / </span>
                                                    <input class="form-control" placeholder="YY"> --}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="mb-3">
                                                <label>CVC Number</label>
                                                <div id="card-cvc-element" class="form-control"></div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div id="card-element"></div> --}}

                                    <div class="error" id="card-errors" role="alert"></div>
                                </div>

                                <div class="mt-3">
                                    <button type="submit" id="card-button" class="btn btn-grn w-100 btn_payment">Pay with Credit/Debit Card</button>
                                </div>
                                <div class="my-4 strip-img">
                                    <img src="{{ asset('assets/images/cards-stripe.png') }}" class="img-fluid">
                                </div>
                                <div class="form-check mb-2 terms">
                                    <input class="form-check-input" type="checkbox" id="terms">
                                    <label class="form-check-label" for="terms">I understand that my personal data will be used to process this order, support my experience throughout this website, and for other purposes described in our <a href="#" class="auth-link">Privacy Policy</a>.</label>
									<span class="terms-error error d-none">This field is required.</span>
                                </div>
                                <div class="form-check mb-2 conditions">
                                    <input class="form-check-input" type="checkbox" id="conditions">
                                    <label class="form-check-label" for="conditions">By joining, I agree to these <a href="#" class="auth-link">Terms/Conditions</a></label>
									<span class="conditions-error error d-none">This field is required.</span>
                                </div>
								<div class="form-check">
									<div id="overlay" style="display: none;"></div>
									<div id="loadingSpinner" style="display: none;">
										<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
										Please wait while we process your order...
									</div>
								</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-5 col-lg-5">
                        <div class="plan-radio mb-4">
                            <div class="mb-3">
                                <input type="radio" class="btn-check" name="membership" id="month" checked value="month" checked>
                                <label id="plan1" class="btn pricing-form-control shadow-none" for="month">
                                    <div class="d-flex gap-1 align-items-center">
                                        <span class="btn-check-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="15" viewBox="0 0 14 15" fill="none">
                                                <path d="M7 13.625C5.37555 13.625 3.81763 12.9797 2.66897 11.831C1.52031 10.6824 0.875 9.12445 0.875 7.5C0.875 5.87555 1.52031 4.31763 2.66897 3.16897C3.81763 2.02031 5.37555 1.375 7 1.375C8.62445 1.375 10.1824 2.02031 11.331 3.16897C12.4797 4.31763 13.125 5.87555 13.125 7.5C13.125 9.12445 12.4797 10.6824 11.331 11.831C10.1824 12.9797 8.62445 13.625 7 13.625ZM7 14.5C8.85652 14.5 10.637 13.7625 11.9497 12.4497C13.2625 11.137 14 9.35652 14 7.5C14 5.64348 13.2625 3.86301 11.9497 2.55025C10.637 1.2375 8.85652 0.5 7 0.5C5.14348 0.5 3.36301 1.2375 2.05025 2.55025C0.737498 3.86301 0 5.64348 0 7.5C0 9.35652 0.737498 11.137 2.05025 12.4497C3.36301 13.7625 5.14348 14.5 7 14.5Z" fill="black"/>
                                                <path d="M7.81371 6.2645L5.80996 6.51562L5.73821 6.84812L6.13196 6.92075C6.38921 6.982 6.43996 7.07475 6.38396 7.33113L5.73821 10.3656C5.56846 11.1505 5.83008 11.5197 6.44521 11.5197C6.92208 11.5197 7.47596 11.2993 7.72708 10.9965L7.80408 10.6325C7.62908 10.7865 7.37358 10.8478 7.20383 10.8478C6.96321 10.8478 6.87571 10.6789 6.93783 10.3814L7.81371 6.2645ZM7.87496 4.4375C7.87496 4.66956 7.78277 4.89212 7.61868 5.05622C7.45458 5.22031 7.23202 5.3125 6.99996 5.3125C6.76789 5.3125 6.54533 5.22031 6.38124 5.05622C6.21715 4.89212 6.12496 4.66956 6.12496 4.4375C6.12496 4.20544 6.21715 3.98288 6.38124 3.81878C6.54533 3.65469 6.76789 3.5625 6.99996 3.5625C7.23202 3.5625 7.45458 3.65469 7.61868 3.81878C7.78277 3.98288 7.87496 4.20544 7.87496 4.4375Z" fill="black"/>
                                              </svg>
                                        </span>
                                        <span>$147.00 Monthly Membership</span>
                                    </div>
                                </label>
                            </div>
                            <div class="mb-3">
                                <input type="radio" class="btn-check" name="membership" id="quartely" autocomplete="off" value="quartely">
                                <label id="plan2" class="btn pricing-form-control shadow-none" for="quartely">
                                    <div class="d-flex gap-1 align-items-center">
                                        <span class="btn-check-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="15" viewBox="0 0 14 15" fill="none">
                                                <path d="M7 13.625C5.37555 13.625 3.81763 12.9797 2.66897 11.831C1.52031 10.6824 0.875 9.12445 0.875 7.5C0.875 5.87555 1.52031 4.31763 2.66897 3.16897C3.81763 2.02031 5.37555 1.375 7 1.375C8.62445 1.375 10.1824 2.02031 11.331 3.16897C12.4797 4.31763 13.125 5.87555 13.125 7.5C13.125 9.12445 12.4797 10.6824 11.331 11.831C10.1824 12.9797 8.62445 13.625 7 13.625ZM7 14.5C8.85652 14.5 10.637 13.7625 11.9497 12.4497C13.2625 11.137 14 9.35652 14 7.5C14 5.64348 13.2625 3.86301 11.9497 2.55025C10.637 1.2375 8.85652 0.5 7 0.5C5.14348 0.5 3.36301 1.2375 2.05025 2.55025C0.737498 3.86301 0 5.64348 0 7.5C0 9.35652 0.737498 11.137 2.05025 12.4497C3.36301 13.7625 5.14348 14.5 7 14.5Z" fill="black"/>
                                                <path d="M7.81371 6.2645L5.80996 6.51562L5.73821 6.84812L6.13196 6.92075C6.38921 6.982 6.43996 7.07475 6.38396 7.33113L5.73821 10.3656C5.56846 11.1505 5.83008 11.5197 6.44521 11.5197C6.92208 11.5197 7.47596 11.2993 7.72708 10.9965L7.80408 10.6325C7.62908 10.7865 7.37358 10.8478 7.20383 10.8478C6.96321 10.8478 6.87571 10.6789 6.93783 10.3814L7.81371 6.2645ZM7.87496 4.4375C7.87496 4.66956 7.78277 4.89212 7.61868 5.05622C7.45458 5.22031 7.23202 5.3125 6.99996 5.3125C6.76789 5.3125 6.54533 5.22031 6.38124 5.05622C6.21715 4.89212 6.12496 4.66956 6.12496 4.4375C6.12496 4.20544 6.21715 3.98288 6.38124 3.81878C6.54533 3.65469 6.76789 3.5625 6.99996 3.5625C7.23202 3.5625 7.45458 3.65469 7.61868 3.81878C7.78277 3.98288 7.87496 4.20544 7.87496 4.4375Z" fill="black"/>
                                            </svg>
                                        </span>
                                        <span>$387.00 Quarterly Membership</span>
                                    </div>

                                    <span class="plan-badge">
                                        <span class="plan-badge-txt">Save <br> $366</span>
                                        <span class="plan-badge-img">
                                            <img src="{{ asset('assets/images/plan-2.svg')}}" class="img-fluid">
                                        </span>
                                    </span>

                                </label>
                            </div>
                            <div class="mb-3">
                                <input type="radio" class="btn-check" name="membership" id="yearly" autocomplete="off" value="yearly">
                                <label id="plan3" class="btn pricing-form-control shadow-none " for="yearly">
                                    <div class="d-flex gap-1 align-items-center">
                                        <span class="btn-check-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="15" viewBox="0 0 14 15" fill="none">
                                                <path d="M7 13.625C5.37555 13.625 3.81763 12.9797 2.66897 11.831C1.52031 10.6824 0.875 9.12445 0.875 7.5C0.875 5.87555 1.52031 4.31763 2.66897 3.16897C3.81763 2.02031 5.37555 1.375 7 1.375C8.62445 1.375 10.1824 2.02031 11.331 3.16897C12.4797 4.31763 13.125 5.87555 13.125 7.5C13.125 9.12445 12.4797 10.6824 11.331 11.831C10.1824 12.9797 8.62445 13.625 7 13.625ZM7 14.5C8.85652 14.5 10.637 13.7625 11.9497 12.4497C13.2625 11.137 14 9.35652 14 7.5C14 5.64348 13.2625 3.86301 11.9497 2.55025C10.637 1.2375 8.85652 0.5 7 0.5C5.14348 0.5 3.36301 1.2375 2.05025 2.55025C0.737498 3.86301 0 5.64348 0 7.5C0 9.35652 0.737498 11.137 2.05025 12.4497C3.36301 13.7625 5.14348 14.5 7 14.5Z" fill="black"/>
                                                <path d="M7.81371 6.2645L5.80996 6.51562L5.73821 6.84812L6.13196 6.92075C6.38921 6.982 6.43996 7.07475 6.38396 7.33113L5.73821 10.3656C5.56846 11.1505 5.83008 11.5197 6.44521 11.5197C6.92208 11.5197 7.47596 11.2993 7.72708 10.9965L7.80408 10.6325C7.62908 10.7865 7.37358 10.8478 7.20383 10.8478C6.96321 10.8478 6.87571 10.6789 6.93783 10.3814L7.81371 6.2645ZM7.87496 4.4375C7.87496 4.66956 7.78277 4.89212 7.61868 5.05622C7.45458 5.22031 7.23202 5.3125 6.99996 5.3125C6.76789 5.3125 6.54533 5.22031 6.38124 5.05622C6.21715 4.89212 6.12496 4.66956 6.12496 4.4375C6.12496 4.20544 6.21715 3.98288 6.38124 3.81878C6.54533 3.65469 6.76789 3.5625 6.99996 3.5625C7.23202 3.5625 7.45458 3.65469 7.61868 3.81878C7.78277 3.98288 7.87496 4.20544 7.87496 4.4375Z" fill="black"/>
                                              </svg>
                                        </span>
                                        <span class="d-flex flex-column align-items-start">
                                            <span class="popular-plan">Most popular</span>
                                            <span>$787.00 Annual Membership</span>
                                        </span>
                                    </div>

                                    <span class="plan-badge">
                                        <span class="plan-badge-txt2">Save <br> $977</span>
                                        <span class="plan-badge-img">
                                            <img src="{{ asset('assets/images/plan-3.svg')}}" class="img-fluid">
                                        </span>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <div class="secure-checkout">
                            <div class="secure-checkout-main-img">
                                <img src="{{ asset('assets/images/secure-checkout.png') }}" class="img-fluid">
                            </div>
                            <div class="secure-checkout-img">
                                <img src="{{ asset('assets/images/secure-checkout1.png') }}" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        
    </section>
    <!-- REGISTER -->

    <!-- POPOVER -->
    <div hidden >
        <div data-name="plan-1">
            <ul class="nav flex-column">
                <li>
                    <span class="popover-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 48 48"><defs><mask id="ipSCheckOne0"><g fill="none" stroke-linejoin="round" stroke-width="4"><path fill="#fff" stroke="#fff" d="M24 44a19.937 19.937 0 0 0 14.142-5.858A19.937 19.937 0 0 0 44 24a19.938 19.938 0 0 0-5.858-14.142A19.937 19.937 0 0 0 24 4A19.938 19.938 0 0 0 9.858 9.858A19.938 19.938 0 0 0 4 24a19.937 19.937 0 0 0 5.858 14.142A19.938 19.938 0 0 0 24 44Z"/><path stroke="#000" stroke-linecap="round" d="m16 24l6 6l12-12"/></g></mask></defs><path fill="currentColor" d="M0 0h48v48H0z" mask="url(#ipSCheckOne0)"/></svg>
                    </span>
                    <span>Average of 2-5 easy to follow trade alerts per week</span>
                </li>
                <li>
                    <span class="popover-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 48 48"><defs><mask id="ipSCheckOne0"><g fill="none" stroke-linejoin="round" stroke-width="4"><path fill="#fff" stroke="#fff" d="M24 44a19.937 19.937 0 0 0 14.142-5.858A19.937 19.937 0 0 0 44 24a19.938 19.938 0 0 0-5.858-14.142A19.937 19.937 0 0 0 24 4A19.938 19.938 0 0 0 9.858 9.858A19.938 19.938 0 0 0 4 24a19.937 19.937 0 0 0 5.858 14.142A19.938 19.938 0 0 0 24 44Z"/><path stroke="#000" stroke-linecap="round" d="m16 24l6 6l12-12"/></g></mask></defs><path fill="currentColor" d="M0 0h48v48H0z" mask="url(#ipSCheckOne0)"/></svg>
                    </span>
                    <span>All swing trades... perfect for the working professional</span>
                </li>
                <li>
                    <span class="popover-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 48 48"><defs><mask id="ipSCheckOne0"><g fill="none" stroke-linejoin="round" stroke-width="4"><path fill="#fff" stroke="#fff" d="M24 44a19.937 19.937 0 0 0 14.142-5.858A19.937 19.937 0 0 0 44 24a19.938 19.938 0 0 0-5.858-14.142A19.937 19.937 0 0 0 24 4A19.938 19.938 0 0 0 9.858 9.858A19.938 19.938 0 0 0 4 24a19.937 19.937 0 0 0 5.858 14.142A19.938 19.938 0 0 0 24 44Z"/><path stroke="#000" stroke-linecap="round" d="m16 24l6 6l12-12"/></g></mask></defs><path fill="currentColor" d="M0 0h48v48H0z" mask="url(#ipSCheckOne0)"/></svg>
                    </span>
                    <span>All entries and exits delivered in real-time via text message</span>
                </li>
                <li>
                    <span class="popover-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 48 48"><defs><mask id="ipSCheckOne0"><g fill="none" stroke-linejoin="round" stroke-width="4"><path fill="#fff" stroke="#fff" d="M24 44a19.937 19.937 0 0 0 14.142-5.858A19.937 19.937 0 0 0 44 24a19.938 19.938 0 0 0-5.858-14.142A19.937 19.937 0 0 0 24 4A19.938 19.938 0 0 0 9.858 9.858A19.938 19.938 0 0 0 4 24a19.937 19.937 0 0 0 5.858 14.142A19.938 19.938 0 0 0 24 44Z"/><path stroke="#000" stroke-linecap="round" d="m16 24l6 6l12-12"/></g></mask></defs><path fill="currentColor" d="M0 0h48v48H0z" mask="url(#ipSCheckOne0)"/></svg>
                    </span>
                    <span>Access to the real time portfolio tracker</span>
                </li>
                <li>
                    <span class="popover-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 48 48"><defs><mask id="ipSCheckOne0"><g fill="none" stroke-linejoin="round" stroke-width="4"><path fill="#fff" stroke="#fff" d="M24 44a19.937 19.937 0 0 0 14.142-5.858A19.937 19.937 0 0 0 44 24a19.938 19.938 0 0 0-5.858-14.142A19.937 19.937 0 0 0 24 4A19.938 19.938 0 0 0 9.858 9.858A19.938 19.938 0 0 0 4 24a19.937 19.937 0 0 0 5.858 14.142A19.938 19.938 0 0 0 24 44Z"/><path stroke="#000" stroke-linecap="round" d="m16 24l6 6l12-12"/></g></mask></defs><path fill="currentColor" d="M0 0h48v48H0z" mask="url(#ipSCheckOne0)"/></svg>
                    </span>
                    <span>Access to the exclusive member only weekly Trading Report with market outlook and portfolio update</span>
                </li>
            </ul>
        </div>


        <div data-name="plan-2">
            <ul class="nav flex-column">
                <li>
                    <span class="popover-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 48 48"><defs><mask id="ipSCheckOne0"><g fill="none" stroke-linejoin="round" stroke-width="4"><path fill="#fff" stroke="#fff" d="M24 44a19.937 19.937 0 0 0 14.142-5.858A19.937 19.937 0 0 0 44 24a19.938 19.938 0 0 0-5.858-14.142A19.937 19.937 0 0 0 24 4A19.938 19.938 0 0 0 9.858 9.858A19.938 19.938 0 0 0 4 24a19.937 19.937 0 0 0 5.858 14.142A19.938 19.938 0 0 0 24 44Z"/><path stroke="#000" stroke-linecap="round" d="m16 24l6 6l12-12"/></g></mask></defs><path fill="currentColor" d="M0 0h48v48H0z" mask="url(#ipSCheckOne0)"/></svg>
                    </span>
                    <span>Average of 2-5 easy to follow trade alerts per week</span>
                </li>
                <li>
                    <span class="popover-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 48 48"><defs><mask id="ipSCheckOne0"><g fill="none" stroke-linejoin="round" stroke-width="4"><path fill="#fff" stroke="#fff" d="M24 44a19.937 19.937 0 0 0 14.142-5.858A19.937 19.937 0 0 0 44 24a19.938 19.938 0 0 0-5.858-14.142A19.937 19.937 0 0 0 24 4A19.938 19.938 0 0 0 9.858 9.858A19.938 19.938 0 0 0 4 24a19.937 19.937 0 0 0 5.858 14.142A19.938 19.938 0 0 0 24 44Z"/><path stroke="#000" stroke-linecap="round" d="m16 24l6 6l12-12"/></g></mask></defs><path fill="currentColor" d="M0 0h48v48H0z" mask="url(#ipSCheckOne0)"/></svg>
                    </span>
                    <span>All swing trades... perfect for the working professional</span>
                </li>
                <li>
                    <span class="popover-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 48 48"><defs><mask id="ipSCheckOne0"><g fill="none" stroke-linejoin="round" stroke-width="4"><path fill="#fff" stroke="#fff" d="M24 44a19.937 19.937 0 0 0 14.142-5.858A19.937 19.937 0 0 0 44 24a19.938 19.938 0 0 0-5.858-14.142A19.937 19.937 0 0 0 24 4A19.938 19.938 0 0 0 9.858 9.858A19.938 19.938 0 0 0 4 24a19.937 19.937 0 0 0 5.858 14.142A19.938 19.938 0 0 0 24 44Z"/><path stroke="#000" stroke-linecap="round" d="m16 24l6 6l12-12"/></g></mask></defs><path fill="currentColor" d="M0 0h48v48H0z" mask="url(#ipSCheckOne0)"/></svg>
                    </span>
                    <span>All entries and exits delivered in real-time via text message</span>
                </li>
                <li>
                    <span class="popover-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 48 48"><defs><mask id="ipSCheckOne0"><g fill="none" stroke-linejoin="round" stroke-width="4"><path fill="#fff" stroke="#fff" d="M24 44a19.937 19.937 0 0 0 14.142-5.858A19.937 19.937 0 0 0 44 24a19.938 19.938 0 0 0-5.858-14.142A19.937 19.937 0 0 0 24 4A19.938 19.938 0 0 0 9.858 9.858A19.938 19.938 0 0 0 4 24a19.937 19.937 0 0 0 5.858 14.142A19.938 19.938 0 0 0 24 44Z"/><path stroke="#000" stroke-linecap="round" d="m16 24l6 6l12-12"/></g></mask></defs><path fill="currentColor" d="M0 0h48v48H0z" mask="url(#ipSCheckOne0)"/></svg>
                    </span>
                    <span>Access to the real time portfolio tracker</span>
                </li>
                <li>
                    <span class="popover-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 48 48"><defs><mask id="ipSCheckOne0"><g fill="none" stroke-linejoin="round" stroke-width="4"><path fill="#fff" stroke="#fff" d="M24 44a19.937 19.937 0 0 0 14.142-5.858A19.937 19.937 0 0 0 44 24a19.938 19.938 0 0 0-5.858-14.142A19.937 19.937 0 0 0 24 4A19.938 19.938 0 0 0 9.858 9.858A19.938 19.938 0 0 0 4 24a19.937 19.937 0 0 0 5.858 14.142A19.938 19.938 0 0 0 24 44Z"/><path stroke="#000" stroke-linecap="round" d="m16 24l6 6l12-12"/></g></mask></defs><path fill="currentColor" d="M0 0h48v48H0z" mask="url(#ipSCheckOne0)"/></svg>
                    </span>
                    <span>Access to the exclusive member only weekly Trading Report with market outlook and portfolio update</span>
                </li>
            </ul>
        </div>

        <div data-name="plan-3">
            <ul class="nav flex-column">
                <li>
                    <span class="popover-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 48 48"><defs><mask id="ipSCheckOne0"><g fill="none" stroke-linejoin="round" stroke-width="4"><path fill="#fff" stroke="#fff" d="M24 44a19.937 19.937 0 0 0 14.142-5.858A19.937 19.937 0 0 0 44 24a19.938 19.938 0 0 0-5.858-14.142A19.937 19.937 0 0 0 24 4A19.938 19.938 0 0 0 9.858 9.858A19.938 19.938 0 0 0 4 24a19.937 19.937 0 0 0 5.858 14.142A19.938 19.938 0 0 0 24 44Z"/><path stroke="#000" stroke-linecap="round" d="m16 24l6 6l12-12"/></g></mask></defs><path fill="currentColor" d="M0 0h48v48H0z" mask="url(#ipSCheckOne0)"/></svg>
                    </span>
                    <span>Average of 2-5 easy to follow trade alerts per week</span>
                </li>
                <li>
                    <span class="popover-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 48 48"><defs><mask id="ipSCheckOne0"><g fill="none" stroke-linejoin="round" stroke-width="4"><path fill="#fff" stroke="#fff" d="M24 44a19.937 19.937 0 0 0 14.142-5.858A19.937 19.937 0 0 0 44 24a19.938 19.938 0 0 0-5.858-14.142A19.937 19.937 0 0 0 24 4A19.938 19.938 0 0 0 9.858 9.858A19.938 19.938 0 0 0 4 24a19.937 19.937 0 0 0 5.858 14.142A19.938 19.938 0 0 0 24 44Z"/><path stroke="#000" stroke-linecap="round" d="m16 24l6 6l12-12"/></g></mask></defs><path fill="currentColor" d="M0 0h48v48H0z" mask="url(#ipSCheckOne0)"/></svg>
                    </span>
                    <span>All swing trades... perfect for the working professional</span>
                </li>
                <li>
                    <span class="popover-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 48 48"><defs><mask id="ipSCheckOne0"><g fill="none" stroke-linejoin="round" stroke-width="4"><path fill="#fff" stroke="#fff" d="M24 44a19.937 19.937 0 0 0 14.142-5.858A19.937 19.937 0 0 0 44 24a19.938 19.938 0 0 0-5.858-14.142A19.937 19.937 0 0 0 24 4A19.938 19.938 0 0 0 9.858 9.858A19.938 19.938 0 0 0 4 24a19.937 19.937 0 0 0 5.858 14.142A19.938 19.938 0 0 0 24 44Z"/><path stroke="#000" stroke-linecap="round" d="m16 24l6 6l12-12"/></g></mask></defs><path fill="currentColor" d="M0 0h48v48H0z" mask="url(#ipSCheckOne0)"/></svg>
                    </span>
                    <span>All entries and exits delivered in real-time via text message</span>
                </li>
                <li>
                    <span class="popover-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 48 48"><defs><mask id="ipSCheckOne0"><g fill="none" stroke-linejoin="round" stroke-width="4"><path fill="#fff" stroke="#fff" d="M24 44a19.937 19.937 0 0 0 14.142-5.858A19.937 19.937 0 0 0 44 24a19.938 19.938 0 0 0-5.858-14.142A19.937 19.937 0 0 0 24 4A19.938 19.938 0 0 0 9.858 9.858A19.938 19.938 0 0 0 4 24a19.937 19.937 0 0 0 5.858 14.142A19.938 19.938 0 0 0 24 44Z"/><path stroke="#000" stroke-linecap="round" d="m16 24l6 6l12-12"/></g></mask></defs><path fill="currentColor" d="M0 0h48v48H0z" mask="url(#ipSCheckOne0)"/></svg>
                    </span>
                    <span>Access to the real time portfolio tracker</span>
                </li>
                <li>
                    <span class="popover-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 48 48"><defs><mask id="ipSCheckOne0"><g fill="none" stroke-linejoin="round" stroke-width="4"><path fill="#fff" stroke="#fff" d="M24 44a19.937 19.937 0 0 0 14.142-5.858A19.937 19.937 0 0 0 44 24a19.938 19.938 0 0 0-5.858-14.142A19.937 19.937 0 0 0 24 4A19.938 19.938 0 0 0 9.858 9.858A19.938 19.938 0 0 0 4 24a19.937 19.937 0 0 0 5.858 14.142A19.938 19.938 0 0 0 24 44Z"/><path stroke="#000" stroke-linecap="round" d="m16 24l6 6l12-12"/></g></mask></defs><path fill="currentColor" d="M0 0h48v48H0z" mask="url(#ipSCheckOne0)"/></svg>
                    </span>
                    <span>Access to the exclusive member only weekly Trading Report with market outlook and portfolio update</span>
                </li>
            </ul>
        </div>
    </div>
    <!-- POPOVER -->

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


        // <=========== password show/hide start ===========>
        $(".toggle-passwords-btn").click(function () {
            $(this).find(".icon").toggle();
            input = $(this).parent().find("input");
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
        // <=========== password show/hide end ===========>

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
				activeQuareterlyIcon();
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

		function activeQuareterlyIcon() {
			monthly_membership.find('.active-icon').addClass('d-none');
			monthly_membership.find('.inactive-icon').removeClass('d-none');
			quarterly_membership.find('.active-icon').removeClass('d-none');
			quarterly_membership.find('.inactive-icon').addClass('d-none');
			yearly_membership.find('.active-icon').addClass('d-none');
			yearly_membership.find('.inactive-icon').removeClass('d-none');
		}

		// payment_option.click(function() {
		// 	// if (!$(this).hasClass('payment_active')) {
		// 	// 	//remove payment-active class
		// 	// 	payment_option.removeClass('payment_active');

		// 	// 	//Add class again
		// 	// 	$(this).addClass('payment_active');

		// 	// 	//remove radion button
		// 	// 	if ($(this).hasClass('stripe-option')) {
		// 	// 		stripe_option.prop('checked', true);
		// 	// 		paypal_option.prop('checked', false);
		// 	// 		img_stripe.removeClass('d-none');
		// 	// 		img_paypal.addClass('d-none');
		// 	// 	} else {
		// 	// 		stripe_option.prop('checked', false);
		// 	// 		paypal_option.prop('checked', true);
		// 	// 		img_stripe.addClass('d-none');
		// 	// 		img_paypal.removeClass('d-none');
		// 	// 	}
		// 	// }

		// 	// var paymentOption = $('input[name="payment_option"]:checked').val();

		// 	// if (paymentOption == 'paypal') {
		// 	// 	stripe_payment.addClass('d-none');
		// 	// 	btn_payment.text('Pay with PayPal');
		// 	// } else {
		// 	// 	stripe_payment.removeClass('d-none');
		// 	// 	btn_payment.text('Pay with Credit/Debit Card');
		// 	// }
		// })

        $("input[name='payment_option']").click(function() {
            var test = $(this).val();
            $(".desc").hide();

            if(test == 'paypal'){
                $(".btn_payment").text('Pay with PayPal');
            } else{
                $("#" + test).show();
                $(".btn_payment").text('Pay with Credit/Debit Card');
            }
        });


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
		// memberships.click(function() {
		// 	var membership_type = 'monthly';

		// 	if ($(this).hasClass('monthly-membership')) {
		// 		updateCheckoutAttributes('monthly', 147, 'mo');
		// 		clearMembershipClass();
		// 		$('.monthly-membership').addClass('membership_active');
		// 		stripe_plan_id.val(month_plan_stripe);
		// 		paypal_plan_id.val(month_plan_paypal);
		// 		activeMonthlyIcon();
		// 	} else if ($(this).hasClass('quarterly-membership')) {
		// 		updateCheckoutAttributes('quarterly', 387, 'qu');
		// 		clearMembershipClass();
		// 		$('.quarterly-membership').addClass('membership_active');
		// 		stripe_plan_id.val(quarter_plan_stripe);
		// 		paypal_plan_id.val(quarter_plan_paypal);
		// 		activeQuareterlyIcon();
		// 	} else if ($(this).hasClass('yearly-membership')) {
		// 		updateCheckoutAttributes('yearly', 787, 'yr');
		// 		clearMembershipClass();
		// 		$('.yearly-membership').addClass('membership_active');
		// 		stripe_plan_id.val(year_plan_stripe);
		// 		paypal_plan_id.val(year_plan_paypal);
		// 		activeYearlyIcon();
		// 	}

		// })

        $("input[name='membership']").click(function() {
            var test = $(this).val();
            if(test == 'quartely'){
                $("#plan-price").text('$387/QU');
                updateCheckoutAttributes('quartely', 387, 'qu');
				clearMembershipClass();
				stripe_plan_id.val(quarter_plan_stripe);
				paypal_plan_id.val(quarter_plan_paypal);
                activeQuareterlyIcon();
            }
            else if(test == 'yearly'){
                $("#plan-price").text('$787/YR');
                updateCheckoutAttributes('yearly', 787, 'yr');
				clearMembershipClass();
				stripe_plan_id.val(year_plan_stripe);
				paypal_plan_id.val(year_plan_paypal);
                activeYearlyIcon();
            }
            else{
                $("#plan-price").text('$147/MO');
                updateCheckoutAttributes('monthly', 147, 'mo');
				clearMembershipClass();
                stripe_plan_id.val(month_plan_stripe);
				paypal_plan_id.val(month_plan_paypal);
                activeMonthlyIcon();
            }
        });

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
		// var card = elements.create('card', {
		// 	style: style,
		// 	hidePostalCode: true
		// });

		// Add an instance of the card Element into the `card-element` <div>
        var cardNumberElement = elements.create('cardNumber', {
            style: style,
            placeholder: 'Card number',
        });
        cardNumberElement.mount('#card-number-element');

        var cardExpiryElement = elements.create('cardExpiry', {
            style: style,
            placeholder: 'MM/YY',
        });
        cardExpiryElement.mount('#card-expiry-element');

        var cardCvcElement = elements.create('cardCvc', {
            style: style,
            placeholder: 'CVC',
        });
        cardCvcElement.mount('#card-cvc-element');
		// card.mount('#card-element');

		// Handle real-time validation errors from the card Element.
		// cardNumberElement.addEventListener('change', function(event) {
		// 	var displayError = document.getElementById('card-errors');
		// 	if (event.error) {
		// 		displayError.textContent = event.error.message;
		// 	} else {
		// 		displayError.textContent = '';
		// 	}
		// });


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
			var first_name = $('#payment-form #first-name');
			var last_name = $('#payment-form #last-name');
			var email = $('#payment-form #email');
			var mobile_number = $('#payment-form #mobile-number');
			var password = $('#payment-form #password1');
			// var password_confirmation = $('#payment-form #password_confirmation');

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
				$('.mobile-number-error').removeClass('d-none').addClass('d-block');
			} else {
				mobile_number.removeClass('error');
			}

			if (password.val() == '') {
				isValid = false;
				password.addClass('error');
				$('.password1-error').removeClass('d-none');
			} else {
				password.removeClass('error');
			}

			if (paymentOption == 'stripe') {

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
					$('.terms-error').removeClass('d-none').addClass('d-block');
				} else {
					$('.terms').removeClass('error');
				}

				if (!conditionsChecked) {
					isValid = false;
					$('.conditions').addClass('error');
					$('.conditions-error').removeClass('d-none').addClass('d-block');
				} else {
					$('.conditions').removeClass('error');
				}
				if (isValid) {

					stripe.createToken(cardNumberElement).then(function(result) {
						if (result.error) {
							// Display an error message to the user.
							$('#card-errors').text(result.error.message)
							// var errorElement = document.getElementById('card-errors');
							// errorElement.textContent = result.error.message;
						} else {
							// You can now use the Payment Method ID on your server to make a payment.
							// console.log(result.token.id);
							stripeTokenHandler(result.token.id);
							// Send the Payment Method ID to your server for further processing.
							$('#overlay, #loadingSpinner').show();
						}
					});
				} else {
					// $('#overlay, #loadingSpinner').hide();
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

		$('input[type="text"],input[type="email"],input[type="password"]').on('keyup',function(e){

			var input_id = $(`#payment-form #${this.id}`);
			if(this.value){

				if(this.id == 'email'){
					var pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
					var email_input = input_id.val();
					if(!pattern.test(email_input)){
						input_id.addClass('error');
						$(`.${this.id}-error-invelid`).removeClass('d-none').addClass('d-block');
					}else{
						input_id.removeClass('error');
						$(`.${this.id}-error-invelid`).addClass('d-none').removeClass('d-block');
					}
				}else{
					input_id.removeClass('error');
				}
				$(`.${this.id}-error`).addClass('d-none').removeClass('d-block');
			}else{
				input_id.addClass('error');
				$(`.${this.id}-error`).removeClass('d-none').addClass('d-block');
			}
		});

		$('input[type="checkbox"]').on('change',function(e){
			var input_check_id = $(`#payment-form #${this.id}`);
			if(input_check_id.is(':checked')){
				input_check_id.removeClass('error');
				$(`.${this.id}-error`).addClass('d-none').removeClass('d-block');
			}else{
				input_check_id.addClass('error');
				$(`.${this.id}-error`).removeClass('d-none').addClass('d-block');
			}
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

		function PayPalHandler() {
			var payment_form = document.getElementById('payment-form');
			payment_form.submit();
		}

        $(document).ready(function() {
            var plan1options = {
                html: true,
                trigger: 'hover',
                placement: 'left',
                customClass: 'popover-custom',
                content: $('[data-name="plan-1"]'),
            }
            var plan1 = document.getElementById('plan1')
            var popover1 = new bootstrap.Popover(plan1, plan1options)

            var plan2options = {
                html: true,
                trigger: 'hover',
                placement: 'left',
                customClass: 'popover-custom',
                content: $('[data-name="plan-2"]'),
            }
            var plan2 = document.getElementById('plan2')
            var popover2 = new bootstrap.Popover(plan2, plan2options)

            var plan3options = {
                html: true,
                trigger: 'hover',
                placement: 'left',
                customClass: 'popover-custom',
                content: $('[data-name="plan-3"]'),
            }
            var plan3 = document.getElementById('plan3')
            var popover3 = new bootstrap.Popover(plan3, plan3options)

        })

        const phoneInputField = document.querySelector("#mobile-number");
        const phoneInput = window.intlTelInput(phoneInputField,{
        utilsScript:"https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",});
	</script>
@endsection
