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
                        {{$exam->name}} Exam - Attendance Sheet Download Page
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="center-text bold-text blue-text">
                        <a href="{{ url('/externalexamcenter/clo/'.$exam->id.'/show-home-page/'.$externalexamcenter->id) }}" class="btn btn-sm btn-success">Click to go for Home Page</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if($examtimetables->count() == 0))
    <tr>
        <td class="red-text">No Examination is found today at your exam center</td>
    </tr>
    @else
        @foreach($examtimetables as $et)
            <section>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                            <div class="center-text bold-text blue-text">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-condensed">
                                        <tr class="grey-background">
                                            <th class="center-text" colspan="6">
                                                {{ $et->startdate->format('d-m-Y h:i A') }}
                                                [{{ $et->startdate->format('l') }}]
                                            </th>
                                        </tr>
                                        <tr class="grey-background">
                                            <th class="center-text" width="10%">Subject Code</th>
                                            <th class="center-text">Subject Name</th>
                                            <th class="center-text" width="20%">Attendance Sheets</th>
                                        </tr>
                                        <tr>
                                            <td>{{ $et->subject->scode }}</td>
                                            <td class="left-text">{{ $et->subject->sname }}</td>
                                            <td class="center-text">
                                                <a href="{{ url('/externalexamcenter/clo/'.$externalexamcenter->id.'/download-attendance-sheet/'.$et->id) }}" class="btn btn-sm btn-success" target="_blank">Download</a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endforeach
    @endif
@endsection