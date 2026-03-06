@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title">
                            Examination Payments
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb well white-background">
                                        <li><a href="{{ url('nber/payments/') }}">Payments</a></li>
                                        <li><a href="{{ url('nber/payments/reevaluation') }}">Re-Evaluation</a></li>
                                        <li class="active">{{ $reevaluation->exam->name }}</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-condensed">
                                            <tr>
                                                <th class="center-text" width="3%">S.No.</th>
                                                <th class="center-text" width="10%">Application No.</th>
                                                <th class="center-text" width="5%">Institute Code</th>
                                                <th class="center-text" width="15%">Course</th>
                                                <th class="center-text" width="10%">Enrolment No</th>
                                                <th class="center-text">Name</th>
                                                <th class="center-text">Link</th>
                                            </tr>

                                            @if($reevaluationapplications)
                                                @php $sno = 1; @endphp
                                                @foreach($reevaluationapplications as $reevaluationapplication)
                                                    <tr>
                                                        <td class="center-text">{{ str_pad($sno, 3, "000", STR_PAD_LEFT) }}@php $sno++; @endphp</td>
                                                        <td class="center-text blue-text bold-text">
                                                            {{ $reevaluationapplication->application_number }}
                                                        </td>
                                                        <td class="center-text">{{ $reevaluationapplication->candidate->approvedprogramme->institute->rci_code }}</td>
                                                        <td>{{ $reevaluationapplication->candidate->approvedprogramme->programme->course_name }}</td>
                                                        <td class="center-text blue-text bold-text">{{ $reevaluationapplication->candidate->enrolmentno }}</td>
                                                        <td>{{ $reevaluationapplication->candidate->name }}</td>
                                                        <td class="center-text">
                                                            <a href="{{ url('/nber/payments/reevaluation/'.$reevaluation->exam_id.'/'.$reevaluationapplication->id) }}" class="btn btn-info btn-sm">
                                                                <span class="glyphicon glyphicon-eye-open"></span> View
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

