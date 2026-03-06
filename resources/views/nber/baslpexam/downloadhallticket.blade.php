<!DOCTYPE html>
<html>
<head>
    <title>{{ $examcenterdetail->baslpcandidate->roll_no }} - BASLP NET {{ $examcenterdetail->baslpexam->date->format('Y') }} Hall ticket</title>
    <style>
        @media print {
            #printPageButton {
                display: none;
            }
        }

        .grey-background {
            background: #EEEEEE;
        }

        .page-break {
            page-break-after: always;
        }
        .bold-text {
            font-weight: bold;
        }
        .underline-text {
            text-decoration: underline;
        }
        .blue-text {
            color: blue;
        }
        .red-text {
            color: red;
        }
        .green-text {
            color: green;
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
        .left-text{
            text-align: left !important;
        }
        .right-text{
            text-align: right !important;
        }
        .center-text{
            text-align: center !important;
        }
        .courier_new_font{
            font-family: "Courier New", Courier, "Lucida Sans Typewriter", "Lucida Typewriter", monospace;
        }
    </style>
</head>
<body>
<div class="right-text">
    <p>
        <button type="button" onclick="window.print();return false;" id="printPageButton">Print</button>
    </p>
</div>


<section>
    <div class="page-break">
        <table border="1" cellpadding="5" cellspacing="0" width="100%">
            <tr>
                <td>

                    <table border="0" cellpadding="3" cellspacing="0" width="100%">
                        <tr>
                            <td class="right-text" width="5%">
                                <img src="{{asset('/images/niepmd.png')}}"  style="width: 60px;" class="img" />
                            </td>
                            <td class="h8-text">
                                <span class="h7-text bold-text">NATIONAL INSTITUTE FOR EMPOWERMENT OF PERSONS WITH MULITPLE DISABILITIES (DIVYANGJAN) [NIEPMD]</span><br>
                                (DEPT. OF EMPOWERMENT OF PERSONS WITH DISABILIITIES (DIVYANGJAN), MSJ&E, GOVT. OF INDIA)<br>
                                <span class="h7-text bold-text">NATIONAL BOARD OF EXAMINATION IN REHABILITATION (NBER)</span><br>
                                (An Adjunct Body of Rehabilitation Council of India, under Ministry of Social Justice and Empowerment)<br>
                                ECR, Muttukadu, Kovalam Post, Chennai-603112, Tamil Nadu.<br>
                                Website: www.niepmdexaminationsnber.com | Email: niepmd.examinations@gmail.com
                            </td>
                        </tr>
                    </table>
                    <hr/>

                    <table border="0" cellpadding="3" cellspacing="0" width="100%">
                        <tr>
                            <td>
                                <div class="center-text bold-text">
                                    <span class="h6-text underline-text">
                                        NATIONAL ENTRANCE TEST (NET) - {{ $examcenterdetail->baslpexam->date->format('Y') }}<br>
                                        {{ $examcenterdetail->baslpexam->name }}<br>
                                        ADMIT CARD
                                    </span>
                                </div>
                            </td>
                        </tr>
                    </table>

                    <table border="1" cellpadding="3" cellspacing="0" width="100%">
                        <tr>
                            <td class="left-text h7-text" width="15%">Roll No.</td>
                            <td class="left-text bold-text h7-text" colspan="3">{{ $examcenterdetail->baslpcandidate->roll_no }}</td>
                            <td class="center-text h7-text" width="20%" rowspan="4">
                                <img src="{{asset('/files/baslp/photos')}}/{{ $examcenterdetail->baslpcandidate->file_photo}}"  style="width: 100px;" class="img" />
                            </td>
                        </tr>
                        <tr>
                            <td class="left-text h7-text">Name</td>
                            <td class="left-text bold-text h7-text" colspan="3">{{ $examcenterdetail->baslpcandidate->name }}</td>
                        </tr>
                        <tr>
                            <td class="left-text h7-text">Father's Name</td>
                            <td class="left-text bold-text h7-text">{{ $examcenterdetail->baslpcandidate->relation_name }}</td>
                            <td class="left-text h7-text" width="15%">Date of Birth</td>
                            <td class="left-text bold-text h7-text" width="15%">
                                {{ $examcenterdetail->baslpcandidate->dob->format('d-m-Y') }}
                            </td>
                        </tr>

                        <tr>
                            <td class="left-text h7-text">Gender</td>
                            <td class="left-text bold-text h7-text">
                                {{ $examcenterdetail->baslpcandidate->gender->gender }}
                            </td>
                            <td class="left-text h7-text" width="15%">Category</td>
                            <td class="left-text bold-text h7-text">
                                {{ $examcenterdetail->baslpcandidate->community->community }}
                            </td>
                        </tr>
                    </table>
                    <br>
                    <table border="1" cellpadding="3" cellspacing="0" width="100%">
                        <tr>
                            <th class="center-text h7-text" colspan="4">Examination Center Details</th>
                        </tr>
                        <tr>
                            <td class="left-text h7-text" width="15%">Center Code</td>
                            <td class="left-text bold-text h7-text">
                                {{ $examcenterdetail->baslpexamcenter->code }}
                            </td>
                            <td class="left-text h7-text" width="15%">Date of Exam</td>
                            <td class="left-text bold-text h7-text" width="15%">
                                {{ $examcenterdetail->baslpexam->date->format('d-m-Y') }}
                            </td>
                        </tr>
                        <tr>
                            <td class="left-text h7-text" width="15%" rowspan="2">Venue</td>
                            <td class="left-text bold-text h7-text" rowspan="2">
                                {{ $examcenterdetail->baslpexamcenter->name }}<br>
                                {{ $examcenterdetail->baslpexamcenter->address }},
                                {{ $examcenterdetail->baslpexamcenter->city->name }},
                                {{ $examcenterdetail->baslpexamcenter->city->state->state_name }} - {{ $examcenterdetail->baslpexamcenter->pincode }}.
                                @if($examcenterdetail->baslpexamcenter->contactnumber1 != '')
                                    <br>Phone No.: {{ $examcenterdetail->baslpexamcenter->contactnumber1 }}
                                    @if($examcenterdetail->baslpexamcenter->contactnumber2 != '')
                                        , {{ $examcenterdetail->baslpexamcenter->contactnumber2 }}
                                    @endif
                                @endif
                            </td>
                            <td class="left-text h7-text" width="15%">Reporting Time</td>
                            <td class="left-text bold-text h7-text" width="15%">
                                10:30 AM
                            </td>
                        </tr>
                        <tr>
                            <td class="left-text h7-text" width="15%">Exam Timing</td>
                            <td class="left-text bold-text h7-text" width="15%">
                                {{\Carbon\Carbon::createFromFormat('H:i:s', $examcenterdetail->baslpexam->starttime)->format('h:i A')}}
                                -<br>
                                {{\Carbon\Carbon::createFromFormat('H:i:s', $examcenterdetail->baslpexam->endtime)->format('h:i A')}}
                            </td>
                        </tr>
                    </table>

                    <table border="0" cellpadding="3" cellspacing="0" width="100%">
                        <tr>
                            <td>
                                <div class="h6-text center-text underline-text bold-text">
                                    General Instructions for the Candidates
                                </div>
                                <ol class="h7-text left-text">
                                    <li>
                                        Candidate should report at the examination center 30 minutes before the
                                        commencement of the examination.
                                    </li>
                                    <li>
                                        Candidates will not be allowed to enter the Examination
                                        Hall without the Admit Card under any circumstances.
                                    </li>
                                    <li>
                                        Candidates must bring their original Government Authoritised Photo Identity Card
                                        (like Voter Id Card, Aadhaar Card, PAN Card) in proof of their identity.
                                    </li>
                                    <li>
                                        Candidates are advised not to bring mobile phone(s) or any kind of electronic gadgets
                                        inside the Examination Hall.
                                    </li>
                                    <li>
                                        Candidate should use only blue / black ball point pen to write / fill his / her particulars
                                        on TEST BOOKLET / OMR SHEET. Use of PENCIL / WHITE FLUID and OVER WRITING / CUTTING on
                                        TEST BOOKLET and OMR SHEET is STRICTLY PROHIBITED.
                                    </li>
                                    <li>
                                        On completion of the examination, the candidate must handover the OMR SHEET along with
                                        the TEST BOOKLET to the Invigilator in the exam hall.
                                    </li>
                                    <li>
                                        The Selection / Admission of the candidates shall be subjected to the document verification
                                        and fulfilment of the Univerisity / RCI norms.
                                    </li>
                                </ol>
                                <div class="h7-text right-text bold-text">
                                    <img src="{{asset('files/baslp/images/2019-Authority_Sign.png')}}"  style="width: 150px;" class="img" />
                                    <br>
                                    Signature of the Authority
                                </div>
                            </td>
                        </tr>
                    </table>

                    <table border="0" cellpadding="3" cellspacing="0" width="100%">
                        <tr>
                            <td class="h7-text left-text bold-text" colspan="3">
                                I do hereby declare, that I have read all the instructions mentioned above and I will abide by them.
                            </td>
                        </tr>
                        <tr>
                            <td class="h7-text left-text bold-text">
                                <br>
                                Date: ________________
                            </td>
                            <td class="h7-text center-text bold-text">
                                <br>
                                ________________________<br>
                                (Signature of the Candidate)
                            </td>
                            <td class="h7-text right-text bold-text">
                                <br>
                                _________________________<br>
                                (Signature of the Invigilator)
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    </div>
</section>
</body>