@extends('layouts.front-master')
@section('title', 'Subscription')

@section('page-style')

@endsection


@section('content')
    <div class="container">
        <section class="subscription-section">
            <h1 class="text-center subscription-title">Start Winning Make Trades Today</h1>
            <div class="row">
                <div class="col-md-6">
                    <div class="side-by-side__image clipped-image blue-underlay">
                        <img src="{{ asset('assets/image/man-desktop-screens-2-1066px.jpg')}}" />
                    </div>
                </div>
                <div class="col-md-6 subscription_content">                
                    <h2 class="text-center">This is what you will get when you join:</h2>
                    <ul>
                        <li>Real-Time Trade Alerts</li>
                        <li>SMS and Email Alerts</li>
                        <li>Real Time Portfolio Tracker</li>
                        <li>Exclusive weekly Newsletter</li>
                        <li>Member Only Educational Center</li>
                        <li>Quick email response</li>
                    </ul>                
                </div>
            </div>
            <div class="subscription_row">
                <div class="subscription_box">
                    <p class="title text-center">Monthly</p>
                    <p class="price text-center"><span class="subscription_price">$147</span>/mo</p>
                    <div class="content">
                        <ul>
                            <li>
                                Average of 2-4 easy to follow real-time trade alerts per week*
                            </li>
                            <li>
                                All entries and exits delivered in real-time via SMS and Email
                            </li>
                            <li>
                                Standard price
                            </li>
                        </ul>
                    </div>
                    @auth
                        @if (count($activeSubscription) > 0)
                            <a href="#" class="btn_subscribe">Subscribed</a>
                        @else
                            <a href="{{ route('front.checkout', 'm') }}" class="btn_subscribe btn_subscribe_popular">Subscribe</a>    
                        @endif
                    @else
                        <a href="{{ route('front.checkout', 'm') }}" class="btn_subscribe">Subscribe</a>
                    @endauth
                    
                </div>

                <div class="subscription_box subsscription_box_popular">
                    <p class="popular_badge">Most Popular</p>
                    <p class="title text-center">Yearly</p>
                    <p class="price text-center"><span class="subscription_price">$787</span>/yr</p>
                    <div class="content">
                        <ul>
                            <li>
                                Average of 2-4 easy to follow real-time trade alerts per week*
                            </li>
                            <li>
                                All entries and exits delivered in real-time via SMS and Email
                            </li>
                            <li>
                                Save $1,174!
                            </li>
                        </ul>
                    </div>
                    @auth
                        @if (count($activeSubscription) > 0)
                            <a href="#" class="btn_subscribe btn_subscribe_popular">Subscribed</a>
                        @else
                            <a href="{{ route('front.checkout', 'y') }}" class="btn_subscribe btn_subscribe_popular">Subscribe</a>    
                        @endif
                    @else
                        <a href="{{ route('front.checkout', 'y') }}" class="btn_subscribe btn_subscribe_popular">Subscribe</a>
                    @endauth
                    
                </div> 

                <div class="subscription_box">
                    <p class="title text-center">Quarterly</p>
                    <p class="price text-center"><span class="subscription_price">$387</span>/qu</p>
                    <div class="content">
                        <ul>
                            <li>
                                Average of 2-4 easy to follow real-time trade alerts per week*
                            </li>
                            <li>
                                All entries and exits delivered in real-time via SMS and Email
                            </li>
                            <li>
                                Save $336!
                            </li>
                        </ul>
                    </div>
                    @auth
                        @if (count($activeSubscription) > 0)
                            <a href="#" class="btn_subscribe">Subscribed</a>
                        @else
                            <a href="{{ route('front.checkout', 'q') }}" class="btn_subscribe btn_subscribe_popular">Subscribe</a>    
                        @endif
                    @else
                        <a href="{{ route('front.checkout', 'q') }}" class="btn_subscribe">Subscribe</a>
                    @endauth
                    
                </div>           
            </div>
            <p class="short-description text-center">(All memberships renew automatically - cancel anytime)</p>
            <p class="short-description text-center">*Number of alerts is fully dependent upon the market conditions and the number of high quality opportunities that present themselves</p>
            <p class="short-description text-center">**Savings displayed on this page are calculated based on the standard monthly price of $147 per month</p>
        </section>
    </div>
    
@endsection


@section('page-script')

@endsection