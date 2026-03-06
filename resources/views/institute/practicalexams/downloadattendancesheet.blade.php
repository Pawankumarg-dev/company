@extends('layouts.app')

@section('content')
    <style>
        @media print {
            #printPageButton {
                display: none;
            }
        }
        .page-break {
            page-break-after: always;
        }
    </style>
    <div  id="printPageButton">
        <section class="container-fluid">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-6 center-text bold-text">
                        {{ $exam->name }} @if($exam->examtype_id == '2') Supplementary @endif - External Practical Examination<br>
                        Attendance Sheet
                    </div>
                    <div class="col-sm-3">
                        <button class="btn btn-primary btn-sm pull-right" onclick="window.print();return false;">
                            <span class="glyphicon glyphicon-print"></span> Print Attendance Sheet
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="page-break">
        <section class="container">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background" style="border: 3px solid">
                    <div class="table-responsive">
                        <table>
                            <thead>
                            <tr>
                                <table class="table table-condensed table-borderless">
                                    <tr>
                                        <td class="center-text" width="15%">
                                            <img src="{{asset('/images/rci.png')}}"  style="width: 100px; height: 80px" class="img" />
                                        </td>
                                        <td class="h8-text center-text">
                                            <span class="h7-text bold-text">NATIONAL INSTITUTE FOR EMPOWERMENT OF PERSONS WITH MULITPLE DISABILITIES (DIVYANGJAN) [NIEPMD]</span><br>
                                            (DEPT. OF EMPOWERMENT OF PERSONS WITH DISABILIITIES (DIVYANGJAN), MSJ&E, GoI)<br>
                                            <span style="font-style: italic">Examination conducted on behalf of</span><br>
                                            <span class="h7-text bold-text">NATIONAL BOARD OF EXAMINATION IN REHABILITATION (NBER)</span><br>
                                            (An Adjunct Body of Rehabilitation Council of India, under Ministry of Social Justice and Empowerment)<br>
                                        </td>
                                        <td class="center-text" width="15%">
                                            <img src="{{asset('/images/niepmd.png')}}"  style="width: 60px;" class="img" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="center-text bold-text" colspan="3">
                                            {{ $exam->name }} @if($exam->examtype_id == '2') Supplementary @endif - External Practical Examination<br>
                                            Attendance Sheet
                                        </td>
                                    </tr>
                                </table>
                                <table class="table table-condensed table-borderless" role="table">
                                    <tr>
                                        <th class="left-text blue-text">
                                            Course :
                                        </th>
                                        <td class="left-text" width="35" colspan="3">
                                            {{ $approvedprogramme->programme->course_name }} -
                                            {{ $approvedprogramme->programme->name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="left-text blue-text">
                                            Institute :
                                        </th>
                                        <td class="left-text" width="35" colspan="3">
                                            {{ $approvedprogramme->institute->code }} -
                                            {{ $approvedprogramme->institute->name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="left-text blue-text">
                                            Subject :
                                        </th>
                                        <td class="left-text" width="35" colspan="3">
                                            {{ $subject->scode }} -
                                            {{ $subject->sname }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="left-text blue-text" width="15%" colspan="2">
                                            Exam. Date :
                                        </th>
                                        <td class="center-text" width="35">

                                        </td>
                                        <th class="right-text blue-text" width="15%" colspan="2">
                                            Time :
                                        </th>
                                        <td class="center-text" width="35">

                                        </td>
                                    </tr>
                                </table>
                                <table class="table table-condensed table-bordered" role="table">
                                    <tr>
                                        <th class="center-text blue-text" width="7%">S.No.</th>
                                        <th class="center-text blue-text" width="15%">Photo</th>
                                        <th class="center-text blue-text" width="18%">Enrolment No.</th>
                                        <th class="center-text blue-text" width="35">Name of the Student</th>
                                        <th class="center-text blue-text" width="25%">Signature</th>
                                    </tr>
                                </table>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <table class="table table-condensed table-bordered" role="table">
                                    @php $sno = '1'; @endphp
                                    @foreach($applications as $app)
                                        <tr>
                                            <th class="center-text blue-text" width="7%">{{ $sno }}</th>
                                            <th class="center-text blue-text" width="15%">
                                                <img src="{{asset('/files/enrolment/photos')}}/{{ $app->candidate->photo }}"  style="width: 60px;" class="img" />
                                            </th>
                                            <th class="center-text blue-text" width="18%">{{ $app->candidate->enrolmentno }}</th>
                                            <th class="center-text blue-text" width="35%">{{ $app->candidate->name }}</th>
                                            <th class="center-text blue-text" width="25%"></th>
                                        </tr>
                                        @php $sno++; @endphp
                                    @endforeach
                                </table>
                            </tr>
                            </tbody>
                            <thead>
                            <table class="table table-condensed table-borderless" role="table">
                                <tr>
                                    <th class="left-text">
                                        <br>
                                        Name and Signature of Internal Examiner<br>
                                        Mobile No.:<br>
                                        Email Id:
                                    </th>
                                    <th class="left-text">
                                        <br>
                                        Name and Signature of External Examiner<br>
                                        Mobile No.:<br>
                                        Email Id:
                                    </th>
                                </tr>
                                <tr>
                                    <th class="left-text">
                                        <br>
                                        <br>
                                        Signature of the Course Coordinator
                                    </th>
                                    <th class="left-text">
                                        <br>
                                        <br>
                                        Date and Seal of the TTI's
                                    </th>
                                </tr>
                            </table>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection