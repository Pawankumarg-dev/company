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
                    <div class="center-text blue-text">
                        <div class="table-responsive">
                            <table class="table table-bordered table-condensed">
                                <tr>
                                    <th class="bg-info h5-text" width="18%">Date of Examination :</th>
                                    <th class="red-text h5-text">{{ $examtimetable->startdate->format('d-m-Y') }}</th>
                                </tr>
                                <tr>
                                    <th class="bg-info h5-text" width="18%">Subject Code :</th>
                                    <th class="red-text h5-text">{{ $examtimetable->subject->name }}</th>
                                </tr>
                                <tr>
                                    <th class="bg-info h5-text" width="18%">Subject Code :</th>
                                    <th class="red-text h5-text">{{ $examtimetable->subject->sname }}</th>
                                </tr>
                            </table>

                            <table class="table table-bordered table-hover">
                                <tr>
                                    <th class="bg-info center-text h6-text" width="5%">S.No.</th>
                                    <th class="bg-info center-text h6-text" width="8%">Study Centre Code</th>
                                    <th class="bg-info center-text h6-text" width="60%">Study Centre Name</th>
                                    <th class="bg-info center-text h6-text" >Batch</th>
                                    <th class="bg-info center-text h6-text" >Mark Attendance</th>
                                </tr>

                                @php $sno = '1'; @endphp
                                @foreach($approvedprogrammes as $approvedprogramme)
                                    <tr>
                                        <td>{{ $sno }}</td>
                                        <td class="center-text bold-text">{{ $approvedprogramme->institute->code }}</td>
                                        <td class="left-text">{{ $approvedprogramme->institute->name }}</td>
                                        <td width="5%">{{ $approvedprogramme->academicyear->year }}</td>
                                        <td width="10%">
                                            <a href="{{ url('/externalexamcenter/attendance/markattendanceform/'.$exam->id.'/'.$externalexamcenter->id.'/'.$examtimetable->id.'/'.$approvedprogramme->id) }}"
                                               target="_blank"
                                               class="btn btn-success btn-sm"
                                            >
                                                <i class="glyphicon glyphicon glyphicon-link"></i> Click here
                                            </a>
                                        </td>
                                    </tr>
                                    @php $sno++ @endphp
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection