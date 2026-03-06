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
                    {{ $externalexamcenter->code }} - {{ $externalexamcenter->name }}
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
                    <div class="center-text bold-text blue-text">
                        {{ $title }}
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
                                    <th class="bg-info h5-text" width="18%">Date of Examination :</th>
                                    <th class="red-text h5-text">{{ date('d-m-Y') }}</th>
                                </tr>
                                <tr>
                                    <th class="bg-info h5-text" width="18%">Course Code :</th>
                                    <th class="red-text h5-text">Course-{{ $id }}</th>
                                </tr>
                                <tr>
                                    <th class="bg-info h5-text" width="18%">Subject Code :</th>
                                    <th class="red-text h5-text">Subject Code-{{ $id }}</th>
                                </tr>
                                <tr>
                                    <th class="bg-info h5-text" width="18%">Subject Name :</th>
                                    <th class="red-text h5-text">Subject Name-{{ $id }}</th>
                                </tr>
                                <tr>
                                    <th class="bg-info h5-text" width="18%">File :</th>
                                    <th class="red-text h5-text">
                                        <a href="{{asset('files/demoexamattendancefiles').'/'.$filename}}" target="_blank">
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

    @php $count = 0; @endphp
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="center-text bold-text blue-text">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover blue-text">
                                <tr>
                                    <th class="bg-info center-text" style="font-size: large" colspan="10">
                                        Institute Code-1 & Name-1
                                    </th>
                                </tr>
                                <tr>
                                    <th rowspan="2" class="center-text darkblue-background" width="5%">S.No.</th>
                                    <th rowspan="2" class="center-text darkblue-background" width="5%">Batch</th>
                                    <th colspan="3" class="center-text darkblue-background">Candidate Details</th>
                                    <th rowspan="2" class="center-text darkblue-background">Attendance</th>
                                    <th rowspan="2" class="center-text darkblue-background" width="15%">Language written</th>
                                    <th rowspan="2" class="center-text darkblue-background" width="15%">Answer Booklet's<br>Serial No.</th>
                                </tr>
                                <tr>
                                    <th class="center-text darkblue-background" width="10%">Photo</th>
                                    <th class="center-text darkblue-background" width="10%">Registration No.</th>
                                    <th class="center-text darkblue-background" width="20%">Name</th>
                                </tr>

                                @php $sno = 1; @endphp
                                @foreach($demoexamattendances as $demo)
                                    <tr>
                                        <td class="center-text blue-text">{{ $sno }}</td>
                                        <td class="center-text blue-text">20__</td>
                                        <td class="center-text blue-text"></td>
                                        <td class="blue-text">{{ $demo->enrolmentno }}</td>
                                        <td class="blue-text">{{ $demo->name }}</td>
                                        <td class="blue-text">{{ $demo->externalattendance->attendance }}</td>
                                        <td @if($demo->externalattendance_id == 1) class="blue-text" @else class="red-text" @endif>{{ $demo->language->language }}</td>
                                        <td @if($demo->externalattendance_id == 1) class="blue-text" @else class="red-text" @endif>
                                            @if(is_null($demo->answersheet_serialnumber))
                                                Not Applicable
                                            @else
                                                {{ $demo->answersheet_serialnumber }}
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

