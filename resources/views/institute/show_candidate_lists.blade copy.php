@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    {{ $exam->name }} Examinations - Application
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <section class="hidethis">
                                            <ul class="breadcrumb">
                                                <li class="heading">Quick Links: </li>
                                                <li>
                                                    <a href="{{ url('/institute/examinations/applications/'.$exam->id) }}">{{ $exam->name }}</a>
                                                </li>
                                                <li class="active">
                                                    {{ $approvedprogramme->programme->course_name }} ({{ $approvedprogramme->academicyear->year }})
                                                </li>
                                            </ul>
                                        </section>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="panel panel-warning">
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-condensed table-hover">
                                                        <tr>
                                                            <th class="center-text orange-text" width="5%">S.No.</th>
                                                            <th class="center-text orange-text" width="5%">Batch</th>
                                                            <th class="center-text orange-text" width="10%">Course</th>
                                                            <th class="center-text orange-text" width="5%">Enrolment No</th>
                                                            <th class="center-text orange-text" width="10%">Name</th>
                                                            <th class="center-text orange-text" width="5%">Application Link</th>
                                                            <th class="center-text orange-text" width="5%">View Application</th>
                                                            <th class="center-text orange-text" width="5%">Applied Subjects</th>
                                                            <th class="center-text orange-text" width="10%">Remarks</th>
                                                        </tr>

                                                        @php $sno = 1; @endphp
                                                        @foreach($candidates as $candidate)
                                                            <tr>
                                                                <td class="center-text blue-text">{{ $sno }}@php $sno++; @endphp</td>
                                                                <td class="center-text blue-text">{{ $candidate->approvedprogramme->academicyear->year }}</td>
                                                                <td class="center-text blue-text">{{ $candidate->approvedprogramme->programme->course_name }}</td>
                                                                <td class="center-text blue-text">{{ $candidate->enrolmentno }}</td>
                                                                <td class="blue-text">{{ $candidate->name }}</td>
                                                                <td class="center-text">
                                                                    @if($exam->exam_application == 1)
                                                                        @if($remarks === "NIL")
                                                                            <a href="{{ url('/institute/examinations/candidateapplication/'.$exam->id.'/'.$approvedprogramme->id.'/'.$candidate->id) }}" class="btn btn-primary btn-sm" target="_blank">
                                                                                <span class="glyphicon glyphicon-th-list"></span>
                                                                            </a>
                                                                        @else
                                                                            <span class="label label-danger">NOT AVAILABLE</span>
                                                                        @endif
                                                                    @else
                                                                        <span class="label label-danger">Exam Link Closed</span>
                                                                    @endif
                                                                </td>
                                                                <td class="center-text">
                                                                    <a href="{{ url('/institute/examinations/applications/'.$exam->id.'/'.$approvedprogramme->id.'/'.$candidate->id) }}" class="btn btn-info btn-sm" target="_blank">
                                                                        <span class="glyphicon glyphicon-eye-open"></span>
                                                                    </a>
                                                                </td>
                                                                <td class="center-text">
                                                                    @php $count = $candidate->applications()->where('exam_id', $exam->id)->count(); @endphp

                                                                    @if($count != 0)
                                                                        <span class="text-success bold-text">{{ $count }}</span>
                                                                    @else
                                                                        <span class="text-danger bold-text">{{ $count }}</span>
                                                                    @endif
                                                                </td>
                                                                <td class="center-text">
                                                                    @if($remarks != "NIL" && $remarks != "")
                                                                        <span class="label label-danger">{{ $remarks }}</span>
                                                                    @endif
                                                                </td>
                                                                {{--
                                                                @if($remarks === 'NIL')
                                                                    <td class="center-text">
                                                                        @if($exam->exam_application == 1)
                                                                        <a href="{{ url('/institute/examinations/candidateapplication/'.$exam->id.'/'.$approvedprogramme->id.'/'.$candidate->id) }}" class="btn btn-primary btn-sm" target="_blank">
                                                                            <span class="glyphicon glyphicon-th-list"></span>
                                                                        </a>
                                                                        @else
                                                                            <span class="label label-danger">Exam Link Closed</span>
                                                                        @endif
                                                                    </td>
                                                                    <td class="center-text">
                                                                        <a href="{{ url('/institute/examinations/applications/'.$exam->id.'/'.$approvedprogramme->id.'/'.$candidate->id) }}" class="btn btn-info btn-sm" target="_blank">
                                                                            <span class="glyphicon glyphicon-eye-open"></span>
                                                                        </a>
                                                                    </td>
                                                                    <td class="center-text">
                                                                        @php $count = $candidate->applications()->where('exam_id', $exam->id)->count(); @endphp
                                                                        @if($count != 0)
                                                                            <span class="text-success bold-text">{{ $count }}</span>
                                                                        @else
                                                                            <span class="text-danger bold-text">{{ $count }}</span>
                                                                        @endif
                                                                    </td>

                                                                @else
                                                                    <td class="center-text">
                                                                        <span class="label label-danger">NOT AVAILABLE</span>
                                                                    </td>
                                                                    <td class="center-text">
                                                                        <span class="label label-danger">NOT AVAILABLE</span>
                                                                    </td>
                                                                    <td class="center-text">
                                                                        <span class="label label-danger">{{ $remarks }}</span>
                                                                    </td>
                                                                @endif
                                                                --}}
                                                            </tr>
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
            </div>
        </div>
    </div>
@endsection
