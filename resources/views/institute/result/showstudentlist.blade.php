@extends('layouts.app')
@section('content')
    <main>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="panel-title">
                                {{ $exam->name }} Examinations - Exam Results
                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <section class="hidethis">
                                        <ul class="breadcrumb">
                                            <li class="heading">Quick Links: </li>
                                            <li>
                                                <a href="{{ url('/institute/dashboard/home') }}">Home</a>
                                            </li>
                                            <li>
                                                <a href="{{ url('/institute/examinations') }}">Examinations</a>
                                            </li>
                                            <li>
                                                <a href="{{ url('/institute/examinations/'.$exam->id) }}">{{ $exam->name }}</a>
                                            </li>
                                            <li>
                                                <a href="{{ url('institute/examinations/results/'.$exam->id) }}">Exam Results</a>
                                            </li>
                                            <li class="active">{{ $approvedprogramme->programme->course_name }} ({{ $approvedprogramme->academicyear->year }})</li>
                                        </ul>
                                    </section>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="center-text green-text bold-text" colspan="7">{{ $approvedprogramme->institute->code }} - {{ $approvedprogramme->institute->name }}</th>
                                        </tr>
                                        <tr>
                                            <th class="center-text green-text bold-text" colspan="7">{{ $approvedprogramme->programme->course_name }} ({{ $approvedprogramme->academicyear->year }})</th>
                                        </tr>
                                        <tr>
                                            <th class="green-text bold-text center-text">#</th>
                                            <th class="green-text bold-text center-text" width="15%">Photo</th>
                                            <th class="green-text bold-text center-text" width="10%">Enrolment No.</th>
                                            <th class="green-text bold-text center-text">Name</th>
                                            <th class="green-text bold-text center-text">Result Status</th>
                                            <th class="green-text bold-text center-text">Result Date</th>
                                            <th class="green-text bold-text center-text">View Result</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @if(is_null($candidates))
                                            <tr>
                                                <td class="red-text bold-text" colspan="5">No Data Found</td>
                                            </tr>
                                        @else
                                            @php $sno = 1; @endphp
                                            @foreach($candidates as $candidate)
                                                <tr>
                                                    <td class="blue-text">{{ $sno }}</td>
                                                    <td class="center-text"><img src="{{asset('/files/enrolment/photos')}}/{{$candidate->photo}}"  style="width: 100px;" class="img" /></td>
                                                    <td class="blue-text">{{ $candidate->enrolmentno }}</td>
                                                    <td class="blue-text">{{ $candidate->name }}</td>

                                                    @php
                                                        $candidateexamresultdate = \App\Candidateexamresultdate::where('exam_id', $exam->id)->where('candidate_id', $candidate->id)->first();
                                                    @endphp

                                                    @if(is_null($candidateexamresultdate))
                                                        <td class="center-text">
                                                            <span class="label label-default">NOT PUBLISHED</span>
                                                        </td>
                                                        <td class="center-text">
                                                            <span class="label label-default">NOT APPLICABLE</span>
                                                        </td>
                                                        <td class="center-text">
                                                            <span class="label label-default">NOT AVAILABLE</span>
                                                        </td>
                                                    @else
                                                        @if($candidateexamresultdate->withheld_status == 1)
                                                            <td class="center-text">
                                                                <span class="label label-danger">WITHHELD</span>
                                                            </td>
                                                            <td class="center-text">
                                                                <span class="label label-danger">NOT APPLICABLE</span>
                                                            </td>
                                                            <td class="center-text">
                                                                <span class="label label-danger">NOT APPLICABLE</span>
                                                            </td>
                                                        @else
                                                            @if($candidateexamresultdate->publish_status == 0)
                                                                <td class="center-text">
                                                                    <span class="label label-default">NOT PUBLISHED</span>
                                                                </td>
                                                                <td class="center-text">
                                                                    <span class="label label-default">NOT APPLICABLE</span>
                                                                </td>
                                                                <td class="center-text">
                                                                    <span class="label label-default">NOT APPLICABLE</span>
                                                                </td>
                                                            @else
                                                                @if($candidateexamresultdate->underreview_status == 1)
                                                                    <td class="center-text">
                                                                        <span class="label label-warning">{{ $candidateexamresultdate->underreview_remarks }}</span>
                                                                    </td>
                                                                    <td class="center-text">
                                                                        @if(!is_null($candidateexamresultdate->publish_date))
                                                                            <span class="label label-warning">
                                                                                {{ $candidateexamresultdate->publish_date->format('d-m-Y') }}
                                                                            </span>
                                                                        @else
                                                                            <span class="label label-warning">
                                                                                NOT AVAILABLE
                                                                            </span>
                                                                        @endif
                                                                    </td>
                                                                    <td class="center-text">
                                                                        <a href="{{url('/examresult/'.$exam->id).'/'.$candidate->id}}" class="btn btn-info btn-sm" target="_blank">
                                                                            <span class="glyphicon glyphicon-eye-open"></span> View
                                                                        </a>
                                                                    </td>
                                                                @elseif($candidateexamresultdate->withheld_status == 1)
                                                                    <td class="center-text">
                                                                        <span class="label label-danger">WITHHELD</span>
                                                                    </td>
                                                                    <td class="center-text">
                                                                        @if(!is_null($candidateexamresultdate->publish_date))
                                                                            <span class="label label-warning">
                                                                                {{ $candidateexamresultdate->publish_date->format('d-m-Y') }}
                                                                            </span>
                                                                        @else
                                                                            <a href="{{url('/examresult/'.$exam->id).'/'.$candidate->id}}" class="btn btn-info btn-sm" target="_blank">
                                                                                <span class="glyphicon glyphicon-eye-open"></span> View
                                                                            </a>
                                                                        @endif
                                                                    </td>
                                                                @else
                                                                    @if(!is_null($candidateexamresultdate->publish_date))
                                                                        <td class="center-text">
                                                                            <span class="label label-success">PUBLISHED</span>
                                                                        </td>
                                                                        <td class="center-text blue-text">
                                                                            {{ $candidateexamresultdate->publish_date->format('d-m-Y') }}
                                                                        </td>
                                                                        <td class="center-text">
                                                                            <a href="{{url('/examresult/'.$exam->id).'/'.$candidate->id}}" class="btn btn-info btn-sm" target="_blank">
                                                                                <span class="glyphicon glyphicon-eye-open"></span> View
                                                                            </a>
                                                                        </td>
                                                                    @else
                                                                        <td class="center-text">
                                                                            <span class="label label-default">NOT AVAILABLE</span>
                                                                        </td>
                                                                        <td class="center-text">
                                                                            <span class="label label-default">NOT AVAILABLE</span>
                                                                        </td>
                                                                        <td class="center-text">
                                                                            <span class="label label-default">NOT AVAILABLE</span>
                                                                        </td>
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        @endif
                                                    @endif
                                                </tr>
                                                @php $sno++; @endphp
                                            @endforeach
                                            @php unset($sno); @endphp
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
