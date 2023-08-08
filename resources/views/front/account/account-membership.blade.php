@extends('layouts.front-master')
@section('title', 'Notification')

@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/toastr.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/form-validation.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endsection


@section('content')
    <div class="container">
        <section class="dashboard-section">        
            {{-- @include('layouts.front-email-verify') --}}
           
        </section>
        <section class="account-section">
            <div class="row">
                <div class="col-md-3">
                    @include('layouts.front-dashboard-sidebar')
                </div>
                <div class="col-md-9">
                    <h2 class="heading pb-3 pt-3">Membership</h2>
                    
                    @include('layouts.error')
                    @if ($subscriptions->data)
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="last_name" class="form-label">Member Since: </label> 
                                {{ \Carbon\Carbon::parse($subscriptions->data[0]['created'])->format('F j, Y') }}
                            </div>
                            <div class="col-md-12">
                                <label for="last_name" class="form-label">Account will cancel on </label> 
                                {{ \Carbon\Carbon::parse($subscriptions->data[0]['current_period_end'])->format('F j, Y') }}
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Membership level: {{ $membership_level }}</label> 
                            </div>
                            <div class="col-md-12">
                                <form method="post" action={{route('front.cancel-card-subscription')}} class="mt-3">
                                    <input type="hidden" name="membership_level" value="{{ $membership_level }}" />
                                    @csrf
                                    @if (auth()->user()->subscription($membership_level)->onGracePeriod())
                                        <button type="submit" disabled class="btn btn-danger">Membership Cancelation Requested</button>
                                    @else
                                        <button type="submit" class="btn btn-danger">Membership Cancelation</button>
                                    @endif                                    
                                </form>                                
                            </div>
                        </div>    

                        <div class="table-responsive">
                            <table class="list-table table">
                                <thead class="table-light">
                                    <tr>
                                        <th>Order#</th=>                        
                                        <th>Billing Start</th>
                                        <th>Billing End</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoices->data as $invoice)
                                        <tr>
                                            <td>{{ $invoice->id }}</td>
                                            <td>{{ \Carbon\Carbon::parse($invoice->period_start)->format('F j, Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($invoice->period_end)->format('F j, Y') }}</td>
                                            <td>{{ getSubscriptionTitle($invoice->subscription) }}</td>
                                            <td>
                                                ${{ $invoice->total/100 }}
                                            </td>
                                            <td>{{$invoice->status}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>    

                    @else
                        <p>There isn't activated subscription</p>
                    @endif
                </div>
            </div>
           
        </section>
    </div>    
@endsection


@section('page-script')
    <script src="{{ asset('app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $('.list-table').DataTable();
    </script>
@endsection