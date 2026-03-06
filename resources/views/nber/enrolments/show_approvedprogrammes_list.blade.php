@extends('layouts.app')

@section('content')
    <input type="hidden" id="percentage" value="{{ $percentage }}">

    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    Course Verification Status - {{ $academicyear->year }} Academic year
                                </div>
                            </div>

                            <div class="panel-body container-fluid">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <ul class="breadcrumb col-sm-12">
                                            <li><a href="{{url('/')}}">Home</a></li>
                                            <li><a href="{{url('/nber/enrolments')}}">Enrolments</a></li>
                                            <li><a href="{{url('/nber/enrolments/showcourseapprovalverificationdetails/'.$academicyear->id)}}">Course Verification Status - <b>{{ $academicyear->year }}</b> Academic year</a></li>
                                            <li><b>{{ $status_remarks }} (Total: {{ $approvedprogrammesCount }})</b></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <p>Verification Status: <b>{{ $status_remarks }} (Total: {{ $approvedprogrammesCount }})</b></p>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-inline right-text">
                                            <label for="sel1">Change:</label>
                                            <select class="form-control" id="changeOptions">
                                                <option @if($status_remarks == 'Verification Pending') selected @endif value="{{ url('/nber/enrolments/showapprovedprogrammeslist/'.$academicyear->id.'/6') }}">Verification Pending</option>
                                                <option @if($status_remarks == 'Pending') selected @endif value="{{ url('/nber/enrolments/showapprovedprogrammeslist/'.$academicyear->id.'/1') }}">
                                                    Pending
                                                </option>
                                                <option @if($status_remarks == 'Approved') selected @endif value="{{ url('/nber/enrolments/showapprovedprogrammeslist/'.$academicyear->id.'/2') }}">Approved</option>
                                                <option @if($status_remarks == 'Rejected') selected @endif value="{{ url('/nber/enrolments/showapprovedprogrammeslist/'.$academicyear->id.'/3') }}">Rejected</option>
                                                <option @if($status_remarks == 'Total') selected @endif value="{{ url('/nber/enrolments/showapprovedprogrammeslist/'.$academicyear->id.'/4') }}">Total</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="progress">
                                            <div id="percentageProgressBar" class="progress-bar progress-bar-default progress-bar-striped active" role="progressbar">

                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive  tableFixHead" style="height: 50% !important;">
                                            <table class="table table-hover table-condensed table-bordered blue-text h7-text" role="table">
                                                <thead>
                                                <tr>
                                                    <th class="center-text" rowspan="2">S.No</th>
                                                    <th class="center-text" colspan="2">Institute</th>
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
                                                    <th class="center-text" width="10%">Actions</th>
                                                    <th class="center-text" width="10%">Candidates</th>
                                                </tr>
                                                </thead>

                                                @php $sno = 1; @endphp
                                                <tbody>
                                                @foreach($approvedprogrammes as $approvedprogramme)
                                                    <tr>
                                                        <td class="center-text">
                                                            {{ $sno }} @php $sno++; @endphp
                                                        </td>
                                                        <td class="center-text bold-text">{{ $approvedprogramme->institute->code }}</td>
                                                        <td>{{ $approvedprogramme->institute->name }}</td>
                                                        @if($approvedprogramme->programme_id != 0)
                                                            <td>{{ $approvedprogramme->programme->course_name }}</td>
                                                            <td>
                                                                @if($approvedprogramme->programme->approval_letter_required == '1')
                                                                    @if($approvedprogramme->status_id == '0' )
                                                                        <div class="label label-danger">
                                                                            <div class="glyphicon glyphicon-alert">
                                                                                Not Uploaded
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        @foreach($approvedprogramme->programmeapprovalfiles as $f)
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
                                                                @if($approvedprogramme->status_id == '0')
                                                                @else
                                                                    <div class="label label-{{ $approvedprogramme->status->class }}">
                                                                        {{ $approvedprogramme->status->status }}
                                                                    </div>
                                                                @endif
                                                            </td>
                                                            <td class="center-text">{{ $approvedprogramme->maxintake }}</td>
                                                            <td class="center-text">
                                                                @if($approvedprogramme->status_id == 2)
                                                                    @if(is_null($approvedprogramme->registered_count))
                                                                        0
                                                                    @else
                                                                        {{ $approvedprogramme->registered_count }}
                                                                    @endif
                                                                @else
                                                                    <span class="label label-danger">NOT APPLICABLE</span>
                                                                @endif
                                                            </td>
                                                            <td class="center-text">
                                                                @if($approvedprogramme->status_id == 2)
                                                                    {{ $approvedprogramme->enrolment_count }}
                                                                @else
                                                                    <span class="label label-danger">NOT APPLICABLE</span>
                                                                @endif
                                                            </td>
                                                            <td class="text-center">
                                                             {{--   @if($approvedprogramme->status_id == '0')
                                                                @elseif($approvedprogramme->status_id == '1')
                                                                    <div class="center-text">
                                                                        <a href="{{ url('/nber/enrolments/course/approve/'.$approvedprogramme->id) }}" class="btn btn-success btn-xs">
                                                                            Approve
                                                                        </a>
                                                                        <a href="{{ url('/nber/enrolments/course/reject/'.$approvedprogramme->id) }}" class="btn btn-danger btn-xs">
                                                                            Reject
                                                                        </a>
                                                                    </div>
                                                                @elseif($approvedprogramme->status_id == '2')
                                                                    <div class="center-text">
                                                                        <a href="{{ url('/nber/enrolments/course/hold/'.$approvedprogramme->id) }}" class="btn btn-warning btn-xs">
                                                                            Hold
                                                                        </a>
                                                                        <a href="{{ url('/nber/enrolments/course/reject/'.$approvedprogramme->id) }}" class="btn btn-danger btn-xs">
                                                                            Reject
                                                                        </a>
                                                                    </div>
                                                                @else
                                                                    <div class="center-text">
                                                                        <a href="{{ url('/nber/enrolments/course/approve/'.$approvedprogramme->id) }}" class="btn btn-success btn-xs">
                                                                            Approve
                                                                        </a>
                                                                        <a href="{{ url('/nber/enrolments/course/hold/'.$approvedprogramme->id) }}" class="btn btn-warning btn-xs">
                                                                            Hold
                                                                        </a>
                                                                    </div>
                                                                @endif
                                                                --}}
                                                            </td>
                                                            <td class="center-text">
                                                                @if($approvedprogramme->status_id == 2)
                                                                    <a href="{{ url('/enrolments/view/candidates')}}?p={{$approvedprogramme->id}}" class="btn btn-primary btn-xs">
                                                                        <span class="glyphicon glyphicon-eye-open"></span>
                                                                        View
                                                                    </a>
                                                                @else
                                                                    <span class="label label-danger">NOT APPLICABLE</span>
                                                                @endif
                                                            </td>
                                                        @else
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                                </tbody>
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

    <script>
        $(function(){
            $('#percentageProgressBar').css("width", $('#percentage').val()+"%");

            $('#changeOptions').on('change', function () {
                var url = $(this).val(); // get selected value
                if (url) { // require a URL
                    window.location = url; // redirect
                }
                return false;
            });
        });
    </script>
@endsection

