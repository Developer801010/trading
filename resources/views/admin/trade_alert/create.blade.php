@extends('layouts.master')

@section('title', 'Trade Creation')

@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/editors/quill/quill.snow.css') }}">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
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

                    @include('layouts.error')           

                    <form action="{{route('trades.store')}}" class="trade-repeater tradeForm" method="post" enctype="multipart/form-data">
                        @csrf
                        <div data-repeater-list="trade">
                            <div data-repeater-item>
                                <div class="row d-flex align-items-end mb-1">
                                    <div class="col-md-3 col-12">
                                        <div class="mb-1">
                                            <label class="form-label mb-1">Trade Type</label><br>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="trade_type" id="trade_type_stock" value="stock" 
                                                {{ old('trade_type', 'stock') == 'stock' ? 'checked' : '' }}  />
                                                <label class="form-check-label" for="trade_type_stock">Stock</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="trade_type" id="trade_type_option" value="option"
                                                {{ old('trade_type', 'stock') == 'option' ? 'checked' : '' }} />
                                                <label class="form-check-label" for="trade_type_option">Option</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-12">
                                        <div class="mb-1">
                                            <label class="form-label">Symbol</label>
                                            <input type="text" class="form-control" name="trade_symbol" id="trade_symbol" value="{{old('trade_symbol')}}" />
                                        </div>
                                    </div>

									<div class="col-md-3 col-12">
                                        <div class="mb-1">
                                            <label class="form-label">Company Name</label>
                                            <input type="text" class="form-control" name="company_name" id="company_name" value="{{old('company_name')}}" />
                                        </div>	
                                    </div>

									<div class="col-md-3 col-12">
                                        <div class="mb-1">
                                            <label class="form-label">Current Price($)</label>
                                            <input type="text" class="form-control" name="current_price" id="current_price" value="{{old('current_price', '0')}}" />
                                        </div>
                                    </div>

                                    {{-- <div class="col-md-2 col-12 mb-50">
                                        <button class="btn btn-outline-danger text-nowrap px-1" data-repeater-delete type="button">
                                            <i data-feather="x" class="me-25"></i>
                                            <span>Delete</span>
                                        </button>
                                    </div> --}}
                                </div>
                                <div class="row">
                                    <div class="col-md-3 col-12 option_column d-none">
                                        <div class="mb-1">
                                            <label class="form-label mb-1">Trade Option</label><br>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="trade_option" id="trade_option_call" value="call" 
                                                {{ old('trade_option', 'call') == 'call' ? 'checked' : '' }}  />
                                                <label class="form-check-label" for="trade_option_call">Call</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="trade_option" id="trade_option_put" value="put"
                                                {{ old('trade_option', 'call') == 'put' ? 'checked' : '' }}  />
                                                <label class="form-check-label" for="trade_option_put">Put</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-12">
                                        <div class="mb-1">
                                            <label class="form-label mb-1">Direction</label><br>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="trade_direction" id="trade_direction_buy" value="buy" 
                                                {{ old('trade_direction', 'buy') == 'buy' ? 'checked' : '' }} />
                                                <label class="form-check-label" for="trade_direction_buy">Buy</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="trade_direction" id="trade_direction_sell" value="sell"
                                                {{ old('trade_direction', 'buy') == 'sell' ? 'checked' : '' }} />
                                                <label class="form-check-label" for="trade_direction_sell">Sell</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-12  option_column d-none">
                                        <div class="mb-1">
                                            <label class="form-label">Expiration Date (YYYY-MM-DD)</label>
                                            <input type="text" class="form-control picker" name="expiration_date" id="expiration_date" value="{{old('expiration_date')}}" />
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-12  option_column d-none">
                                        <div class="mb-1">
                                            <label class="form-label">Strike Price($)</label>
                                            <input type="text" class="form-control" name="strike_price" id="strike_price" value="{{old('strike_price', '0')}}" />
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-12">
                                        <div class="mb-1">
                                            <label class="form-label">Entry Price($)</label>
                                            <input type="text" class="form-control" name="entry_price" id="entry_price" value="{{old('entry_price')}}" />
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-12">
                                        <div class="mb-1">
                                            <label class="form-label">Stop Price($)</label>
                                            <input type="text" class="form-control" name="stop_price" id="stop_price" value="{{old('stop_price') }}"  />
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-12">
                                        <div class="mb-1">
                                            <label class="form-label">Target Price($)</label>
                                            <input type="text" class="form-control" name="target_price" id="target_price" value="{{old('target_price')}}"  />
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-12">
                                        <div class="mb-1">
                                            <label class="form-label">Entry Date</label>
                                            <input type="text" class="form-control picker" name="entry_date" id="entry_date" value="{{old('entry_date')}}"  />
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-12">
                                        <div class="mb-1">
                                            <label class="form-label">Position Size(%)</label>
                                            <select class="form-select" name="position_size" id="position_size">
                                                @for ($i = 0.5; $i <= 10; $i += 0.5)
                                                    <option value="{{$i}}" {{ old('position_size') == $i ? 'selected' : '' }}>{{$i}}</option>
                                                @endfor                                                
                                            </select>
                                        </div>
                                    </div>
                                  
                                </div>
                              
                                <div class="row">
                                    <div class="col-md-12 mb-5">
                                        <label class="form-label">Comment on Trade</label>
                                        <div class="quill-toolbar">
                                            <span class="ql-formats">
                                                <select class="ql-header">
                                                    <option value="1">Heading</option>
                                                    <option value="2">Subheading</option>
                                                    <option selected>Normal</option>
                                                </select>
                                                <select class="ql-font">
                                                    <option selected>Sailec Light</option>
                                                    <option value="sofia">Sofia Pro</option>
                                                    <option value="slabo">Slabo 27px</option>
                                                    <option value="roboto">Roboto Slab</option>
                                                    <option value="inconsolata">Inconsolata</option>
                                                    <option value="ubuntu">Ubuntu Mono</option>
                                                </select>
                                            </span>
                                            <span class="ql-formats">
                                                <button class="ql-bold"></button>
                                                <button class="ql-italic"></button>
                                                <button class="ql-underline"></button>
                                            </span>
                                            <span class="ql-formats">
                                                <button class="ql-list" value="ordered"></button>
                                                <button class="ql-list" value="bullet"></button>
                                            </span>
                                            <span class="ql-formats">
                                                <button class="ql-link"></button>
                                                <button class="ql-image"></button>
                                                <button class="ql-video"></button>
                                            </span>
                                            <span class="ql-formats">
                                                <button class="ql-formula"></button>
                                                <button class="ql-code-block"></button>
                                            </span>
                                            <span class="ql-formats">
                                                <button class="ql-clean"></button>
                                            </span>
                                        </div>
                                        <div class="quill_editor">
                                                
                                        </div>                                       
                                    </div>
                                    <input type="hidden" id="quill_html" name="quill_html">
                                </div>

                                <div class="col-12 mt-2 mb-1 image_row">
                                    <label for="customFile" class="form-label">Chart Image</label>
                                    <input class="form-control" type="file" id="image" name="image" />
                                </div>
								<input type="hidden" id="symbol_image" name="symbol_image" value="{{ old('image') }}"/>


                                {{-- <div class="col-12 mb-1 d-none">
                                    <label class="form-label">Trade Date (yyyy-mm-dd)</label>
                                    <input type="text" class="form-control picker" name="trade_date" id="trade_date" />
                                </div> --}}

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mt-2">
                                {{-- <button class="btn btn-icon btn-primary" type="button" data-repeater-create>
                                    <i data-feather="plus" class="me-25"></i>
                                    <span>Add New</span>
                                </button> --}}
                                <button type="submit" class="btn btn-success" style="margin-right:15px;">Save</button>
                                <a href="{{route('trades.index')}}" class="btn btn-outline-primary">Cancel</a>
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
{{-- <script src="{{asset('app-assets/vendors/js/forms/repeater/jquery.repeater.min.js')}}"></script> --}}
<script src="{{asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js')}}"></script>
<script src="{{asset('app-assets/vendors/js/forms/cleave/cleave.min.js')}}"></script>
<script src="{{asset('app-assets/vendors/js/forms/cleave/addons/cleave-phone.us.js')}}"></script>
<script src="{{asset('app-assets/vendors/js/editors/quill/quill.min.js')}}"></script>
{{-- <script src="{{asset('app-assets/js/scripts/forms/form-quill-editor.js')}}"></script> --}}
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>


    var option_column = $('.option_column');
	var msg_column = $('.message-column');
	
    var tradeForm = $('.tradeForm');
    
    // $('.trade-repeater, .repeater-default').repeater({
    //     show: function () {
    //         $(this).slideDown();
    //         // Feather Icons
    //             if (feather) {
    //                 feather.replace({ width: 14, height: 14 });
    //             }
    //         },
    //     hide: function (deleteElement) {
    //         if (confirm('Are you sure you want to delete this element?')) {
    //             $(this).slideUp(deleteElement);
    //         }
    //     }
    // });

    var fields = ['#entry_price', '#target_price','#strike_price'];
    var options = {
        numeral: true,
        numeralThousandsGroupStyle: 'thousand'
    };

    fields.forEach(element => {
        new Cleave(element, options);
    });

    $(document).ready(function () {

        var tradeType = @json(old('trade_type'));
        if(tradeType == 'option'){
            option_column.removeClass('d-none');
        }else if (tradeType == 'stock'){
            option_column.addClass('d-none');
        } 
        // var tradeType = $('input[name="trade_type"]').val();

      
        tradeForm.validate({
            rules: {
                'trade_symbol': {
                    required: true
                },
                'entry_price': {
                    required: true
                },
                'stop_price': {
                    required: true
                },
                'target_price': {
                    required: true
                },
                'entry_date': {
                    required: true
                },
            }
        });

        $('input[name="trade_type"]').change(function() {

            
            // Get the value of the selected radio button
            var selectedValue = $(this).val(); 
            
            // Perform actions based on the selected value
            if (selectedValue === "stock") 
            {
                option_column.addClass('d-none');
				msg_column.addClass('d-none');

                tradeForm.validate({
                    rules: {
                        'trade_symbol': {
                            required: true
                        },
                        'entry_price': {
                            required: true
                        },
                        'stop_price': {
                            required: true
                        },
                        'target_price': {
                            required: true
                        },
                        'entry_date': {
                            required: true
                        },
                    }
                });
            } 
            else if (selectedValue === "option") 
            {
                option_column.removeClass('d-none');
				msg_column.addClass('d-none');

                tradeForm.validate({
                    rules: {
                        'trade_symbol': {
                            required: true
                        },
                        'expiration_date': {
                            required: true
                        },
                        'strike_price': {
                            required: true
                        },
                        'entry_price': {
                            required: true
                        },
                        'stop_price': {
                            required: true
                        },
                        'target_price': {
                            required: true
                        },
                        'entry_date': {
                            required: true
                        },
                    }
                });
            } 
        });


        var quill = new Quill('.quill_editor', {
            modules: {
                toolbar: '.quill-toolbar'
            },
            theme: 'snow'
        });

      
        quill.on('text-change', function(delta, oldDelta, source) {
            document.getElementById("quill_html").value = quill.root.innerHTML; 
        });

		$( "#trade_symbol" ).autocomplete({
			source: function( request, response ) {
				$.ajax({
					method: "POST",
					url: "{{ route('admin.trade-search') }}",
					dataType: "json",
					data: {
						_token: "{{ csrf_token() }}",
						symbol: request.term,
						type: 'list-companies'
					},
					success: function( data ) {
						response( data );
					}
				});
			},
			minLength: 2,
			select: function( event, ui ) {
				$.ajax({
					method: "POST",
					url: "{{ route('admin.trade-search') }}",
					data: {
						_token: "{{ csrf_token() }}",
						symbol: ui.item.value,
						type: 'company-details'
					},
					dataType: "json",
					success: function (response) {
						$('#current_price').val(response.price);
						$('#company_name').val(response.company_name);

						$('#symbol_image').val(response.image);
					}
				});
			}
		});
        
    });

    picker = $('.picker');
    picker.flatpickr({
        allowInput: true,
        // dateFormat: "d-m-Y",  // Date format set to day-month-year
        onReady: function (selectedDates, dateStr, instance) {
            if (instance.isMobile) {
                $(instance.mobileInput).attr('step', null);
            }
        }
    });

   

</script>
@endsection