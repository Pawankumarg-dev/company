<!DOCTYPE html>
<html>
<head>
    <title>NBER - 2023 Examinations - Hallticket</title>
    <style>
        @media print {
            #printPageButton {
                display: none;
            }
        }

        .page-break {
            page-break-after: always;
        }
        .bold-text {
            font-weight: bold;
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
        .custom-li-style {
            margin-left: -25px !important;
        }
    </style>
</head>
<body>
<div class="right-text">
    <p>
        <button type="button" onclick="window.print();return false;" id="printPageButton">Print</button>
    </p>
</div>

@for ($i = 1; $i <= 2; $i++)
    @php  
        $applicationData = $applications->where("term", $i)->unique("subject_id");
    @endphp

    @if(count($applicationData) > 0)
        <div class="page-break">
            <table border="1" cellpadding="5" cellspacing="0" width="100%">
                <tr>
                    <td>
                        <table border="0" cellpadding="3" cellspacing="0" width="100%">
                            <tr>
                                <td class="center-text" width="15%">
                                    <img src="{{asset('/images/niepmd_logo.png')}}"  style="width: 50px; height: 60px" class="img" />
                                </td>
                                <td class="h8-text center-text" width="70%">
                                    <div class="center-text blue-text">
                                        <span class="h7-text bold-text">National Institute for Empowerment of Persons with Multiple Disabilities (Divyangjan) [NIEPMD(D)]</span><br>
                                        <span class="h8-text">(Dept. of Empowerment of Persons with Disabilities (Divyangjan), MS&E, Govt. of India)</span><br>
                                        <span class="h7-text bold-text">National Board of Examination in Rehabilitation (NBER)</span><br>
                                        <span class="h8-text">East Coast Road, Muttukadu, Kovalam, P.O, Chennai-603 112, Tamil Nadu.<br></span>
                                    </div>
                                </td>
                                <td class="center-text" width="15%">
                                    <img src="{{asset('/images/g20_2023_logo.png')}}"  style="width: 60px; height: 70px !important" class="img" />
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table border="1" cellpadding="2" cellspacing="0" width="100%" class="h7-text">
                            <tr>
                                <td class="center-text blue-text" colspan="6"><span class="h6-text bold-text">{{ $title }} Examinations - Hall Ticket</span></td>
                            </tr>
                            <tr>
                                <td class="left-text blue-text" width="15%">Name</td>
                                <td class="left-text blue-text bold-text" width="25%">{{ $candidate->name }}</td>
                                <td class="left-text blue-text" width="15%">Registration No.</td>
                                <td class="left-text blue-text bold-text" width="25%">{{ $candidate->enrolmentno }}</td>
                                <td class="left-text blue-text center-text" width="14%" rowspan="4">
                                    <img src="{{asset('/files/enrolment/photos')}}/{{$candidate->photo}}"  style="width: 60px;" class="img" />
                                </td>
                            </tr>
                            <tr>
                                <td class="left-text blue-text" width="15%">Father's Name</td>
                                <td class="left-text blue-text bold-text" width="25%">{{ $candidate->fathername }}</td>
                                <td class="left-text blue-text" width="15%">Date of Birth</td>
                                <td class="left-text blue-text bold-text" width="25%">{{ $candidate->dob->format('d-m-Y') }}</td>
                            </tr>
                            <tr>
                                <td class="left-text blue-text" width="15%">Course</td>
                                <td class="left-text blue-text bold-text" width="25%">{{ $candidate->approvedprogramme->programme->course_name }}</td>
                                <td class="left-text blue-text" width="15%">Batch</td>
                                <td class="left-text blue-text bold-text" width="25%">
                                    {{ $candidate->approvedprogramme->academicyear->year }}@if($candidate->approvedprogramme->programme->numberofterms == 2)-{{ array_sum(array($candidate->approvedprogramme->academicyear->year, 2)) }}@endif
                                </td>
                            </tr>
                            <tr>
                                <td class="left-text blue-text" width="15%">Study Center</td>
                                <td class="left-text blue-text bold-text" width="25%" colspan="3">
                                    ( {{ $institute->code }} ) - {{ $institute->name }}
                                </td>
                            </tr>
                            <tr>
                                <td class="left-text blue-text" width="15%"><i>Exam Center</i>
                                </td>
                                <td class="left-text blue-text bold-text" width="25%" colspan="3" rowspan="2">
                                    @if(!is_null($externalexamcenter))
                                        ({{ $externalexamcenter->code }}) - 
                                        {{ $externalexamcenter->name }}
                                        @if($externalexamcenter->address != '')<br>{{ $externalexamcenter->address }}@endif
                                        @if($externalexamcenter->district != ''), {{ $externalexamcenter->district }}@endif
                                        @if($externalexamcenter->state != ''), {{ $externalexamcenter->state }} - {{ $externalexamcenter->pincode }}@endif
                                        @if($externalexamcenter->contactnumber1 != '')<br>Phone No.: {{ $externalexamcenter->contactnumber1 }}@endif @if($externalexamcenter->contactnumber2 != '')/{{ $externalexamcenter->contactnumber2 }}@endif
                                        @if($externalexamcenter->email1 != '')<br>Email Id: {{ $externalexamcenter->email1 }}@endif @if($externalexamcenter->email2 != '')/{{ $externalexamcenter->email2 }}@endif
                                    @endif
                                </td>
                                <td class="center-text blue-text bold-text" style="vertical-align: bottom">
                                    <br><br><br>
                                    Signature of the Candidate
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table border="1" cellpadding="3" cellspacing="0" width="100%" class="h7-text">
                            <tr>
                                <td class="center-text blue-text bold-text" width="5%">S.No.</td>
                                <td class="center-text blue-text bold-text" width="12%">Date</td>
                                <td class="center-text blue-text bold-text" width="10%">From</td>
                                <td class="center-text blue-text bold-text" width="10%">To</td>
                                <td class="center-text blue-text bold-text" width="5%">Paper<br>Year</td>
                                <td class="center-text blue-text bold-text" width="5%">Paper<br>Code</td>
                                <td class="center-text blue-text bold-text" width="38%">Paper<br>Name</td>
                                <td class="center-text blue-text bold-text" width="20%">Signature of the Invigilator</td>
                            </tr>

                            @php $sno = '1'; @endphp
                            @foreach($applicationData as $application)
                                @php 
                                    $subject = $application->subject;
                                @endphp

                                <tr>
                                    <td class="center-text blue-text">{{ $sno }}</td>
                                    <td class="center-text blue-text bold-text">
                                        @if($application->examtimetable_id != 0)
                                            {{ $application->examtimetable->startdate->format('d-m-Y') }}
                                        @endif
                                    </td>
                                    <td class="center-text blue-text">
                                        @if($application->examtimetable_id != 0)
                                            {{ $application->examtimetable->startdate->format('h:i A') }}
                                        @endif
                                    </td>
                                    <td class="center-text blue-text">
                                        @if($application->examtimetable_id != 0)
                                            {{ $application->examtimetable->enddate->format('h:i A') }}
                                        @endif
                                    </td>
                                    <td class="center-text blue-text bold-text">{{ $i }}</td>
                                    <td class="center-text blue-text bold-text">{{ $subject->scode }}</td>
                                    <td class="left-text blue-text bold-text">{{ $subject->sname }}</td>
                                    <td><br><br></td>
                                    @php $sno++; @endphp
                                </tr>
                            @endforeach
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table border="1" cellpadding="3" cellspacing="0" width="100%" class="h7-text">
                            <tr>
                                <td>
                                    <div class="center-text bold-text blue-text">
                                        <u>General Instructions to the Candidate - <span class="h8-text">उम्मीदवारों के लिए</span> </u>
                                    </div>
                                    <div class="left-text blue-text">
                                        <ol>
                                            <li class="custom-li-style bold-text">
                                                Personal details (Name / Father's Name / Date of Birth) given at the time of time of enrolment is reflected in this hall ticket and the same will be printed in your Statement of Marks &
                                                Certificates. If correction(s) needed, report immediately to NIEPMD-NBER through your study centre before the declaration of results.
                                                <span class="h8-text">
                                                    नामांकन के समय दिया गया व्यक्तिगत विवरण (नाम / पिता का नाम / जन्म तिथि) इस हॉल टिकट में परिलक्षित होता है और इसे आपके अंकों और प्रमाणपत्रों के विवरण में मुद्रित किया जाएगा। यदि सुधार की आवश्यकता है, तो परिणामों की घोषणा से पहले अपने अध्ययन केंद्र के माध्यम से एनआईईपीएमडी-एनबीईआर को तुरंत सूचित करें।
                                                </span>
                                            </li>
                                            <li class="custom-li-style">
                                                Candidates has to report at the Examination Centre 30 minutes before the commencement of the examination.
                                                <span class="h8-text">
                                                    उम्मीदवारों को परीक्षा शुरू होने से 30 मिनट पहले परीक्षा केंद्र पर रिपोर्ट करना होगा।
                                                </span>
                                            </li>
                                            <li class="custom-li-style">
                                                Candidates has to bring their original Government Authorised Photo Identity Card (like Voter Id, Aadhaar Card, PAN Card) in proof of their identity.
                                                <span class="h8-text">
                                                    उम्मीदवारों को अपनी पहचान के प्रमाण में अपना मूल सरकारी अधिकृत फोटो पहचान पत्र (जैसे मतदाता पहचान पत्र, आधार कार्ड, पैन कार्ड) लाना होगा।
                                                </span>
                                            </li>
                                            <li class="custom-li-style">
                                                Candidates are advised not to bring mobile phone(s) or any kind of electronic gadgets inside the Examination Hall.
                                                <span class="h8-text">
                                                    उम्मीदवारों को सलाह दी जाती है कि वे परीक्षा हॉल के अंदर मोबाइल फोन या किसी भी तरह के इलेक्ट्रॉनिक यंत्र न लाएं।
                                                </span>
                                            </li>
                                        </ol>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table border="1" cellpadding="3" cellspacing="0" width="100%" class="h7-text">
                            <tr>
                                <td width="25%">
                                    <div class="center-text">
                                        <img src="{{asset('/images/hallticket/covid19-nov2021.jpg')}}"  style="width:60%; height: 40%" class="img" />
                                    </div>
                                </td>
                                <td width="25%" valign="bottom">
                                    <div class="center-text bold-text blue-text">
                                        Seal and Signature<br>
                                        of the Study Centre
                                    </div>
                                </td>
                                <td width="25%" valign="bottom">
                                    <div class="center-text bold-text blue-text">
                                    Signature of the Centre Superintendent
                                    </div>
                                </td>
                                <td class="center-text bold-text blue-text" width="15%">
                                    <img src="{{asset('/images/hallticket/Dr_Balabaskar.png')}}"  style="width: 80px;" class="img" />

                                    <br>I/c NBER,<br>NIEPMD, Chennai
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    @endif    
@endfor

</body>
</html>
