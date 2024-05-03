@extends('layouts.front-master')
@section('title', 'Closed Options Trades')

@section('page-style')
<style>
    .pagination .page-item{
        padding: 0;
    }
</style>
@endsection


@section('content')
     <!-- MAIN -->
     <main class="main-wrapper">
        <div class="main-feed">
            <div class="container-lg">
                <div class="d-flex gap-3 flex-wrap justify-content-between mb-4">
                    <h1 class="title">Closed Options Trades</h1>
                    <div class="search-input">
                        <form action="{{ route('front.closed-options-trades') }}" method="GET" class="mainFeedSearch">
                            <div class="input-group mb-3">
                                <span class="input-group-text svg-24" id="basic-addon1">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M18.319 14.433C19.566 12.8254 20.1537 10.803 19.9625 8.77748C19.7714 6.7519 18.8157 4.87524 17.29 3.52927C15.7642 2.1833 13.783 1.46913 11.7494 1.53206C9.71584 1.59499 7.7826 2.43028 6.34301 3.86801C4.90217 5.30674 4.06414 7.24073 3.99971 9.27588C3.93528 11.311 4.64929 13.2942 5.99624 14.8211C7.34319 16.3481 9.22171 17.304 11.249 17.4941C13.2763 17.6842 15.2997 17.094 16.907 15.844L16.95 15.889L21.192 20.132C21.2849 20.2249 21.3952 20.2986 21.5166 20.3489C21.638 20.3992 21.7681 20.4251 21.8995 20.4251C22.0309 20.4251 22.161 20.3992 22.2824 20.3489C22.4038 20.2986 22.5141 20.2249 22.607 20.132C22.6999 20.0391 22.7736 19.9288 22.8239 19.8074C22.8742 19.686 22.9001 19.5559 22.9001 19.4245C22.9001 19.2931 22.8742 19.163 22.8239 19.0416C22.7736 18.9202 22.6999 18.8099 22.607 18.717L18.364 14.475C18.3494 14.4606 18.3344 14.4466 18.319 14.433ZM16.243 5.28301C16.8076 5.83849 17.2566 6.50026 17.5642 7.23015C17.8718 7.96004 18.0318 8.7436 18.035 9.53563C18.0382 10.3277 17.8846 11.1125 17.583 11.8449C17.2814 12.5772 16.8378 13.2426 16.2777 13.8027C15.7176 14.3628 15.0522 14.8064 14.3199 15.108C13.5875 15.4096 12.8027 15.5632 12.0106 15.56C11.2186 15.5568 10.435 15.3968 9.70514 15.0892C8.97526 14.7816 8.31349 14.3326 7.75801 13.768C6.64793 12.6397 6.02866 11.1185 6.03511 9.53563C6.04156 7.95281 6.67319 6.43666 7.79242 5.31742C8.91165 4.19819 10.4278 3.56656 12.0106 3.56011C13.5935 3.55367 15.1147 4.17293 16.243 5.28301Z" fill="#737373"/>
                                    </svg>
                                </span>
                                <input type="text" name="search" class="form-control search_input" placeholder="Search"value="{{ request()->get('search') }}">
                                <i class="fas fa-times-circle close-icon m-auto p-2"></i>
                                <button type="submit" class="btn btn-primary opacity-0 d-none">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="tbl-card">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle list">
                            <thead>
                                <tr>
                                    <th>Symbol</th>
									{{-- <th>Company</th> --}}
									<th class="tbl-sm-w-180">Contract</th>
                                    <th>Long/Short</th>
                                    <th>Entry Date</th>
                                    <th>Average Entry Price</th>
                                    <th>Exit Date</th>
                                    <th>Exit Price</th>
                                    <th>Position Size(%)</th>
                                    <th>Profit(%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($trades) && (count($trades) > 0))
                                    @foreach ($trades as $trade)
                                    <tr>
                                        <td>
                                            <div class="stock-profile">
                                                <span class="stock-img">
													@if (check_image($trade->symbol_image) ?? false)
														<img src="{{ $trade->symbol_image }}" data-image="{{ $trade->symbol_image }}"  />
													@endif
                                                </span>
                                                <span class="text-uppercase">{{strtoupper($trade->trade_symbol)}}</span>
                                            </div>
                                        </td>
										{{-- <td class="text-uppercase">{{ $trade->company_name }}</td> --}}
                                        <td>{{ strtoupper($trade->trade_symbol) .' '. \Carbon\Carbon::parse($trade->entry_date)->format('ymd').' '.ucfirst(substr($trade->trade_option, 0, 1)).' '.$trade->strike_price }}</td>
                                        <td>
                                            @if($trade->trade_direction == 'buy') Long @else Short @endif
                                        </td>
                                        <td>{{\Carbon\Carbon::parse($trade->entry_date)->format('m/d/Y')}}</td>
                                        <td>${{ number_format($trade->entry_price, 2) }}</td>
                                        <td>{{Carbon\Carbon::parse($trade->exit_date)->format('m/d/Y')}}</td>
                                        <td>${{ number_format($trade->exit_price, 2) }}</td>
                                        <td>{{ rtrim(rtrim(number_format($trade->position_size, 1), '0'), '.') }}%</td>
                                        <td>
                                            @if ($trade->trade_direction == 'buy')
                                                @php
                                                    $buyProfit =  number_format(( $trade->exit_price - $trade->entry_price ) / $trade->entry_price * 100, 2);
                                                @endphp
                                                <span class="@if($buyProfit > 0) tblprofit @else tblloss @endif">{{ $buyProfit  }}%</span>
                                            @else
                                                @php $sellProfit = ($trade->exit_price >= $trade->entry_price) ? number_format(($trade->exit_price - $trade->entry_price) / $trade->entry_price * 100, 2) : number_format(($trade->entry_price - $trade->exit_price) / $trade->entry_price * 100, 2); @endphp

                                                <span class="@if($trade->exit_price >= $trade->entry_price) tblprofit @else tblloss @endif">{{ $sellProfit }}%</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="10" class="text-center py-5">
                                            <h4 class="fw-bold text-dark">No data Found</h4>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                {{ $trades->appends(request()->query())->links() }}
            </div>
        </div>
    </main>
    <!-- MAIN -->
@endsection


@section('page-script')
<script>
    var search_input = $('.search_input');
       $(document).ready(function () {
          var search_input_length = search_input.val().length;
          if(search_input_length > 0){
               $('.close-icon').show();
          } else {
               $('.close-icon').hide();
          }

       });

        function delay(callback, ms) {
            var timer = 0;
            return function() {
                var context = this, args = arguments;
                clearTimeout(timer);
                timer = setTimeout(function () {
                callback.apply(context, args);
                }, ms || 0);
            };
        }

        $(document).ready(function() {
            $('.mainFeedSearch').keyup(delay(function (e) {
                $(".mainFeedSearch").submit();
            }, 500));
        });

      // JavaScript to handle the close icon click event
        $('.close-icon').click(function() {
           const input = $(this).parent().find('input');
           input.val('');
           input.focus();
           $(this).hide();
           $(".mainFeedSearch").submit();
        });

       search_input.on('input', function() {
           const icon = $(this).parent().find('.close-icon');
           if ($(this).val().length > 0) {
               icon.show();
           } else {
               icon.hide();
           }
       });
</script>

@endsection
