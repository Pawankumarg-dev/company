@php set_time_limit(0); @endphp

@extends('layouts.app');

@section('content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">

                <div class="table-responsive">
                    <table class="table table-hover table-condensed table-bordered blue-text h6-text" role="table">
                        <tr>
                            <td class="center-text" colspan="10">
                                <label class="radio-inline"><input type="radio" name="statusoption" id="show_all" checked>
                                    <span class="label label-info h6-text">All</span>
                                </label>
                                <label class="radio-inline"><input type="radio" name="statusoption" id="show_approved">
                                    <span class="label label-success h6-text">Approved</span>
                                </label>
                                <label class="radio-inline"><input type="radio" name="statusoption" id="show_pending">
                                    <span class="label label-warning h6-text">Pending</span>
                                </label>
                                <label class="radio-inline"><input type="radio" name="statusoption" id="show_rejected">
                                    <span class="label label-danger h6-text">Rejected</span>
                                </label>
                            </td>
                            <td class="right-text">
                                <a class="btn btn-success btn-sm" id="addDetail">
                                    <span class="glyphicon glyphicon-plus"></span>
                                    Add Details
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th class="center-text" colspan="11">List of Institutes enrolled in Academic Year: {{ $academicyear->year }}</th>
                        </tr>
                        <tr>
                            <th class="center-text" rowspan="2">S.No</th>
                            <th class="center-text" colspan="2">Institute Details</th>
                            <th class="center-text" rowspan="2">Course Name</th>
                            <th class="center-text" rowspan="2">File</th>
                            <th class="center-text" rowspan="2">Status</th>
                            <th class="center-text" colspan="3">Candidate Count</th>
                            <th class="center-text" colspan="2">Links</th>
                        </tr>

                        <tr>
                            <th class="center-text">Code</th>
                            <th class="center-text" width="20%">Name</th>
                            <th class="center-text">Max. Intake</th>
                            <th class="center-text">Registered</th>
                            <th class="center-text">Enrolment</th>
                            <th class="center-text" width="10%">Approval<br>Letter</th>
                            <th class="center-text" width="10%">Candidates</th>
                        </tr>

                        @php $sno = '1'; @endphp
                        <div id="show_all_div">
                            @foreach($approvedprogrammes as $ap)
                                <tr>
                                    <td class="center-text">
                                        {{ $sno }}
                                    </td>
                                    <td>{{ $ap->institute->code }}</td>
                                    <td>{{ $ap->institute->name }}</td>
                                    <td>{{ $ap->programme->course_name }}</td>
                                    <td class="text-left">
                                        @if($ap->programme->approval_letter_required == '1')
                                            @if($ap->status_id == '0' )
                                                <div class="label label-danger">
                                                <span class="glyphicon glyphicon-alert">
                                                    Not Uploaded
                                                </span>
                                                </div>
                                            @else
                                                @foreach($ap->programmeapprovalfiles as $f)
                                                    <i class="fa fa-file-text-o"></i>&nbsp;&nbsp;
                                                    <a href="{{url('files/rciapproval/'.$f->filename)}}" target="_blank" >{{$f->filename}}</a>&nbsp;&nbsp;
                                                    <br/>
                                                @endforeach
                                            @endif
                                        @else
                                            <div class="label label-danger">NOT APPLICABLE</div>
                                        @endif
                                    </td>
                                    <td class="center-text">
                                        @if($ap->status_id == '0')
                                        @else
                                            <div class="label label-{{ $ap->status->class }}">
                                                {{ $ap->status->status }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="center-text">{{ $ap->maxintake }}</td>
                                    <td class="center-text">
                                        {{ $ap->registered_count }}
                                        {{--
                                        {{ $ap->enrolled_count }}
                                        --}}
                                    </td>
                                    <td class="center-text red-text">
                                        {{ $ap->enrolment_count }}
                                        {{--
                                        {{ $ap->enrolment_count }}
                                        --}}
                                    </td>
                                    <td class="text-center">
                                        @if($ap->status_id == '0')
                                        @elseif($ap->status_id == '1')
                                            <div class="center-text">
                                                <a href="{{ url('/enrolments/course/approve/'.$ap->id) }}" class="btn btn-success btn-xs">
                                                    Approve
                                                </a>
                                                <a href="{{ url('/enrolments/course/reject/'.$ap->id) }}" class="btn btn-danger btn-xs">
                                                    Reject
                                                </a>
                                            </div>
                                        @elseif($ap->status_id == '2')
                                            <div class="center-text">
                                                <a href="{{ url('/enrolments/course/hold/'.$ap->id) }}" class="btn btn-warning btn-xs">
                                                    Hold
                                                </a>
                                                <a href="{{ url('/enrolments/course/reject/'.$ap->id) }}" class="btn btn-danger btn-xs">
                                                    Reject
                                                </a>
                                            </div>
                                        @else
                                            <div class="center-text">
                                                <a href="{{ url('/enrolments/course/approve/'.$ap->id) }}" class="btn btn-success btn-xs">
                                                    Approve
                                                </a>
                                                <a href="{{ url('/enrolments/course/hold/'.$ap->id) }}" class="btn btn-warning btn-xs">
                                                    Hold
                                                </a>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="center-text">
                                            <a href="{{ url('/enrolments/view/candidates')}}?p={{$ap->id}}" class="btn btn-primary btn-xs">
                                                <span class="glyphicon glyphicon-eye-open"></span>
                                                View
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                                @php $sno++; @endphp
                            @endforeach
                        </div>

                        {{--

                        @php $sno = '1'; @endphp
                        @foreach($institutes as $i)
                            @php $courseCount =  $approvedprogrammes->where('institute_id', $i->id)->count(); @endphp
                            @if($courseCount == '1')
                                <tr>
                                    <td class="center-text">
                                        {{ $sno }}
                                    </td>
                                    <td>{{ $i->code }}</td>
                                    <td>{{ $i->name }}</td>
                                    @foreach($approvedprogrammes->where('institute_id', $i->id) as $ap)
                                        <td>
                                            {{ $ap->programme->course_name }}
                                        </td>
                                        <td>
                                            {{ $ap->maxintake}}
                                        </td>
                                        <td>
                                            {{ $ap->allotted_count }}
                                        </td>
                                        <td>{{ $ap->enrolled_count }}</td>
                                        <td>
                                            {{ $ap->enrolment_count }}
                                        </td>
                                        <td class="center-text">
                                            <a href="{{ url('/enrolments/'.$academicyear->id.'/institute/'.$ap->id) }}" class="btn btn-xs btn-primary">
                                                <span class="glyphicon glyphicon-eye-open"></span>
                                                View Details
                                            </a>
                                        </td>
                                    @endforeach
                                </tr>
                            @else
                                <tr>
                                    <td class="center-text" rowspan="{{ $courseCount }}">
                                        {{ $sno }}
                                    </td>
                                    <td rowspan="{{ $courseCount }}">{{ $i->code }}</td>
                                    <td rowspan="{{ $courseCount }}">{{ $i->name }}</td>

                                @php $count='1'; @endphp
                                @foreach($approvedprogrammes->where('institute_id', $i->id) as $ap)
                                    @if($count != '1')
                                        <tr>
                                            <td>
                                                {{ $ap->programme->course_name }}
                                            </td>
                                            <td>
                                                {{ $ap->maxintake}}
                                            </td>
                                            <td>
                                                {{ $ap->allotted_count }}
                                            </td>
                                            <td>{{ $ap->enrolled_count }}</td>
                                            <td>
                                                {{ $ap->enrolment_count }}
                                            </td>
                                            <td class="center-text">
                                                <a href="{{ url('/enrolments/'.$academicyear->id.'/institute/'.$ap->id) }}" class="btn btn-xs btn-primary">
                                                    <span class="glyphicon glyphicon-eye-open"></span>
                                                    View Details
                                                </a>
                                            </td>
                                        </tr>
                                    @else
                                        <td>
                                            {{ $ap->programme->course_name }}
                                        </td>
                                        <td>
                                            {{ $ap->maxintake}}
                                        </td>
                                        <td>
                                            {{ $ap->allotted_count }}
                                        </td>
                                        <td>{{ $ap->enrolled_count }}</td>
                                        <td>
                                            {{ $ap->enrolment_count }}
                                        </td>
                                        <td class="center-text">
                                            <a href="{{ url('/enrolments/'.$academicyear->id.'/institute/'.$ap->id) }}" class="btn btn-xs btn-primary">
                                                <span class="glyphicon glyphicon-eye-open"></span>
                                                View Details
                                            </a>
                                        </td>
                                        </tr>
                                    @endif
                                    @php $count++; @endphp
                                @endforeach

                            @endif
                            @php $sno++; @endphp
                        @endforeach
--}}
                    </table>
                </div>
            </div>
        </div>
    </section>
    
    <script>
        $(document).ready(function () {
            
        })
        
    </script>

@endsection