@extends('layouts.front-master')
@section('title', 'Open Stock Trades')

@section('page-style')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css') }}">
<style>
    #DataTables_Table_0_length select{
        width: 80px;
    }
</style>
@endsection


@section('content')
    <div class="container">
        <section class="dashboard-section">        
    
            @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{Session::get('success')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </section>
        <section class="open-position-section  position-section">
            <div class="table-responsive">
                <h1 class="table-title">Open Stock Trades</h1>
                <table class="list-table table">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>                        
                            <th>Long/Short</th>
                            <th>BUY/SELL</th>
                            <th>Entry Date</th>
                            <th>Entry Price</th>
                            <th>Buy Position Size</th>
                            <th>Total Position in Stock</th>
                            <th>Average Price</th5%>
                            <th>Stop Price</th>
                            <th>Projected Target Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td>1</td>
                            <td>2</td>
                            <td>3</td>
                            <td>4</td>
                            <td>5</td>
                            <td>6</td>
                            <td>7</td>
                            <td>7</td>
                            <td>7</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>    
@endsection


@section('page-script')    
<script src="{{ asset('app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js') }}"></script>
    <script>
        $('.list-table').DataTable({

        });
    </script>
    
@endsection