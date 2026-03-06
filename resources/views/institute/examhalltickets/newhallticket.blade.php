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
            font-weight: 200;
        }
        .blue-text {
            color: black;
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
        $applicationData = $candidate->applications->where("term", $i)->unique("subject_id");
    @endphp

    @if(count($applicationData) > 0)
        <div class="page-break">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td>
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>

                                <td width="15%">
                                    <img src="{{asset('/images')}}/nber_logo.png"  style="width: 70px; height: 70px !important" class="img" />
                                </td>
                              
                                <td class="h8-text center-text" width="70%">
                                    <div class="center-text blue-text">
                                        <span class="h7-text bold-text">National Board of Examination in Rehabilitation (NBER)</span><br>
                                        
                                        <span class="h8-text">
                                        (An Adjunct Body of Rehabilitation Council of India, under Ministry of Social Justice and Empowerment)    
                                        </span><br>

                                        <span class="h7-text bold-text">{{$candidate->approvedprogramme->programme->nber->name}}</span><br>
                                        
                                        <span class="h8-text">
                                        (Dept of Empowerment of persons with disabilities, (DIVYANGJAN) MSJ & E Govt Of India)

                                        </span>
                                    </div>
                                </td>
                                <td  width="15%">
                                    <img src="{{asset('/images/')}}/{{$candidate->approvedprogramme->programme->nber->logo}}"  style="height: 70px" class="img" />
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table border="1" cellpadding="2" cellspacing="0" width="100%" class="h7-text">
                            <tr>
                                <td class="center-text blue-text" colspan="6"><span class="h6-text bold-text">HALL TICKET FOR THEORY EXAMINATIONS - 2023</span></td>
                            </tr>
                            <tr>
                                <td class="left-text blue-text" width="15%">Name</td>
                                <td class="left-text blue-text bold-text" width="25%">{{ $candidate->name }}</td>
                                <td class="left-text blue-text" width="15%">Registration No.</td>
                                <td class="left-text blue-text bold-text" width="25%">{{ $candidate->enrolmentno }}</td>
                                <td class="left-text blue-text center-text" width="14%" rowspan="5">
                                    <img src="{{asset('/files/enrolment/photos')}}/{{$candidate->photo}}"  style="width: 90px;" class="img" />
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
                                    {{ $candidate->approvedprogramme->academicyear->year }}
                                </td>
                            </tr>
                            <tr>
                                <td class="left-text blue-text" width="15%">Study Center</td>
                                <td class="left-text blue-text bold-text" width="25%" colspan="3">
                                    ( {{ $institute->user->username }} ) - {{ $institute->name }}
                                </td>
                            </tr>
                            <tr>
                                <td class="left-text blue-text" width="15%"><i>Exam Center</i>
                                </td>
                                <td class="left-text blue-text bold-text" width="25%" colspan="2" rowspan="2">
                                   {{-- @if(!is_null($externalexamcenter))
                                        ({{ $externalexamcenter->code }}) - 
                                        {{ $externalexamcenter->name }}
                                        @if($externalexamcenter->address != '')<br>{{ $externalexamcenter->address }}@endif
                                        @if($externalexamcenter->district != ''), {{ $externalexamcenter->district }}@endif
                                        @if($externalexamcenter->state != ''), {{ $externalexamcenter->state }} - {{ $externalexamcenter->pincode }}@endif
                                        @if($externalexamcenter->contactnumber1 != '')<br>Phone No.: {{ $externalexamcenter->contactnumber1 }}@endif @if($externalexamcenter->contactnumber2 != '')/{{ $externalexamcenter->contactnumber2 }}@endif
                                        @if($externalexamcenter->email1 != '')<br>Email Id: {{ $externalexamcenter->email1 }}@endif @if($externalexamcenter->email2 != '')/{{ $externalexamcenter->email2 }}@endif
                                    @endif --}}
                                    <?php
                                          //  $institute = \App\Institute::where('user_id',$user_id)->first();
                                         //   echo $institute->id;
                                            $kvname = \App\Kvtti::where('institute_id',$institute->id)->first();
                                        ?>
                                        <?php
                                        if(\App\Kvtti::where('institute_id',$institute->id)->count()>0){
                                            $kvname = \App\Kvtti::where('institute_id',$institute->id)->first();
                                            ?>
                                            <?php 
                                            $ecenter = \App\Externalexamcenter::where('id',$kvname->externalexamcenter_id);
                                            if($ecenter->count()>0){
                                                $execenter = $ecenter->first();
                                                ?>
                                                        ( {{$execenter->code}} ) - 
                                                        {{$execenter->address}}
                                                <?php
                                            }

                                        }
                                    ?>
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
                        <br>
                        <table border="1" cellpadding="1" cellspacing="0" width="100%" class="h7-text">
                            <tr>
                                <td class="center-text blue-text bold-text" width="5%">S.No.</td>
                                <td class="center-text blue-text bold-text" width="12%">Date</td>
                                <td class="center-text blue-text bold-text" width="10%">From</td>
                                <td class="center-text blue-text bold-text" width="10%">To</td>
                                <td class="center-text blue-text bold-text" width="5%">Year</td>
                                <td class="center-text blue-text bold-text" width="5%">Subject Code</td>
                                <td class="center-text blue-text bold-text" width="38%">Subject</td>
                                <td class="center-text blue-text bold-text" width="20%">Signature of Invigilator</td>
                            </tr>

                            @php $sno = '1'; @endphp
                            @foreach($applicationData as $application)
                                @php 
                                    $subject = $application->subject;
                                @endphp
                                <?php $show = 1; ?>
                                <?php $table = \App\Examtimetable::where('subject_id',$application->subject->id)->where('exam_id',22); ?>
                                @if(str_contains($institute->user->username,'DL') == 1)
                                    @if($table->count() > 0)
                                        <input type="hidden" value="{{$table->first()->examdate}}" />
                                        @if(str_contains($table->first()->examdate, '2023-09-09')  || str_contains($table->first()->examdate, '2023-09-10')  )
                                            <?php $show = 0; ?>
                                        @endif 
                                    @endif
                                @endif
                                @if($subject->subjecttype_id==1 && $show == 1)
                                <tr>
                                    <td class="center-text blue-text">{{ $sno }}</td>
                                    <td class="center-text blue-text bold-text">
                                       @if($table->count() > 0)
                                            {{$table->first()->startdate->format('d-m-Y')}}
                                        @endif
                                    </td>
                                    <td class="center-text blue-text">
                                        @if($table->count() > 0)
                                            {{ \Carbon\Carbon::parse($table->first()->starttime)->format('h:i A')}}
                                        @endif
                                    </td>
                                    <td class="center-text blue-text">
                                        @if($table->count() > 0)
                                            {{\Carbon\Carbon::parse($table->first()->endtime)->format('h:i A')}}
                                        @endif
                                    </td>
                                    <td class="center-text blue-text bold-text">{{ $i }}</td>
                                    <td class="center-text blue-text bold-text">{{ $subject->scode }}</td>
                                    <td class="left-text blue-text bold-text">{{ $subject->sname }}</td>
                                    <td></td>
                                    @php $sno++; @endphp
                                </tr>
                                @endif
                            @endforeach
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <br>
                        <table border="1" cellpadding="1" cellspacing="0" width="100%" class="h7-text">
                            <tr>
                                <td class="center-text blue-text bold-text" width="35%">Reporting time at examination center</td>
                                <td class="center-text blue-text bold-text" width="15%">10:00 AM</td>
                                <td class="center-text blue-text bold-text" width="35%">Gate closing time of examination Center</td>
                                <td class="center-text blue-text bold-text" width="15%">10:00 AM</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            
                
                <tr>
                    <td>
                        <br>
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="h7-text">
                            <tr>
                                <td>
                                    <div class="center-text bold-text blue-text">
                                        <u>General Instructions to the Candidate - <span class="h8-text">उम्मीदवारों के लिए</span> </u>
                                    </div>
                                    <div class="left-text blue-text">
                                        <ol>
                                            <li class="custom-li-style bold-text">
                                                Personal details (Name / Father's Name / Date of Birth) given at the time of time of enrolment is reflected in this hall ticket and the same will be printed in your Statement of Marks &
                                                Certificates. If correction(s) needed, report immediately to {{$candidate->approvedprogramme->programme->nber->name_code}}-NBER through your study centre before the declaration of results.
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
                        <br>
                        <table border="1" cellpadding="0" cellspacing="0" width="100%" class="h7-text">
                            <tr style="min-height:300px;">
                                <td width="50%" valign="bottom" colspan="2">
                                    <div class="center-text bold-text blue-text" >
                                        <br><br><br><br>
                                        Candidate's Photo<br/>
                                        (Same as uploaded on the portal, to be affixed before reaching the exam center)
                                    </div>
                                </td>

                                <td width="50%"  valign="bottom" colspan="2">
                                    <div class="center-text bold-text blue-text" >
                                        <br><br><br><br>
                                        Candidates's Left hand thumb impression
                                        <br>
                                        (To be affixed on reaching exam center)
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <br>
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="h7-text">
                            <tr style="min-height:300px;">
                                <td width="50%" valign="bottom" colspan="2">
                                    <div class="center-text bold-text blue-text" >
                                        <br><br><br><br>
                                        Seal and Signature of the Study Centre
                                    </div>
                                </td>

                                <td width="50%"  valign="bottom" colspan="2">
                                    <div class="center-text bold-text blue-text" >
                                        <img src="{{url('images')}}/{{$candidate->approvedprogramme->programme->nber->signature}}" style="height:60px;" alt="">
                                        <br />
                                        I/c  NBER - {{$candidate->approvedprogramme->programme->nber->name_code}}
                                    </div>
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
