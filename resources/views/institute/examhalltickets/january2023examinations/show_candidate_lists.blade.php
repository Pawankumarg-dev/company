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
                                    {{ $exam->name }} Examinations
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <section class="hidethis">
                                            <ul class="breadcrumb">
                                                <li class="heading">Quick Links: </li>
                                                <li>
                                                    <a href="{{ url('/institute/examinations') }}">Exam Lists</a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('/institute/examinations/applications/'.$exam->id) }}">{{ $exam->name }} Exam Applications</a>
                                                </li>
                                                <li class="active">{{ $approvedprogramme->programme->course_name }} ( {{ $approvedprogramme->academicyear->year }})</li>
                                            </ul>
                                        </section>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="panel panel-success">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    Candidate Lists for Downloading Theory Hall Ticket
                                                </div>
                                            </div>

                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-condensed table-hover">
                                                                <thead>
                                                                <tr>
                                                                    <th class="center-text" width="5%">S.No.</th>
                                                                    <th class="center-text" width="15%">Photo</th>
                                                                    <th class="center-text" width="5%">Enrolment No.</th>
                                                                    <th class="center-text" width="15%">Name</th>
                                                                    <th class="center-text" width="30%">Exam Centre Details</th>
                                                                    <th class="center-text" width="10%">Download Link</th>
                                                                    <th class="center-text">Remarks</th>
                                                                </tr>
                                                                </thead>

                                                                <tbody>
                                                                @if($applications->count() == 0)
                                                                    <tr>
                                                                        <td colspan="7" class="center-text red-text">
                                                                            <h3>No Applications Found</h3>
                                                                        </td>
                                                                    </tr>
                                                                @else
                                                                    @php $sno = 1; @endphp
                                                                    @foreach($candidates as $candidate)
                                                                        <tr>
                                                                            <td class="center-text blue-text">{{ $sno }} @php $sno++; @endphp</td>
                                                                            <td class="center-text">
                                                                                <img src="{{ asset('/files/enrolment/photos')}}/{{$candidate->photo }}"  style="width: 100px;" class="img" />
                                                                            </td>
                                                                            <td class="center-text blue-text">{{ $candidate->enrolmentno }}</td>
                                                                            <td class="blue-text">{{ $candidate->name }}</td>

                                                                            @php
                                                                              $externalexamcenter = $applications->where('candidate_id', $candidate->id)->first()->externalexamcenter;
                                                                            @endphp

                                                                            @if(is_null($externalexamcenter))
                                                                                <td class="center-text">
                                                                                    <span class="label label-danger">NOT MAPPED</span>
                                                                                </td>
                                                                                <td class="center-text">
                                                                                    <span class="label label-danger">NOT AVAILABLE</span>
                                                                                </td>
                                                                                <td class="center-text">
                                                                                    <span class="label label-danger">NOT AVAILABLE</span>
                                                                                </td>
                                                                            @else
                                                                                <td class="blue-text">
                                                                                    ( {{ $externalexamcenter->code }} ) - {{ $externalexamcenter->name }}
                                                                                    @if($externalexamcenter->address != '')<br>{{ $externalexamcenter->address }}@endif
                                                                                    @if($externalexamcenter->district != ''), {{ $externalexamcenter->district }}@endif
                                                                                    @if($externalexamcenter->state != ''), <br>{{ $externalexamcenter->state }} - {{ $externalexamcenter->pincode }}@endif
                                                                                    @if($externalexamcenter->contactnumber1 != '')<br>{{ $externalexamcenter->contactnumber1 }}@endif @if($externalexamcenter->contactnumber2 != ''),{{ $externalexamcenter->contactnumber2 }}@endif
                                                                                    @if($externalexamcenter->email1 != '')<br>{{ $externalexamcenter->email1 }}@endif @if($externalexamcenter->email2 != ''),{{ $externalexamcenter->email2 }}@endif
                                                                                </td>
                                                                            
                                                                                @if($applications->where('candidate_id', $candidate->id)->where('payment_status', 'Approved')->count() >= 1)
                                                                                    @if($applications->where('candidate_id', $candidate->id)->where('internalresult_id', 1)->count() >= 1)
                                                                                        @php
                                                                                            $candidateattendance =  \App\Attendance::where('exam_id', $exam->id)->where('candidate_id', $candidate->id)->first();
                                                                                        @endphp

                                                                                        @if(is_null($candidateattendance))
                                                                                            <td class="center-text">
                                                                                                <span class="label label-danger">NOT AVAILABLE</span>
                                                                                            </td>
                                                                                            <td>
                                                                                                <span class="red-text"><i class="fa fa-info-circle"></i> Please enter the Attendance details</span>
                                                                                            </td>
                                                                                        @else
                                                                                            @php
                                                                                                $theoryattendance = $candidateattendance->attendance_t;
                                                                                                $theoryattendance_document = $candidateattendance->document_t;
                                                                                                $exemption = $candidateattendance->document_exemption;
                                                                                            @endphp

                                                                                            @if(is_null($theoryattendance_document) || $theoryattendance_document == "")
                                                                                                <td class="center-text">
                                                                                                    <span class="label label-danger">NOT AVAILABLE</span>
                                                                                                </td>
                                                                                                <td>
                                                                                                    <span class="red-text"><i class="fa fa-info-circle"></i> Please upload the Consolidated Attendance</span>
                                                                                                </td>
                                                                                            @else
                                                                                                @if(is_null($theoryattendance) || $theoryattendance == "")
                                                                                                    <td class="center-text">
                                                                                                        <span class="label label-danger">NOT AVAILABLE</span>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <span class="red-text"><i class="fa fa-info-circle"></i> Please enter the Theory Attendance Percentage</span>
                                                                                                    </td>
                                                                                                @elseif($theoryattendance >= 70 && $theoryattendance < 75)
                                                                                                    @if(is_null($exemption) || $exemption == "")
                                                                                                        <td class="center-text">
                                                                                                            <span class="label label-danger">NOT AVAILABLE</span>
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            <span class="red-text"><i class="fa fa-info-circle"></i> Please upload the Percentage Exception document</span>
                                                                                                        </td>
                                                                                                    @else
                                                                                                        @if(!is_null($externalexamcenter))
                                                                                                            <td class="center-text">
                                                                                                                <a href="{{ url('/institute/hallticket-download/download-candidate-hallticket/'.$exam->id.'/'.$candidate->id) }}" class="btn btn-info btn-sm" target="_blank"><i class="fa fa-download"></i> &nbsp;&nbsp;Hallticket</a>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                <span class="green-text"><i class="fa fa-info-circle"></i> Please download Hall Ticket</span>
                                                                                                            </td>
                                                                                                        @endif
                                                                                                    @endif
                                                                                                @elseif($theoryattendance >= 75)
                                                                                                    @if(!is_null($externalexamcenter))
                                                                                                        <td class="center-text">
                                                                                                            <a href="{{ url('/institute/hallticket-download/download-candidate-hallticket/'.$exam->id.'/'.$candidate->id) }}" class="btn btn-info btn-sm" target="_blank"><i class="fa fa-download"></i> &nbsp;&nbsp;Hallticket</a>
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            <span class="green-text"><i class="fa fa-info-circle"></i> Please download Hall Ticket</span>
                                                                                                        </td>
                                                                                                    @endif
                                                                                                @else
                                                                                                    <td class="center-text">
                                                                                                        <span class="label label-danger">NOT AVAILABLE</span>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <span class="red-text"><i class="fa fa-info-circle"></i> Shortage of Attendance Percentage</span>
                                                                                                    </td>
                                                                                                @endif
                                                                                            @endif
                                                                                        @endif
                                                                                    @else
                                                                                        <td class="center-text">
                                                                                            <span class="label label-danger">NOT AVAILABLE</span>
                                                                                        </td>
                                                                                        <td>
                                                                                            <span class="red-text"><i class="fa fa-info-circle"></i> Internal Marks Not Entered / Not Passed</span>
                                                                                        </td>
                                                                                    @endif
                                                                                @else
                                                                                    <td class="center-text">
                                                                                        <span class="label label-danger">NOT AVAILABLE</span>
                                                                                    </td>
                                                                                    <td>
                                                                                        <span class="red-text"><i class="fa fa-info-circle"></i> Examination fee - Not Paid / Not Entered / Not Approved</span>
                                                                                    </td>
                                                                                @endif                                                                            
                                                                            @endif
                                                                        </tr>
                                                                    @endforeach
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--
    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text">
                    {{ $title }} - Hall Ticket Downloads
                </div>
            </div>
        </div>
    </section>

    <section class="container">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-condensed">
                        @if($applications->count() == 0)
                            <tr>
                                <td colspan="6" class="center-text red-text">
                                    <h3>No Applications Found</h3>
                                </td>
                            </tr>
                        @else
                            <tr>
                                <th colspan="2">Course Code :</th>
                                <th colspan="5">{{ $approvedprogramme->programme->common_code }}</th>
                            </tr>
                            <tr>
                                <th colspan="2">Batch :</th>
                                <th colspan="5">{{ $approvedprogramme->academicyear->year }}</th>
                            </tr>
                            <tr class="grey-background">
                                <th class="center-text">S.No</th>
                                <th class="center-text">Photo</th>
                                <th class="center-text">Enrolment</th>
                                <th class="center-text">Name</th>
                                <th class="center-text">DoB</th>
                                <th class="center-text">Options</th>
                                <th class="center-text">Exam Center Details</th>
                            </tr>

                            @php $sno = '1'; @endphp

                            @foreach($candidates as $c)
                                <tr>
                                    <td class="center-text blue-text">{{ $sno }}</td>
                                    <td class="center-text"><img src="{{asset('/files/enrolment/photos')}}/{{$candidate->photo}}"  style="width: 100px;" class="img" /></td>
                                    <td class="center-text blue-text">{{ $candidate->enrolmentno }}</td>
                                    <td class="center-text blue-text">{{ $candidate->name }}</td>
                                    <td class="center-text blue-text">{{ $candidate->dob->format('d-m-Y') }}</td>
                                    <td class="center-text">
                                        @php
                                            $application_count = 0; $mark_count = 0; $fail_count = 0;

                                            $externalexamcenter = \App\Externalexamcenter::where('id', $applications->where('candidate_id', $candidate->id)->first()->externalexamcenter_id)->first();
                                        @endphp
                                        @foreach($applications->where('candidate_id', $candidate->id) as $app)
                                            @php
                                                $application_count++;
                                            @endphp

                                            @if(!is_null($app->mark))
                                                @php $mark_count++;@endphp
                                                @if($app->mark->internalresult_id != '1')
                                                    @php $fail_count++; @endphp
                                                @endif
                                            @endif
                                        @endforeach

                                        @if($application_count == $mark_count)
                                            @if($fail_count == $application_count)
                                                <span class="red-text"><i class="fa fa-info-circle"></i> You are not eligible to write the examination</span>
                                            @else
                                                @if($candidate->approvedprogramme->year < 2018)
                                                    <a href="{{url('/institute/hallticket-download/'.$exam->id.'/download-candidates-hallticket/'.$candidate->id)}}" class="btn btn-info btn-sm" target="_blank"><i class="fa fa-download"></i> &nbsp;&nbsp;Hallticket</a>

                                                @else
                                                    @php
                                                        $candidateattendance =  \App\Attendance::where('exam_id', $exam->id)->where('candidate_id', $candidate->id)->first();
                                                    @endphp

                                                    @if(is_null($candidateattendance))
                                                        <span class="red-text"><i class="fa fa-info-circle"></i> Please enter the Attendance details</span>
                                                    @else
                                                        @php
                                                            $theoryattendance = $candidateattendance->attendance_t;
                                                            $theoryattendance_document = $candidateattendance->document_t;
                                                            $exemption = $candidateattendance->document_exemption;
                                                        @endphp

                                                        @if(is_null($theoryattendance_document) || $theoryattendance_document == "")
                                                            <span class="red-text"><i class="fa fa-info-circle"></i> Please upload the Consolidated Attendance</span>
                                                        @else
                                                            @if(is_null($theoryattendance) || $theoryattendance == "")
                                                                <span class="red-text"><i class="fa fa-info-circle"></i> Please enter the Theory Attendance Percentage</span>
                                                            @elseif($theoryattendance >= 70 && $theoryattendance < 75)
                                                                @if(is_null($exemption) || $exemption == "")
                                                                    <span class="red-text"><i class="fa fa-info-circle"></i> Please upload the Percentage Exception document</span>
                                                                @else
                                                                    @if(!is_null($externalexamcenter))
                                                                        <a href="{{url('/institute/hallticket-download/'.$exam->id.'/download-candidates-hallticket/'.$candidate->id)}}" class="btn btn-info btn-sm" target="_blank"><i class="fa fa-download"></i> &nbsp;&nbsp;Hallticket</a>
                                                                    @endif
                                                                @endif
                                                            @elseif($theoryattendance >= 75)
                                                                @if(!is_null($externalexamcenter))
                                                                    <a href="{{url('/institute/hallticket-download/'.$exam->id.'/download-candidates-hallticket/'.$candidate->id)}}" class="btn btn-info btn-sm" target="_blank"><i class="fa fa-download"></i> &nbsp;&nbsp;Hallticket</a>
                                                                @endif
                                                            @else
                                                                <span class="red-text"><i class="fa fa-info-circle"></i> You are not eligible to write the examination due to the shortage of attendance</span>
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endif
                                            @endif
                                        @else
                                            <span class="red-text"><i class="fa fa-info-circle"></i> Please enter the Internal Theory Marks</span>
                                        @endif
                                    </td>
                                    <td width="35%">
                                        @if(!is_null($externalexamcenter))
                                            ( {{ $externalexamcenter->code }} ) - {{ $externalexamcenter->name }}
                                            @if($externalexamcenter->address != '')<br>{{ $externalexamcenter->address }}@endif
                                            @if($externalexamcenter->district != ''), {{ $externalexamcenter->district }}@endif
                                            @if($externalexamcenter->state != ''), {{ $externalexamcenter->state }} - {{ $externalexamcenter->pincode }}@endif
                                            @if($externalexamcenter->contactnumber1 != '')<br>{{ $externalexamcenter->contactnumber1 }}@endif @if($externalexamcenter->contactnumber2 != ''),{{ $externalexamcenter->contactnumber2 }}@endif
                                            @if($externalexamcenter->email1 != '')<br>{{ $externalexamcenter->email1 }}@endif @if($externalexamcenter->email2 != ''),{{ $externalexamcenter->email2 }}@endif
                                        @else

                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </section>
    --}}
@endsection