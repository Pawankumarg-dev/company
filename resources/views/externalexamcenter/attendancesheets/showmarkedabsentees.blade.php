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
                    <div class="right-text bold-text blue-text">
                        <a href="{{ url('/externalexamcenter/') }}" class="btn btn-sm btn-success">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <input type="hidden" name="exam_id" value="{{ $exam->id }}">
    <input type="hidden" name="externalexamcenter_id" value="{{ $externalexamcenter->id }}">

    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="center-text bold-text blue-text">
                        {{$exam->name}} Exam - {{ $title }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    @php $count = 0; @endphp
    @foreach($examtimetables as $et)
        @foreach($approvedprogrammes as $ap)
            @php $sno = 1; @endphp

            @if($applications->where('approvedprogramme_id', $ap->id)->where('subject_id', $et->subject_id)->count() > 0)
                <section>
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                                <div class="center-text blue-text">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <tr>
                                                <th colspan="2" class="left-text darkblue-background">
                                                    Institute Details
                                                </th>
                                                <th colspan="8" class="left-text bold-text red-text">
                                                    {{ $ap->institute->code }} - {{ $ap->institute->name }}
                                                </th>
                                            </tr>
                                            <tr>
                                                <th colspan="2" class="left-text darkblue-background">
                                                    Course Details
                                                </th>
                                                <th colspan="8" class="left-text bold-text red-text">
                                                    {{ $ap->programme->course_name }}
                                                </th>
                                            </tr>
                                            <tr>
                                                <th rowspan="2" class="center-text darkblue-background" width="5%">S.No.</th>
                                                <th rowspan="2" class="center-text darkblue-background" width="5%">Academic Year</th>
                                                <th rowspan="2" class="center-text darkblue-background" width="10%">Subject Code</th>
                                                <th colspan="3" class="center-text darkblue-background">Candidate Details</th>
                                                <th rowspan="2" class="center-text darkblue-background" width="5%">Attendance Remarks</th>
                                            </tr>
                                            <tr>
                                                <th class="center-text darkblue-background" width="10%">Photo</th>
                                                <th class="center-text darkblue-background" width="10%">Enrolment No.</th>
                                                <th class="center-text darkblue-background" width="20%">Name</th>
                                            </tr>

                                            @foreach($candidates->where('approvedprogramme_id', $ap->id) as $c)
                                                @php
                                                    $application = $applications->where('candidate_id', $c->id)->where('subject_id', $et->subject_id)->first();
                                                @endphp

                                                <tr>
                                                    <td>{{ $sno }}</td>
                                                    <td class="bold-text brown-text">{{ $ap->academicyear->year }}</td>
                                                    <td class="bold-text red-text h5-text">
                                                        {{ $et->subject->scode }}
                                                    </td>
                                                    <td>
                                                        <img src="{{asset('/files/enrolment/photos')}}/{{$c->photo}}"  style="width: 60px;" class="img" />
                                                    </td>
                                                    <td class="bold-text red-text h5-text">
                                                        {{ $c->enrolmentno }}
                                                    </td>
                                                    <td class="left-text bold-text blue-text">
                                                        {{ $c->name }}
                                                    </td>

                                                    @php
                                                        $mark = \App\Mark::where('application_id', $application->id)->first();
                                                    @endphp

                                                    @if(is_null($mark))
                                                        <td>
                                                        <span class="bold-text blue-text">

                                                        </span>
                                                        </td>
                                                    @else
                                                        <td>
                                                            @if($mark->external == 'Abs')
                                                                <span class="bold-text red-text">
                                                            Absent
                                                            </span>
                                                            @endif
                                                        </td>
                                                    @endif
                                                </tr>
                                                @php $count++; $sno++; @endphp
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @endif
        @endforeach
    @endforeach

    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="center-text bold-text blue-text">
                        {{$exam->name}} Exam - {{ $title }}
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection