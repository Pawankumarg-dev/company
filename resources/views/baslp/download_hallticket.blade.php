<!DOCTYPE html>
<html>
<head>
    <title>2019 - BASLP Exam</title>
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
                            <td>
                                <span class="h7-text bold-text">NATIONAL INSTITUTE FOR EMPOWERMENT OF PERSONS WITH MULITPLE DISABILITIES (DIVYANGJAN) [NIEPMD]</span><br>
                                <span class="h8-text">(DEPT. OF EMPOWERMENT OF PERSONS WITH DISABILIITIES (DIVYANGJAN), MSJ&E, GOVT. OF INDIA)</span><br>
                                <span class="h7-text bold-text">NATIONAL BOARD OF EXAMINATION IN REHABILITATION (NBER)</span><br>
                                <span class="h8-text">(An Adjunct Body of Rehabilitation Council of India, under Ministry of Social Justice and Empowerment)</span><br>
                                <span class="h8-text">ECR, Muttukadu, Kovalam Post, Chennai-603112, Tamil Nadu.</span><br>
                                <span class="h8-text">Website: www.niepmdexaminationsnber.com | Email: niepmd.examinations@gmail.com</span>
                            </td>
                        </tr>
                    </table>
                    <hr/>

                    <table border="0" cellpadding="3" cellspacing="0" width="100%">
                        <tr>
                            <td>
                                <div class="center-text bold-text">
                                    <span class="h7-text">BACHELOR OF AUDIOLOGY & SPEECH LANGUAGE PATHOLOGY</span><br>
                                    <span class="h7-text underline-text">NATIONAL ENTRANCE TEST (NET) - 2019</span><br>
                                    <span class="h7-text underline-text">ADMIT CARD</span>
                                </div>
                            </td>
                        </tr>
                    </table>

                    <table border="1" cellpadding="3" cellspacing="0" width="100%">
                        <tr>
                            <td class="left-text h7-text" width="15%">Roll No.</td>
                            <td colspan="3"></td>
                            <td class="center-text-text h7-text" width="20%" rowspan="4"></td>
                        </tr>
                        <tr>
                            <td class="left-text h7-text">Name</td>
                            <td colspan="3"></td>
                        </tr>
                        <tr>
                            <td class="left-text h7-text">Father's Name</td>
                            <td></td>
                            <td class="left-text h7-text" width="15%">Date of Birth</td>
                            <td></td>
                        </tr>

                        <tr>
                            <td class="left-text h7-text">Gender</td>
                            <td></td>
                            <td class="left-text h7-text" width="15%">Category</td>
                            <td></td>
                        </tr>
                    </table>
                    <br>
                    <table border="1" cellpadding="3" cellspacing="0" width="100%">
                        <tr>
                            <th class="center-text h7-text" colspan="4">Exam Details</th>
                        </tr>
                        <tr>
                            <td class="left-text h7-text" width="15%">Code</td>
                            <td></td>
                            <td class="left-text h7-text" width="15%">Date of Exam</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="left-text h7-text" width="15%" rowspan="2">Venue</td>
                            <td rowspan="2"></td>
                            <td class="left-text h7-text" width="15%">Reporting Time</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="left-text h7-text" width="15%">Duration</td>
                            <td></td>
                        </tr>
                    </table>

                    {{--
                    <table border="1" cellpadding="3" cellspacing="0" width="100%">
                        <tr>
                            <td class="left-text" width="15%">
                                <span class="h7-text">Roll No.</span>
                            </td>
                            <td class="left-text bold-text" width="50%">

                            </td>
                            <td class="center-text">
                                <span class="h7-text">Candidate Photo</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="left-text">
                                <span class="h7-text">Candidate Name</span>
                            </td>
                            <td class="left-text bold-text">

                            </td>
                            <td class="center-text" rowspan="6">

                            </td>
                        </tr>
                        <tr>
                            <td class="left-text">
                                <span class="h7-text">Father's Name</span>
                            </td>
                            <td class="left-text bold-text">

                            </td>
                        </tr>
                        <tr>
                            <td class="left-text">
                                <span class="h7-text">Date of Birth</span>
                            </td>
                            <td class="left-text bold-text">

                            </td>
                        </tr>
                        <tr>
                            <td class="left-text">
                                <span class="h7-text">Gender</span>
                            </td>
                            <td class="left-text bold-text">

                            </td>
                        </tr>
                        <tr>
                            <td class="left-text">
                                <span class="h7-text">Category</span>
                            </td>
                            <td class="left-text bold-text">

                            </td>
                        </tr>
                        <tr>
                            <td class="left-text">
                                <span class="h7-text">Exam Center<br>Details</span>
                            </td>
                            <td>
                                <table border="1" cellpadding="3" cellspacing="0" width="100%">
                                    <tr>
                                        <td width="7%">
                                            <span class="h7-text">Code</span>
                                        </td>
                                        <td class="bold-text h6-text">
                                            2019CHE01
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="7%">
                                            <span class="h7-text">Venue</span>
                                        </td>
                                        <td class="bold-text h6-text">
                                                NIEPMD<br>
                                                ECR, Muttukadu, Kovalam Post, Chennai, Tamil Nadu - 603112.<br>
                                                Contact Number(s): 044-27472104<br>
                                                Email: niepmd@gmail.com
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td class="left-text">
                                <span class="h7-text">Date & Time</span>
                            </td>
                            <td class="center-text">
                                <table border="1" cellpadding="0" cellspacing="0" width="100%">
                                    <tr class="h7-text">
                                        <td>Date of Test</td>
                                        <td>Reporting Time</td>
                                        <td>Time of Test</td>
                                    </tr>

                                    <tr class="h6-text bold-text">
                                        <td>14 July 2019</td>
                                        <td>10:30 AM</td>
                                        <td>11:00 AM - 01:00 PM</td>
                                    </tr>
                                </table>
                            </td>
                            <td class="h7-text center-text bold-text">
                               <br><br>
                                Signature of the Candidate<br>in presence of Invigilator
                            </td>
                        </tr>
                    </table>
                    --}}

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
                                        On completion of the examination, the candidate must handover the OMR SHEET to the Invigilator
                                        in the exam hall and take away only the TEST BOOKLET.
                                    </li>
                                    <li>
                                        The Selection / Admission of the candidates shall be subjected to the document verification
                                        and fulfilment of the Univerisity / RCI norms.
                                    </li>
                                </ol>
                                <div class="h7-text right-text bold-text">
                                    <img src="{{asset('files/baslp/images/2019-Authority_Sign.jpg')}}"  style="width: 100px;" class="img" />
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