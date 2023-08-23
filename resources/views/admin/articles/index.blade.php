@extends('layouts.master')

@section('title', 'ARticle Management')

@section('page-style')
@endsection


@section('content')
<div class="card">
    <div class="table-responsive">
        <table class="user-list-table table">
            <thead class="table-light">
                <tr>
                    <th></th>                        
                    <th>Title</th>                    
                    <th>Content</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                {{-- @foreach ($data as $key => $news)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>                           
                            <a class="btn btn-primary mr-1" href="{{ route('users.edit',$user->id) }}">Edit</a>
                                {!! Form::open(['method' => 'DELETE', 'class' => 'delete_form', 'route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach --}}
            </tbody>
        </table>
    </div>
</div>

<!-- Modal to add new user Ends-->
@endsection

@section('page-script')
<script src="{{ asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>   
<script src="{{ asset('app-assets/vendors/js/forms/cleave/cleave.min.js') }}"></script>    
<script src="{{ asset('app-assets/vendors/js/forms/cleave/addons/cleave-phone.us.js') }}"></script>  

<script>
    $(document).ready(function(){
        new Cleave($('.phone-number-mask'), {
            phone: true,
            phoneRegionCode: 'US'
        });

        new Cleave($('.date-mask'), {
            date: true,
            delimiter: '-',
            datePattern: ['Y', 'm', 'd']
        });
    });

</script>
@endsection