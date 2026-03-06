@extends('layouts.externalexamcenter')

@section('content')
    <header>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 well well-sm darkblue-background">
                    <div class="center-text">
                        <span class="h4-text">National Institute for Empowerment of Persons with Multiple Disabilities (Divyangjan)</span><br>
                        <span class="h8-text">(Dept. of Empowerment of Persons with Disabilities (Divyangjan), MS&E, Govt. of India)</span><br>
                        <span class="h4-text">National Board of Examination in Rehabilitation (NBER)</span><br>
                        <span class="h8-text">(An Adjunct Body of Rehabilitation Council of India, under Ministry of Social Justice and Empowerment)</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text blue-text">
                    {{ $externalexamcenter->code }} - {{ $externalexamcenter->name }},
                    @if($externalexamcenter->address != ''){{ $externalexamcenter->address }},@endif
                    @if($externalexamcenter->district != ''){{ $externalexamcenter->district }},@endif
                    @if($externalexamcenter->state != ''){{ $externalexamcenter->state }}@endif
                    @if($externalexamcenter->state != '') - {{ $externalexamcenter->pincode }}.@endif
                    @if($externalexamcenter->contactnumber1 != '')<br>Contact No(s): {{ $externalexamcenter->contactnumber1 }}@endif @if($externalexamcenter->contactnumber2 != ''), {{ $externalexamcenter->contactnumber2 }}@endif
                    @if($externalexamcenter->email1 != '')<br>Email(s): {{ $externalexamcenter->email1 }}@endif @if($externalexamcenter->email2 != ''), {{ $externalexamcenter->email2 }}@endif

                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="center-text bold-text blue-text">
                        <a href="{{ url('/externalexamcenter/'.$externalexamcenter->id.'/show-home-page/'.$exam->id) }}" class="btn btn-sm btn-success">Click to go for Home Page</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="row">
                        <div class="col-sm-10 center-text bold-text blue-text">
                            {{ $title }}
                        </div>
                        {{--
                        <div class="col-sm-2">
                            <a href="{{ url('/externalexamcenter/attendance/updatemarkedattendanceform/'.$exam->id.'/'.$externalexamcenter->id.'/'.$examtimetable->id) }}"
                               target="_blank"
                               class="btn btn-success"
                            >
                                <i class="glyphicon glyphicon-edit"></i>&nbsp; Edit Attendance
                            </a>
                        </div>
                        --}}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="center-text bold-text blue-text">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <th class="bg-info" width="15%">Examination Centre :</th>
                                    <th class="red-text">{{ $externalexamcenter->code }} - {{ $externalexamcenter->name }}</th>
                                </tr>
                                <tr>
                                    <th class="bg-info" width="15%">Date of Examination :</th>
                                    <th class="red-text">{{ $examtimetable->startdate->format('d-m-Y') }}</th>
                                </tr>
                                <tr>
                                    <th class="bg-info" width="15%">Course Code :</th>
                                    <th class="red-text">{{ $examtimetable->subject->programme->course_name }}</th>
                                </tr>
                                <tr>
                                    <th class="bg-info" width="15%">Subject :</th>
                                    <th class="red-text">{{ $examtimetable->subject->scode }} - {{ $examtimetable->subject->sname }}</th>
                                </tr>
                                <tr>
                                    <th class="bg-info" width="15%">Uploaded File :</th>
                                    <th class="red-text">
                                        <a href="{{asset('files/examattendancefiles').'/'.$filename}}" target="_blank">
                                            File &nbsp;&nbsp;<i class="fa fa-share-square-o"></i>
                                        </a>
                                    </th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                        <div class="center-text bold-text blue-text">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover blue-text">
                                    <tr>
                                        <th class="bg-info center-text" style="font-size: large" colspan="10">
                                            {{ $approvedprogramme->institute->code }} - {{ $approvedprogramme->institute->name }}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th rowspan="2" class="center-text darkblue-background" width="5%">S.No.</th>
                                        <th rowspan="2" class="center-text darkblue-background" width="5%">Batch</th>
                                        <th colspan="3" class="center-text darkblue-background">Candidate Details</th>
                                        <th rowspan="2" class="center-text darkblue-background" width="5%">Attendance Remarks</th>
                                        <th rowspan="2" class="center-text darkblue-background" width="15%">Language written</th>
                                        <th rowspan="2" class="center-text darkblue-background" width="15%">Answer Booklet's<br>Serial No.</th>
                                    </tr>
                                    <tr>
                                        <th class="center-text darkblue-background" width="10%">Photo</th>
                                        <th class="center-text darkblue-background" width="10%">Registration No.</th>
                                        <th class="center-text darkblue-background" width="20%">Name</th>
                                    </tr>

                                    @php $sno = 1; @endphp
                                    @foreach($markexamattendances->where('approvedprogramme_id', $approvedprogramme->id) as $markexamattendance)
                                        <tr>
                                            <td>{{ $sno }}</td>
                                            <td>{{ $markexamattendance->approvedprogramme->academicyear->year }}</td>
                                            <td>
                                                <img src="{{asset('/files/enrolment/photos')}}/{{$markexamattendance->application->candidate->photo}}"  style="width: 60px;" class="img" />
                                            </td>
                                            <td>{{ $markexamattendance->application->candidate->enrolmentno }}</td>
                                            <td>{{ $markexamattendance->application->candidate->name }}</td>
                                            <td class="center-text">
                                                @if($markexamattendance->externalattendance_id == 1)
                                                    <span class="blue-text">{{ strtoupper($markexamattendance->externalattendance->attendance) }}</span>
                                                @else
                                                    <span class="red-text">{{ strtoupper($markexamattendance->externalattendance->attendance) }}</span>
                                                @endif
                                            </td>
                                            <td class="center-text">
                                                @if($markexamattendance->language_id == 0)
                                                    <span class="red-text">NOT APPLICABLE</span>
                                                @else
                                                    <span class="blue-text">{{ $markexamattendance->language->language }}</span>
                                                @endif
                                            </td>
                                            <td class="center-text">
                                                @if($markexamattendance->externalattendance_id == 1)
                                                    <span class="blue-text">{{ $markexamattendance->answersheet_serialnumber }}</span>
                                                @else
                                                    <span class="red-text">NOT APPLICABLE</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @php $sno++; @endphp
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection