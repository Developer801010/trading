@extends('layouts.master')

@section('title', 'Trade Alerts')

@section('page-script')
    <script src="https://kit.fontawesome.com/8c0eabb613.js" crossorigin="anonymous"></script>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Trade Alerts</h4>
    </div>
    <div class="row">
        <div class="col-md-12">
            @include('layouts.error')
        </div>
    </div>
    <div class="table-responsive">
        <table class="table trade-alert-table">
            <thead class="table-light">
                <tr>
                    <th></th>
                    <th>Trade</th>
                    <th>Trade Date</th>
                    <th>Average Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($parentTrades as $parentTrade)
                    <tr style="font-weight:bold">
                        <td class="expand-icon text-primary" style="width: 5%">
                            @if($parentTrade->tradeDetail !== null && $parentTrade->tradeDetail->count())
                                <i class="expand-toggle fa-solid fa-chevron-right" style="cursor: pointer;"></i>
                            @endif
                        </td>
                        <td class="parent-trade text-primary" data-trade-id="{{ $parentTrade->id }}"  style="width: 25%">
                            {{ $parentTrade->trade_symbol }}
                        </td>
                        <td  style="width: 15%">{{ $parentTrade->entry_date }}</td>
                        <td style="width: 35%" class="average-price">
                            <span class="price">${{ $parentTrade->entry_price }}</span>
                            <span class="size">({{ number_format($parentTrade->position_size, 0) }}%)</span>
                        </td>
                        <td style="width: 20%">

                        </td>
                    </tr>
                    @if($parentTrade->tradeDetail !== null && $parentTrade->tradeDetail->count())
                        @php
                            //parent row's data
                            $totalPrice = $parentTrade->entry_price * $parentTrade->position_size / 100;
                            $totalPercentage = $parentTrade->position_size / 100;  
                        @endphp
                        <tr class="child-trade child-trade-{{ $parentTrade->id }}" style="display: none;">
                            <td></td>
                            <td></td>
                            <td>{{ $parentTrade->entry_date }}</td>
                            <td>
                                <span>${{ $parentTrade->entry_price }}</span>
                                <span>({{ number_format($parentTrade->position_size, 0) }}%)</span>
                            </td>
                            <td></td>
                        </tr>
                        @foreach($parentTrade->tradeDetail as $childTrade)
                            @php
                                $totalPrice += $childTrade->entry_price * $childTrade->position_size /100;
                                $totalPercentage += $childTrade->position_size / 100;
                            @endphp
                            <tr class="child-trade child-trade-{{ $parentTrade->id }}" style="display: none;">
                                <td></td>
                                <td></td>
                                <td>{{ $childTrade->entry_date }}</td>
                                <td>
                                    <span>${{ $childTrade->entry_price }}</span>
                                    <span>({{ number_format($childTrade->position_size, 0) }}%)</span>
                                </td>
                                <td></td>
                            </tr>
                        @endforeach
                        @php
                            $averagePrice = $totalPrice / $totalPercentage;
                        @endphp
                        <script>
                            $(document).ready(function() {
                                var averagePrice = {{ $averagePrice }};
                                var totalPercentage = {{$totalPercentage}}

                                $('.parent-trade[data-trade-id="{{ $parentTrade->id }}"]').closest('tr').find('.average-price').
                                find('.price').text('$'+parseFloat(averagePrice).toFixed(2));

                                $('.parent-trade[data-trade-id="{{ $parentTrade->id }}"]').closest('tr').find('.average-price')
                                .find('.size').text(' ('+totalPercentage * 100+'%)');
                            });

                             // Show/hide child rows on expand icon click
                             $('body').on('click', '.expand-toggle', function() {
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
                        </script>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('page-script')
    <script>
      
    </script>
@endsection
