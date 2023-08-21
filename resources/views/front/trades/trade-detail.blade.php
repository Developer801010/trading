@extends('layouts.front-master')
@section('title', 'Main Feed')

@section('page-style')
@endsection


@section('content')
    <div class="container">
        <section class="dashboard-section">        
    
           
        </section>
        <section class="main-feed-section position-section">
            <div class="row">
                <div class="col-12">
                    <div class="card mainFeedCard">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-8">
                                    <h5 class="card-title" style="font-weight: bold">
                                        @if($type == 'a')   {{-- Add Trade --}}                                        
                                            {{ucfirst($trade->trade->trade_type)}} Alert - {{ucfirst($trade->trade->trade_direction)}} {{ $trade->trade->trade_symbol }} (Add)
                                        @else
                                            {{ucfirst($trade->trade_type)}} Alert - {{ucfirst($trade->trade_direction == 'buy' ? 'Sell' : 'Cover')}} 
                                            @if ($trade->exit_price !== null && $trade->exit_date !== null)
                                                to Close
                                            @endif
                                            {{$trade->trade_symbol}}{{\Carbon\Carbon::parse($trade->updated_at)->format('ymd')}}  {{ucfirst(substr($trade->trade_option,0,1))}} {{rtrim(rtrim(number_format($trade->entry_price, 1), '0'), '.')}}
                                        @endif
                                        
                                    </h5>
                                </div>
                                <div class="col-12 col-md-4">
                                    <p class="main-feed-published-time">{{\Carbon\Carbon::parse($trade->updated_at)->format('F d, Y h:i A')}}</p>
                                </div>
                            </div>      
                            @if($type == 'a')
                                @if($trade->trade->trade_direction == 'buy') 
                                    Long {{$trade->trade->trade_symbol}}
                                @else
                                    Short {{$trade->trade->trade_symbol}}
                                @endif
                            @else
                                <p class="mb-1">{{ucfirst($trade->trade_direction)}} {{$trade->trade_symbol}} {{\Carbon\Carbon::parse($trade->updated_at)->format('M d, Y')}} ${{$trade->entry_price}} {{$trade->trade_option}}.</p>
                            @endif
                        @if ($trade->exit_price !== null && $trade->exit_date !== null)
                            <p class="mb-1"><b>Exit Price: </b>${{$trade->exit_price}}</p>  
                        @else
                            <p class="mb-1"><b>Entry Price: </b>${{$trade->entry_price}}</p>    
                        @endif
                        @if ($trade->exit_price !== null && $trade->exit_date !== null)
                            @if($trade->tradeDetail !== null && $trade->tradeDetail->count())
                                @php
                                    $totalPrice = $trade->entry_price * $trade->position_size / 100;
                                    $totalPercentage = $trade->position_size / 100;  
                                @endphp
                                @foreach ($trade->tradeDetail as $childTrade)
                                    @php
                                        $totalPrice += $childTrade->entry_price * $childTrade->position_size /100;
                                        $totalPercentage += $childTrade->position_size / 100;
                                    @endphp
                                @endforeach
                                @php
                                    $averagePrice = $totalPrice / $totalPercentage;
                                @endphp
                                <p class="mb-1"><b>Position Size: </b>{{rtrim(rtrim(number_format($totalPercentage * 100, 1), '0'), '.')}}% of Portfolio</p> 
                                <p class="mb-1"><b>Average Entry Price: </b><span class="average_entry_price">${{number_format($averagePrice,2)}}</span></p>
                            @else
                                <p class="mb-1"><b>Position Size: </b>{{rtrim(rtrim(number_format($trade->position_size, 1), '0'), '.')}}% of Portfolio</p> 
                                <p class="mb-1"><b>Average Entry Price: </b><span class="average_entry_price">${{$trade->entry_price}}</span></p>
                            @endif

                            <p class="mb-1"><b>Entry Date: </b>{{\Carbon\Carbon::parse($trade->entry_date)->format('m/d/Y')}}</p>
                        @else
                        <p class="mb-1"><b>Position Size: </b>{{rtrim(rtrim(number_format($trade->position_size, 1), '0'), '.')}}% of Portfolio</p> 
                            <p class="mb-1"><b>Stop Price: </b>{{$trade->stop_price}}</p>
                            <p class="mb-1"><b>Target Price: </b> ${{$trade->target_price}}</p>
                        @endif

                        @if ($trade->exit_price !== null && $trade->exit_date !== null)  
                            <p class="mb-1"><b>Profits: </b>
                                @if($trade->tradeDetail !== null && $trade->tradeDetail->count())
                                    @php
                                        $averageEntryPrice = $averagePrice;
                                    @endphp
                                @else
                                    @php
                                       $averageEntryPrice =  $trade->entry_price;
                                    @endphp
                                @endif
                                @if ($trade->trade_direction == 'buy')
                                    <span class="text-success">
                                        {{ number_format(( $trade->exit_price - $averageEntryPrice ) / $averageEntryPrice * 100, 2)  }}%
                                    </span>
                                @else
                                    <span class="text-success">
                                        {{ number_format(( $averageEntryPrice - $trade->exit_price ) / $averageEntryPrice * 100, 2) }}%
                                    </span>
                                @endif
                            </p>
                        @endif
                         {{-- for Add trade --}}
                        @if($type == 'a')
                            {{$trade->trade_description}}

                            @if($trade->chart_image && file_exists(public_path($trade->chart_image)))
                                <img src="{{ asset($trade->chart_image) }}" class="mb-1" />
                            @endif
                        @else
                            <p class="mb-1">
                                @if ($trade->exit_price !== null && $trade->exit_date !== null)
                                    {{$trade->close_comment}}
                                @else
                                    {{$trade->trade_description}}
                                @endif
                            </p>
                            {{-- for Close trade --}}
                            @if ($trade->exit_price !== null && $trade->exit_date !== null)
                                @if($trade->close_image && file_exists(public_path($trade->close_image)))
                                    <img src="{{ asset($trade->close_image) }}" class="mb-1" />
                                @endif
                            @else
                                @if($trade->chart_image && file_exists(public_path($trade->chart_image)))
                                    <img src="{{ asset($trade->chart_image) }}" class="mb-1" />
                                @endif
                            @endif
                        @endif
                        
                        </div>
                    </div>
                </div>
            </div>
           
        </section>
    </div>    
@endsection


@section('page-script')    
    
@endsection