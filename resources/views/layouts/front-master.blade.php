<!DOCTYPE html>
<html lang="en">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Ivan">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'HomePage')</title>
    <link rel="apple-touch-icon" href="{{ asset('app-assets/images/ico/apple-icon-120.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/image/favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

    
    <link href="{{asset('assets/css/bootstrap.css')}}" rel="stylesheet">
    
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    

    @yield('page-style')
</head>
<!-- END: Head-->
<body>
    @include('layouts.front-header')
    @yield('content')
    @include('layouts.front-footer')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{asset('assets/js/bootstrap.js')}}"></script>
    <script src="https://kit.fontawesome.com/8c0eabb613.js" crossorigin="anonymous"></script>
    @yield('page-script')

</body>
<!-- END: Body-->

</html>

