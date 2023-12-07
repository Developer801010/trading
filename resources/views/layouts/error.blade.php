@if ($errors->any())
    <div class="alert alert-danger login-error">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{!! $error !!}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(Session::has('flash_success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{Session::get('flash_success')}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif