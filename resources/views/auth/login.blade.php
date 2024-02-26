@extends('layouts.front-master')
@section('title', 'Login Page')
@section('page-style')

@endsection

@section('content')
 <!-- LOGIN -->
 <section class="auth-wrapper auth-login">
    <div class="container-lg container-section">
        <div class="card">
            <h1 class="title">Login</h1>
            @include('layouts.error')
            <form class="auth-login-form mt-2" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Email Address</label>
                    <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="{{ old('email') }}" required autofocus>
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" class="form-control" id="password" name="password"  placeholder="Password" required>
                </div>
                {{-- <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">Term Condition & policies apply</label>
                </div> --}}
                <div class="mb-4">
                    <a href="{{ url('/password/reset') }}" class="auth-link">Forgot Password?</a>
                </div>
                <div class="mb-4">
                    <button class="btn shadow-none btn-grn w-100 rounded-0">Login</button>
                </div>
                <p>You don't have an account? <a href="{{ route('front.checkout', 'm') }}" class="auth-link">Register</a></p>
            </form>
        </div>
    </div>
</section>
<!-- LOGIN -->
@endsection

@section('custom-js')
<!-- BEGIN: Page JS-->
    <script src="{{ asset('app-assets/js/scripts/pages/auth-login.js') }}"></script>
<!-- END: Page JS-->
@endsection
