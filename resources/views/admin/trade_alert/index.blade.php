@extends('layouts.master')

@section('title', 'Trade Alerts')

@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css')}}">
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Trade Alerts</h4>
        <a href="{{ route('trades.create') }}" class="btn btn-primary">Add Trade</a>
    </div>
   
    <div class="table-responsive">
        <table class="table trade-alert-table">
            <thead class="table-light">
                <tr>
                    <th></th>
                    <th>Trade</th>
                    <th>Trade Type</th>
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
                        <td class="parent-trade text-primary" data-trade-id="{{ $parentTrade->id }}"  style="width: 20%">
                            {{ $parentTrade->trade_symbol }}
                        </td>
                        <td style="width:10%">{{ $parentTrade->trade_type }}</td>
                        <td style="width: 15%">{{ $parentTrade->entry_date }}</td>
                        <td style="width: 30%" class="average-price">
                            @if($parentTrade->trade_direction == 'sell')
                                <span class="price">(${{ $parentTrade->entry_price }})</span>
                            @else
                                <span class="price">${{ $parentTrade->entry_price }}</span>
                            @endif                            
                            <span class="size">({{ rtrim(rtrim(number_format($parentTrade->position_size, 1), '0'), '.') }}%)</span>
                        </td>
                        <td style="width: 20%">
                            <a href="#" class="btn btn-success btnClose"
                                data-id="{{ $parentTrade->id }}" 
                                data-direction="{{ $parentTrade->trade_direction }}"
                                data-position = "{{ $parentTrade->position_size }}"
                                data-symbol="{{$parentTrade->trade_symbol}}" 
                                data-strikeprice = "{{$parentTrade->strike_price}}" 
                                data-option="{{$parentTrade->trade_option}}" 
                                data-entryprice="{{$parentTrade->entry_price}}" 
                                data-expirationdate="{{\Carbon\Carbon::parse($parentTrade->expiration_date)->format('dMY')}}" >
                                Close
                            </a>
                            <a href="#" class="btn btn-success btnAdd"  
                                data-id="{{ $parentTrade->id }}" 
                                data-direction="{{ $parentTrade->trade_direction }}"
                                data-position = "{{ $parentTrade->position_size }}"
                                data-symbol="{{$parentTrade->trade_symbol}}" 
                                data-strikeprice = "{{$parentTrade->strike_price}}" 
                                data-option="{{$parentTrade->trade_option}}" 
                                data-entryprice="{{$parentTrade->entry_price}}" 
                                data-expirationdate="{{\Carbon\Carbon::parse($parentTrade->expiration_date)->format('dMY')}}"
                               >
                              Add
                            </a>
                        </td>
                    </tr>
                    @if($parentTrade->tradeDetail !== null && $parentTrade->tradeDetail->count())
                        @php
                            //parent row's data
                            $totalPrice = $parentTrade->entry_price * $parentTrade->position_size / 100;
                            $totalPercentage = $parentTrade->position_size / 100;  
                            $averagePrice = 0;
                        @endphp
                        <tr class="child-trade child-trade-{{ $parentTrade->id }}" style="display: none;">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>{{ $parentTrade->entry_date }}</td>
                            <td>
                                <span>${{ $parentTrade->entry_price }}</span>
                                <span>({{ rtrim(rtrim(number_format($parentTrade->position_size, 1), '0'), '.') }}%)</span>
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
                                <td></td>
                                <td>{{ $childTrade->entry_date }}</td>
                                <td>
                                    <span>${{ $childTrade->entry_price }}</span>
                                    <span>({{ rtrim(rtrim(number_format($parentTrade->position_size, 1), '0'), '.') }}%)</span>
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
       
        {{ $parentTrades->appends(request()->query())->links() }}
    </div>

     <!-- Add Trade Modal -->
     <div class="modal fade" id="addTrade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-add-trade">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    <div class="text-center mb-2">
                        <h1 class="modal_trade_title">Add Trade</h1>
                        <h2 class="mb-1 tradeAddTitle" style="font-weight: bold;"></h2>
                    </div>
                    
                    <form id="addTradeForm" method="post" action="{{route('admin.trade-add')}}" class="row gy-1 pt-75" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="addFormID" id="addFormID" value="" />
                        <input type="hidden" name="addTradeSymbol" id="addTradeSymbol" value="" />
                        <input type="hidden" name="addTradeOption" id="addTradeOption" value="" />
                        <input type="hidden" name="addTradeDirection" id="addTradeDirection" value="" />
                        <input type="hidden" name="addTradeStrikePrice" id="addTradeStrikePrice" value="" />
                        
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="AddEntryDate">Entry Date</label>
                            <input type="text" id="addEntryDate" name="addEntryDate" class="form-control picker" value="{{old('addEntryDate')}}" />
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label" for="addBuyPrice">Buy Price</label>
                            <input type="text" id="addBuyPrice" name="addBuyPrice" class="form-control numeral-mask" value="{{old('addBuyPrice')}}" />
                        </div>

                        <div class="col-12 col-md-4">
                            <label class="form-label" for="itemname">Position Size(%)</label>
                            <select class="form-select" name="addPositionSize" id="addPositionSize">
                                @for ($i = 0.5; $i <= 10; $i += 0.5)
                                    <option value="{{$i}}" {{ old('addPositionSize') == $i ? 'selected' : '' }}>{{$i}}</option>
                                @endfor                                                
                            </select>
                        </div>

                        <div class="col-12 col-md-4">
                            <label class="form-label" for="addStopPrice">Stop Price</label>
                            <input type="text" id="addStopPrice" name="addStopPrice" class="form-control" value="No Stop" value="{{old('addStopPrice')}}"  />
                        </div>

                        <div class="col-12 col-md-4">
                            <label class="form-label" for="AddBuyPrice">Target Price</label>
                            <input type="text" id="addTargetPrice" name="addTargetPrice" class="form-control numeral-mask" value="{{old('addTargetPrice')}}" />
                        </div>

                        <div class="col-12 col-md-12">
                            <label class="form-label" for="itemname">Comment on Trade</label>
                            <textarea class="form-control" name="addComments" id="addComments" rows="3">{{ old('addComments') }}</textarea>
                        </div>

                        <div class="col-12 col-md-12">
                            <label for="customFile" class="form-label">Chart Image</label>
                            <input class="form-control" type="file" id="addImage" name="addImage" />
                        </div>
                       
                        <div class="col-12 text-center mt-2 pt-50">
                            <button type="submit" class="btn btn-primary me-1">Submit</button>
                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--/ Add Trade Modal -->


    <!-- Close Trade Modal -->
    <div class="modal fade" id="closeTrade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-close-trade">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    <div class="text-center mb-2">
                        <h1 class="modal_trade_title">Close Trade</h1>
                        <h2 class="mb-1 tradeCloseTitle" style="font-weight: bold;"></h2>
                    </div>
                    
                    <form id="closeTradeForm" method="post" action="{{route('admin.trade-close')}}" class="row gy-1 pt-75" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="closeFormID" id="closeFormID" value="" />
                        <input type="hidden" name="closeTradeSymbol" id="closeTradeSymbol" value="" />
                        <input type="hidden" name="closeTradeOption" id="closeTradeOption" value="" />
                        <input type="hidden" name="closeTradeDirection" id="closeTradeDirection" value="" />
                        <input type="hidden" name="closeTradeStrikePrice" id="closeTradeStrikePrice" value="" />
                        <input type="hidden" name="closeTradeEntryPrice" id="closeTradeEntryPrice" value="" />
                        

                        <div class="col-12 col-md-4">
                            <label class="form-label" for="closeExitDate">Exit Date</label>
                            <input type="text" class="form-control" value="<?php echo date('Y-m-d'); ?>" disabled />
                            <input type="hidden" id="closeExitDate" name="closeExitDate"  value="<?php echo date('Y-m-d'); ?>" />
                        </div>

                        <div class="col-12 col-md-4">
                            <label class="form-label" for="closeExitPrice">Exit Price</label>
                            <input type="text" id="closeExitPrice" name="closeExitPrice" class="form-control numeral-mask" value="{{old('closeExitPrice')}}" />
                        </div>

                        <div class="col-12 col-md-4">
                            <label class="form-label" for="itemname">Position Size(%)</label>
                            <input type="text" id="PositionSize" name="PositionSize" class="form-control" value="All" disabled />
                        </div>

                        <div class="col-12 col-md-12">
                            <label class="form-label" for="itemname">Comment on Trade</label>
                            <textarea class="form-control" name="closedComments" id="closedComments" rows="3">{{ old('closedComments') }}</textarea>
                        </div>

                        <div class="col-12 col-md-12">
                            <label for="customFile" class="form-label">Chart Image</label>
                            <input class="form-control" type="file" id="closeImage" name="closeImage" />
                        </div>
                       
                        <div class="col-12 text-center mt-2 pt-50">
                            <button type="submit" class="btn btn-primary me-1">Submit</button>
                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--/ Edit Trade Modal -->
