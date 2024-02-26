<!DOCTYPE html>
<html lang="en">
<!-- BEGIN: Head-->

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Ivan">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'HomePage')</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('app-assets/images/ico/apple-icon-120.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">


    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/css/swiper-bundle.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}?v={{date('YmdHis')}}">
    <link rel="stylesheet" href="{{asset('assets/css/intlTelInput.css')}}"/>
    <script src="{{asset('assets/js/jquery-3.6.3.min.js')}}"></script>

    @yield('page-style')
</head>
<!-- END: Head-->
<body>
    <header @if (!Auth::check()) class="lp-header" @endif>
        <div class="container-xl">
            @if (Auth::check())
                @include('layouts.front-top-bar')
                @include('layouts.front-header')
            @else
                @include('layouts.front-header-home')
            @endif
        </div>
    </header>
    @yield('content')
    @if (Auth::check())
        @include('layouts.front-footer')
    @else
        @include('layouts.front-footer-home')
    @endif
    {{-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script> --}}
    <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/js/popper.min.js') }}"></script>
    <script src="{{asset('assets/js/fslightbox.js')}}"></script>
    <script src="{{asset('assets/js/swiper-bundle.min.js')}}"></script>
    <script src="{{asset('assets/js/main.js')}}"></script>
    <script src="{{asset('assets/js/intlTelInput.min.js')}}"></script>
    <script src="https://kit.fontawesome.com/8c0eabb613.js" crossorigin="anonymous"></script>


    @yield('page-script')
    <script>
       window.csrfToken = "{{ csrf_token() }}";

       $.ajaxSetup({
            error: function (xhr) {
                if (xhr.status === 419) { // Session timeout
                    location.href = '/login';
                }
            }
        });
    </script>
</body>
<!-- END: Body-->

</html>

