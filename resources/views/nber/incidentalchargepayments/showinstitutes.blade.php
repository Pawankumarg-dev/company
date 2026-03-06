@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-primary">
                    <div class="panel-heading hidethis">
                        <div class="panel-title">
                            Incidental Charge Payment - {{ $academicyear->year }}
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="hidethis">
                                    <ul class="breadcrumb">
                                        <li>
                                            <a href="{{ url('/nber/payments/') }}">Payments</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('/nber/payments/incidentalcharge/') }}">Incidental Charge</a>
                                        </li>
                                        <li>
                                            {{ $academicyear->year }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>


                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th class="center-text bg-info" width="5%">S.No.</th>
                                    <th class="center-text bg-info" width="10%">Institute Code</th>
                                    <th class="center-text bg-info" width="75%">Institute Name</th>
                                    <th class="center-text bg-info" width="75%">No. of Entries</th>
                                    <th class="center-text bg-info" width="75%">No. of Verification Pending</th>
                                    <th class="center-text bg-info hidethis" width="10%">Link</th>
                                </tr>
                                </thead>

                                @php $sno = 1; @endphp
                                <tbody>
                                @foreach($incidentalpayments as $incidentalpayment)
                                    <tr>
                                        <td class="center-text blue-text">{{ $sno }}@php $sno++; @endphp</td>
                                        <td class="center-text blue-text">{{ $incidentalpayment->institute->code }}</td>
                                        <td class="blue-text">{{ $incidentalpayment->institute->name }}</td>
                                        <td class="blue-text center-text">
                                            @php
                                            \App\Http\Controllers\Nber\IncidentalchargePaymentController::checknoofpaymententries($academicyear->id, $incidentalpayment->institute->id);
                                            @endphp
                                        </td>
                                        <td class="center-text blue-text">
                                            @php
                                                \App\Http\Controllers\Nber\IncidentalchargePaymentController::checknoofverificationpending($academicyear->id, $incidentalpayment->institute->id);
                                            @endphp
                                        </td>
                                        <td class="center-text hidethis">
                                            <a href="{{ url('/nber/payments/incidentalcharge/'.$academicyear->id.'/'.$incidentalpayment->institute->id) }}" class="btn btn-sm btn-success" target="_blank" role="link">
                                                <span class="glyphicon glyphicon-eye-open">&nbsp;View</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{--
                        @foreach($institutes as $institute)
                                    <tr>
                                        <td class="center-text blue-text">{{ $sno }}@php $sno++; @endphp</td>
                                        <td class="center-text blue-text">{{ $institute->code }}</td>
                                        <td class="blue-text">{{ $institute->name }}</td>
                                        <td class="blue-text center-text">
                                            @php
                                            \App\Http\Controllers\Nber\IncidentalchargePaymentController::checknoofpaymententries($academicyear->id, $institute->id);
                                            @endphp
                                        </td>
                                        <td class="center-text blue-text">
                                            @php
                                                \App\Http\Controllers\Nber\IncidentalchargePaymentController::checknoofverificationpending($academicyear->id, $institute->id);
                                            @endphp
                                        </td>
                                        <td class="center-text hidethis">
                                            <a href="{{ url('/nber/payments/incidentalcharge/'.$academicyear->id.'/'.$institute->id) }}" class="btn btn-sm btn-success" target="_blank" role="link">
                                                <span class="glyphicon glyphicon-eye-open">&nbsp;View</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                    --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection