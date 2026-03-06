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

    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="center-text bold-text blue-text">
                        <a href="{{ url('/demoexternalexamcenter/showhomepage') }}" class="btn btn-sm btn-success">Click to go for Home Page</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="blue-text">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <th class="bg-primary h5-text" colspan="6">Date of Examination : {{ date('d-m-Y') }}</th>
                                </tr>
                                <tr>
                                    <th class="center-text h6-text" width="5%">S.No.</th>
                                    <th class="center-text h6-text" width="13%">Course Code</th>
                                    <th class="center-text h6-text" width="10%">Subject Code</th>
                                    <th class="center-text h6-text" width="50%">Subject Name</th>
                                    <th class="center-text h6-text">Attendance Sheet</th>
                                    <th class="center-text h6-text" width="15%">Mark Attendance Online</th>
                                </tr>

                                @php $sno = 1; @endphp
                                <tr>
                                    <td class="center-text">{{ $sno }}</td>
                                    <td class="center-text">Course-{{ $sno }}</td>
                                    <td class="center-text">Subject Code-{{ $sno }}</td>
                                    <td>Subject Name-{{ $sno }}</td>
                                    <td class="center-text">
                                        <a href="{{ url('/demoexternalexamcenter/demoattendancesheet/download/'.$sno) }}"
                                           target="_blank"
                                           class="btn btn-success"
                                        >
                                            <i class="fa fa-arrow-circle-down"></i> Download
                                        </a>
                                    </td>
                                    <td class="center-text">
                                        @php $count = (int) \App\Demoexamattendance::where("subject_id", $sno)->count(); @endphp

                                        @if($count == 0)
                                            <a href="{{ url('/demoexternalexamcenter/demoattendancesheet/markattendance/'.$sno) }}"
                                               target="_blank"
                                               class="btn btn-warning"
                                            >
                                                <i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Mark Attendances
                                            </a>
                                        @else
                                            <a href="{{ url('/demoexternalexamcenter/demoattendancesheet/viewmarkedattendance/'.$sno) }}"
                                               target="_blank"
                                               class="btn btn-success"
                                            >
                                                <i class="fa fa-eye" aria-hidden="true"></i>&nbsp; View Marked Attendances
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @php $sno++; @endphp
                                <tr>
                                    <td class="center-text">{{ $sno }}</td>
                                    <td class="center-text">Course-{{ $sno }}</td>
                                    <td class="center-text">Subject Code-{{ $sno }}</td>
                                    <td>Subject Name-{{ $sno }}</td>
                                    <td class="center-text">
                                        <a href="{{ url('/demoexternalexamcenter/demoattendancesheet/download/'.$sno) }}"
                                           target="_blank"
                                           class="btn btn-success"
                                        >
                                            <i class="fa fa-arrow-circle-down"></i> Download
                                        </a>
                                    </td>
                                    <td class="center-text">
                                        @php $count = (int) \App\Demoexamattendance::where("subject_id", $sno)->count(); @endphp

                                        @if($count == 0)
                                            <a href="{{ url('/demoexternalexamcenter/demoattendancesheet/markattendance/'.$sno) }}"
                                               target="_blank"
                                               class="btn btn-warning"
                                            >
                                                <i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Mark Attendances
                                            </a>
                                        @else
                                            <a href="{{ url('/demoexternalexamcenter/demoattendancesheet/viewmarkedattendance/'.$sno) }}"
                                               target="_blank"
                                               class="btn btn-success"
                                            >
                                                <i class="fa fa-eye" aria-hidden="true"></i>&nbsp; View Marked Attendances
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @php $sno++; @endphp
                                <tr>
                                    <td class="center-text">{{ $sno }}</td>
                                    <td class="center-text">Course-{{ $sno }}</td>
                                    <td class="center-text">Subject Code-{{ $sno }}</td>
                                    <td>Subject Name-{{ $sno }}</td>
                                    <td class="center-text">
                                        <a href="{{ url('/demoexternalexamcenter/demoattendancesheet/download/'.$sno) }}"
                                           target="_blank"
                                           class="btn btn-success"
                                        >
                                            <i class="fa fa-arrow-circle-down"></i> Download
                                        </a>
                                    </td>
                                    <td class="center-text">
                                        @php $count = (int) \App\Demoexamattendance::where("subject_id", $sno)->count(); @endphp

                                        @if($count == 0)
                                            <a href="{{ url('/demoexternalexamcenter/demoattendancesheet/markattendance/'.$sno) }}"
                                               target="_blank"
                                               class="btn btn-warning"
                                            >
                                                <i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Mark Attendances
                                            </a>
                                        @else
                                            <a href="{{ url('/demoexternalexamcenter/demoattendancesheet/viewmarkedattendance/'.$sno) }}"
                                               target="_blank"
                                               class="btn btn-success"
                                            >
                                                <i class="fa fa-eye" aria-hidden="true"></i>&nbsp; View Marked Attendances
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection