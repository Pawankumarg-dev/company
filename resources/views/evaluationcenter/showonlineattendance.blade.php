@extends('layouts.evaluationcenter')
@section('content')
    @php
        use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
    @endphp

    <style>
        @media print {
            #printPageButton {
                display: none;
            }
            #noprint {
                display: none;
            }
            .noprint {
                display: none;
            }
            a[href]:after {
                display: none;
                visibility: hidden;
            }
        }
    </style>

    <header class="noprint">
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

    <section class="noprint">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 well well-sm darkblue-background minus15px-margin-top">
                    <div class="center-text bold-text">

                        {{$title}}

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="noprint">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="table-responsive">
                        <table class="table table-bordered table-condensed">
                            <tr>
                                <th class="center-text" colspan="2">Evaluation Center Information</th>
                            </tr>
                            <tr>
                                <th width="6%">Code</th>
                                <td>{{ $evaluationcenter->code }}</td>
                            </tr>
                            <tr>
                                <th width="6%">Name</th>
                                <td>{{ $evaluationcenter->name }}</td>
                            </tr>
                            <tr>
                                <th width="6%">Address</th>
                                <td>{{ $evaluationcenter->address }}, {{ $evaluationcenter->state }} - {{ $evaluationcenter->pincode }}.</td>
                            </tr>
                            <tr>
                                <th width="10%">State / Region</th>
                                <td class="red-text bold-text">{{ $remarks }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <form class="form-horizontal" role="form" method="POST"
          action="{{ url('/evaluationcenter/onlineattendance/updateonlineattendance') }}" autocomplete="off" accept-charset="UTF-8"
          onsubmit="return validateForm()">

        {{ csrf_field() }}

        <input type="hidden" id="exam_id" name="exam_id" value="{{ $exam->id }}" />
        <input type="hidden" id="evaluationcenter_id" name="evaluationcenter_id" value="{{ $evaluationcenter->id }}" />
        <input type="hidden" id="bundle_number" name="bundle_number" value="{{ $common->bundle_number }}" />

        <section>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 well well-sm white-background minus15px-margin-top">

                        <div class="table-responsive">
                            <table class="table table-bordered table-condensed table-hover">
                                <tr>
                                    <th class="right-text" colspan="10">
                                        <a href="{{ url('/evaluationcenter/onlineattendance/updateonlineattendanceform/'.$evaluationcenter->id.'/'.$exam->id.'/'.$common->bundle_number) }}" class="btn btn-primary">
                                            <span class="glyphicon glyphicon-pencil"></span>&nbsp; Update Attendance
                                        </a>
                                    </th>
                                </tr>
                                <tr>
                                    <th class="red-text bold-text right-text" colspan="8">
                                        Bundle No.:
                                    </th>
                                    <th class="red-text bold-text center-text" colspan="2">
                                        {{ $common->bundle_number }}
                                    </th>
                                </tr>
                                <tr class="green-background">
                                    <th class="center-text" width="3%">S. No.</th>
                                    <th class="center-text" width="5%">Exam Centre</th>
                                    <th class="center-text" width="5%">Study Centre</th>
                                    <th class="center-text" width="10%">Course</th>
                                    <th class="center-text" width="7%">Subject Code</th>
                                    <th class="center-text" width="7%">Enrolment No.</th>
                                    <th class="center-text" width="10%">Name</th>
                                    <th class="center-text" width="7%">Language</th>
                                    <th class="center-text" width="7%">Answer Booklet No.</th>
                                    <th class="center-text" width="7%">Reference No.</th>
                                </tr>

                                @php $sno = 1; $count = 0; @endphp
                                @foreach($markexamattendances as $markexamattendance)
                                    <input type="hidden" id="markexamattendance_id{{ $count }}" name="markexamattendance_id[{{ $count }}]" value="{{ $markexamattendance->id }}" />

                                    <tr>
                                        <td class="center-text blue-text">{{ $sno }}</td>
                                        <td class="center-text blue-text">{{ $markexamattendance->application->externalexamcenter->code }}</td>
                                        <td class="center-text blue-text">{{ $markexamattendance->approvedprogramme->institute->code }}</td>
                                        <td class="blue-text">{{ $markexamattendance->approvedprogramme->programme->course_name }}</td>
                                        <td class="blue-text">{{ $markexamattendance->application->subject->scode }}</td>
                                        <td class="blue-text">{{ $markexamattendance->application->candidate->enrolmentno }}</td>
                                        <td class="blue-text">{{ $markexamattendance->application->candidate->name }}</td>
                                        <td class="blue-text">
                                            {{ $markexamattendance->language->language }}
                                        </td>
                                        <td class="center-text blue-text bold-text">
                                            {{ $markexamattendance->answersheet_serialnumber }}
                                        </td>
                                        <td class="center-text green-text bold-text">
                                            @if(is_null($markexamattendance->dummy_number))
                                                <span class="label label-danger">NOT GENERATED</span>
                                            @else
                                                {{ $markexamattendance->dummy_number }}
                                            @endif
                                        </td>
                                    </tr>
                                    @php $sno++; $count++; @endphp
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>

    <script>

    </script>
@endsection


