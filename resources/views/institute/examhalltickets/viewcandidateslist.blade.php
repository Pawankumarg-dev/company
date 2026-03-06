@extends('layouts.app')

@section('content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text">
                    {{ $exam->name }} Examination - Hall Ticket Downloads
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
                            @if(!is_null($examcenter))
                                @if($examcenter->active_status == '1')
                                    <tr>
                                        <td colspan="2" class="center-text blue-text">Exam Venue</td>
                                        <td colspan="4" class="blue-text">
                                            {{ $examcenter->externalexamcenter->code }} -
                                            {{ $examcenter->externalexamcenter->name }}
                                            @if($examcenter->externalexamcenter->address != '')<br>{{ $examcenter->externalexamcenter->address }}@endif
                                            @if($examcenter->externalexamcenter->district != '')<br>{{ $examcenter->externalexamcenter->district }}@endif
                                            @if($examcenter->externalexamcenter->state != '')<br>{{ $examcenter->externalexamcenter->state }}@endif
                                            @if($examcenter->externalexamcenter->state != '')<br>Pincode - {{ $examcenter->externalexamcenter->pincode }}@endif
                                            @if($examcenter->externalexamcenter->contactnumber1 != '')<br>{{ $examcenter->externalexamcenter->contactnumber1 }}@endif @if($examcenter->externalexamcenter->contactnumber2 != ''),{{ $examcenter->externalexamcenter->contactnumber2 }}@endif
                                            @if($examcenter->externalexamcenter->email1 != '')<br>{{ $examcenter->externalexamcenter->email1 }}@endif @if($examcenter->externalexamcenter->email2 != ''),{{ $examcenter->externalexamcenter->email2 }}@endif
                                        </td>
                                    </tr>
                                @endif
                            @endif
                            <tr>
                                <th colspan="6" class="center-text blue-text">{{ $approvedprogramme->programme->course_name }} ({{ $approvedprogramme->academicyear->year }} Batch)</th>
                            </tr>

                            <tr class="grey-background">
                                <th class="center-text">S.No</th>
                                <th class="center-text">Photo</th>
                                <th class="center-text">Enrolment</th>
                                <th class="center-text">Name</th>
                                <th class="center-text">DoB</th>
                                <th class="center-text">Options</th>
                            </tr>
                            @php $sno = '1'; @endphp
                            @foreach($candidates as $c)
                                <tr>
                                    <td class="center-text blue-text">{{ $sno }}</td>
                                    <td class="center-text"><img src="{{asset('/files/enrolment/photos')}}/{{$c->photo}}"  style="width: 100px;" class="img" /></td>
                                    <td class="center-text blue-text">{{ $c->enrolmentno }}</td>
                                    <td class="center-text blue-text">{{ $c->name }}</td>
                                    <td class="center-text blue-text">{{ $c->dob->format('d-m-Y') }}</td>
                                    <td class="center-text">
                                        @if($c->status_id == 2)
                                            @php $application_count = 0; $mark_count = 0; $fail_count = 0; @endphp
                                            @foreach($applications->where('candidate_id', $c->id) as $app)
                                                @php
                                                    $application_count++;

                                                    $mark = $marks->where('application_id', $app->id)->first();
                                                @endphp

                                                @if(!is_null($mark))
                                                    @php $internal = $mark->internal;@endphp
                                                    @if(!is_null($internal))
                                                        @php $mark_count++;@endphp
                                                        @if($internal < $app->subject->imin_marks || $internal == 'Abs')
                                                            @php $fail_count++; @endphp
                                                        @endif
                                                    @endif
                                                @endif
                                            @endforeach

                                            @if($application_count == $mark_count)
                                                @if($fail_count == $application_count)
                                                    <span class="red-text"><i class="fa fa-info-circle"></i> You are not eligible to write the examination</span>
                                                @else
                                                    {{--
                                                    @php
                                                        $candidateattendance =  \App\Attendance::where('exam_id', $exam->id)->where('candidate_id', $c->id)->first();
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
                                                                    @if($examcenter->active_status == '1')
                                                                        <a href="{{url('/institute/hallticket-download/'.$exam->id.'/download-candidates-hallticket/'.$c->id)}}" class="btn btn-info btn-sm" target="_blank"><i class="fa fa-download"></i> &nbsp;&nbsp;Hallticket</a>
                                                                    @endif
                                                                @endif
                                                            @elseif($theoryattendance >= 75)
                                                                @if($examcenter->active_status == '1')
                                                                    <a href="{{url('/institute/hallticket-download/'.$exam->id.'/download-candidates-hallticket/'.$c->id)}}" class="btn btn-info btn-sm" target="_blank"><i class="fa fa-download"></i> &nbsp;&nbsp;Hallticket</a>
                                                                @endif
                                                            @else
                                                                <span class="red-text"><i class="fa fa-info-circle"></i> You are not eligible to write the examination due to the shortage of attendance</span>
                                                            @endif
                                                        @endif
                                                    @endif
                                                    --}}

                                                    @if($examcenter->active_status == '1')
                                                        <a href="{{url('/institute/hallticket-download/'.$exam->id.'/download-candidates-hallticket/'.$c->id)}}" class="btn btn-info btn-sm" target="_blank"><i class="fa fa-download"></i> &nbsp;&nbsp;Hallticket</a>
                                                    @endif
                                                @endif
                                            @else
                                                <span class="red-text"><i class="fa fa-info-circle"></i> Please enter the Internal Theory Marks</span>
                                            @endif
                                        @else
                                            <span class="red-text"><i class="fa fa-info-circle"></i> Approval of Candidate's Status is required to download the exam hall ticket</span>
                                        @endif
                                    </td>
                                </tr>
                                @php $sno++; @endphp
                            @endforeach
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection