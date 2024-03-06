@extends('layouts.front-master')
@section('title', 'Homepage')

@section('page-style')
<style>
    .error{
        color: red !important;
    }
    #msg{
        display: none;
        color: green;
    }
    .trade-stocks-card{
        background-color: white;
        padding: 20px;
    }
</style>
@endsection


@section('content')
     <!-- BANNER -->
    <section class="trade-stocks">
        <div class="container-xl">
            <div class="row g-4 g-lg-3 position-relative">
                <div class="col-12 col-md-6 col-lg-6 order-2 order-md-1">
                    <h1 class="title">Trade stocks like a pro with the help of experts with over 20 years of profitable trading experience.</h1>
                    <p>Significantly grow your profits & de-risk your investments with our real-time trade alerts.</p>
                    <a href="{{ route('front.checkout', 'm') }}" class="btn btn-grn">Monthly for $147</a>
                    <div class="small-txt"> Average of 2-4 easy to follow real-time trade alerts per week*</div>
                </div>
                <div class="col-12 col-md-6 col-lg-6 order-1 order-md-2 position-relative">

                    @php $collection = collect($trades); @endphp

                    @if (sizeof($trades))
                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper">
                                @foreach($trades->chunk(4) as $trade)
                                    <div  class="swiper-slide">
                                    @foreach($trade as $trade_detail)
                                        <div class="stock-card">
                                            <div class="stockname">
                                                <div class="stockprofile">
                                                    <div class="stockimg">
                                                        @if(!empty($trade_detail->symbol_image))
                                                            <img src="{{ $trade_detail->symbol_image }}" alt="">
                                                        @else
                                                            <img src="{{ asset('assets/images/Logo.png')}}" alt="">
                                                        @endif
                                                    </div>
                                                    <div class="stock-name">{{$trade_detail->trade_symbol}}</div>
                                                </div>
                                                <ul class="nav">
                                                    <li>@if($trade_detail->trade_direction == 'buy') Long @else Short @endif</li>
                                                    {{-- <li class="divider"></li> --}}
                                                    {{-- <li>Current price: ${{!empty($trade_detail->current_price) ? number_format($trade_detail->current_price,2) : ''}}</li> --}}
                                                </ul>
                                            </div>
                                            <div class="stockdetail">
                                                <ul class="nav">
                                                    <li>Entry date: {{!empty($trade_detail->entry_date) ? date('d-m-Y',strtotime($trade_detail->entry_date)) : ''}}</li>
                                                    <li class="divider"></li>
                                                    <li>Entry price: ${{!empty($trade_detail->entry_price) ? number_format($trade_detail->entry_price,2) : ''}}</li>
                                                </ul>
                                                <ul class="nav">
                                                    <li>Exit date: {{!empty($trade_detail->exit_date) ? date('d-m-Y',strtotime($trade_detail->exit_date)) : ''}}</li>
                                                    <li class="divider"></li>
                                                    <li>Exit price: ${{!empty($trade_detail->exit_price) ? number_format($trade_detail->exit_price,2) : ''}}</li>
                                                </ul>
                                                <ul class="nav">
                                                    <li>Position: {{!empty($trade_detail->position_size) ? number_format($trade_detail->position_size) : '0'}}%  </li>
                                                    <li class="divider"></li>
                                                    <li class="stockprofit">Profit (%):
                                                        <span class="tblprofit">@if ($trade_detail->trade_direction == 'buy')
                                                        @php
                                                            $buyProfits = number_format(( $trade_detail->exit_price - $trade_detail->entry_price ) / $trade_detail->entry_price * 100, 2);
                                                        @endphp
                                                        @if ($trade_detail->entry_price != 0 ) {{ $buyProfits }}% @else 0% @endif
                                                    @else
                                                        @php
                                                            $sellProfits = number_format(( $trade_detail->entry_price - $trade_detail->exit_price ) / $trade_detail->entry_price * 100, 2);
                                                        @endphp
                                                        @if ($trade_detail->entry_price != 0 ) {{ $sellProfits }}% @else 0% @endif
                                                    @endif</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    @endforeach()
                                    </div>
                                @endforeach


                            {{-- <div class="swiper-slide">
                                <div class="stock-card">
                                    <div class="stockname">
                                        <div class="stockprofile">
                                            <div class="stockimg">
                                                <img src="{{ asset('assets/images/unh1.png')}}" alt="">
                                            </div>
                                            <div class="stock-name">UNH</div>
                                        </div>
                                        <ul class="nav">
                                            <li>Long</li>
                                            <li class="divider"></li>
                                            <li>Current price: $530.00</li>
                                        </ul>
                                    </div>
                                    <div class="stockdetail">
                                        <ul class="nav">
                                            <li>Entry date: 19-09-2023</li>
                                            <li class="divider"></li>
                                            <li>Entry price: $479.00</li>
                                        </ul>
                                        <ul class="nav">
                                            <li>Exit date: 21-09-2023</li>
                                            <li class="divider"></li>
                                            <li>Exit price: $502.00</li>
                                        </ul>
                                        <ul class="nav">
                                            <li>Position: 4%  </li>
                                            <li class="divider"></li>
                                            <li class="stockprofit">Profit (%): <span class="tblprofit">23%</span></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="stock-card">
                                        <div class="stockname">
                                            <div class="stockprofile">
                                                <div class="stockimg">
                                                    <img src="{{ asset('assets/images/amzn.png')}}" alt="">
                                                </div>
                                                <div class="stock-name">AMZN</div>
                                            </div>
                                            <ul class="nav">
                                                <li>Long</li>
                                                <li class="divider"></li>
                                                <li>Current price: $90.00</li>
                                            </ul>
                                        </div>
                                        <div class="stockdetail">
                                            <ul class="nav">
                                                <li>Entry date: 19-09-2023</li>
                                                <li class="divider"></li>
                                                <li>Entry price: $136.40</li>
                                            </ul>
                                            <ul class="nav">
                                                <li>Exit date: 21-09-2023</li>
                                                <li class="divider"></li>
                                                <li>Exit price: $107.00</li>
                                            </ul>
                                            <ul class="nav">
                                                <li>Position: 4%  </li>
                                                <li class="divider"></li>
                                                <li class="stockprofit">Profit (%): <span class="tblloss">-18%</span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="stock-card">
                                    <div class="stockname">
                                        <div class="stockprofile">
                                            <div class="stockimg">
                                                <img src="{{ asset('assets/images/aapl2.png')}}" alt="">
                                            </div>
                                            <div class="stock-name">AAPL</div>
                                        </div>
                                        <ul class="nav">
                                            <li>Long</li>
                                            <li class="divider"></li>
                                            <li>Current price: $210.00</li>
                                        </ul>
                                    </div>
                                    <div class="stockdetail">
                                        <ul class="nav">
                                            <li>Entry date: 19-09-2023</li>
                                            <li class="divider"></li>
                                            <li>Entry price: $176.00</li>
                                        </ul>
                                        <ul class="nav">
                                            <li>Exit date: 21-09-2023</li>
                                            <li class="divider"></li>
                                            <li>Exit price: $200.00</li>
                                        </ul>
                                        <ul class="nav">
                                            <li>Position: 4%</li>
                                            <li class="divider"></li>
                                            <li class="stockprofit">Profit (%): <span class="tblprofit">32%</span></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="stock-card">
                                    <div class="stockname">
                                        <div class="stockprofile">
                                            <div class="stockimg">
                                                <img src="{{ asset('assets/images/sqqq2.png')}}" alt="">
                                            </div>
                                            <div class="stock-name">SQQQ</div>
                                        </div>
                                        <ul class="nav">
                                            <li>Long</li>
                                            <li class="divider"></li>
                                            <li>Current price: $22.00</li>
                                        </ul>
                                    </div>
                                    <div class="stockdetail">
                                        <ul class="nav">
                                            <li>Entry date: 19-09-2023</li>
                                            <li class="divider"></li>
                                            <li>Entry price: $16.00</li>
                                        </ul>
                                        <ul class="nav">
                                            <li>Exit date: 21-09-2023</li>
                                            <li class="divider"></li>
                                            <li>Exit price: $20.00</li>
                                        </ul>
                                        <ul class="nav">
                                            <li>Position: 4%  </li>
                                            <li class="divider"></li>
                                            <li class="stockprofit">Profit (%): <span class="tblprofit">6%</span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="stock-card">
                                    <div class="stockname">
                                        <div class="stockprofile">
                                            <div class="stockimg">
                                                <img src="{{ asset('assets/images/unh1.png')}}" alt="">
                                            </div>
                                            <div class="stock-name">UNH</div>
                                        </div>
                                        <ul class="nav">
                                            <li>Long</li>
                                            <li class="divider"></li>
                                            <li>Current price: $530.00</li>
                                        </ul>
                                    </div>
                                    <div class="stockdetail">
                                        <ul class="nav">
                                            <li>Entry date: 19-09-2023</li>
                                            <li class="divider"></li>
                                            <li>Entry price: $479.00</li>
                                        </ul>
                                        <ul class="nav">
                                            <li>Exit date: 21-09-2023</li>
                                            <li class="divider"></li>
                                            <li>Exit price: $502.00</li>
                                        </ul>
                                        <ul class="nav">
                                            <li>Position: 4%  </li>
                                            <li class="divider"></li>
                                            <li class="stockprofit">Profit (%): <span class="tblprofit">23%</span></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="stock-card">
                                        <div class="stockname">
                                            <div class="stockprofile">
                                                <div class="stockimg">
                                                    <img src="{{ asset('assets/images/amzn.png')}}" alt="">
                                                </div>
                                                <div class="stock-name">AMZN</div>
                                            </div>
                                            <ul class="nav">
                                                <li>Long</li>
                                                <li class="divider"></li>
                                                <li>Current price: $90.00</li>
                                            </ul>
                                        </div>
                                        <div class="stockdetail">
                                            <ul class="nav">
                                                <li>Entry date: 19-09-2023</li>
                                                <li class="divider"></li>
                                                <li>Entry price: $136.40</li>
                                            </ul>
                                            <ul class="nav">
                                                <li>Exit date: 21-09-2023</li>
                                                <li class="divider"></li>
                                                <li>Exit price: $107.00</li>
                                            </ul>
                                            <ul class="nav">
                                                <li>Position: 4%  </li>
                                                <li class="divider"></li>
                                                <li class="stockprofit">Profit (%): <span class="tblloss">-18%</span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="stock-card">
                                    <div class="stockname">
                                        <div class="stockprofile">
                                            <div class="stockimg">
                                                <img src="{{ asset('assets/images/aapl2.png')}}" alt="">
                                            </div>
                                            <div class="stock-name">AAPL</div>
                                        </div>
                                        <ul class="nav">
                                            <li>Long</li>
                                            <li class="divider"></li>
                                            <li>Current price: $210.00</li>
                                        </ul>
                                    </div>
                                    <div class="stockdetail">
                                        <ul class="nav">
                                            <li>Entry date: 19-09-2023</li>
                                            <li class="divider"></li>
                                            <li>Entry price: $176.00</li>
                                        </ul>
                                        <ul class="nav">
                                            <li>Exit date: 21-09-2023</li>
                                            <li class="divider"></li>
                                            <li>Exit price: $200.00</li>
                                        </ul>
                                        <ul class="nav">
                                            <li>Position: 4%</li>
                                            <li class="divider"></li>
                                            <li class="stockprofit">Profit (%): <span class="tblprofit">32%</span></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="stock-card">
                                    <div class="stockname">
                                        <div class="stockprofile">
                                            <div class="stockimg">
                                                <img src="{{ asset('assets/images/sqqq2.png')}}" alt="">
                                            </div>
                                            <div class="stock-name">SQQQ</div>
                                        </div>
                                        <ul class="nav">
                                            <li>Long</li>
                                            <li class="divider"></li>
                                            <li>Current price: $22.00</li>
                                        </ul>
                                    </div>
                                    <div class="stockdetail">
                                        <ul class="nav">
                                            <li>Entry date: 19-09-2023</li>
                                            <li class="divider"></li>
                                            <li>Entry price: $16.00</li>
                                        </ul>
                                        <ul class="nav">
                                            <li>Exit date: 21-09-2023</li>
                                            <li class="divider"></li>
                                            <li>Exit price: $20.00</li>
                                        </ul>
                                        <ul class="nav">
                                            <li>Position: 4%  </li>
                                            <li class="divider"></li>
                                            <li class="stockprofit">Profit (%): <span class="tblprofit">6%</span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <div class="position-relative testimonial_nav">
                        <div class="swiper-button-next">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 6L10 16l10 10"/></svg>
                        </div>
                        <div class="swiper-button-prev">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m12 26l10-10L12 6"/></svg>
                        </div>
                    </div>
                    @else
                    <div class="trade-stocks-card ">
                        SHOW widget of closed trades from system. Dynamically update to show last 12 closed trades each week here.
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- BANNER -->

    <!-- CHOOSE PLAN -->
    <section class="choose-plan" id="overview">
        <div class="container-xl">
            <h1 class="title">Get Timely Stock and Options Trade Ideas Delivered Daily To Your Inbox.</h1>
            <div class="row">
                <div class="col-12 col-lg-6 order-2 order-lg-1">
                    <h6>We pick the stock and option entry points for the best and quickest success…</h6>
                    <p>With us, you’ll receive alerts for the precise trades we execute. with exact entry levels for each stock or option we trade. Our trading activities encompass a diverse array of stocks, spanning large, mid, and small-cap stocks, ETFs, commodities, and currencies. These real-time trade alert signals will be promptly delivered to you through email or SMS, ensuring you receive precise entry and exit price details in a timely manner. By joining our service, Stack the odds of winning in your favor, and maximize the chances of growing your wealth! Our strategies have been deployed and back tested for several years now, while continuously outpacing the broader markets.</p>
                    <a href="{{ route('front.subscription') }}" class="lp-link">Choose your plan</a>
                </div>
                <div class="col-12 col-lg-6 order-1 order-lg-2 my-3 my-lg-0 text-center">
                    <img src="{{ asset('assets/images/choose-plan.png')}}" class="img-fluid">
                </div>
            </div>
        </div>
    </section>
    <!-- CHOOSE PLAN -->

    <!-- INVESTOR -->
    <section class="investor">
        <div class="container-xl">
            <h1 class="title">TradeInSync works for every type of investor.</h1>
            <div class="row justify-content-center">

                <div class="col-12 col-sm-11 col-md-10 v-investor mt-4">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <button class="nav-link active" id="v-pills-new-tab" data-bs-toggle="pill" data-bs-target="#v-pills-new" type="button" role="tab" aria-controls="v-pills-new" aria-selected="true">New Investor:</button>
                        <button class="nav-link" id="v-pills-busy-tab" data-bs-toggle="pill" data-bs-target="#v-pills-busy" type="button" role="tab" aria-controls="v-pills-busy" aria-selected="false">Busy Investor:</button>
                        <button class="nav-link" id="v-pills-power-tab" data-bs-toggle="pill" data-bs-target="#v-pills-power" type="button" role="tab" aria-controls="v-pills-power" aria-selected="false">Power Investor:</button>
                    </div>
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-new" role="tabpanel" aria-labelledby="v-pills-new-tab">
                            <ul class="flex-column">
                                <li>Start investing like a professional, no experience required.</li>
                                <li> Grow your money faster with TradeInSync. Unlike slow-growth savings accounts, CDs and bonds, TradeInSync picks growth stocks to power your portfolio forward faster.</li>
                                <li>We give you full trading plans. We’ll do the heavy lifting—picking the best stocks and creating optimized trading plans. We’ll even alert you when stocks reach buy or sell points.</li>
                                <li>No commissions or extra fees. One low price.Invest for yourself and keep the profits! With TradeInSync, you’ll pay only one low monthly or annual price.</li>
                            </ul>
                        </div>
                        <div class="tab-pane fade" id="v-pills-busy" role="tabpanel" aria-labelledby="v-pills-busy-tab">
                            <ul class="flex-column">
                                <li>TradeInSync does the stock research for you.</li>
                                <li>Start buying the best stocks. We scan the market daily and gives you the 10-15 best ones right now.</li>
                                <li>Buy. Sell. Profit. TradeInSync’s streamlined trading plans give you exact buy points, profit targets, sell signals and position size.</li>
                                <li>Take charge of your investing. With TradeInSync, you pay one low monthly price. There’s no financial advisor taking a cut of your profits.</li>
                            </ul>
                        </div>
                        <div class="tab-pane fade" id="v-pills-power" role="tabpanel" aria-labelledby="v-pills-power-tab">
                            <ul class=" flex-column">
                                <li>Take your investing to the next level.</li>
                                <li>Powered by technical and fundamental analysis. TradeInSync combines fundamental and technical analysis to produce superior returns.</li>
                                <li>A simpler way to achieve peak investing performance. We filter through thousands of trade ideas every day and gives you the best 10-15 trade ideas right now.</li>
                                <li>TradeInSync is based on a market-beating system. You get trading plans based off of our back tested proprietary strategy with proven results.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- INVESTOR -->

    <!-- HOW DOES WORK -->
    <section class="how-does-work" id="features">
        <div class="container-xl">
            <h1 class="title">How does TradeInSync work?</h1>
            <div class="howto-work-wrapper">
                <div class="howto-work-list">
                    <div class="d-flex flex-column align-items-center">
                        <div class="step-no">1</div>
                        <div class="step-line h-100"></div>
                    </div>
                    <div>
                        <div class="how-card-heading">We pick the stocks that are at levels for a 10-20% move.</div>
                        <div class="how-card-content">We sort through thousands of stock ideas to give you those ones with strongest probability, primed for big price jumps.</div>
                    </div>
                </div>

                <div class="howto-work-list">
                    <div class="d-flex flex-column align-items-center">
                        <div class="step-no">2</div>
                        <div class="step-line h-100"></div>
                    </div>
                    <div>
                        <div class="how-card-heading">We put together full trading plans.</div>
                        <div class="how-card-content">The team at TradeInSync analyzes the market for you. We’ll tell you when it’s a good time to buy or sell. You will get notified of entry and exit prices along with proper position sizing for each trade.</div>
                    </div>
                </div>

                <div class="howto-work-list">
                    <div class="d-flex flex-column align-items-center">
                        <div class="step-no">3</div>
                    </div>
                    <div>
                        <div class="how-card-heading">You trade and watch your investment account grow.</div>
                        <div class="how-card-content">Start realizing profits in days, not months or years! SwingTrader helps you outperform the market and grow your portfolio faster. Reinvest the profits and watch the gains multiply!</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- HOW DOES WORK -->
    <!-- STOCKS OPTIONS -->
    <section class="stocks-options">
        <div class="container-xl">
            <h1 class="title">Take your investing to the next level with our actionable ideas for stocks & options</h1>

            <div class="stocks-options-wrapper">

                <div class="stocks-options-item">
                    <div class="stocks-item-icon">
                        <svg width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3.46154 30C2.54348 30 1.66303 29.6353 1.01386 28.9861C0.364697 28.337 0 27.4565 0 26.5385V3.46154C0 2.54348 0.364697 1.66303 1.01386 1.01386C1.66303 0.364697 2.54348 0 3.46154 0H21.9231C22.2291 0 22.5226 0.121566 22.739 0.337954C22.9554 0.554342 23.0769 0.847827 23.0769 1.15385C23.0769 1.45987 22.9554 1.75335 22.739 1.96974C22.5226 2.18613 22.2291 2.30769 21.9231 2.30769H3.46154C3.15552 2.30769 2.86203 2.42926 2.64565 2.64565C2.42926 2.86203 2.30769 3.15552 2.30769 3.46154V26.5385C2.30769 26.8445 2.42926 27.138 2.64565 27.3544C2.86203 27.5707 3.15552 27.6923 3.46154 27.6923H26.5385C26.8445 27.6923 27.138 27.5707 27.3544 27.3544C27.5707 27.138 27.6923 26.8445 27.6923 26.5385V15C27.6923 14.694 27.8139 14.4005 28.0303 14.1841C28.2466 13.9677 28.5401 13.8462 28.8462 13.8462C29.1522 13.8462 29.4457 13.9677 29.662 14.1841C29.8784 14.4005 30 14.694 30 15V26.5385C30 27.4565 29.6353 28.337 28.9861 28.9861C28.337 29.6353 27.4565 30 26.5385 30H3.46154Z" fill="#627413"/>
                            <path d="M15.8172 20.4322L31.971 4.27838C32.0783 4.1711 32.1634 4.04374 32.2215 3.90357C32.2795 3.7634 32.3094 3.61317 32.3094 3.46146C32.3094 3.30974 32.2795 3.15951 32.2215 3.01934C32.1634 2.87917 32.0783 2.75181 31.971 2.64453C31.8637 2.53725 31.7364 2.45215 31.5962 2.39409C31.456 2.33604 31.3058 2.30615 31.1541 2.30615C31.0024 2.30615 30.8522 2.33604 30.712 2.39409C30.5718 2.45215 30.4445 2.53725 30.3372 2.64453L15.0003 17.9838L8.8941 11.8753C8.78682 11.768 8.65946 11.6829 8.5193 11.6249C8.37913 11.5668 8.2289 11.5369 8.07718 11.5369C7.92546 11.5369 7.77523 11.5668 7.63506 11.6249C7.4949 11.6829 7.36754 11.768 7.26026 11.8753C7.15298 11.9826 7.06788 12.1099 7.00982 12.2501C6.95176 12.3903 6.92187 12.5405 6.92188 12.6922C6.92188 12.8439 6.95176 12.9942 7.00982 13.1343C7.06788 13.2745 7.15298 13.4019 7.26026 13.5091L14.1833 20.4322C14.2905 20.5397 14.4178 20.6249 14.558 20.6831C14.6982 20.7413 14.8485 20.7712 15.0003 20.7712C15.152 20.7712 15.3023 20.7413 15.4425 20.6831C15.5827 20.6249 15.71 20.5397 15.8172 20.4322Z" fill="#627413"/>
                        </svg>
                    </div>
                    <div class="stocks-item-content">
                        <h6>Curated list of winning stocks</h6>
                        <p>From our carefully compiled list, we dispatch stock alerts complete with a trade setup. This includes a precise purchase price, potential target, stop-loss, and the all-important position size.</p>
                    </div>
                </div>

                <div class="stocks-options-item">
                    <div class="stocks-item-icon">
                        <svg width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3.46154 30C2.54348 30 1.66303 29.6353 1.01386 28.9861C0.364697 28.337 0 27.4565 0 26.5385V3.46154C0 2.54348 0.364697 1.66303 1.01386 1.01386C1.66303 0.364697 2.54348 0 3.46154 0H21.9231C22.2291 0 22.5226 0.121566 22.739 0.337954C22.9554 0.554342 23.0769 0.847827 23.0769 1.15385C23.0769 1.45987 22.9554 1.75335 22.739 1.96974C22.5226 2.18613 22.2291 2.30769 21.9231 2.30769H3.46154C3.15552 2.30769 2.86203 2.42926 2.64565 2.64565C2.42926 2.86203 2.30769 3.15552 2.30769 3.46154V26.5385C2.30769 26.8445 2.42926 27.138 2.64565 27.3544C2.86203 27.5707 3.15552 27.6923 3.46154 27.6923H26.5385C26.8445 27.6923 27.138 27.5707 27.3544 27.3544C27.5707 27.138 27.6923 26.8445 27.6923 26.5385V15C27.6923 14.694 27.8139 14.4005 28.0303 14.1841C28.2466 13.9677 28.5401 13.8462 28.8462 13.8462C29.1522 13.8462 29.4457 13.9677 29.662 14.1841C29.8784 14.4005 30 14.694 30 15V26.5385C30 27.4565 29.6353 28.337 28.9861 28.9861C28.337 29.6353 27.4565 30 26.5385 30H3.46154Z" fill="#627413"/>
                            <path d="M15.8172 20.4322L31.971 4.27838C32.0783 4.1711 32.1634 4.04374 32.2215 3.90357C32.2795 3.7634 32.3094 3.61317 32.3094 3.46146C32.3094 3.30974 32.2795 3.15951 32.2215 3.01934C32.1634 2.87917 32.0783 2.75181 31.971 2.64453C31.8637 2.53725 31.7364 2.45215 31.5962 2.39409C31.456 2.33604 31.3058 2.30615 31.1541 2.30615C31.0024 2.30615 30.8522 2.33604 30.712 2.39409C30.5718 2.45215 30.4445 2.53725 30.3372 2.64453L15.0003 17.9838L8.8941 11.8753C8.78682 11.768 8.65946 11.6829 8.5193 11.6249C8.37913 11.5668 8.2289 11.5369 8.07718 11.5369C7.92546 11.5369 7.77523 11.5668 7.63506 11.6249C7.4949 11.6829 7.36754 11.768 7.26026 11.8753C7.15298 11.9826 7.06788 12.1099 7.00982 12.2501C6.95176 12.3903 6.92187 12.5405 6.92188 12.6922C6.92188 12.8439 6.95176 12.9942 7.00982 13.1343C7.06788 13.2745 7.15298 13.4019 7.26026 13.5091L14.1833 20.4322C14.2905 20.5397 14.4178 20.6249 14.558 20.6831C14.6982 20.7413 14.8485 20.7712 15.0003 20.7712C15.152 20.7712 15.3023 20.7413 15.4425 20.6831C15.5827 20.6249 15.71 20.5397 15.8172 20.4322Z" fill="#627413"/>
                        </svg>
                    </div>
                    <div class="stocks-item-content">
                        <h6>Simplified stocks charts</h6>
                        <p>In each trade alert, you will also receive our annotated stock chart that provides a simplified analysis of the trade’s buy and sell zones.</p>
                    </div>
                </div>

                <div class="stocks-options-item">
                    <div class="stocks-item-icon">
                        <svg width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3.46154 30C2.54348 30 1.66303 29.6353 1.01386 28.9861C0.364697 28.337 0 27.4565 0 26.5385V3.46154C0 2.54348 0.364697 1.66303 1.01386 1.01386C1.66303 0.364697 2.54348 0 3.46154 0H21.9231C22.2291 0 22.5226 0.121566 22.739 0.337954C22.9554 0.554342 23.0769 0.847827 23.0769 1.15385C23.0769 1.45987 22.9554 1.75335 22.739 1.96974C22.5226 2.18613 22.2291 2.30769 21.9231 2.30769H3.46154C3.15552 2.30769 2.86203 2.42926 2.64565 2.64565C2.42926 2.86203 2.30769 3.15552 2.30769 3.46154V26.5385C2.30769 26.8445 2.42926 27.138 2.64565 27.3544C2.86203 27.5707 3.15552 27.6923 3.46154 27.6923H26.5385C26.8445 27.6923 27.138 27.5707 27.3544 27.3544C27.5707 27.138 27.6923 26.8445 27.6923 26.5385V15C27.6923 14.694 27.8139 14.4005 28.0303 14.1841C28.2466 13.9677 28.5401 13.8462 28.8462 13.8462C29.1522 13.8462 29.4457 13.9677 29.662 14.1841C29.8784 14.4005 30 14.694 30 15V26.5385C30 27.4565 29.6353 28.337 28.9861 28.9861C28.337 29.6353 27.4565 30 26.5385 30H3.46154Z" fill="#627413"/>
                            <path d="M15.8172 20.4322L31.971 4.27838C32.0783 4.1711 32.1634 4.04374 32.2215 3.90357C32.2795 3.7634 32.3094 3.61317 32.3094 3.46146C32.3094 3.30974 32.2795 3.15951 32.2215 3.01934C32.1634 2.87917 32.0783 2.75181 31.971 2.64453C31.8637 2.53725 31.7364 2.45215 31.5962 2.39409C31.456 2.33604 31.3058 2.30615 31.1541 2.30615C31.0024 2.30615 30.8522 2.33604 30.712 2.39409C30.5718 2.45215 30.4445 2.53725 30.3372 2.64453L15.0003 17.9838L8.8941 11.8753C8.78682 11.768 8.65946 11.6829 8.5193 11.6249C8.37913 11.5668 8.2289 11.5369 8.07718 11.5369C7.92546 11.5369 7.77523 11.5668 7.63506 11.6249C7.4949 11.6829 7.36754 11.768 7.26026 11.8753C7.15298 11.9826 7.06788 12.1099 7.00982 12.2501C6.95176 12.3903 6.92187 12.5405 6.92188 12.6922C6.92188 12.8439 6.95176 12.9942 7.00982 13.1343C7.06788 13.2745 7.15298 13.4019 7.26026 13.5091L14.1833 20.4322C14.2905 20.5397 14.4178 20.6249 14.558 20.6831C14.6982 20.7413 14.8485 20.7712 15.0003 20.7712C15.152 20.7712 15.3023 20.7413 15.4425 20.6831C15.5827 20.6249 15.71 20.5397 15.8172 20.4322Z" fill="#627413"/>
                        </svg>
                    </div>
                    <div class="stocks-item-content">
                        <h6>Email, desktop and mobile alerts</h6>
                        <p>You don’t have to follow the market every minute – we will alert you when it’s a good time to trade.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- STOCKS OPTIONS -->

    <!-- PRICING PLAN -->
    <section class="pricing-plans" id="pricing">
        <div class="container-xl">
            <h1 class="title">Choose your TradeInSync plan:</h1>
            <div class="plans-wrapper">
                <div class="row subscription_wappar border-bottom gx-0 gy-md-3 mb-5">
                    <div class="col-sm-6 col-md-4">
                        <div class="card">
                            <div class="sub-txt">Real-Time Trade Alerts</div>
                            <div class="sub-txt">Exclusive weekly Newsletter</div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="card">
                            <div class="sub-txt">SMS and Email Alerts</div>
                            <div class="sub-txt">Member Only Educational Center</div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card">
                            <div class="sub-txt">Real Time Portfolio Tracker</div>
                            <div class="sub-txt">Quick email response</div>
                        </div>
                    </div>
                </div>
                <div class="row gx-0 gy-md-3 mb-5">
                    <div class="col-sm-6 col-md-4">
                        <div class="card">
                            <div class="card-header">Monthly</div>
                            <div class="price-box">
                                <span class="price">$147</span>
                                {{-- <span>For 4 Weeks</span> --}}
                            </div>
                            <p>Average of 2-4 easy to follow real-time trade alerts per week*</p>
                            <p>All entries and exits delivered in real-time via SMS and Email</p>
                            <p>Standard price</p>
                            <a href="{{ route('front.checkout', 'm') }}" class="btn">Subscribe</a>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-4">
                        <div class="card">
                            <div class="card-header">Yearly</div>
                            <div class="price-box">
                                <span class="price">$787</span>
                                <span>For Save $1,174!</span>
                            </div>
                            <p>Average of 2-4 easy to follow real-time trade alerts per week*</p>
                            <p>All entries and exits delivered in real-time via SMS and Email</p>
                            <p>Save $1,174!</p>
                            <a href="{{ route('front.checkout', 'm') }}" class="btn">Subscribe</a>
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="card">
                            <div class="card-header">Quarterly</div>
                            <div class="price-box">
                                <span class="price">$387</span>
                                <span>Save $336!</span>
                            </div>
                            <p>Get the quarterly & get 20% discount.</p>
                            <p>All entries and exits delivered in real-time via SMS and Email</p>
                            <p>Save $336!</p>
                            <a href="{{ route('front.checkout', 'm') }}" class="btn">Subscribe</a>
                        </div>
                    </div>

                </div>
                <div class="text-caption">
                    <div class="short-description text-center">(All memberships renew automatically - cancel anytime)</div>
                    <div class="short-description text-center">*Number of alerts is fully dependent upon the market conditions and the number of high quality opportunities that present themselves</div>
                    <div class="short-description text-center">**Savings displayed on this page are calculated based on the standard monthly price of $147 per month</div>
                </div>
            </div>
        </div>
    </section>
    <!-- PRICING PLAN -->

    <!-- FAQ -->
    <section class="faq">
        <div class="container-xl">
            <h1 class="title">FAQ’s</h1>
            <div class="accordion accordion-flush" id="accordionFlushExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                            How do you choose your stock trades?
                        </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse collapse show" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <p>We apply fundamentals and technical analysis using many different sources and methods to determine what we believe are the best stock trades of the day or week, or even month. You can learn about some of the methods we use in the learning center.</p>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                            How frequently do you trade and how long is your average holding time?
                        </button>
                    </h2>
                    <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <p>Trading depends on the opportunities that are present in the current market environment. This gives us the ideal number of trades on names that are worth trading without over-trading unnecessarily. We only stick to the best opportunities that we have conviction on. Generally hold 3-5 swing trades a month. And 5-10 option trades a month.</p>
                            <p>As far as average position duration, we aim to hold positions that work in our favor for as long as possible, until they stop working. On average, this tends to be a hold time of 2-4 weeks. However, some positions can stay on for months on end because their technical and fundamentals continually advance forward. </p>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                            Do I need to have any existing trading knowledge?
                        </button>
                    </h2>
                    <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <p>Not at all. Our platform is designed with the novice in mind, offering a user-friendly experience without the need for previous stock trading experience. While we do offer basic educational content on options trading for those interested, it's not a prerequisite. We advocate for learning by doing—meaning the most effective way to grasp trading strategies is through direct observation and active participation.</p>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingFour">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                            What stocks do you trade and what kind of alerts do I receive?
                        </button>
                    </h2>
                    <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <p>Our trading focus is on highly liquid medium to large cap stocks in the market, characterized by their significant trading volume, often reaching millions of shares daily. We also prioritize stocks with substantial institutional ownership. This approach aims to tap into stocks that tend to outpace the overall market's growth, while effectively minimizing the risk of holding losing positions. Our strategy ensures that stop losses are promptly executed, safeguarding against significant losses.</p>
                            <p>As part of our service, you will receive immediate alerts whenever we initiate or exit a position, ensuring you're informed at every critical stage of the trade's lifecycle. Moreover, we keep you updated with real-time alerts on significant market news, particularly those that might prompt changes during the trading day</p>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingFive">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFive" aria-expanded="false" aria-controls="flush-collapseFive">
                            Which brokerage should I use?
                        </button>
                    </h2>
                    <div id="flush-collapseFive" class="accordion-collapse collapse" aria-labelledby="flush-headingFive" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <p>Our brokerage of choice for swing trades and options trading is Interactive Broikers.. For charting, we recommend primarily use Tradingview.</p>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingSix">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSix" aria-expanded="false" aria-controls="flush-collapseSix">
                            How much does TradeInSync cost?
                        </button>
                    </h2>
                    <div id="flush-collapseSix" class="accordion-collapse collapse" aria-labelledby="flush-headingSix" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <p>If you are new to TradeInSync, you can try it for only $49. After that, your membership will renew at $149/month. You save 20% by switching to our quarterly membership at a rate of </p>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingSeven">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSeven" aria-expanded="false" aria-controls="flush-collapseSeven">
                            Is this a Trading Platform? Do you make the trades for me?
                        </button>
                    </h2>
                    <div id="flush-collapseSeven" class="accordion-collapse collapse" aria-labelledby="flush-headingSeven" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <p>This is not a Trading Platform and we do not make the trades for you. This is a trade alert service that provides stock picks and option trade ideas in real-time. You make your own trades and we just provide you with the information. Our trades tell you exactly when to buy and when to sell with precise entry and exit points. You always maintain 100% control over your portfolio and you always execute the trades yourself. We tell you what to buy, the buy price and amount to buy and when to sell.</p>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingEight">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseEight" aria-expanded="false" aria-controls="flush-collapseEight">
                            Can I cancel my Leaderboard membership?
                        </button>
                    </h2>
                    <div id="flush-collapseEight" class="accordion-collapse collapse" aria-labelledby="flush-headingEight" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <p>You can cancel any time. Log into the accounts section and go to the membership area to cancel online.</p>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingNine">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseNine" aria-expanded="false" aria-controls="flush-collapseNine">
                            Do your trade alerts include the exit price target?
                        </button>
                    </h2>
                    <div id="flush-collapseNine" class="accordion-collapse collapse" aria-labelledby="flush-headingNine" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <p>Yes. Each time we send a buy trade alert, we will also indicate our expected price target for each trade. Meaning, if we send a trade alert to buy APPL stock at $120, that trade alert will also include our price target for where we expect to exit the trade.</p>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingTen">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTen" aria-expanded="false" aria-controls="flush-collapseTen">
                            Are you registered financial adviser or a brokerage?
                        </button>
                    </h2>
                    <div id="flush-collapseTen" class="accordion-collapse collapse" aria-labelledby="flush-headingTen" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <p>No. The information we provide is not professional financial advice. They are simply our opinions drawn from experience. We are not responsible for any transactions you choose to engage in; please do your own due diligence first!</p>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingEleven">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseEleven" aria-expanded="false" aria-controls="flush-collapseEleven">
                            Does The TradeInSync trade options or stocks?
                        </button>
                    </h2>
                    <div id="flush-collapseEleven" class="accordion-collapse collapse" aria-labelledby="flush-headingEleven" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <p>We trade both options and stocks.</p>
                            <p>While our alerts are usually focused on Stocks, we will send out option trades as well.</p>
                            <ul>
                                <li>The market environment is unfavorable, meaning general market volatility is high and options are expensive,</li>
                                <li>Particular stock options are expensive and the majority of our members would be unable to satisfy the requirements (e.g. AMZN),</li>
                                <li>The options on a potential stock are illiquid (meaning a large spread, or poor option interest)</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- FAQ -->

    <!-- CONTACT US -->
    <section class="contact-us">
        <div class="container-xl">
            <h1 class="title">Contact us today</h1>
            <div class="contact-form">
                <span id="msg" ></span>
                <form action="" method="post" id="contact-us-form">
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label>Email Address</label>
                        <input type="email" class="form-control" name="email" id="email" required>
                    </div>
                    <div class="mb-3">
                        <label>Message</label>
                        <textarea class="form-control" rows="3" name="message" id="message" required></textarea>
                    </div>
                    {{-- <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" value="true" name="termcondition" id="termcondition" required>
                        <label class="form-check-label" for="termcondition">Term Condition & policies apply</label>
                    </div> --}}
                    <div>
                        <button type="submit" class="btn shadow-none btn-form w-100 postbutton">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- CONTACT US -->
@endsection
@section('page-script')
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
<script>
    // HEADER
    // (function ($) {
    //     $(function () {
    //         $('.lp-navigation-menu ul li a:not(:only-child)').click(function (e) {
    //             $(this).siblings('.nav-dropdown').toggle();
    //             $('.nav-dropdown').not($(this).siblings()).hide();
    //             e.stopPropagation();
    //         });
    //         $('html').click(function () {
    //             $('.nav-dropdown').hide();
    //         });
    //         $('#nav-toggle').click(function () {
    //             $('.lp-navigation-menu ul').slideToggle(300).toggleClass("dm-block","dm-flex");
    //         });
    //         $('#nav-toggle').on('click', function () {
    //             this.classList.toggle('active');
    //         });
    //     });
    // })(jQuery);


    var swiper = new Swiper(".mySwiper", {
        loop:true,
        navigation: {
            nextEl: ".swiper-button-prev",
            prevEl: ".swiper-button-next",
        },
        slidesPerView: 1,
        spaceBetween: {{count($trades)}},
    });

    $("#contact-us-form").validate({
        errorElement: "span",
        submitHandler: function(form) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var name = $("#name").val();
            var email = $("#email").val();
            var message = $("#message").val();
            // var termcondition = $("#termcondition").val();
            $.ajax({
                /* the route pointing to the post function */
                url: "{{route('front.contact-us-mail-send')}}",
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: {_token: CSRF_TOKEN, name:name, email:email, message:message}, //termcondition:termcondition
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function (data) {
                    $(form)[0].reset();
                    if(data.status == true){
                        $('#msg').css('display','block').css('color','green').text(data.message);
                    }else{
                        $('#msg').css('display','block').css('color','red').text(data.message);
                    }
                }
            });
        }
    });


</script>
@endsection
