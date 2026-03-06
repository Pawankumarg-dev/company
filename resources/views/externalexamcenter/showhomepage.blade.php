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
                        {{ $title }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if($show == 1)
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                        <div class="bold-text red-text" style="font-size: 30px">
                            Dear Center Superintendent (CS) / Central Level Observer (CLO), <br>
                            Requested to check your mail, NIEPMD-NBER has sent answerbooklet number to be filled by the Student.<br>
                            Without Answerbooklet number, Online Attendance will not be accepted.
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6 well well-sm white-background minus15px-margin-top">
                    <div class="table-responsive">
                        <table class="table table-bordered table-condensed">
                            <tr>
                                <th width="5%">S.No.</th>
                                <th width="65%">Exam Name</th>
                                <th width="15%">Attendance Sheet</th>
                                <th width="15%">Question Paper</th>
                            </tr>
                            @php $sno = 1; @endphp
                            @foreach($exams as $exam)
                                <tr>
                                    <td>{{ $sno }}</td>
                                    <td>{{ $exam->name }}</td>
                                    <td>
                                        <a href="{{ url('/externalexamcenter/'.$externalexamcenter->id.'/attendance-sheet/'.$exam->id.'/show-exam-schedules') }}" class="btn btn-success btn-sm">
                                            <span class="glyphicon glyphicon-arrow-right"></span>  Click here
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ url('/externalexamcenter/questionpaper/showlist/'.$exam->id.'/'.$externalexamcenter->id) }}" class="btn btn-primary btn-sm">
                                            <span class="glyphicon glyphicon-arrow-right"></span>  Click here
                                        </a>
                                    </td>
                                </tr>
                                @php $sno++; @endphp
                            @endforeach
                        </table>
                    </div>
                </div>
                <div class="col-sm-3"></div>
            </div>
        </div>
    </section>
@endsection

