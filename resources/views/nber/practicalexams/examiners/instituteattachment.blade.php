<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>

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
        <div class="col-sm-6"><div class="pull-left">NIEPMD–NBER/Exam-July2022-3(12)/2022-23</div></div>
        <div class="col-sm-6"><div class="pull-right">{{ date("d") }}<span class="sup">{{ date("S") }}</span> {{ date(" F, Y.") }}</div></div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            To<br>
            The Head of the Institution / Course Coordinator,<br>
            {{ $practicalexam->institute->code }} - {{ $practicalexam->institute->name }}<br>
            Email: <b>{{ $practicalexam->institute->email }}</b>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-12">
            <table class="table table-borderless table-condensed">
                <tr>
                    <td class="right-text">Sub.:</td>
                    <td class="justified-text">
                        Appointment of External Examiner for External Practical Exam - {{$practicalexaminer->practicalexam->exam->name}} Examinations - reg.,
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
                                Circular No. 07/22, dated 23.05.2022
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
               NIEPMD-NBER has appointed the External Practical Examiners for the RCI Diploma / Certificte courses for External Practical Examination - {{$practicalexaminer->practicalexam->exam->name}}. The details are as follows:
            </div>
            <br>
            <table class="table table-bordered table-condensed" width="100%">
                <tr>
                    <td class="bold-text center-text" width="30%">Name of the External Examiner</td>
                    <td class="bold-text center-text" width="20%">Exam Date(s)</td>
                    <td class="bold-text center-text" width="20%">Course</td>
                    <td class="bold-text center-text">Details</td>
                </tr>
                <tr>
                    <td>{{ $practicalexaminer->name }}</td>
                    <td class="text-center">
                        {{ $practicalexam->exam_date->format("d-m-Y") }} @if(!is_null($practicalexam->exam_date2))<br>-<br>{{ $practicalexam->exam_date2->format("d-m-Y") }}@endif
                    </td>
                    <td class="text-center">{{ $practicalexam->common_code }}</td>
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
            You are kindly requested to contact the above mentioned External examiner.<br>
            Note: In case the number of students count varies with the students applied for Practical Examinations, kindly contact NIEPMD-NBER.
        </div>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-borderless table-condensed" width="100%">
                    <tr>
                        <td width="60%"></td>
                        <td class="text-center" width="40%">
                            Yours Sincerely,<br>
                            Sd/-<br>
                            <span class="bold-text">I/c NBER<br>NIEPMD, Chennai</span><br>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>