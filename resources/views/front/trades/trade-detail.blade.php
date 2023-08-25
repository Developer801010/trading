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
                                    @php
                                        if($type == 'a') {
                                            $trade_add_symbol = strtoupper($trade->trade->trade_symbol); 
                                            $trade_add_direction = $trade->trade->trade_direction;
                                            $trade_add_type = $trade->trade->trade_type;
                                        } 
                                    @endphp
                                    <h5 class="card-title" style="font-weight: bold">
                                        @if($type == 'a')   {{-- Add Trade --}}                                        
                                            {{ucfirst($trade_add_type)}} Alert - {{ucfirst($trade_add_direction)}} {{ $trade_add_symbol }} (Add)
                                        @else
                                            {{ucfirst($trade->trade_type)}} Alert - 
                                            @if ($trade->exit_price !== null && $trade->exit_date !== null)
                                                {{ucfirst($trade->trade_direction == 'Buy' ? 'Sell' : 'Buy')}} to Close
                                            @else
                                                New Trade {{ucfirst($trade->trade_direction) }}
                                            @endif
                                            {{strtoupper($trade->trade_symbol)}} @if($trade->trade_type == 'option') {{\Carbon\Carbon::parse($trade->updated_at)->format('ymd')}}  {{ucfirst(substr($trade->trade_option,0,1))}} {{rtrim(rtrim(number_format($trade->entry_price, 1), '0'), '.')}}  @endif
                                        @endif
                                        
                                    </h5>
                                </div>
                                <div class="col-12 col-md-4">
                                    <p class="main-feed-published-time">{{\Carbon\Carbon::parse($trade->updated_at)->format('F d, Y h:i A')}}</p>
                                </div>
                            </div>      
                            @if($type == 'a')
                                <p class="mb-1">                                
                                    {{ucfirst($trade_add_direction)}} {{$trade_add_symbol }} @if($trade_add_type == 'option') {{\Carbon\Carbon::parse($trade->trade->updated_at)->format('M d, Y')}} ${{number_format($trade->trade->strike_price, 2)}} {{$trade->trade->trade_option}} @endif                              
                                </p>
                            @else
                                <p class="mb-1">
                                    @if ($trade->exit_price !== null && $trade->exit_date !== null)
                                        {{ ucfirst($trade->trade_direction) == 'Buy' ? 'Sell' : 'Buy' }}  
                                    @else
                                        {{ucfirst($trade->trade_direction)}} 
                                    @endif
                                   {{strtoupper($trade->trade_symbol)}}  @if($trade->trade_type == 'option') {{\Carbon\Carbon::parse($trade->updated_at)->format('M d, Y')}} ${{$trade->entry_price}} {{$trade->trade_option}} @endif
                                </p>
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
                            <p class="mb-1"><b>Stop Price: </b>
                                {{ is_numeric($trade->stop_price) ? '$' . number_format((float) $trade->stop_price, 0) : $trade->stop_price }}
                            </p>
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
                         <p><b>Comments:</b></p>
                        @if($type == 'a')
                            {!! $trade->trade_description !!}

                            @if($trade->chart_image && file_exists(public_path($trade->chart_image)))
                                <img src="{{ asset($trade->chart_image) }}" class="mb-1 comment_img" 
                                data-image="{{ asset($trade->chart_image) }}" />
                            @endif
                        @else
                            <p class="mb-1">
                                @if ($trade->exit_price !== null && $trade->exit_date !== null)
                                    {!! $trade->close_comment !!}
                                    @if($trade->close_image && file_exists(public_path($trade->close_image)))
                                        <img src="{{ asset($trade->close_image) }}" class="mb-1 comment_img" 
                                        data-image="{{ asset($trade->close_image) }}"/>
                                    @endif
                                @else
                                    {!! $trade->trade_description !!}
                                    @if($trade->chart_image && file_exists(public_path($trade->chart_image)))
                                        <img src="{{ asset($trade->chart_image) }}" class="mb-1 comment_img" 
                                        data-image="{{ asset($trade->chart_image) }}"/>
                                    @endif
                                @endif
                            </p>
                        @endif
                        
                        </div>
                    </div>
                </div>
            </div>
           
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
    <script>
        $('body').on('click', '.comment_img', function(e) {
            e.preventDefault();

            var comment_img = $(this).data('image');  
            $('#commentImage').modal('show');
            $('.modalImg').attr('src', comment_img);
        });
    </script>
@endsection