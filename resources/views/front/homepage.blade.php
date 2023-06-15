@extends('layouts.frontmaster')
@section('title', 'Homepage')

@section('page-style')

@endsection


@section('content')
    <section class="home-banner">
        <img src="{{ asset('assets/image/banner.png') }}" />
    </section>
    <section class="home-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="welcome-msg">
                        Welcome to TradeInSync, your premier destination for reliable and timely stock and options trading alerts. Gain an edge in the market with our expertly curated trade recommendations and stay informed about profitable opportunities. Join our community of traders and unlock your potential for financial success. Take control of your investments with TradeinSync, where profitable trades are just a click away.
                    </h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-7">
                    <h4 class="welcome-msg mobile-pt-0">
                        We make trading quick, simple and accessible for new and experienced traders. We help our members gain confidence in their trades by equipping them with the tools they need to expand their portfolio & earn profits. 
        
                    </h4>
                </div>
                <div class="col-md-5">
                    <img src="{{asset('assets/image/computer.png')}}" />
                </div>
            </div>
        </div>
    </section>
@endsection


@section('page-script')

@endsection