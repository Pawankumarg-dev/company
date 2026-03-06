@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb col-md-12">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li><a href="{{url('/payment')}}">Payments</a></li>
                    <li>Affiliation feePayments</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title">
                        Affiliation fee Payments
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-condensed table-hover">
                                <tr>
                                    <th>S. No.</th>
                                    <th>Academic Year</th>
                                    <th>Link</th>
                                </tr>

                                @php $sno = '1'; @endphp
                                @foreach ($academicyears as $ay)
                                    <tr>
                                        <td>{{ $sno }}</td>
                                        <td>{{ $ay->year }}</td>
                                        <td>
                                            <a href="{{ url('/institute/incidentalpayments/'.$ay->id) }}" class="btn btn-primary">
                                            Affiliation fee Payment for {{ $ay->year }}
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
            <div class="col-sm-3"></div>
        </div>
    </div>

@endsection