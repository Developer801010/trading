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
                    <div class="col-sm-3">
                        <input type="text" name="search" class="form-control col-md-8" value="{{ request()->get('search') }}" />            
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
                                        <h5 class="card-title" style="font-weight: bold">                                            
                                            {{ucfirst($trade->trade_type)}} Alert - 

                                            @if( $trade->exit_price == null && $trade->exit_date == null && $trade->child_direction == null )
                                                New Trade
                                            @endif

                                            @if ($trade->exit_price !== null && $trade->exit_date !== null)
                                                @if ($trade->original_trade_direction == 'buy')
                                                    Sell 
                                                @else
                                                    Buy
                                                @endif 
                                                to Close
                                            @else
                                                {{ucfirst($trade->original_trade_direction)}}                                  
                                            @endif

                                            @if($trade->trade_type == 'option')
                                                {{$trade->trade_symbol}} {{\Carbon\Carbon::parse($trade->updated_at)->format('ymd')}} {{ucfirst(substr($trade->trade_option,0,1))}} {{rtrim(rtrim(number_format($trade->strike_price, 1), '0'), '.')}}
                                            @else
                                                {{$trade->trade_symbol}}
                                            @endif

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
                                @if($trade->trade_type == 'option')
                                    {{ucfirst($trade->original_trade_direction)}} {{$trade->trade_symbol}} {{\Carbon\Carbon::parse($trade->updated_at)->format('M d, Y')}} ${{number_format($trade->entry_price, 0)}} {{$trade->trade_option}}.
                                @else
                                    {{ucfirst($trade->original_trade_direction)}} {{$trade->trade_symbol}}
                                @endif
                                
                            </p>
                            @if ($trade->exit_price !== null && $trade->exit_date !== null)
                                <p class="mb-1"><b>Exit Price: </b>${{number_format($trade->exit_price, 0)}}</p>  
                            @else
                                <p class="mb-1"><b>Entry Price: </b>${{number_format($trade->entry_price, 0)}}</p>    
                            @endif
                            <p class="mb-1"><b>Position Size: </b>{{rtrim(rtrim(number_format($trade->position_size, 1), '0'), '.')}}% of Portfolio</p> 
                            
                            @if ($trade->exit_price !== null && $trade->exit_date !== null)
                                <p class="mb-1"><b>Average Entry Price: </b><span class="average_entry_price"></span></p>
                                {{-- <p class="mb-1"><b>Entry Date: </b>{{\Carbon\Carbon::parse($trade->entry_date)->format('m/d/Y')}}</p> --}}
                            @else
                                <p class="mb-1"><b>Stop Price: </b>{{$trade->stop_price == 'No Stop' ? 'No Stop' : '$'.number_format((float)$trade->stop_price, 0)}}</p>
                                <p class="mb-1"><b>Target Price: </b> ${{number_format($trade->target_price, 0)}}</p>
                            @endif
                           
                            @if ($trade->exit_price !== null && $trade->exit_date !== null)  
                                <p class="mb-1"><b>Profits: </b>
                                    @if ($trade->original_trade_direction == 'buy')
                                        <span class="text-success">{{ number_format(( $trade->exit_price - $trade->entry_price ) / $trade->entry_price * 100, 0)  }}%</span>
                                    @else
                                        <span class="text-success">{{ number_format(( $trade->entry_price - $trade->exit_price ) / $trade->entry_price * 100, 0) }}%</span>
                                    @endif
                                </p>
                            @endif
                            <p class="mb-1">
                                @if ($trade->exit_price !== null && $trade->exit_date !== null)
                                    {{$trade->close_comment}}
                                @else
                                    {{$trade->trade_description}}
                                @endif
                                
                            </p>
                            {{-- for Close trade --}}
                            @if ($trade->exit_price !== null && $trade->exit_date !== null)
                                
                            @else
                                @if($trade->chart_image && file_exists(public_path($trade->chart_image)))
                                    <img src="{{ asset($trade->chart_image) }}" class="mb-1" />
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
@endsection


@section('page-script')    
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
    </script>
@endsection