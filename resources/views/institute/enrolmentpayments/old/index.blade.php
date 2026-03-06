@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <div class="row">
                                <div class="col-sm-9">Enrolment Payments</div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <table class="table table-bordered table-striped table-hover table-condensed">
                            <tr>
                                <th>S.No</th>
                                <th>Academic Year</th>
                                <th>Links</th>
                            </tr>

                            @php $sno = 1; @endphp
                            @foreach($academicyears as $ay)
                                <tr>
                                    <td>{{ $sno }}</td>
                                    <td>{{ $ay->year }}</td>
                                    <td class="center-text">
                                        <a href="{{ url('/institute/enrolmentpayments/').'/'.$ay->id }}" class="btn btn-info">Click here to pay for Enrolment {{ $ay->year }}</a>
                                    </td>
                                </tr>
                                @php $sno++; @endphp
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-3"></div>
        </div>
    </div>
@endsection