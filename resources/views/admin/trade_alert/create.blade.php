@extends('layouts.master')

@section('title', 'Trade Creation')

@section('page-style')
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css')}}">
@endsection
@section('content')
<section>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Trade Creation</h4>
                </div>

                <div class="card-body">                    
                    <form action="{{route('trades.store')}}" class="trade-repeater" method="post">
                        @csrf
                        <div data-repeater-list="trade">
                            <div data-repeater-item>
                                <div class="row d-flex align-items-end mb-1">
                                    <div class="col-md-3 col-12">
                                        <div class="mb-1">
                                            <label class="form-label mb-1" for="itemname">Trade Type</label><br>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="trade_type" id="trade_type_stock" value="stock" checked />
                                                <label class="form-check-label" for="trade_type_stock">Stock</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="trade_type" id="trade_type_option" value="option" />
                                                <label class="form-check-label" for="trade_type_option">Option</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2 col-12 mb-50">
                                        <button class="btn btn-outline-danger text-nowrap px-1" data-repeater-delete type="button">
                                            <i data-feather="x" class="me-25"></i>
                                            <span>Delete</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="itemname">Symbol</label>
                                            <input type="text" class="form-control" name="trade_symbol" id="trade_symbol" />
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-12">
                                        <div class="mb-1">
                                            <label class="form-label mb-1" for="itemname">Trade Direction</label><br>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="trade_direction" id="trade_direction_buy" value="buy" checked />
                                                <label class="form-check-label" for="trade_direction_buy">Buy</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="trade_direction" id="trade_direction_sell" value="sell" />
                                                <label class="form-check-label" for="trade_direction_sell">Sell</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-12">
                                        <div class="mb-1">
                                            <label class="form-label mb-1" for="itemname">Trade Option</label><br>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="trade_option" id="trade_option_call" value="call" checked />
                                                <label class="form-check-label" for="trade_option_call">Call</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="trade_option" id="trade_option_put" value="put" />
                                                <label class="form-check-label" for="trade_option_put">Put</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-12">
                                        <div class="mb-1">
                                            <label class="form-label mb-1" for="itemname">Trade Long/Short</label><br>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="trade_long_shirt" id="trade_long" value="long" checked />
                                                <label class="form-check-label" for="trade_long">Long</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="trade_long_shirt" id="trade_short" value="shirt" />
                                                <label class="form-check-label" for="trade_short">Shirt</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="itemname">Entry Date (yyyy-mm-dd)</label>
                                            <input type="text" class="form-control picker" name="entry_date" id="entry_date" />
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="itemname">Entry Price</label>
                                            <input type="text" class="form-control" name="entry_price" id="entry_price" />
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="itemname">Position Size(%)</label>
                                            <input type="text" class="form-control" name="position_size" id="position_size" />
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="itemname">Stop Price</label>
                                            <input type="text" class="form-control" name="stop_price" id="stop_price" />
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="itemname">Target Price</label>
                                            <input type="text" class="form-control" name="projected_target_price" id="projected_target_price" />
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="itemname">Total Position In Stock</label>
                                            <input type="text" class="form-control" name="total_position_in_stock" id="total_position_in_stock" />
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="itemname">Average Price</label>
                                            <input type="text" class="form-control" name="average_price" id="average_price" />
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="itemname">Exit Price</label>
                                            <input type="text" class="form-control" name="exit_price" id="exit_price" />
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="itemname">Exit Date(yyyy-mm-dd)</label>
                                            <input type="text" class="form-control picker" name="exit_date" id="exit_date" />
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="itemname">Profit(%)</label>
                                            <input type="text" class="form-control" name="profit_percentage" id="profit_percentage" />
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="itemname">Gain Loss</label>
                                            <input type="text" class="form-control" name="gain_loss" id="gain_loss" />
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="itemname">Gain Loss(%)</label>
                                            <input type="text" class="form-control" name="gain_loss_percentage" id="gain_loss_percentage" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-1">
                                        <label class="form-label" for="itemname">Trade Description</label>
                                        <textarea class="form-control" name="trade_description" id="trade_description" rows="3"></textarea>
                                    </div>

                                    <div class="col-6 mb-1">
                                        <label for="customFile" class="form-label">Chart Image</label>
                                        <input class="form-control" type="file" id="chart_image" name="chart_image" />
                                    </div>

                                    <div class="col-6 mb-1">
                                        <label class="form-label" for="itemname">Trade Date (yyyy-mm-dd)</label>
                                        <input type="text" class="form-control picker" name="trade_date" id="trade_date" />
                                    </div>
                                </div>

                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button class="btn btn-icon btn-primary" type="button" data-repeater-create>
                                    <i data-feather="plus" class="me-25"></i>
                                    <span>Add New</span>
                                </button>
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </div>
                    </form>
                </div>                
            </div>
        </div>
    </div>        
</section>
@endsection
@section('page-script')
<script src="{{asset('app-assets/vendors/js/forms/repeater/jquery.repeater.min.js')}}"></script>
<script src="{{asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js')}}"></script>
<script>
    $('.trade-repeater, .repeater-default').repeater({
        show: function () {
            $(this).slideDown();
            // Feather Icons
                if (feather) {
                    feather.replace({ width: 14, height: 14 });
                }
            },
        hide: function (deleteElement) {
            if (confirm('Are you sure you want to delete this element?')) {
                $(this).slideUp(deleteElement);
            }
        }
  });

  picker = $('.picker');
  picker.flatpickr({
      allowInput: true,
      onReady: function (selectedDates, dateStr, instance) {
        if (instance.isMobile) {
          $(instance.mobileInput).attr('step', null);
        }
      }
  });
</script>
@endsection