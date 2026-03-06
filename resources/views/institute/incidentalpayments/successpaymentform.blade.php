@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="table-responsive">
                <table class="table table-condensed table-bordered">
                    <tr>
                        <th>Order No.</th>
                        <th>Transaction Date</th>
                        <th>Amount</th>
                        <th>Payment Status</th>
                        <th>Payment remarks</th>
                    </tr>
                    <tr>
                        <td>{{ $order["order_number"] }}</td>
                        <td>{{ $order["payment_date"] }}</td>
                        <td>{{ $order["actual_amount"] }}</td>
                        <td>{{ $order["order_status"] }}</td>
                        <td>{{ $order["payment_remarks"] }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection