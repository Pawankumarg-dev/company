<!DOCTYPE html>
<html lang="">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Appointment Letter</title>

    <link rel="stylesheet" href=""{{asset('css\3.3.6\bootstrap.min.css')}}">
    <style>
        .table-borderless > tbody > tr > td,
        .table-borderless > tbody > tr > th,
        .table-borderless > tfoot > tr > td,
        .table-borderless > tfoot > tr > th,
        .table-borderless > thead > tr > td,
        .table-borderless > thead > tr > th {
            border: none;
        }

        .bold-text {
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

        .justified-text {
            text-align: justify;
            text-justify: inter-word;
        }

        .medium-text {
            font-size: medium;
        }

        .h5-text {
            font-size: 20px;
            font-weight: bold;
        }
        .h6-text {
            font-size: 15px;
        }
        .h7-text {
            font-size: 12px;
        }
        .h8-text {
            font-size: 10px;
        }
        .sup {
            font-size: 60%;
            vertical-align: super;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <table border="0" cellpadding="5" cellspacing="0" width="100%">
                <tr>
                    <td class="center-text" width="15%">
                        @php
                            $path= public_path()."/images/niepmd_logo.png";
                            $type = pathinfo($path, PATHINFO_EXTENSION);
                            $data = file_get_contents($path);
                            $base64_2 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                        @endphp

                        <img src="<?php echo $base64_2; ?>"  style="width: 100px; height: 80px" class="img" />
                    </td>
                    <td class="h8-text center-text">
                        <span class="h7-text bold-text">NATIONAL INSTITUTE FOR EMPOWERMENT OF PERSONS WITH MULITPLE DISABILITIES (DIVYANGJAN) [NIEPMD]</span><br>
                        (DEPT. OF EMPOWERMENT OF PERSONS WITH DISABILIITIES (DIVYANGJAN), MSJ&E, GoI)<br>
                        <span style="font-style: italic; text-decoration: underline;">Examination conducted on behalf of</span><br>
                        <span class="h7-text bold-text">NATIONAL BOARD OF EXAMINATION IN REHABILITATION (NBER)</span><br>
                        (An Adjunct Body of Rehabilitation Council of India, under Ministry of Social Justice and Empowerment)<br>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm-6"><div class="pull-left">NIEPMD-NBER/Exam.Prac.3(1)/2021-22</div></div>
        <div class="col-sm-6"><div class="pull-right">{{ date("d") }}<span class="sup">{{ date("S") }}</span> {{ date(" F, Y.") }}</div></div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            To<br>
            {{ $practicalexaminer->title->title }} {{ $practicalexaminer->name }}<br>
            {{ $practicalexaminer->address }}, {{ $practicalexaminer->city->name }},
            {{ $practicalexaminer->city->state->state_name }}-{{ $practicalexaminer->pincode }}<br>
            Mobile No.: <b>{{ $practicalexaminer->contactnumber }}</b><br>
            Whatsapp No.: <b>{{ $practicalexaminer->whatsappnumber }}</b><br>
            Email: <b>{{ $practicalexaminer->email }}</b>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-12">
            <table class="table table-borderless table-condensed">
                <tr>
                    <td class="right-text">Sub.:</td>
                    <td class="justified-text">
                        Appointment of External Examiner for External Practical Examination - {{$practicalexaminer->practicalexam->exam->name}} - reg.,
                    </td>
                </tr>
                <tr>
                    <td class="right-text">Ref.:</td>
                    <td class="justified-text">
                        <ol>
                            <li>
                                RCI - Scheme of Examinations - 2018
                            </li>
                            <li>
                                Circular No. 21/24, dated 27.10.2021
                            </li>
                        </ol>
                    </td>
                </tr>
                <tr>
                    <td class="center-text" colspan="3">*****</td>
                </tr>
            </table>
        </div>
        <div class="col-sm-12">
            Respected Sir/Madam,
        </div>
        <div class="col-sm-12">
            <div class="justified-text">
                NIEPMD-NBER is pleased to appoint you as the "<b>External Practical Examiner</b>" for the RCI Diploma / Certificate courses scheduled for <b>November / December 2021</b>. The details are as follows:
            </div>
            <br>
            <table class="table table-bordered table-condensed" width="100%">
                <tr>
                    <td class="bold-text text-center" width="40%">Institute</td>
                    <td class="bold-text text-center" width="20%">Course</td>
                    <td class="bold-text text-center" width="20%">Exam Date</td>
                    <td class="bold-text text-center">Details</td>
                </tr>
                <tr>
                    <td>
                        {{ $practicalexam->institute->code}} - {{ $practicalexam->institute->name }}<br>
                        {{ $practicalexam->institute->street_address }}<br>
                        @if($practicalexam->institute->city_id != 0)
                            {{ $practicalexam->institute->city->name }}, {{ $practicalexam->institute->city->state->state_name }}
                        @endif
                        @if($practicalexam->institute->pincode != '') - {{$practicalexam->institute->pincode}}. @endif<br>
                        @if($practicalexam->institute->landmark != '') <br>LANDMARK - {{ strtoupper($practicalexam->institute->landmark)}} @endif
                        @if($practicalexam->institute->email != '') <br>Email - {{ $practicalexam->institute->email}} @if($practicalexam->institute->email2 != ''), Email - {{ $practicalexam->institute->email2}} @endif @endif
                        @if($practicalexam->institute->contactnumber1 != '') <br>Contact No. - {{ $practicalexam->institute->contactnumber1}} @if($practicalexam->institute->contactnumber2 != ''), {{ $practicalexam->institute->contactnumber2}} @endif @endif
                    </td>
                    <td class="text-center">{{ $practicalexam->common_code }}</td>
                    <td class="text-center">
                        {{ $practicalexam->exam_date->format("d-m-Y") }} @if(!is_null($practicalexam->exam_date2))<br>-<br>{{ $practicalexam->exam_date2->format("d-m-Y") }}@endif
                    </td>
                    <td>
                        <table class="table table-bordered table-condensed" width="100%">
                            <tr>
                                <th class="text-center">Batch</th>
                                <th class="text-center">No. of Students</th>
                            </tr>
                            @foreach($practicalexamfeedetails as $detail)
                                <tr>
                                    <td class="text-center">{{ $detail->approvedprogramme->academicyear->year }}</td>
                                    <td class="text-center">{{ $detail->candidate_count }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-sm-12">
            <ol type="a">
                <li class="justified-text">
                    External practical examination shall be conducted with all necessary precautionary measure in view of COVID-19 (Masks, Social distancing, Hand sanitization, etc…).
                </li>
                <li class="justified-text">
                    All officials involved in Examination process ensure COVID-19 vaccination(s).
                </li>
                <li class="justified-text">
                    Students should report for Practical Examinations with their Hall Ticket.
                </li>
                <li class="justified-text">
                    In case the number of students count varies with the list of students applied for Practical Examinations, please contact NIEPMD-NBER immediately.
                </li>
                <li class="justified-text">
                    Ensure the presence of Internal Faculty throughout the Practical Examination.
                </li>
                <li class="justified-text">
                    Enter the External Practical marks and attendance through online mode.
                </li>
                <li class="justified-text">
                    The scanned copy of the External Practical Examinations marks should be sent through email (nber.exam@gmail.com) by the external examiner on the same day along with the signature of the Internal Examiner, External Examiner and the Course Coordinator. Ensure seal of the concerned institution.
                </li>
                <li class="justified-text">
                    Hard copy of the External Practical Examinations need to be sent to NIEPMD-NBER.
                </li>
                <li class="justified-text">
                    External Examiner are requested to retain a copy of the external practical marks.
                </li>
                <li class="justified-text">
                    Claim form for the external practical examiner should be filled and sent to NIEPMD-NBER by the Course Coordinator within 15 days after completion of the Examinations. The claim form & remuneration details enclosed for kind reference and available at www.niepmdexaminationsnber.com.
                </li>
                <li class="justified-text">
                    Payment to External Examiner will be made from NIEPMD-NBER directly.
                </li>
            </ol>
            <p class="justified-text">
                You are kindly requested to contact the above mentioned institute in advance and conduct the practical examinations. Best practices need to be documented and send to NIEPMD-NBER, Chennai.
            </p>
            <p class="justified-text">
                For further details and any queries contact Mr.M.Gunasekaran, Consultant, NIEPMD-NBER, <b>Ph.:8056832302</b>, and Email: <b>nber.exam@gmail.com.</b>
            </p>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-borderless table-condensed" width="100%">
                    <tr>
                        <td width="60%"></td>
                        <td class="text-center" width="40%">
                            Yours Sincerely,<br>
                            Sd/-<br>
                            <span class="bold-text">I/c – NBER / Lecturer, AIL</span><br>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-borderless table-condensed" width="100%">
                    <tr>
                        <td width="80%">
                            <p>Enclosures:</p>
                            <ol>
                                <li>Claim forms</li>
                                <li>SoP for Practical Examinations</li>
                                <li>Mark Entry form</li>
                            </ol>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

</div>
</body>
</html>