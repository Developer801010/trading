@extends('layouts.front-master')
@section('title', 'Closed Options Trades')

@section('page-style')

@endsection


@section('content')
    <div class="container">
        <section class="dashboard-section">            
           
        </section>
        <section class="open-position-section  position-section">
            <div class="table-responsive">
                <h1 class="table-title">Closed Options Trades</h1>
                <table class="list-table table">
                    <thead class="table-light">
                        <tr>
                            <th>Symbol</th>
                            <th>Entry Date</th>
                            <th>Exit Date</th>
                            <th>Option</th>
                            <th>Position Size</th>
                            <th>Entry Price</th>
                            <th>Exit Price</th5%>
                            <th>Gain/loss</th>
                            <th>Gain/loss(%)</th>
                            <th>Position size</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>2</td>
                            <td>3</td>
                            <td>4</td>
                            <td>5</td>
                            <td>6</td>
                            <td>7</td>
                            <td>8</td>
                            <td>9</td>
                            <td>10</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>    
@endsection


@section('page-script')    

    
@endsection
