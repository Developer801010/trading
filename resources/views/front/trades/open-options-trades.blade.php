@extends('layouts.front-master')
@section('title', 'Open Options Trades')

@section('page-style')
<style>
    .pagination .page-item{
        padding: 0;
    }
</style>
@endsection


@section('content')
    <div class="container">
        <section class="dashboard-section">        
    
        </section>
        <section class="open-position-section  position-section">
            <div class="">
                <h1 class="table-title">Open Options Trades</h1>
                <form action="{{ route('front.open-options-trades') }}" method="GET">
                    <div class="mb-3 row search-row-position">
                        <label class="col-md-1 col-form-label" style="padding-top:10px;"><b>Search</b></label>
                        <div class="col-sm-3">
                            <input type="text" name="search" class="form-control col-md-8" value="{{ request()->get('search') }}"   />            
                        </div>
                        <div class="col-sm-1">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </form>
                <table class="list-table table">
                    <thead class="table-light">
                        <tr>
                            <th></th>
                            <th>Symbol</th>
                            <th>BUY/SELL</th>
                            <th>Long/Short</th>
                            <th>Entry Date</th>
                            <th>Option</th>
                            <th>Entry Price</th>
                            <th>Stop Price</th>
                            <th>Target Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($trades as $trade)
                            <tr class="expanded">
                                <td class="expand-icon text-primary" style="text-align: center;">
                                    @if($trade->tradeDetail !== null && $trade->tradeDetail->count())
                                        <i class="expand-toggle fa-solid fa-chevron-down" style="cursor: pointer;"></i>
                                    @endif
                                </td>
                                <td class="parent-trade text-primary" data-trade-id="{{ $trade->id }}">
                                    {{strtoupper($trade->trade_symbol)}}
                                </td>
                                <td>{{ucfirst($trade->trade_direction)}}</td>
                                <td>
                                    @if($trade->trade_direction == 'buy') 
                                        Long
                                    @else
                                        Short
                                    @endif
                                </td>
                                <td>
                                    {{\Carbon\Carbon::parse($trade->entry_date)->format('m/d/Y')}}
                                </td>
                                <td>
                                    @if($trade->trade_option =='call')
                                        @php $trade_option = 'C'; @endphp
                                    @else
                                        @php $trade_option = 'P'; @endphp
                                    @endif
                                    {{ $trade->trade_symbol .' '. \Carbon\Carbon::parse($trade->entry_date)->format('ymd').' '.$trade_option.' '.$trade->strike_price }}
                                </td>                                
                                <td class="average-price">
                                    <span class="price">${{$trade->entry_price}}</span>
                                    <span class="size">( {{ rtrim(rtrim(number_format($trade->position_size, 1), '0'), '.') }}% )</span>
                                </td>
                                <td>{{$trade->stop_price}}</td>
                                <td>${{$trade->target_price}}</td>
                            </tr>
                            @if($trade->tradeDetail !== null && $trade->tradeDetail->count())
                                @php
                                    //parent row's data
                                    $totalPrice = $trade->entry_price * $trade->position_size / 100;
                                    $totalPercentage = $trade->position_size / 100;  
                                    $averagePrice = 0;
                                 @endphp
                                 <tr class="child-trade child-trade-{{ $trade->id }}">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>{{ \Carbon\Carbon::parse($trade->entry_date)->format('m/d/Y') }}</td>
                                    <td></td>
                                    <td>
                                        <span>${{ $trade->entry_price }}</span>
                                        <span>({{ rtrim(rtrim(number_format($trade->position_size, 1), '0'), '.') }}%)</span>
                                    </td>
                                    <td>{{$trade->stop_price}}</td>
                                    <td>${{$trade->target_price}}</td>
                                </tr>
                                 @foreach($trade->tradeDetail as $childTrade)
                                    @php
                                        $totalPrice += $childTrade->entry_price * $childTrade->position_size /100;
                                        $totalPercentage += $childTrade->position_size / 100;
                                    @endphp
                                    <tr class="child-trade child-trade-{{ $trade->id }}">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>{{ \Carbon\Carbon::parse($childTrade->entry_date)->format('m/d/Y') }}</td>
                                        <td></td>
                                        <td>
                                            <span>${{ $childTrade->entry_price }}</span>
                                            <span>({{ rtrim(rtrim(number_format($childTrade->position_size, 1), '0'), '.') }}%)</span>
                                        </td>
                                        <td>{{$childTrade->stop_price}}</td>
                                        <td>${{$childTrade->target_price}}</td>
                                    </tr>
                                @endforeach
                             @php
                                 $averagePrice = $totalPrice / $totalPercentage;
                             @endphp
                             <script>
                                 $(document).ready(function() {
                                     var averagePrice = {{ $averagePrice }};
                                     var totalPercentage = {{$totalPercentage}}
     
                                     $('.parent-trade[data-trade-id="{{ $trade->id }}"]').closest('tr').find('.average-price').
                                     find('.price').text('$'+parseFloat(averagePrice).toFixed(2));
     
                                     $('.parent-trade[data-trade-id="{{ $trade->id }}"]').closest('tr').find('.average-price')
                                     .find('.size').text(' ('+totalPercentage * 100+'%)');
     
                                     // Show/hide child rows on expand icon click
                                     $(".expand-toggle").off('click').on('click', function() {
                                         // console.log('toggle icon is clicked');
                                         var parentRow = $(this).closest('tr');  
                                         var tradeId = parentRow.find('.parent-trade').data('trade-id');
                                         var childRows = $('.child-trade-' + tradeId);
                                         if (parentRow.hasClass('expanded')) {
                                             parentRow.removeClass('expanded');
                                             childRows.hide();
                                             $(this).removeClass('fa-chevron-down').addClass('fa-chevron-right');
                                         } else {
                                             parentRow.addClass('expanded');
                                             childRows.show();
                                             $(this).removeClass('fa-chevron-right').addClass('fa-chevron-down');
                                         }    
                                     });
                                 });
                             </script>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                {{ $trades->appends(request()->query())->links() }}
            </div>
        </section>
    </div>    
@endsection


@section('page-script')    

    
@endsection