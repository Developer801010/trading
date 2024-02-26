@extends('layouts.front-master')

@section('content')
<!-- FORGOT PASSWORD -->
<section class="auth-wrapper auth-login forgot-pass">
    <div class="container-lg container-section">
        <div class="card">
            <h1 class="title">Forgot Password</h1>
            <p>Reset your password:</p>
            <p class="mb-4">Enter the email address associated with your account and we'll send you a password reset link</p>
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form  action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Email Address</label>
                    <input type="email" class="form-control" id="email" name="email"  value="{{ old('email') }}">
                    @include('layouts.error')
                </div>
                <div class="mb-4">
                    <button type="submit" class="btn shadow-none btn-grn w-100 rounded-0">submit</button>
                </div>
                <p>Already you have an account? <a href="{{ url('/login')}}" class="auth-link">Login</a></p>
            </form>
        </div>
    </div>
</section>
<!-- FORGOT PASSWORD -->
@endsection
@section('custom-js')
<!-- BEGIN: Page JS-->
    <script src="{{ asset('app-assets/js/scripts/pages/auth-forgot-password.js') }}"></script>
<!-- END: Page JS-->
@endsection
