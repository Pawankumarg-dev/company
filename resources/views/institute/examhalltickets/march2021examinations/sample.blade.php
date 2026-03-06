@extends('layouts.app')

@section('content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text">
                    {{--
                    {{ $exam->name }} Examination - Hall Ticket Downloads
                    --}}
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
                                    <td class="center-text"><img src="{{asset('/files/enrolment/photos')}}/{{$c->photo}}"  style="width: 100px;" class="img" /></td>
                                    <td class="center-text blue-text">{{ $c->enrolmentno }}</td>
                                    <td class="center-text blue-text">{{ $c->name }}</td>
                                    <td class="center-text blue-text">{{ $c->dob->format('d-m-Y') }}</td>
                                    <td class="center-text">
                                        @php
                                            $application_count = 0; $mark_count = 0; $fail_count = 0;

                                            $externalexamcenter = \App\Externalexamcenter::where('id', $applications->where('candidate_id', $c->id)->first()->externalexamcenter_id)->first();
                                        @endphp
                                        @foreach($applications->where('candidate_id', $c->id) as $app)
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
                                                @if($c->approvedprogramme->year < 2018)
                                                    <a href="{{url('/institute/hallticket-download/'.$exam->id.'/download-candidates-hallticket/'.$c->id)}}" class="btn btn-info btn-sm" target="_blank"><i class="fa fa-download"></i> &nbsp;&nbsp;Hallticket</a>

                                                @else
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
                                                                    @if(!is_null($externalexamcenter))
                                                                        <a href="{{url('/institute/hallticket-download/'.$exam->id.'/download-candidates-hallticket/'.$c->id)}}" class="btn btn-info btn-sm" target="_blank"><i class="fa fa-download"></i> &nbsp;&nbsp;Hallticket</a>
                                                                    @endif
                                                                @endif
                                                            @elseif($theoryattendance >= 75)
                                                                @if(!is_null($externalexamcenter))
                                                                    <a href="{{url('/institute/hallticket-download/'.$exam->id.'/download-candidates-hallticket/'.$c->id)}}" class="btn btn-info btn-sm" target="_blank"><i class="fa fa-download"></i> &nbsp;&nbsp;Hallticket</a>
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
@endsection