@extends('layouts.master')

@section('title', 'Trade Alerts')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Trade Alerts</h4>
    </div>
    <div class="row">
        <div class="col-md-12">
            @include('layouts.error')
        </div>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Date</th>
                    <th>Patient Name</th>
                    <th>Patient Email</th>
                    <th>Attorney Name</th>
                    <th>Doctor Name</th>
                    <th>Clinic</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection
