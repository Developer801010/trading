@extends('layouts.master')

@section('title', 'Setting')
@section('page-style')
    <style>
        .alert{
            padding: 10px !important;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css')}}">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endsection
@section('content')
<section>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Setting</h4>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        @include('layouts.error')
                    </div>
                </div>

                <div class="card-body">    
                    <form action="{{ route('settings.store') }}" method="POST" class="row gy-1 pt-75">       
                        @csrf             
                        <div class="col-6">
                            <label class="form-label" for="portfolio_size">Portfolio Size</label>
                            <input type="text" class="form-control" name="portfolio_size" id="portfolio_size" value="{{old('portfolio_size',(isset($getData) && !empty($getData->portfolio_size) ? number_format($getData->portfolio_size) : ''))}}"/>
                        </div>
                
                        <div class="col-6">
                            <label class="form-label" for="investment_amount">Investment Amount</label>
                            <input type="text" class="form-control" name="investment_amount" id="investment_amount" value="{{old('investment_amount',(isset($getData) && !empty($getData->investment_amount) ? number_format($getData->investment_amount) : '0'))}}" readonly/>
                        </div>

                        <div class="col-6">
                            <label class="form-label" for="start_date">Start Date</label>
                            <input type="text" class="form-control picker" name="start_date" id="start_date" value="{{old('start_date',(isset($getData) && !empty($getData->date) ? $getData->date : ''))}}"  />
                        </div>

                        <div class="col-6">
                            <label class="form-label" for="losers_amount">Losers Amount</label>
                            <input type="text" class="form-control" name="losers_amount" id="losers_amount" value="{{old('losers_amount',(isset($getData) && !empty($getData->losers_amount) ? number_format($getData->losers_amount) : '0'))}}" readonly/>
                        </div>
                
                        <div class="col-12 text-center mt-2 pt-50">
                            <button type="submit" class="btn btn-primary me-1">Save</button>
                        </div>
                    </form>
                </div>  
            </div>         
        </div>
    </div>
</section>
@endsection
@section('page-script')
<script src="{{asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js')}}"></script>
<script src="{{asset('app-assets/vendors/js/forms/cleave/cleave.min.js')}}"></script>
<script src="{{asset('app-assets/vendors/js/forms/cleave/addons/cleave-phone.us.js')}}"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
    var fields = ['#portfolio_size'];
    var options = {
        numeral: true,
        numeralThousandsGroupStyle: 'thousand'
    };

    fields.forEach(element => {
        new Cleave(element, options);
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