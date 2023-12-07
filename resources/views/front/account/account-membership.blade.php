@extends('layouts.front-master')
@section('title', 'Notification')

@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/sweetalert2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/extensions/ext-component-sweet-alerts.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endsection


@section('content')
    <!-- MAIN -->
    <main class="main-wrapper">
        <div class="main-feed">
            <div class="container-lg">
                <div class="row">
                    <div class="col-lg-3">
                        @include('layouts.front-dashboard-sidebar')
                    </div>
                    <div class="col-lg-9">
                        <div class="tab-card">
                            <div class="tab-card-header">My Subscription</div>
                            <div class="tab-card-body">
                                @include('layouts.error')
                                @if(isset($paymentType) && $paymentType == 'paypal')
                                    <div class="d-flex gap-3 flex-wrap align-items-end justify-content-between">
                                        <div class="">
                                            <ul class="nav flex-column">
                                                <li class="d-flex flex-column mb-3">
                                                    <span class="m-title">Member Since:</span>
                                                    <span class="m-subtitle">{{ \Carbon\Carbon::parse($agreementDetails->getStartDate())->format('F j, Y') }}</span>
                                                </li>
                                                <li class="d-flex flex-column mb-3">
                                                    <span class="m-title">Membership level:</span>
                                                    <span class="m-subtitle">{{ $agreementDetails->description }}</span>
                                                </li>
                                                <li class="d-flex flex-column">
                                                    <span class="m-title">Account will cancel on:</span>
                                                    <span class="m-subtitle">{{ \Carbon\Carbon::parse($agreementDetails->getAgreementDetails()->next_billing_date)->format('F j, Y') }}</span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div>
                                            <form method="post" id="cancelForm" action={{route('front.pause-agreement-paypal', ['id' => $subscription_id])}} class="mt-3">
                                                <input type="hidden" name="membership_level" value="{{ $membership_level }}" />
                                                @csrf
                                                @if ($subscriptionStatus == 'Active')
                                                    <button type="submit" class="btn btn-dang cancelButton">Membership Cancelation</button>
                                                @else
                                                    <button disabled class="btn btn-dang">Membership Cancelation Requested</button>
                                                @endif
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    @if (isset($subscriptions->data) && $subscriptions->data)
                                        <div class="d-flex gap-3 flex-wrap align-items-end justify-content-between">
                                            <div class="">
                                                <ul class="nav flex-column">
                                                    <li class="d-flex flex-column mb-3">
                                                        <span class="m-title">Member Since:</span>
                                                        <span class="m-subtitle">{{ \Carbon\Carbon::parse($subscriptions->data[0]['created'])->format('F j, Y') }}</span>
                                                    </li>
                                                    <li class="d-flex flex-column mb-3">
                                                        <span class="m-title">Membership level:</span>
                                                        <span class="m-subtitle">{{ $membership_level }}</span>
                                                    </li>
                                                    <li class="d-flex flex-column">
                                                        <span class="m-title">Account will cancel on:</span>
                                                        <span class="m-subtitle">{{ \Carbon\Carbon::parse($subscriptions->data[0]['current_period_end'])->format('F j, Y') }}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div>
                                                <form method="post" id="cancelForm" action={{route('front.cancel-card-subscription')}} class="mt-3">
                                                    @csrf
                                                    <input type="hidden" name="membership_level" value="{{ $membership_level }}" />
                                                    <input type="hidden" name="cancelAt" value="{{\Carbon\Carbon::parse($subscriptions->data[0]['current_period_end'])->format('F j, Y') }}"/>

                                                    @if (auth()->user()->subscription($membership_level)->onGracePeriod())
                                                        <button disabled class="btn btn-dang">Membership Cancelation Requested</button>
                                                    @else
                                                        <button type="submit" class="btn btn-dang cancelButton">Membership Cancelation</button>
                                                    @endif
                                                </form>
                                            </div>
                                        </div>
                                    @else
                                        <p>There isn't activated subscription</p>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="tab-card">
                            <div class="tab-card-header">Invoices</div>
                            <div class="tab-card-body">
                                
                                @if(isset($paymentType) && $paymentType != 'paypal')
                                {{-- <div class="d-flex justify-content-end">
                                    <div class="search-inputinv">
                                        <form action="">
                                            <div class="input-group mb-3">
                                                <span class="input-group-text svg-24" id="basic-addon1">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M18.319 14.433C19.566 12.8254 20.1537 10.803 19.9625 8.77748C19.7714 6.7519 18.8157 4.87524 17.29 3.52927C15.7642 2.1833 13.783 1.46913 11.7494 1.53206C9.71584 1.59499 7.7826 2.43028 6.34301 3.86801C4.90217 5.30674 4.06414 7.24073 3.99971 9.27588C3.93528 11.311 4.64929 13.2942 5.99624 14.8211C7.34319 16.3481 9.22171 17.304 11.249 17.4941C13.2763 17.6842 15.2997 17.094 16.907 15.844L16.95 15.889L21.192 20.132C21.2849 20.2249 21.3952 20.2986 21.5166 20.3489C21.638 20.3992 21.7681 20.4251 21.8995 20.4251C22.0309 20.4251 22.161 20.3992 22.2824 20.3489C22.4038 20.2986 22.5141 20.2249 22.607 20.132C22.6999 20.0391 22.7736 19.9288 22.8239 19.8074C22.8742 19.686 22.9001 19.5559 22.9001 19.4245C22.9001 19.2931 22.8742 19.163 22.8239 19.0416C22.7736 18.9202 22.6999 18.8099 22.607 18.717L18.364 14.475C18.3494 14.4606 18.3344 14.4466 18.319 14.433ZM16.243 5.28301C16.8076 5.83849 17.2566 6.50026 17.5642 7.23015C17.8718 7.96004 18.0318 8.7436 18.035 9.53563C18.0382 10.3277 17.8846 11.1125 17.583 11.8449C17.2814 12.5772 16.8378 13.2426 16.2777 13.8027C15.7176 14.3628 15.0522 14.8064 14.3199 15.108C13.5875 15.4096 12.8027 15.5632 12.0106 15.56C11.2186 15.5568 10.435 15.3968 9.70514 15.0892C8.97526 14.7816 8.31349 14.3326 7.75801 13.768C6.64793 12.6397 6.02866 11.1185 6.03511 9.53563C6.04156 7.95281 6.67319 6.43666 7.79242 5.31742C8.91165 4.19819 10.4278 3.56656 12.0106 3.56011C13.5935 3.55367 15.1147 4.17293 16.243 5.28301Z" fill="#737373"/>
                                                    </svg>
                                                </span>
                                                <input type="text" class="form-control" placeholder="Search">
                                            </div>
                                        </form>
                                    </div>
                                </div> --}}
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle invoice-list">
                                        <thead>
                                            <tr>
                                                <th class="tbl-w-140">Order #</th>
                                                {{-- <th class="tbl-w-140">Billing Start</th> --}}
                                                <th class="tbl-w-140">Billing end</th>
                                                <th class="tbl-w-180">Description</th>
                                                <th class="tbl-w-140">Amount</th>
                                                <th class="tbl-w-100">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($invoices->agreement_transaction_list))
                                                @foreach ($invoices->agreement_transaction_list as $key=>$invoice)
                                                    <tr>
                                                        <td>{{ $key+1000 }}</td>
                                                        {{-- <td></td> --}}
                                                        <td> {{ \Carbon\Carbon::parse($invoice->time_stamp)->format('F j, Y') }}</td>
                                                        <td>{{ $membership_level }}</td>
                                                        <td>
                                                            ${{  json_decode($invoice->amount)->value }}
                                                        </td>
                                                        <td class="text-success">{{$invoice->status}}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                @else
                                {{-- <div class="d-flex justify-content-end">
                                    <div class="search-inputinv">
                                        <form action="">
                                            <div class="input-group mb-3">
                                                <span class="input-group-text svg-24" id="basic-addon1">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M18.319 14.433C19.566 12.8254 20.1537 10.803 19.9625 8.77748C19.7714 6.7519 18.8157 4.87524 17.29 3.52927C15.7642 2.1833 13.783 1.46913 11.7494 1.53206C9.71584 1.59499 7.7826 2.43028 6.34301 3.86801C4.90217 5.30674 4.06414 7.24073 3.99971 9.27588C3.93528 11.311 4.64929 13.2942 5.99624 14.8211C7.34319 16.3481 9.22171 17.304 11.249 17.4941C13.2763 17.6842 15.2997 17.094 16.907 15.844L16.95 15.889L21.192 20.132C21.2849 20.2249 21.3952 20.2986 21.5166 20.3489C21.638 20.3992 21.7681 20.4251 21.8995 20.4251C22.0309 20.4251 22.161 20.3992 22.2824 20.3489C22.4038 20.2986 22.5141 20.2249 22.607 20.132C22.6999 20.0391 22.7736 19.9288 22.8239 19.8074C22.8742 19.686 22.9001 19.5559 22.9001 19.4245C22.9001 19.2931 22.8742 19.163 22.8239 19.0416C22.7736 18.9202 22.6999 18.8099 22.607 18.717L18.364 14.475C18.3494 14.4606 18.3344 14.4466 18.319 14.433ZM16.243 5.28301C16.8076 5.83849 17.2566 6.50026 17.5642 7.23015C17.8718 7.96004 18.0318 8.7436 18.035 9.53563C18.0382 10.3277 17.8846 11.1125 17.583 11.8449C17.2814 12.5772 16.8378 13.2426 16.2777 13.8027C15.7176 14.3628 15.0522 14.8064 14.3199 15.108C13.5875 15.4096 12.8027 15.5632 12.0106 15.56C11.2186 15.5568 10.435 15.3968 9.70514 15.0892C8.97526 14.7816 8.31349 14.3326 7.75801 13.768C6.64793 12.6397 6.02866 11.1185 6.03511 9.53563C6.04156 7.95281 6.67319 6.43666 7.79242 5.31742C8.91165 4.19819 10.4278 3.56656 12.0106 3.56011C13.5935 3.55367 15.1147 4.17293 16.243 5.28301Z" fill="#737373"/>
                                                    </svg>
                                                </span>
                                                <input type="text" class="form-control" placeholder="Search">
                                            </div>
                                        </form>
                                    </div>
                                </div> --}}
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle invoice-list">
                                        <thead>
                                            <tr>
                                                <th class="tbl-w-140">Order #</th>
                                                <th class="tbl-w-140">Billing Start</th>
                                                <th class="tbl-w-140">Billing end</th>
                                                <th class="tbl-w-180">Description</th>
                                                <th class="tbl-w-140">Amount</th>
                                                <th class="tbl-w-100">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($invoices->data))
                                                @foreach ($invoices->data as $key => $invoice)
                                                    <tr>
                                                        <td>{{ $key+1000 }}</td>
                                                        <td>{{ \Carbon\Carbon::parse(json_decode($invoice->lines['data'][0]['period']['start']))->format('F j, Y') }}</td>
                                                        <td> {{ \Carbon\Carbon::parse(json_decode($invoice->lines['data'][0]['period']['end']))->format('F j, Y') }}</td>
                                                        <td>{{ getSubscriptionTitle($invoice->subscription) }}</td>
                                                        <td>
                                                            ${{  $invoice->total/100 }}
                                                        </td>
                                                        <td class="text-success">{{$invoice->status}}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- MAIN -->
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
