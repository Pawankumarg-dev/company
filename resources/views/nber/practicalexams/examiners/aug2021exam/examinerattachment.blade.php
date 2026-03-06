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
                            $path= public_path()."/images/rci_logo.png";
                            $type = pathinfo($path, PATHINFO_EXTENSION);
                            $data = file_get_contents($path);
                            $base64_1 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                        @endphp

                        <img src="<?php echo $base64_1; ?>"  style="width: 100px; height: 80px" class="img" />
                    </td>
                    <td class="h8-text center-text">
                        <span class="h7-text bold-text">NATIONAL INSTITUTE FOR EMPOWERMENT OF PERSONS WITH MULITPLE DISABILITIES (DIVYANGJAN) [NIEPMD]</span><br>
                        (DEPT. OF EMPOWERMENT OF PERSONS WITH DISABILIITIES (DIVYANGJAN), MSJ&E, GoI)<br>
                        <span style="font-style: italic; text-decoration: underline;">Examination conducted on behalf of</span><br>
                        <span class="h7-text bold-text">NATIONAL BOARD OF EXAMINATION IN REHABILITATION (NBER)</span><br>
                        (An Adjunct Body of Rehabilitation Council of India, under Ministry of Social Justice and Empowerment)<br>
                    </td>
                    <td class="center-text" width="15%">
                        @php
                            $path= public_path()."/images/niepmd_logo.png";
                            $type = pathinfo($path, PATHINFO_EXTENSION);
                            $data = file_get_contents($path);
                            $base64_2 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                        @endphp

                        <img src="<?php echo $base64_2; ?>"  style="width: 100px; height: 80px" class="img" />
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm-6"><div class="pull-left">NIEPMD/NBER/RCI/Exam/2021-21/</div></div>
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
            Respected Sir/Madam,
        </div>
        <div class="col-sm-12">
            <table class="table table-borderless table-condensed">
                <tr>
                    <td class="right-text">Sub.:</td>
                    <td class="justified-text">
                        Appointment of External Examiner for External Practical Examination - August 2021 - reg.,
                    </td>
                </tr>
                <tr>
                    <td class="right-text">Ref.:</td>
                    <td class="justified-text">
                        {{--
                        File no. 25-1/NBER(Policy)/RCI/2016 dated: 23.10.2020.
                        --}}
                        <b>Circular-21/08</b> dated 30<span class="sup">th</span> June, 2021
                    </td>
                </tr>
                <tr>
                    <td class="center-text" colspan="3">*****</td>
                </tr>
            </table>
        </div>
        <div class="col-sm-12">
            <div class="justified-text">
                NIEPMD-NBER is pleased to appoint you as an external practical examiner for the RCI Diploma / Certificate courses for External Practical Examination - August 2021.
                The details are as follows:
            </div>
            <br>
            <table class="table table-bordered table-condensed" width="100%">
                <tr>
                    <td class="bold-text text-center" width="20%">Institute Name</td>
                    <td class="bold-text text-center" width="20%">Course</td>
                    <td class="bold-text text-center" width="20%">Exam Date</td>
                    <td class="bold-text text-center">Details</td>
                </tr>
                <tr>
                    <td>{{ $practicalexam->institute->name }}</td>
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
            You are kindly requested to contact the above mentioned institute in advance.
        </div>
        <div class="col-sm-12">
            <ol type="a">
                <li class="justified-text">
                    External practical examination shall be conducted with all necessary precautionary measure in view of COVID-19 (Such as Masks, Social distancing, Hand sanitization, etc…).
                </li>
                <li class="justified-text">
                    All students to produce their hall ticket before the practical examinations.
                </li>
                <li class="justified-text">
                    In case the number of students count varies with the students applied for Practical Examinations, kindly contact NIEPMD-NBER.
                </li>
                <li class="justified-text">
                    Ensure the presence of Internal Faculty throughout the practical examination.
                </li>
                <li class="justified-text">
                    After completion of the practical examination, enter the external practical marks in the prescribed format online mode.
                </li>
                <li class="justified-text">
                    The scanned copy of the External Practical Examinations marks should be sent through email by the external examiner on the same day with the signature of the internal examiner, external examiner and course coordinator with seal of the concerned institution. Email ID: kavitha.nber@gmail.com
                </li>
                <li class="justified-text">
                    The hard copy of the marks sheet of external practical examinations should be sent to NIEPMD-NBER through SpeedPost.
                </li>
                <li class="justified-text">
                    External practical examiner is required to retain a copy of the external practical marks for future reference.
                </li>
                <li class="justified-text">
                    Claim form for the external practical examiner should be filled and sent to NIEPMD-NBER by the Course Coordinator. The claim form & remuneration details enclosed for kind reference and available at <a href="http://www.niepmdexaminationsnber.com/" target="_blank">www.niepmdexaminationsnber.com</a>.
                </li>
                <li class="justified-text">
                    Payment to External Examiner will be done by NIEPMD-NBER directly.
                </li>
                <li class="justified-text">
                    Online Mark Entry of the Practical Examinations to be done on the same day.
                </li>
            </ol>
            <p class="justified-text">
                For further details and any queries contact Mrs. Kavitha Anilkumar, ADCE, NBER, NIEPMD, Ph.:9444086060, and Email: kavitha.nber@gmail.com.
            </p>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-borderless table-condensed" width="100%">
                    <tr>
                        <td width="80%"></td>
                        <td class="text-center" width="20%">
                            Sd/-<br>
                            <span class="bold-text">ADCE</span><br>
                            NIEPMD-NBER
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>