@extends('layouts.front-master')
@section('title', 'Main Feed')

@section('page-style')
@endsection


@section('content')
    <div class="container">
        <section class="dashboard-section">        
    
           
        </section>
        <section class="main-feed-section position-section">
            @if(auth()->user()->close_feed == 0)
                <div class="alert alert-warning alert-dismissible fade show alertPanel" role="alert">
                    <h3 style="text-align: center">Congratulations…</h3>
                    <h3 style="text-align: center" class="mb-4">And thank you for your order. You’ve made a great decision! Important Next Steps:</h3>
                    <ul>
                        <li><strong>If you wish to receive alerts via SMS then you will need to activate SMS under the nonfiction settings. </strong></li>
                        <li><strong>You can access all the member content right now by clicking on the tabs above. There, you’ll find current open positions and some important information.</strong></li>
                        <li><strong>You will receive new trade posts as soon as they are available to the registered email address.</strong></li>
                        <li><strong>You will also receive a separate welcome email explaining a ton of important information. Make sure you check it out!</strong></li>
                    </ul>
                    
                    <p class="feed-divide"></p>

                    <div class="row accountInfoCard">
                        <div class="col-12">
                            <p><strong>Thank you for your order, {{auth()->user()->first_name}}!</strong></p>
                            <p>Your login credentials are:</p>                                
                            <p>Username: {{auth()->user()->name}}</p>
                            <p>Email: {{auth()->user()->email}}</p>                                
                            <br>
                            <p><strong>Here are your order details:</strong></p>
                            <p>Name: {{auth()->user()->first_name}}  {{auth()->user()->last_name}}</p>
                            <p>Email: {{auth()->user()->email}}</p>                                
                            <p>Order ID: {{ $billing_data->id }}</p>
                            <p>Subtotal: ${{ getPlanPrice(getMiddleWord($billing_data->name)) }}</p>
                            <p>Subscription: {{ getMiddleWord($billing_data->name) }}</p>
                            {{-- <p>Billing Address:</p> --}}
                                
                            <p>If you have any questions concerning your order, feel free to contact us at <a target="_blank" href="mailto:support@tradeinsync.com">support@tradeinsync.com</a></p>
                        </div>
                    </div>                
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    
                </div>            
            @endif

            <form action="{{ route('front.main-feed') }}" method="GET" class="mainFeedSearch">
                <div class="mb-3 mt-5 row" style="justify-content: flex-end">                    
                    <div class="col-sm-3 input-container">
                        <input type="text" name="search" class="form-control col-md-8 search_input" value="{{ request()->get('search') }}" />      
                        <i class="fas fa-times-circle close-icon"></i>      
                    </div>
                    <div class="col-sm-1">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </form>
            @foreach ($results as $trade)
                <div class="row">
                    <div class="col-12">
                        <div class="card mainFeedCard">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-md-8">  
                                        {{-- A: Add trade, C: Close trade, N:New trade --}}
                                        @php
                                            $tradeDirection = ucfirst($trade->original_trade_direction);
                                            $tradeSymbol = strtoupper($trade->trade_symbol);
                                            $formattedExpirationDate = \Carbon\Carbon::parse($trade->expiration_date)->format('M d, Y');
                                            $formattedStrikePrice = number_format($trade->strike_price, 2);
                                            $formattedEntryPrice = number_format($trade->entry_price, 2);
                                            $formattedExitPrice = number_format($trade->exit_price, 2);
                                            $tradeOption = ucfirst($trade->trade_option);

                                        @endphp     
                                        <h5 class="card-title" style="font-weight: bold">                                            
                                            {{ucfirst($trade->trade_type)}} Alert - 

                                            @if( $trade->exit_price == null && $trade->exit_date == null && $trade->child_direction == null )
                                                New Trade
                                            @endif
                                             {{-- closed trade    --}}
                                            @if ($trade->exit_price !== null && $trade->exit_date !== null)
                                                @if ($trade->original_trade_direction == 'buy')
                                                    Sell to Close
                                                @else
                                                    Cover to Close
                                                @endif
                                            @else
                                                {{$tradeDirection}}                                  
                                            @endif
                                          
                                            
                                            {{$tradeSymbol}} @if($trade->trade_type == 'option') {{\Carbon\Carbon::parse($trade->expiration_date)->format('ymd')}} {{ucfirst(substr($trade->trade_option,0,1))}} {{rtrim(rtrim(number_format($trade->strike_price, 1), '0'), '.')}} @endif

                                            @if ($trade->child_direction !== null )
                                                ({{$trade->child_direction}})
                                            @endif
                                            
                                        </h5>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <p class="main-feed-published-time">{{\Carbon\Carbon::parse($trade->updated_at)->format('F d, Y h:i A')}}</p>
                                    </div>
                                </div>                          
                            <p class="mb-1">
                                {{-- close trade --}}
                                @if ($trade->exit_price !== null && $trade->exit_date !== null)
                                    {{ $tradeDirection == 'Buy' ? 'Sell' : 'Buy' }} {{ $tradeSymbol }} @if($trade->trade_type == 'option'){{ $formattedExpirationDate }} ${{ $formattedStrikePrice }} {{ $tradeOption }}@endif
                                @else
                                    {{ $tradeDirection }} {{ $tradeSymbol }} @if($trade->trade_type == 'option'){{ $formattedExpirationDate }} ${{ $formattedStrikePrice }} {{ $tradeOption }}@endif
                                @endif
                            </p>
                            @if ($trade->exit_price !== null && $trade->exit_date !== null)
                                <p class="mb-1"><b>Exit Price: </b>${{$formattedExitPrice}}</p>  
                            @else
                                <p class="mb-1"><b>Entry Price: </b>${{$formattedEntryPrice}}</p>    
                            @endif
                            <p class="mb-1"><b>Position Size: </b>{{rtrim(rtrim(number_format($trade->position_size, 1), '0'), '.')}}% of Portfolio</p> 
                            
                            @if ($trade->exit_price !== null && $trade->exit_date !== null)
                                <p class="mb-1"><b>Average Entry Price: </b>
                                    <span class="average_entry_price">${{$formattedEntryPrice}}</span>
                                </p>                                
                            @else
                                <p class="mb-1"><b>Stop Price: </b>
                                    {{ is_numeric($trade->stop_price) ? '$' . number_format((float) $trade->stop_price, 2) : $trade->stop_price }}
                                </p>
                                <p class="mb-1"><b>Target Price: </b> ${{number_format($trade->target_price, 2)}}</p>
                            @endif
                           
                            @if ($trade->exit_price !== null && $trade->exit_date !== null)  
                                <p class="mb-1"><b>Profits: </b>
                                    @if ($trade->original_trade_direction == 'buy')
                                        @php
                                            $buyProfits = number_format(( $trade->exit_price - $trade->entry_price ) / $trade->entry_price * 100, 2);
                                        @endphp
                                        <span class="@if($buyProfits >= 0 )text-success @else text-danger @endif">
                                            @if ($trade->entry_price != 0 )
                                                {{ $buyProfits }}%
                                            @else
                                                0%
                                            @endif                                            
                                        </span>
                                    @else
                                        @php
                                            $sellProfits = number_format(( $trade->entry_price - $trade->exit_price ) / $trade->entry_price * 100, 2);
                                        @endphp
                                        <span class="@if($sellProfits >= 0 )text-success @else text-danger @endif">
                                            @if ($trade->entry_price != 0 )
                                                {{ $sellProfits }}%
                                            @else
                                                0%
                                            @endif
                                            
                                        </span>
                                    @endif
                                </p>
                            @endif
                            <p class="mb-1"><b>Comments: </b>
                                @if ($trade->exit_price !== null && $trade->exit_date !== null)
                                    {!! $trade->close_comment !!}
                                @else
                                    {!! $trade->trade_description !!}
                                @endif
                                
                            </p>
                            {{-- for Close trade --}}
                            @if ($trade->exit_price !== null && $trade->exit_date !== null)
                                @if($trade->close_image && file_exists(public_path($trade->close_image)))
                                    <img src="{{ asset($trade->close_image) }}" class="mb-1 comment_img"
                                    data-image="{{ asset($trade->close_image) }}"  />
                                @endif
                            @else
                                @if($trade->chart_image && file_exists(public_path($trade->chart_image)))
                                    <img src="{{ asset($trade->chart_image) }}" class="mb-1 comment_img"
                                    data-image="{{ asset($trade->chart_image) }}"  />
                                @endif
                            @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            {{ $results->appends(request()->query())->links() }}
        </section>
    </div>    

    <div class="modal fade" id="commentImage" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-add-trade">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    <img class="modalImg" src="" />
                </div>
            </div>
        </div>
    </div>
@endsection


@section('page-script')    
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $('.btn-close').click(function (e) { 
            e.preventDefault();
            $.ajax({
                url: '{{ route("front.update-close-event") }}',
                type:'GET',
                success: function(data) {
                    console.log(data);
                },
                error: function(xhr, status, error) {
                    console.log('Error occurred: ' + error);
                }
            })
        });

        $('body').on('click', 'img', function(e) {
            e.preventDefault();

            var comment_img = $(this).attr('src');
            $('#commentImage').modal('show');
            $('.modalImg').attr('src', comment_img);
        });
        
        $('#commentImage').draggable({
            handle: ".modal-header" 
        });

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