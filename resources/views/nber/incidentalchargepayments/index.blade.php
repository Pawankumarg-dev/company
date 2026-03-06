@extends('layouts.app')

@section('content')
    <section class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    Incidental Charges Payment
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <ul class="breadcrumb col-sm-12">
                                            <li><a href="{{url('/')}}">Home</a></li>
                                            <li><a href="{{url('/nber/payments/')}}">Payments</a></li>
                                            <li><b>Incidental Charges Payment</b></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6 col-sm-offset-3">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-striped">
                                                <tr>
                                                    <th class="center-text">S. No.</th>
                                                    <th class="center-text">Academic Years</th>
                                                    <th class="center-text">Select Years</th>
                                                    <th class="center-text">Institutes</th>
                                                    <th class="center-text">Update</th>
                                                </tr>

                                                @php $sno = 1; @endphp
                                                @foreach($academicyears as $ay)
                                                    <tr>
                                                        <td class="center-text">{{{ $sno }}}</td>
                                                        <td class="center-text">{{{ $ay->year }}}</td>
                                                        <td class="center-text">
                                                            <a href="{{ url('/nber/payments/incidentalcharge/'.$ay->id) }}" class="btn btn-success">{{ $ay->year }}</a>
                                                        </td>
                                                        <td class="center-text">
                                                            <a href="{{ url('/nber/payments/incidentalcharge/viewinstitutes/'.$ay->id) }}">
                                                                <span class="glyphicon glyphicon-eye-open"></span>&nbsp;
                                                                View
                                                            </a>
                                                        </td>
                                                        <td class="center-text">
                                                            <a href="#">
                                                                <span class="glyphicon glyphicon-edit"></span>&nbsp;
                                                                Fee details
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @php $sno++; @endphp
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection