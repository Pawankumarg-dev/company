@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title">
                            New Payments
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading text-center" style="background-color: #003A77">
                                        <div class="panel-title" style="color: #EEEEEE">Incidental Charges Payment</div>
                                    </div>

                                    <div class="panel-body text-center">
                                        <a href="{{ url('/nber/payments/incidentalcharge') }}">Click here for Incidental Charges Payment</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading text-center" style="background-color: #003A77">
                                        <div class="panel-title" style="color: #EEEEEE">Enrolment Payment</div>
                                    </div>

                                    <div class="panel-body text-center">
                                        <a href="{{ url('/nber/payments/enrolment') }}">Click here for Enrolment Payment</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading text-center" style="background-color: #003A77">
                                        <div class="panel-title" style="color: #EEEEEE">Examination Payment</div>
                                    </div>

                                    <div class="panel-body text-center">
                                        <a href="{{ url('/nber/examinationpayments') }}">Click here for Examination Payment</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading text-center" style="background-color: #003A77">
                                        <div class="panel-title" style="color: #EEEEEE">Re-Evaluation Payment</div>
                                    </div>

                                    <div class="panel-body text-center">
                                        <a href="{{ url('/nber/payments/reevaluation') }}">Click here for Re-Evaluation Payment</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection