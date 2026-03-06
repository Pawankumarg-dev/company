<!DOCTYPE html>
<html>
<head>
    <title>Course Coordinator Information</title>
    <style>
        @media print {
            #printPageButton {
                display: none;
            }
        }
        .page-break {
            page-break-after: always;
        }
        .table-borderless > tbody > tr > td,
        .table-borderless > tbody > tr > th,
        .table-borderless > tfoot > tr > td,
        .table-borderless > tfoot > tr > th,
        .table-borderless > thead > tr > td,
        .table-borderless > thead > tr > th {
            border: none;
        }
        @media print {
            #printPageButton {
                display: none;
            }
        }

        .equal-height-row {
            display: flex;
        }

        .minus15px-margin-top {
            margin-top: -15px !important;
        }

        .white-background {
            background-color: white;
            color: black;
        }

        .black-background {
            background-color: black;
            color: white;
        }

        .red-background {
            background-color: red !important;
            color: white !important;
        }

        .ghostwhite-background {
            background-color: ghostwhite;
            color: deepskyblue;
        }

        .darkblue-background {
            background-color: darkblue;
            color: white;
        }

        .green-background {
            background: green !important;
            color: white !important;
        }

        .grey-background {
            background: #EEEEEE;
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

        .green-text {
            color: darkgreen;
        }

        .red-text {
            color: red;
        }

        .blue-text {
            color: blue;
        }

        .brown-text {
            color: brown;
        }

        .yellow-text {
            color: yellow;
        }

        .icon-text {
            font-size: 30px;
        }

        .large-text {
            font-size: large;
        }

        .footer {
            background: #3fc3ee;
            color: white;
        }

        td, th {
            vertical-align: middle !important;
        }

        . {
            display: flex; /* equal height of the children */
        }
        .page-break {
            page-break-after: always;
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

        .red-button {
            background-color: red !important;
            color: white !important;
        }

        .red-button:focus,
        .red-button:hover {
            background-color: indianred !important;
            border-color: indianred !important;
            color: white !important;
        }
    </style>
</head>
<body>
<div class="right-text">
    <p>
        <button type="button" onclick="window.print();return false;" id="printPageButton">Print</button>
    </p>
</div>

<div class="page-break">
    <table border="1" cellpadding="5" cellspacing="0" width="100%">
        <tr>
            <td>
                <table border="0" cellpadding="5" cellspacing="0" width="100%">
                    <tr>
                        <td class="center-text" width="15%">
                            <img src="{{asset('/images/rci_logo.png')}}"  style="width: 100px; height: 80px" class="img" />
                        </td>
                        <td class="h8-text center-text">
                            <span class="h7-text bold-text">NATIONAL INSTITUTE FOR EMPOWERMENT OF PERSONS WITH MULITPLE DISABILITIES (DIVYANGJAN) [NIEPMD]</span><br>
                            (DEPT. OF EMPOWERMENT OF PERSONS WITH DISABILIITIES (DIVYANGJAN), MSJ&E, GoI)<br>
                            <span style="font-style: italic">Examination conducted on behalf of</span><br>
                            <span class="h7-text bold-text">NATIONAL BOARD OF EXAMINATION IN REHABILITATION (NBER)</span><br>
                            (An Adjunct Body of Rehabilitation Council of India, under Ministry of Social Justice and Empowerment)<br>
                        </td>
                        <td class="center-text" width="15%">
                            <img src="{{asset('/images/niepmd.png')}}"  style="width: 65px;" class="img" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="medium-text center-text bold-text">
                COURSE COORDINATOR INFORMATION
            </td>
        </tr>
        <tr>
            <td>
                <table border="0" cellpadding="5" cellspacing="0" width="100%">
                    <tr>
                        <td class="medium-text center-text">
                            {{ $approvedcoursecoordinator->institute->code }} - {{ $approvedcoursecoordinator->institute->name }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table border="0" cellpadding="5" cellspacing="0" width="100%">
                    <tr>
                        <th class="medium-text center-text bold-text" colspan="3">Personal Details</th>
                    </tr>
                    <tr>
                        <td class="medium-text left-text" width="19%">
                            Name
                        </td>
                        <td class="medium-text center-text" width="1%">
                            :
                        </td>
                        <td class="medium-text left-text">
                            {{ $approvedcoursecoordinator->coursecoordinator->title->title }} {{ $approvedcoursecoordinator->coursecoordinator->name }}
                        </td>
                    </tr>
                    <tr>
                        <td class="medium-text left-text" width="19%">
                            {{ $approvedcoursecoordinator->coursecoordinator->relationtype->name }}'s Name
                        </td>
                        <td class="medium-text center-text" width="1%">
                            :
                        </td>
                        <td class="medium-text left-text">
                            {{ $approvedcoursecoordinator->coursecoordinator->relationname }}
                        </td>
                    </tr>
                    <tr>
                        <td class="medium-text left-text" width="19%">
                            Date of Birth
                        </td>
                        <td class="medium-text center-text" width="1%">
                            :
                        </td>
                        <td class="medium-text left-text">
                            {{ $approvedcoursecoordinator->coursecoordinator->dob->format('d-m-Y') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="medium-text left-text" width="19%">
                            Gender
                        </td>
                        <td class="medium-text center-text" width="1%">
                            :
                        </td>
                        <td class="medium-text left-text">
                            {{ $approvedcoursecoordinator->coursecoordinator->gender->gender }}
                        </td>
                    </tr>
                    <tr>
                        <td class="medium-text left-text" width="19%">
                            Disability Status
                        </td>
                        <td class="medium-text center-text" width="1%">
                            :
                        </td>
                        <td class="medium-text left-text">
                            {{ $approvedcoursecoordinator->coursecoordinator->disability_status }}
                            @if($approvedcoursecoordinator->coursecoordinator->disability_status == 'Yes')
                                (Type: {{ $approvedcoursecoordinator->coursecoordinator->disability_type }},
                                Certificate No.: {{ $approvedcoursecoordinator->coursecoordinator->disabilitycertificate_number }})
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="medium-text left-text" width="19%">
                            Aadhaar Card No.
                        </td>
                        <td class="medium-text center-text" width="1%">
                            :
                        </td>
                        <td class="medium-text left-text">
                            {{ $approvedcoursecoordinator->coursecoordinator->aadhaarcard_number }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table border="0" cellpadding="5" cellspacing="0" width="100%">
                    <tr>
                        <th class="medium-text center-text bold-text" colspan="3">Communication Details</th>
                    </tr>
                    <tr>
                        <td class="medium-text left-text" width="19%">
                            Mobile No(s).
                        </td>
                        <td class="medium-text center-text" width="1%">
                            :
                        </td>
                        <td class="medium-text left-text">
                            @if(!is_null($approvedcoursecoordinator->coursecoordinator->mobile_number2))
                                {{ $approvedcoursecoordinator->coursecoordinator->mobile_number1 }}, {{$approvedcoursecoordinator->coursecoordinator->mobile_number2}}
                            @else
                                {{ $approvedcoursecoordinator->coursecoordinator->mobile_number1 }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="medium-text left-text" width="19%">
                            WhatsApp No.
                        </td>
                        <td class="medium-text center-text" width="1%">
                            :
                        </td>
                        <td class="medium-text left-text">
                            {{ $approvedcoursecoordinator->coursecoordinator->whatsapp_number }}
                        </td>
                    </tr>
                    <tr>
                        <td class="medium-text left-text" width="19%">
                            Email Address(es)
                        </td>
                        <td class="medium-text center-text" width="1%">
                            :
                        </td>
                        <td class="medium-text left-text">
                            @if(!is_null($approvedcoursecoordinator->coursecoordinator->email_address2))
                                {{ $approvedcoursecoordinator->coursecoordinator->email_address1 }}, {{$approvedcoursecoordinator->coursecoordinator->email_address2}}
                            @else
                                {{ $approvedcoursecoordinator->coursecoordinator->email_address1 }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="medium-text left-text" width="19%">
                            Present Address
                        </td>
                        <td class="medium-text center-text" width="1%">
                            :
                        </td>
                        <td class="medium-text left-text">
                            {{ $approvedcoursecoordinator->coursecoordinator->address }}, {{ $approvedcoursecoordinator->coursecoordinator->city->name }},
                            {{ $approvedcoursecoordinator->coursecoordinator->city->state->state_name }} - {{ $approvedcoursecoordinator->coursecoordinator->pincode }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table border="0" cellpadding="5" cellspacing="0" width="100%">
                    <tr>
                        <th class="medium-text center-text bold-text" colspan="3">{{$approvedcoursecoordinator->coursecoordinator->coursecoordinatorcoursetype->council_name}} ({{$approvedcoursecoordinator->coursecoordinator->coursecoordinatorcoursetype->council_code}}) - Registration Number Details</th>
                    </tr>
                    <tr>
                        <td class="medium-text left-text" width="19%">
                            {{$approvedcoursecoordinator->coursecoordinator->coursecoordinatorcoursetype->certificate_code}}
                        </td>
                        <td class="medium-text center-text" width="1%">
                            :
                        </td>
                        <td class="medium-text left-text">
                            {{$approvedcoursecoordinator->coursecoordinator->registration_number}}
                        </td>
                    </tr>
                    <tr>
                        <td class="medium-text left-text" width="19%">
                            Validity Duration
                        </td>
                        <td class="medium-text center-text" width="1%">
                            :
                        </td>
                        <td class="medium-text left-text">
                            {{ $approvedcoursecoordinator->coursecoordinator->registration_year }} - {{ $approvedcoursecoordinator->coursecoordinator->expiration_year }}  (in years)
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table border="0" cellpadding="5" cellspacing="0" width="100%">
                    <tr>
                        <th class="medium-text center-text bold-text" colspan="3">Present Working Details</th>
                    </tr>

                    <tr>
                        <td class="medium-text left-text" width="19%">
                            Course Coordinator for
                        </td>
                        <td class="medium-text center-text" width="1%">
                            :
                        </td>
                        <td class="medium-text left-text">
                            {{$approvedcoursecoordinator->programme->common_name}} - {{$approvedcoursecoordinator->programme->common_code}}
                        </td>
                    </tr>
                    <tr>
                        <td class="medium-text left-text" width="19%">
                            Date of Joining
                        </td>
                        <td class="medium-text center-text" width="1%">
                            :
                        </td>
                        <td class="medium-text left-text">
                            {{ $approvedcoursecoordinator->joining_date->format('d-m-Y') }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
<div class="page-break">
    <table border="1" cellpadding="5" cellspacing="0" width="100%">
        <tr>
            <td>
                <table border="0" cellpadding="5" cellspacing="0" width="100%">
                    <tr>
                        <th class="medium-text center-text bold-text">Educational Qualification Details</th>
                    </tr>
                </table>
                <table border="1" cellpadding="5" cellspacing="0" width="100%">
                    @php
                        $qualifications = \App\Coursecoordinatoreducationalqualification::where('coursecoordinator_id', $approvedcoursecoordinator->coursecoordinator_id)->get();
                        $sno = '1';
                    @endphp
                    <tr>
                        <th class="medium-text left-text" width="2%">S.No.</th>
                        <th class="medium-text left-text" width="10%">Course</th>
                        <th class="medium-text left-text" width="10%">Institute</th>
                        <th class="medium-text left-text" width="5%">Completion Year</th>
                    </tr>
                    @foreach($qualifications as $q)
                        <tr>
                            <td class="medium-text left-text">{{ $sno }}</td>
                            <td class="medium-text left-text">{{ $q->coursecoordinatorcourse->course_code }}</td>
                            <td class="medium-text left-text">{{ $q->institute_name }}, {{ $q->state->state_name }}</td>
                            <td class="medium-text left-text">{{ $q->completion_year }}</td>
                        </tr>
                        @php $sno++; @endphp
                    @endforeach
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table border="0" cellpadding="5" cellspacing="0" width="100%">
                    <tr>
                        <th class="medium-text center-text bold-text">Past Teaching Work Experience Details</th>
                    </tr>
                </table>
                <table border="1" cellpadding="5" cellspacing="0" width="100%">
                    @php
                        $pastexperiences = \App\Coursecoordinatorpastteachingexperience::where('coursecoordinator_id', $approvedcoursecoordinator->coursecoordinator_id)->get();
                        $sno = '1';
                    @endphp
                    <tr>
                        <th class="medium-text left-text" width="2%">S.No.</th>
                        <th class="medium-text left-text" width="10%">Designation</th>
                        <th class="medium-text left-text" width="10%">Institute</th>
                        <th class="medium-text left-text" width="10%">Date of Joining</th>
                        <th class="medium-text left-text" width="10%">Date of Relieving</th>
                    </tr>
                    @foreach($pastexperiences as $p)
                        <tr>
                            <td class="medium-text left-text">{{ $sno }}</td>
                            <td class="medium-text left-text">{{ $p->designation }}</td>
                            <td class="medium-text left-text">{{ $p->institute_name }}, {{ $p->state->state_name }}</td>
                            <td class="medium-text left-text">{{ $p->joining_date->format('d-m-Y') }}</td>
                            <td class="medium-text left-text">{{ $p->relieving_date->format('d-m-Y') }}</td>
                        </tr>
                        @php $sno++; @endphp
                    @endforeach
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table border="0" cellpadding="5" cellspacing="0" width="100%">
                    <tr>
                        <th class="medium-text center-text bold-text">Language(s) Known Details</th>
                    </tr>
                </table>
                <table border="1" cellpadding="5" cellspacing="0" width="75%" align="center">
                    @php
                        $languagesknown = \App\Coursecoordinatorknownlanguage::where('coursecoordinator_id', $approvedcoursecoordinator->coursecoordinator_id)->where('active_status', '1')->get();
                        $sno = '1';
                    @endphp
                    <tr>
                        <th class="medium-text left-text" width="2%">S.No.</th>
                        <th class="medium-text left-text" width="10%">Language</th>
                        <th class="medium-text center-text" width="10%">Read</th>
                        <th class="medium-text center-text" width="10%">Write</th>
                        <th class="medium-text center-text" width="10%">Speak</th>
                    </tr>
                    @foreach($languagesknown as $l)
                        <tr>
                            <td class="medium-text left-text">{{ $sno }}</td>
                            <td class="medium-text left-text">{{ $l->language->language }}</td>
                            <td class="medium-text center-text">@if($l->read_status == '1') &#10003;@endif</td>
                            <td class="medium-text center-text">@if($l->read_status == '1') &#10003;@endif</td>
                            <td class="medium-text center-text">@if($l->read_status == '1') &#10003;@endif</td>
                        </tr>
                        @php $sno++; @endphp
                    @endforeach
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table border="0" cellpadding="5" cellspacing="0" width="100%">
                    <tr>
                        <th class="medium-text center-text bold-text"><u>Head of the Institute (HoI)</u></th>
                    </tr>
                    <tr>
                        <td class="medium-text justified-text">
                            I, <b>{{ $approvedcoursecoordinator->institute->institutehead->name }}, {{ $approvedcoursecoordinator->institute->institutehead->designation }}</b>, of the Institute, certify that the above entered information for the Course Coordinator are found to be true/genuine.
                        </td>
                    </tr>
                </table>

                <table border="0" cellpadding="5" cellspacing="0" width="100%">
                    <tr>
                        <th class="left-text" height="50px" style="vertical-align: bottom !important;">Date :</th>
                        <th class="center-text" height="50px" style="vertical-align: bottom !important;">Seal of the Institute</th>
                        <th class="right-text" height="50px" style="vertical-align: bottom !important;">Signature of the HoI</th>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>

</body>
</html>