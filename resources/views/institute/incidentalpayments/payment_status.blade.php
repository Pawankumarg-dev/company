@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title">
                            {{ $order->transaction_remarks }}
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
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
                                            <td>{{ $order->order_number }}</td>
                                            <td>{{ $order->payment_date->format('d-m-Y h:i:s') }}</td>
                                            <td>{{ $order->actual_amount }}</td>
                                            <td>{{ $order->order_status }}</td>
                                            <td>{{ $order->payment_remarks }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="pull-right">
                                    <a href="{{ url('/institute/affiliationfee/'.$approvedprogramme->academicyear_id) }}" class="btn btn-info btn-sm">
                                        <span class="glyphicon glyphicon-hand-right"></span>
                                        Click here
                                    </a> to go back
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection