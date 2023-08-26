@extends('layouts.master')

@section('title', 'Article Management')

@section('page-style')
<style>
    /* .dataTables_length, 
    .dataTables_info{
        padding-left: 15px;
    }

    .dataTables_filter,
    .dataTables_paginate {
        padding-right: 15px;
    } */
</style>
@endsection


@section('content')
<div class="card">
    <div class="table-responsive">
        <table class="articles-list-table table">
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

<script>
    $(document).ready(function(){
       
    });

</script>
@endsection