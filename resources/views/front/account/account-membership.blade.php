@extends('layouts.front-master')
@section('title', 'Notification')

@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/sweetalert2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/extensions/ext-component-sweet-alerts.css') }}">
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
                    @if($paymentType == 'paypal')
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="last_name" class="form-label">Member Since: </label> 
                                {{ \Carbon\Carbon::parse($agreementDetails->getStartDate())->format('F j, Y') }}
                            </div>
                            <div class="col-md-12">
                                <label for="last_name" class="form-label">Account will cancel on </label>                                 
                                {{ \Carbon\Carbon::parse($agreementDetails->getAgreementDetails()->next_billing_date)->format('F j, Y') }}
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Membership level: {{ $agreementDetails->description }}</label> 
                            </div>
                            <div class="col-md-12">
                                <form method="post" id="cancelForm" action={{route('front.pause-agreement-paypal', ['id' => $subscription_id])}} class="mt-3">
                                    <input type="hidden" name="membership_level" value="{{ $membership_level }}" />
                                    @csrf
                                    @if ($subscriptionStatus == 'Active')
                                        <button type="submit" class="btn btn-danger cancelButton">Membership Cancelation</button>                                        
                                    @else
                                        <button disabled class="btn btn-danger">Membership Cancelation Requested</button>
                                    @endif                                    
                                </form>                                
                            </div>
                        </div>                

                        <h3>Invoice History</h3>
                        <div class="table-responsive">
                            <table class="list-table table">
                                <thead class="table-light">
                                    <tr>
                                        <th>Order#</th=>                        
                                        {{-- <th>Billing Start</th> --}}
                                        <th>Billing End</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($invoices->agreement_transaction_list as $invoice)
                                        <tr>
                                            <td>{{ $invoice->transaction_id }}</td>
                                            {{-- <td></td> --}}
                                            <td> {{ \Carbon\Carbon::parse($invoice->time_stamp)->format('F j, Y') }}</td>
                                            <td>{{ $membership_level }}</td>
                                            <td>
                                                ${{  json_decode($invoice->amount)->value }}
                                            </td>
                                            <td class="text-success">{{$invoice->status}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> 
                    @else
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
                                    <form method="post" id="cancelForm" action={{route('front.cancel-card-subscription')}} class="mt-3">
                                        <input type="hidden" name="membership_level" value="{{ $membership_level }}" />
                                        <input type="hidden" name="cancelAt" 
                                        value="{{\Carbon\Carbon::parse($subscriptions->data[0]['current_period_end'])->format('F j, Y') }}" />
                                        @csrf
                                        @if (auth()->user()->subscription($membership_level)->onGracePeriod())
                                            <button type="submit" disabled class="btn btn-danger">Membership Cancelation Requested</button>
                                        @else
                                            <button type="submit" class="btn btn-danger cancelButton">Membership Cancelation</button>
                                        @endif                                    
                                    </form>    
                                </div>
                            </div>                                 
                        @else
                            <p>There isn't activated subscription</p>
                        @endif

                        <h3>Invoice History</h3>
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
                                        @foreach ($invoices->data as $key => $invoice)
                                            <tr>
                                                <td>{{ $invoice->id }}</td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse(json_decode($invoice->lines['data'][0]['period']['start']))->format('F j, Y') }}
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse(json_decode($invoice->lines['data'][0]['period']['end']))->format('F j, Y') }}</td>
                                                {{-- <td>{{ \Carbon\Carbon::parse($invoice->period_start)->format('F j, Y') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($invoice->period_end)->format('F j, Y') }}</td> --}}
                                                <td>{{ getSubscriptionTitle($invoice->subscription) }}</td>
                                                <td>
                                                    ${{ $invoice->total/100 }}
                                                </td>
                                                <td class="text-success">
                                                    {{$invoice->status}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>   
                    @endif                    
                </div>
            </div>
           
        </section>
    </div>    
@endsection


@section('page-script')
    <script src="{{ asset('app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $('.list-table').DataTable({
            "order": false
        });
        
        //get cancel_at date 

        <?php if($paymentType == 'paypal'): ?>            
            var cancelAt = "<?php echo \Carbon\Carbon::parse($agreementDetails->getAgreementDetails()->next_billing_date)->format('F j, Y'); ?>";
        <?php else: ?>
            <?php if($subscriptions->data): ?>
                var cancelAt = "<?php echo \Carbon\Carbon::parse($subscriptions->data[0]['current_period_end'])->format('F j, Y'); ?>";
            <?php endif; ?>       
        <?php endif; ?>
        


        var cancelButton = $('.cancelButton');

        if (cancelButton.length) {
            var message = "Your plan will be canceled, but it will still be available until the end of your billing period on " + cancelAt + ".  If you change your mind, you can renew your subscription.";

            cancelButton.on('click', function (e) {
                e.preventDefault();
                Swal.fire({
                        title: 'Cancel your plan?',
                        text: message,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Cancel Plan',
                        customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ms-1'
                    },
                    buttonsStyling: false
                }).then(function (result) {
                    if (result.value) {
                        $('#cancelForm').submit();
                    }
                });
            });
        }
    </script>
@endsection