@extends('layouts.front-master')
@section('title', 'Closed Options Trades')

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
                <h1 class="table-title">Closed Options Trades</h1>
                <table class="list-table table">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>                        
                            <th>Symbol</th>
                            <th>Entry Date</th>
                            <th>Exit Date</th>
                            <th>Option</th>
                            <th>Position Size</th>
                            <th>Entry Price</th>
                            <th>Exit Price</th5%>
                            <th>Gain/loss</th>
                            <th>Gain/loss(%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>0</td>
                            <td>1</td>
                            <td>2</td>
                            <td>3</td>
                            <td>4</td>
                            <td>5</td>
                            <td>6</td>
                            <td>7</td>
                            <td>8</td>
                            <td>9</td>
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