</div>
@endsection

@section('page-script')
<script src="https://kit.fontawesome.com/8c0eabb613.js" crossorigin="anonymous"></script>
<script src="{{asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js')}}"></script>
<script src="{{asset('app-assets/vendors/js/forms/cleave/cleave.min.js')}}"></script>
<script src="{{asset('app-assets/vendors/js/forms/cleave/addons/cleave-phone.us.js')}}"></script>
<script>    
    $(document).ready(function () {
        var addTradeForm = $('#addTradeForm');
        var closeTradeForm = $('#closeTradeForm');

        $('body').on('click', '.btnAdd', function(e) {
            e.preventDefault();
            var space = ' ';
            var id = $(this).data('id');
            var direction = $(this).data('direction').toUpperCase();
            var symbol = $(this).data('symbol');
            var strikeprice = $(this).data('strikeprice');
            var option = $(this).data('option');
            var entryprice = $(this).closest('tr').find('.average-price').find('.price').text();
            if(entryprice == undefined)
                entryprice = $(this).data('entryprice');
            var expirationdate = $(this).data('expirationdate');
            var tradeTitle = direction+space+space+symbol+space+expirationdate+space+strikeprice+space+option+entryprice.replace(/[\$\(\)]/g, '');
            // console.log(tradeTitle);
            
            $('#addTrade').modal('show');
            $('.tradeAddTitle').text(tradeTitle);
            $('#addFormID').val(id);
            $('#addTradeSymbol').val(symbol);
            $('#addTradeOption').val(option);
            $('#addTradeDirection').val(direction);
            $('#addTradeStrikePrice').val(strikeprice);
        });

        $('body').on('click', '.btnClose', function(e) {
            e.preventDefault();  
            var space = ' ';
            var id = $(this).data('id');
            var direction = $(this).data('direction');
             //if there is a total position size
            var position_size = $(this).closest('tr').find('.average-price').find('.size').text();
            if(position_size == undefined)
                position_size = parseFloat($(this).data('position'))+'%';

            var symbol = $(this).data('symbol');
            var strikeprice = $(this).data('strikeprice');
            var option = $(this).data('option');
            var entryprice = $(this).closest('tr').find('.average-price').find('.price').text();
            if(entryprice == undefined)
                entryprice = $(this).data('entryprice');
            var expirationdate = $(this).data('expirationdate');
            if(direction =='sell') direction = 'Buy';
            else direction = 'Sell'
            var tradeTitle = direction.toUpperCase()+space+symbol+space+position_size.replace(/[\$\(\)]/g, '')+space+expirationdate+space+
                strikeprice+space+option+entryprice.replace(/[\$\(\)]/g, '');
            // console.log(tradeTitle);
            
            $('#closeTrade').modal('show');
            $('.tradeCloseTitle').text(tradeTitle);
            $('#closeFormID').val(id);
            $('#closeTradeSymbol').val(symbol);
            $('#closeTradeOption').val(option);
            $('#closeTradeDirection').val(direction);
            $('#closeTradeStrikePrice').val(strikeprice);
            $('#closeTradeEntryPrice').val(entryprice);
        });

        $.validator.addMethod('filesize', function(value, element, param) {
            // param = size (in bytes) 
            // element = element to validate (<input>)
            // value = value of the element (file name)
            return this.optional(element) || (element.files[0].size <= param) 
        });

        $.validator.addMethod("extension", function(value, element, param) {
            param = typeof param === "string" ? param.replace(/,/g, '|') : "png|jpe?g|gif";
            return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
        });
        
        addTradeForm.validate({
            rules: {
                'addEntryDate': {
                    required: true
                },
                'addBuyPrice': {
                    required: true
                },
                'addStopPrice': {
                    required: true
                },
                'addTargetPrice': {
                    required: true
                },
                'addImage':{
                    extension: "png|jpg|jpeg",
                    filesize: 1048576  //1MB
                }
            },
            messages: {
                field: {
                    extension: "Please upload file in .jpg, .png format",
                    filesize: "File must be less than 1MB"
                }
            }
        });

        closeTradeForm.validate({
            rules: {
                'closeExitDate': {
                    required: true
                },
                'closeExitPrice': {
                    required: true
                },               
                'closeImage':{
                    extension: "png|jpg|jpeg",
                    filesize: 1048576  //1MB
                }
            },
            messages: {
                field: {
                    extension: "Please upload file in .jpg, .png format",
                    filesize: "File must be less than 1MB"
                }
            }
        });

        var picker = $('.picker');
        picker.flatpickr({
            allowInput: true,
            // dateFormat: "d-m-Y",  // Date format set to day-month-year
            onReady: function (selectedDates, dateStr, instance) {
                if (instance.isMobile) {
                    $(instance.mobileInput).attr('step', null);
                }
            }
        });

        var fields = ['#addBuyPrice', '#addTargetPrice', '#closeExitPrice'];
        var options = {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand'
        };

        fields.forEach(element => {
            new Cleave(element, options);
        });
    });    
</script>
@endsection
