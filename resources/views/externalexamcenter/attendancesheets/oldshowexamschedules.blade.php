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
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="center-text bold-text blue-text h5-text">
                        {{$exam->name}} Exam - {{ $title }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="center-text blue-text">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <th rowspan="2" class="center-text h5-text" width="5%">S.No.</th>
                                    <th rowspan="2" class="center-text h5-text" width="15%">Date of Examination</th>
                                    <th colspan="2" class="center-text h5-text">Examination Timings</th>
                                    <th rowspan="2" class="center-text h5-text">Download Options</th>
                                    <th rowspan="2" class="center-text h5-text">Mark Attendance Link</th>
                                    <th rowspan="2" class="center-text h5-text">Mark Absentees Link</th>
                                </tr>
                                <tr>
                                    <th class="center-text h5-text" width="20%">Start Time</th>
                                    <th class="center-text h5-text" width="20%">End Time</th>
                                </tr>

                                @php $sno = '1'; @endphp
                                @foreach($examtimetables as $et)
                                    <tr>
                                        <td class="bold-text h5-text">{{ $sno }}</td>
                                        <td class="brown-text bold-text h5-text">{{ $et->startdate->format('d-m-Y') }}</td>
                                        <td class="red-text bold-text h5-text">{{ $et->startdate->format('h:i A') }}</td>
                                        <td class="red-text bold-text h5-text">{{ $et->enddate->format('h:i A') }}</td>
                                        <td>
                                            <a href="{{ url('/externalexamcenter/'.$externalexamcenter->id.'/attendance-sheet/'.$exam->id.'/view-attendances/'.$et->startdate) }}"
                                               target="_blank"
                                               class="btn btn-success"
                                               disabled="true"
                                            >
                                                <i class="fa fa-arrow-circle-down"></i> Download Exam Attendance Sheet
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ url('/externalexamcenter/'.$externalexamcenter->id.'/attendance-sheet/'.$exam->id.'/show-markattendance-forms/'.$et->startdate) }}"
                                               class="btn btn-success"
                                               disabled="true"
                                            >
                                                <span class="glyphicon glyphicon-share-alt"></span> Mark Exam Attendance
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ url('/externalexamcenter/'.$externalexamcenter->id.'/attendance-sheet/'.$exam->id.'/show-markabsent-forms/'.$et->startdate) }}"
                                               class="btn btn-primary"
                                            >
                                                <span class="glyphicon glyphicon-share-alt"></span> Mark Exam Absentees
                                            </a>
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