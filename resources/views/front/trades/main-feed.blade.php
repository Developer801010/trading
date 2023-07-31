@extends('layouts.front-master')
@section('title', 'Main Feed')

@section('page-style')
@endsection


@section('content')
    <div class="container">
        <section class="dashboard-section">        
    
           
        </section>
        <section class="main-feed-section position-section">
            <form action="{{ route('front.main-feed') }}" method="GET" class="mainFeedSearch">
                <div class="mb-4 row" style="justify-content: flex-end">                    
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
                                            {{ucfirst($trade->trade_type)}} Alert - {{ucfirst($trade->trade_direction)}} 
                                            @if ($trade->exit_price !== null && $trade->exit_date !== null)
                                                to Close
                                            @endif
                                            {{$trade->trade_symbol}}{{\Carbon\Carbon::parse($trade->updated_at)->format('ymd')}}
                                            @if ($trade->trade_option == 'call')
                                                C
                                            @elseif($trade->trade_option == 'put')
                                                P
                                            @else
                                            
                                            @endif{{rtrim(rtrim(number_format($trade->entry_price, 1), '0'), '.')}}
                                        </h5>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <p class="main-feed-published-time">{{\Carbon\Carbon::parse($trade->updated_at)->format('F d, Y h:i A')}}</p>
                                    </div>
                                </div>                          
                            <p class="mb-1">{{ucfirst($trade->trade_direction)}} {{$trade->trade_symbol}} {{\Carbon\Carbon::parse($trade->updated_at)->format('M d, Y')}} ${{$trade->entry_price}} {{$trade->trade_option}}.</p>
                            @if ($trade->exit_price !== null && $trade->exit_date !== null)
                                <p class="mb-1"><b>Exit Price: </b>${{$trade->exit_price}}</p>  
                            @else
                                <p class="mb-1"><b>Entry Price: </b>${{$trade->entry_price}}</p>    
                            @endif
                            <p class="mb-1"><b>Position Size: </b>{{rtrim(rtrim(number_format($trade->position_size, 1), '0'), '.')}}% of Portfolio</p> 
                            
                            @if ($trade->exit_price !== null && $trade->exit_date !== null)
                                <p class="mb-1"><b>Average Entry Price: </b><span class="average_entry_price"></span></p>
                                {{-- <p class="mb-1"><b>Entry Date: </b>{{\Carbon\Carbon::parse($trade->entry_date)->format('m/d/Y')}}</p> --}}
                            @else
                                <p class="mb-1"><b>Stop Price: </b>{{$trade->stop_price}}</p>
                                <p class="mb-1"><b>Target Price: </b> ${{$trade->target_price}}</p>
                            @endif
                           
                            @if ($trade->exit_price !== null && $trade->exit_date !== null)  
                                <p class="mb-1"><b>Profits: </b>
                                    @if ($trade->trade_direction == 'buy')
                                        {{ number_format(( $trade->exit_price - $trade->entry_price ) / $trade->entry_price * 100, 2)  }}%
                                    @else
                                        {{ number_format(( $trade->entry_price - $trade->exit_price ) / $trade->entry_price * 100, 2) }}%
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
            {{ $results->links() }}
        </section>
    </div>    
@endsection


@section('page-script')    
    
@endsection