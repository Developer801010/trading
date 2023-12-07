@if(Session::has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{Session::get('success')}}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if (session('resent'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ __('A fresh verification link has been sent to your email address.') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if (auth()->user()->email_verified_at == null)
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    Please check your inbox or spam folder for email verification.  If you did not receive the email
    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
        @csrf
        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
    </form>
        
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>    
@endif