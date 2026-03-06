@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <div class="row">
                                <div class="col-sm-9">Examination Fee Check</div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <table class="table table-bordered table-striped table-hover table-condensed">
                            <tr>
                                <th class="blue-text">S.No.</th>
                                <th class="blue-text">Exam</th>
                                <th class="blue-text">Batch</th>
                                <th class="blue-text">Programme</th>
                                <th class="blue-text">Enrolment No</th>
                                <th class="blue-text">Name</th>
                                <th class="blue-text">Total Subjects Applied</th>
                                <th class="blue-text">Amount</th>
                                <th class="blue-text">Payment Details</th>
                            </tr>

                            @php $sno = 1; @endphp
                            @foreach($candidates as $c)
                                <tr>
                                    <td>
                                        {{ $sno }}
                                        @php $sno++; @endphp
                                    </td>
                                    <td class="blue-text">{{ $exam->name }}</td>
                                    <td class="blue-text">{{ $c->approvedprogramme->academicyear->year }}</td>
                                    <td class="blue-text">{{ $c->approvedprogramme->programme->course_name }}</td>
                                    <td class="blue-text">
                                        @if($c->enrolmentno == '')
                                            NOT ASSIGNED
                                        @else
                                            {{ $c->enrolmentno }}
                                        @endif
                                    </td>
                                    <td class="blue-text">{{ $c->name }}</td>
                                    <td class="blue-text">
                                        @php
                                        $subjectcount = \App\Http\Controllers\Institute\ExaminationpaymentController::calculatecandidatesubjectcount($exam->id, $c->id);
                                        $amount = 150 * $subjectcount;
                                        @endphp
                                        {{ $subjectcount }}
                                    </td>
                                    <td class="blue-text">
                                        {{ $amount }}
                                    </td>
                                    <td>
                                        <a href="{{ url('/institute/examinationpayments/addpayment/'.$exam->id.'/'.$c->id) }}" class="btn btn-primary">
                                            Enter
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection