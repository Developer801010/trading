@extends('layouts.master')
@section('title', 'Dashboard')

@section('page-style')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/charts/apexcharts.css') }}">
@endsection

@section('content')
 <!-- Dashboard Analytics Start -->
 <section id="dashboard-analytics">
    <div class="row match-height">
        <!-- Subscribers Chart Card starts -->
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card">
                <div class="dashbaord-header card-header flex-column align-items-start pb-0">
                    <div class="avatar bg-light-primary p-50 m-0">
                        <div class="avatar-content">
                            <i data-feather="users" class="font-medium-5"></i>
                        </div>
                    </div>
                    <h2 class="fw-bolder mt-1">{{$totalUsers}}</h2>
                    <p class="card-text">Registered Users</p>
                </div>
            </div>
        </div>
        <!-- Subscribers Chart Card ends -->

        <!-- Orders Chart Card starts -->
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card">
                <div class="dashbaord-header card-header flex-column align-items-start pb-0">
                    <div class="avatar bg-light-warning p-50 m-0">
                        <div class="avatar-content">
                            <i data-feather="package" class="font-medium-5"></i>
                        </div>
                    </div>
                    <h2 class="fw-bolder mt-1">{{$subscribedUsers}}</h2>
                    <p class="card-text">Subscribed Users</p>
                </div>
            </div>
        </div>
        <!-- Orders Chart Card ends -->

        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card">
                <div class="dashbaord-header card-header flex-column align-items-start">
                    <div class="avatar bg-light-primary p-50 m-0">
                        <div class="avatar-content">
                            <i data-feather="users" class="font-medium-5"></i>
                        </div>
                    </div>
                    <h2 class="fw-bolder mt-1">{{$unsubscribedUsers}}</h2>
                    <p class="card-text">Unsubscribed Users</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Dashboard Analytics end -->
@endsection   

@section('page-script')
    <!-- BEGIN: Page Vendor JS-->    
    {{-- <script src="{{ asset('app-assets/vendors/js/charts/apexcharts.min.js') }}"></script> --}}
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Page JS-->
    {{-- <script src="{{ asset('app-assets/js/scripts/pages/dashboard-analytics.js') }}"></script>     --}}
    <!-- END: Page JS-->
@endsection
   

   

