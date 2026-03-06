@extends('layouts.result')

@section('content')
    <style>
        body {
            padding-top: 10px !important;
        }
        .h3-text {
            font-size: 30px;
            font-weight: bold;
        }
        .center-text {
            text-align: center !important;
        }
        .left-text {
            text-align: left !important;
        }
        .right-text {
            text-align: right !important;
        }
        .bold-text {
            font-weight: bold;
        }
        .red-text {
            color: red;
        }
        .green-text {
            color: green;
        }
        .blue-text {
            color: blue;
        }
        .h4-text {
            font-size: 16px;
            font-weight: bold;
        }
        .h5-text {
            font-size: 15px;
            font-weight: bold;
        }
        .h6-text {
            font-size: 13px;
        }
        .h7-text {
            font-size: 12px;
        }
        .h8-text {
            font-size: 10px;
        }

    </style>

    <main>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <div class="panel-title">
                                                <div class="blue-text center-text">
                                                    <span class="h4-text">National Institute for Empowerment of Persons with Multiple Disabilities (Divyangjan)</span><br>
                                                    <span class="h8-text">(Dept. of Empowerment of Persons with Disabilities (Divyangjan), MS&E, Govt. of India)</span><br>
                                                    <span class="h4-text">National Board of Examination in Rehabilitation (NBER)</span><br>
                                                    <span class="h5-text">{{$title}}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="panel-body">
                                            <div class="panel-group">
                                                <div class="panel panel-info">
                                                    <div class="panel-heading">
                                                        <div class="panel-title">
                                                            Student Information
                                                        </div>
                                                    </div>

                                                    <div class="panel-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-condensed">
                                                                <tr>
                                                                    <td class="center-text" width="20%" rowspan="5">
                                                                        <img src="{{asset('/files/enrolment/photos')}}/{{$correctionrequest->candidate->photo}}"  style="width: 100px;" class="img" />
                                                                    </td>
                                                                    <th width="13%">Reference No.</th>
                                                                    <td class="blue-text">{{ $correctionrequest->reference_number }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Enrolment No.</th>
                                                                    <td class="blue-text">{{ $correctionrequest->candidate->enrolmentno }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Programme</th>
                                                                    <td class="blue-text">{{ $correctionrequest->candidate->approvedprogramme->programme->course_name }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Batch</th>
                                                                    <td class="blue-text">
                                                                        {{ $correctionrequest->candidate->approvedprogramme->academicyear->year }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Institute</th>
                                                                    <td class="blue-text">
                                                                        {{ $correctionrequest->candidate->approvedprogramme->institute->code }} - {{ $correctionrequest->candidate->approvedprogramme->institute->name }}
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>

                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-condensed">
                                                                <tr>
                                                                    <th width="10%">Name</th>
                                                                    <td class="blue-text">
                                                                        {{ strtoupper($correctionrequest->candidate->name) }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Father Name</th>
                                                                    <td class="blue-text">
                                                                        {{ strtoupper($correctionrequest->candidate->fathername) }}
                                                                    </td>
                                                                </tr><tr>
                                                                    <th>Date of Birth</th>
                                                                    <td class="blue-text">
                                                                        {{ $correctionrequest->candidate->dob->format('d-m-Y') }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Email</th>
                                                                    <td class="blue-text">
                                                                        {{ $correctionrequest->candidate->email }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Mobile No.</th>
                                                                    <td class="blue-text">
                                                                        {{ $correctionrequest->candidate->contactnumber }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Mobile No.</th>
                                                                    <td class="blue-text">
                                                                        {{ $correctionrequest->subject }}
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="panel panel-info">
                                                    <div class="panel-heading">
                                                        <div class="panel-title">
                                                            Tracking Remarks
                                                        </div>
                                                    </div>

                                                    <div class="panel-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-condensed">
                                                                <thead>
                                                                <tr>
                                                                    <th class="red-text center-text" width="3%">#</th>
                                                                    <th class="red-text center-text" width="7%">Update Date</th>
                                                                    <th class="red-text center-text" width="40%">Update Remarks</th>
                                                                </tr>
                                                                </thead>

                                                                <tbody>
                                                                @if(!is_null($correctionrequestupdates))
                                                                    @php $sno = 1; @endphp

                                                                    @foreach($correctionrequestupdates as $correctionrequestupdate)
                                                                        <tr>
                                                                            <td class="blue-text center-text">{{ str_pad($sno,2,"0",STR_PAD_LEFT) }} @php $sno++; @endphp</td>
                                                                            <td class="blue-text center-text">{{ $correctionrequestupdate->created_at->format("d-m-Y") }}</td>
                                                                            <td class="blue-text left-text">{{ $correctionrequestupdate->update_remarks }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                @else
                                                                    <tr>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                    </tr>
                                                                @endif
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
