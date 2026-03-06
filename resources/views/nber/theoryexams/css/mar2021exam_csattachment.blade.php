<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
        <div class="col-sm-6 h7-text"><div class="pull-left bold-text">NIEPMD/NBER-RCI/ March / EXAM-{{$cstype}} </div></div>
        <div class="col-sm-6 h7-text"><div class="pull-right bold-text">{{ date("d") }}<span class="sup">{{ date("S") }}</span> {{ date(" F, Y.") }}</div></div>
    </div>
    <div class="row">
        <div class="col-sm-12 h7-text">
            To<br>
            <b>{{ $cs->title->title }} {{ $cs->name }}</b><br>
            Mobile No.: <b>{{ $cs->contactnumber1 }} @if(!is_null($cs->contactnumber2))/ {{ $cs->contactnumber2 }}@endif</b><br>
            Email: <b>{{ $cs->email1 }} @if(!is_null($cs->email2))/ {{ $cs->email2 }}@endif</b>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-12 h7-text">
            <table class="table table-borderless table-condensed">
                <tr>
                    <td class="right-text">Sub.:</td>
                    <td class="justified-text">
                        Appointment of @if($cstype == 'CS') Centre Superintendent @else Exam Centre Incharge @endif ({{ $cstype }}) for March 2021 Examinations
                        for RCI recognized courses - reg.,
                    </td>
                </tr>
                <tr>
                    <td class="center-text" colspan="3">*****</td>
                </tr>
            </table>
            Respected Sir/Madam,
            <div class="col-sm-12">
                <div class="left-text">
                    <span class="bold-text" style="font-style: italic;">Greetings from NIEPMD-NBER!</span>
                </div>
                <div class="justified-text">
                    As per the direction of RCI, NIEPMD-NBER has scheduled to conduct the year end examinations for the following courses D.Ed. Spl. of (ID, MR, CP, ASD) and DRT from <b>1<span class="sup">st</span> March to 6<span class="sup">th</span> March 2021</b> from <b>2 pm to 5 pm</b>.<br>
                    Consequent upon expression of your interest; NIEPMD - NBER is pleased to appoint you as the @if($cstype == 'CS') Centre Superintendent @else Exam Centre Incharge @endif in the following examination centre:
                </div>
                <br>
                <table border="2" class="table table-bordered table-condensed" width="100%">
                    <tr>
                        <td class="bold-text text-center" width="10%">Exam Centre Code</td>
                        <td class="bold-text text-center" width="60%">Name and Address of the Examination Center</td>
                        <td class="bold-text text-center" width="20%">Date of Examination</td>
                    </tr>
                    <tr>
                        <td class="text-center">{{ $cs->externalexamcenter->code }}</td>
                        <td class="text-center">
                            {{ $cs->externalexamcenter->name }}<br>
                            {{ $cs->externalexamcenter->address }}
                            @if($cs->externalexamcenter->district != ''), {{ $cs->externalexamcenter->district }} @endif
                            @if($cs->externalexamcenter->state != ''), {{ $cs->externalexamcenter->state }} @endif
                            @if($cs->externalexamcenter->pincode != '')- {{ $cs->externalexamcenter->pincode }} @endif<br>
                            Contact No.: {{ $cs->externalexamcenter->contactnumber1 }} @if($cs->externalexamcenter->contactnumber2 != '')/ {{ $cs->externalexamcenter->contactnumber2 }} @endif<br>
                            Email: {{ $cs->externalexamcenter->email1 }}@if($cs->externalexamcenter->email2 != '')/ {{ $cs->externalexamcenter->email2 }} @endif

                        </td>
                        <td class="text-center">
                            01<span class="sup">st</span> March<br>
                            to<br>
                            06<span class="sup">th</span> March 2021<br>
                            2pm to 5 pm
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-12 justified-text">
                Ensure all the student trainees wear mask, follow physical distancing and maintain hand hygiene. You are advised to submit the <b><u>Online Daily Reports & Online Attendance Sheet</u></b> of the Examinations in the prescribed format.
                <br>
            </div>
            <br>
            <div class="col-sm-12 justified-text">
                You are requested to <b><u>give your consent letter</u></b> by return mail along with the duly signed in the mail. For any clarification please to contact:
                <b><u>Dr. B. Bharath Narayanan, ACE- NBER- NIEPMD, Chennai  (0908 9545 339)</u></b>.
            </div>
            <br>
            <div class="col-sm-12 justified-text">
                <b><u>COVID 19 pandemic situation and austerity measures to be followed for conducting the examinations process smoothly.</u></b>

            </div>
            <br>
            <div class="col-sm-12 h7-text center-text">
                Thank you
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 h7-text">
                <table class="table table-borderless table-condensed" width="100%">
                    <tr>
                        <td width="80%"></td>
                        <td class="text-center" width="20%">
                            Yours Sincerely,<br>
                            Sd/-<br>
                            <span class="bold-text">ADCE</span><br>
                            NIEPMD-NBER
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 h7-text">
                <b>Copy to: The State Nodal Officer</b><br>
                @if($cstype == 'CS')
                    <i>NOTE: CS honorarium will be settled by NIEPMD NBER</i>
                @else
                    <i>NOTE: ECI honorarium will be paid</i>
                @endif
            </div>
        </div>
    </div>
</div>
</body>
</html>