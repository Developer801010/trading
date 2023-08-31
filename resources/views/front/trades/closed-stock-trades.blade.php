@extends('layouts.front-master')
@section('title', 'Closed Stock Trades')

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
                <h1 class="table-title">Closed Stock Trades</h1>
                <form action="{{ route('front.closed-stock-trades') }}" method="GET">
                    <div class="mb-3 row search-row-position">
                        <label class="col-md-1 col-form-label" style="padding-top:10px;"><b>Search</b></label>
                        <div class="col-sm-3 input-container">
                            <input type="text" name="search" class="form-control col-md-8 search_input" value="{{ request()->get('search') }}" />      
                            <i class="fas fa-times-circle close-icon"></i>      
                        </div>
                        <div class="col-sm-1">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </form>
                <table class="list-table table">
                    <thead class="table-light">
                        <tr>
                            <th>Symbol</th>      
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
                        @foreach ($trades as $trade)
                        <tr class="expanded">
                            <td class="parent-trade text-primary" data-trade-id="{{ $trade->id }}">
                                {{strtoupper($trade->trade_symbol)}}
                            </td>
                            <td>
                                @if($trade->trade_direction == 'buy') 
                                    Long
                                @else
                                    Short
                                @endif
                            </td>
                            <td>{{\Carbon\Carbon::parse($trade->entry_date)->format('m/d/Y')}}</td>
                            <td class="average-price">
                                <span class="price">${{ $trade->entry_price }}</span>                                
                            </td>
                            <td>{{Carbon\Carbon::parse($trade->exit_date)->format('m/d/Y')}}</td>
                            <td>${{$trade->exit_price}}</td>
                            <td class="average-size">
                                <span class="size">{{ rtrim(rtrim(number_format($trade->position_size, 1), '0'), '.') }}%</span>
                            </td>
                            <td class="profit">
                                @if($trade->tradeDetail !== null && $trade->tradeDetail->count())
                                    <span class="size"></span>
                                @else
                                    @if ($trade->trade_direction == 'buy')
                                        <span class="size">                                        
                                            {{ number_format(( $trade->exit_price - $trade->entry_price ) / $trade->entry_price * 100, 2)  }}%
                                        </span>    
                                    @else
                                        <span class="size">
                                            {{ number_format(( $trade->entry_price - $trade->exit_price ) / $trade->entry_price * 100, 2) }}%
                                        </span>
                                    @endif
                                @endif
                            </td>                          
                        </tr>  
                        @if($trade->tradeDetail !== null && $trade->tradeDetail->count())
                            @php
                                //parent row's data
                                $totalPrice = $trade->entry_price * $trade->position_size / 100;
                                $totalPercentage = $trade->position_size / 100;  
                                $exitPrice = $trade->exit_price;
                                $averagePrice = $positionSize = 0;
                                $tradeDirection = $trade->trade_direction;
                            @endphp
                            @foreach($trade->tradeDetail as $childTrade)
                            @php
                                $totalPrice += $childTrade->entry_price * $childTrade->position_size /100;
                                $totalPercentage += $childTrade->position_size / 100;
                            @endphp
                        @endforeach
                        @php
                            $averagePrice = $totalPrice / $totalPercentage;
                        @endphp
                        <script>
                            $(document).ready(function() {
                                var averagePrice = {{ $averagePrice }};
                                var totalPercentage = {{$totalPercentage}}
                                var exitPrice = {{$exitPrice}}
                                var tradeDirection = '{{$tradeDirection}}'
                                var profitPercentage = 0; 

                                if(tradeDirection == 'buy')
                                    profitPercentage = (exitPrice - averagePrice)/averagePrice * 100;
                                else
                                    profitPercentage = (averagePrice - exitPrice)/averagePrice * 100;

                                $('.parent-trade[data-trade-id="{{ $trade->id }}"]').closest('tr').find('.average-price').
                                find('.price').text('$'+parseFloat(averagePrice).toFixed(2));

                                $('.parent-trade[data-trade-id="{{ $trade->id }}"]').closest('tr').find('.average-size')
                                .find('.size').text(totalPercentage * 100+'%' );

                                $('.parent-trade[data-trade-id="{{ $trade->id }}"]').closest('tr').find('.profit').
                                find('.size').text(parseFloat(profitPercentage).toFixed(2)+'%');

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
            </div>
        </section>
    </div>    
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

       // JavaScript to handle the close icon click event
       $('.close-icon').click(function() {
            const input = $(this).parent().find('input');
            input.val('');
            input.focus();
            $(this).hide();
            
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