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
                    <th>Image</th>              
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($articles as $key => $article)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $article->title }}</td>
                        <td><img src="{{ asset($article->post_image) }}" style="width: 70px;" /></td>                        
                        <td>                           
                            <a class="btn btn-primary mr-1" href="{{ route('articles.edit',$article->id) }}">Edit</a>
                                {!! Form::open(['method' => 'DELETE', 'class' => 'delete_form', 'route' => ['articles.destroy', $article->id],'style'=>'display:inline']) !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
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