<!DOCTYPE html>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Edu+TAS+Beginner&family=Playpen+Sans:wght@500&display=swap');
        @media print {
            #printPageButton {
                display: none;
            }
        }
       
    
        .page-break {
            

        }
        .bold-text {
           
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
        .center-text, .text-center{
            text-align: center !important;
        }
        .courier_new_font{
            font-family: "Courier New", Courier, "Lucida Sans Typewriter", "Lucida Typewriter", monospace;
        }
        .custom-li-style {
            margin-left: -25px !important;
        }
        #watermark{
            position: fixed;
            bottom:   5cm;
            left:     7cm;
            z-index:  -1000;
            width:    12cm;
            height:   7cm;
            opacity: .3;
        }
        .fixed-bottom{
            position: fixed;
            bottom:   120px;
            left:     0.10in;
            z-index:  -1000;
            width:    100%;
        }
        .small-text{
            font-size:10px;
        }
        td, th{
            vertical-align: middle!important;
        }
    </style>

        <div class="page-break" style="">
            <div id="watermark">
                <img src="/var/www/html/rcinber/public/images/rci.jpg" height="100%" width="100%" />
            </div>
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td>
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>

                                <td width="15%" style="vertical-align:middle;">
                                    <img src="/var/www/html/rcinber/public/images/nber_logo.png"  style="width: 80px; height: 80px !important" class="img" />
                                </td>
                                
                                <td class="h8-text center-text" width="70%">
                                    <div class="center-text blue-text">
                                        <span class="h7-text bold-text" style="font-size:20px;  text-transform: uppercase;font-weight:500;"><b>National Board of Examination in Rehabilitation (NBER)</b></span><br>
                                        <span class="h8-text"  style="font-size:16px;">
                                        (An Adjunct Body of Rehabilitation Council of India)    
                                        </span><br>
                                        <span class="h8-text" style="font-size:12px;">
                                        B-22, Qutab Institutional Area, New Delhi-110016
                                        </span>
                                        <br>
                                        <span class="h8-text" style="font-size:12px;" >
                                        (Department of Empowerment of Persons with Disabilities (Divyangjan), Ministry of Social Justice & Empowerment, Govt.of India)
                                        </span>
                                    </div>
                                </td>
                                <td  width="15%"  style="vertical-align:middle;">
                                    <?php $nber_id = $candidate->approvedprogramme->programme->nber_id; ?>
                                    <img src="/var/www/html/rcinber/public/images/{{$candidate->approvedprogramme->programme->nber->logo}}"  style="height: 70px;float:right;" class="img" />
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <hr style="color:#DDDDDD;" />
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="h7-text">
                            <tr>
                                <td class="center-text blue-text" colspan="6"  style="font-family: 'Brush Script MT', cursive;"><span class="h6-text bold-text" style="font-family: 'Edu TAS Beginner', cursive;font-size:18px;">Statement of Marks</span> <br> <br> 
                             </td>
                            </tr>
                            <tr>
                                <td class="left-text blue-text" width="16%"  style="padding-bottom:2px;">Name Of the Candidate</td>
                                <td class="left-text blue-text"   width="54%" style="padding-bottom:2px;"> : {{ strtoupper($candidate->name) }}</td>
                                <td class="left-text blue-text" style="padding-bottom:2px;" >Session</td>
                                <td class="left-text blue-text" style="padding-bottom:2px;"> : 
                                    @if($term == 1)
                                        {{$candidate->approvedprogramme->academicyear->term_one_name}}
                                    @else
                                        {{$candidate->approvedprogramme->academicyear->term_two_name}}
                                    @endif
                                </td>
                                <td class="left-text blue-text" style="padding-bottom:2px;"> 
                                    SL. No.
                                </td>
                                <td class="left-text blue-text" style="padding-bottom:2px;"> : 
                                @if($term==1)
                                        <?php $aslo = str_pad($candidate->currentapplicant->sl_no_marksheet_term_one,5,'0',STR_PAD_LEFT); ?>
                                    @else
                                        <?php $aslo = str_pad($candidate->currentapplicant->sl_no_marksheet_term_two,5,'0',STR_PAD_LEFT); ?>
                                    @endif
                                @if($candidate->approvedprogramme->programme->nber_id == 1)
                                        {{'CH23'.$aslo}}
                                    @endif
                                    @if($candidate->approvedprogramme->programme->nber_id == 2)
                                        {{'MU23'.$aslo}}
                                    @endif
                                    @if($candidate->approvedprogramme->programme->nber_id == 3)
                                        {{'DE23'.$aslo}}
                                    @endif
    
                                    
                                </td>
                                
                            </tr>
                            <tr>
                                <td class="left-text blue-text" style="padding-bottom:2px;">Father/Mother/Spouse Name</td>
                                <td class="left-text blue-text bold-text" style="padding-bottom:2px;"> : {{ strtoupper($candidate->fathername) }}</td>
                                <td class="left-text blue-text" style="padding-bottom:2px;">Year / Term</td>
                                <td class="left-text blue-text bold-text" style="padding-bottom:2px;"> : 
                                @if($term==1) I @else II @endif
                                </td>
                                <td class="left-text blue-text" style="padding-bottom:2px;">PRN No</td>
                                <td class="left-text blue-text bold-text" style="padding-bottom:2px;"> : {{ $candidate->enrolmentno }}</td>
                                
                            </tr>
                            <tr>
                                <td class="left-text blue-text"  style="padding-bottom:2px;">Name of the Course</td>
                                <td colspan="3" class="left-text blue-text bold-text" style="padding-bottom:2px;" > : {{ strtoupper($candidate->approvedprogramme->programme->name) }} 
                                
                                </td>
                                <td class="left-text blue-text" style="padding-bottom:2px;">Date of Birth</td>
                                <td class="left-text blue-text bold-text"  style="padding-bottom:2px;"> : {{ \Carbon\Carbon::parse($candidate->dob)->format('d-m-Y') }}</td>
                                
                            </tr>
                            <tr>
                                <td class="left-text blue-text"  style="padding-bottom:2px;">Name of the Training Institute</td>
                                <td class="left-text blue-text bold-text"  colspan="3" style="padding-bottom:2px;"> : 
                                    @if($candidate->approvedprogramme->academicyear_id == 10)
                                        {{strtoupper($candidate->approvedprogramme->institute->rci_name).','}} {{strtoupper($candidate->approvedprogramme->institute->rci_district).','}} {{$candidate->approvedprogramme->institute->rci_pin_code}}
                                    @else
                                        @if($candidate->approvedprogramme->programme->numberofterms == 1)
                                            {{strtoupper($candidate->approvedprogramme->institute->rci_name).','}} {{strtoupper($candidate->approvedprogramme->institute->rci_district).','}}  {{$candidate->approvedprogramme->institute->rci_pin_code}}
                                        @else
                                            @if($candidate->approvedprogramme->programme->nber_id == 2)
                                                @if(!is_null($candidate->approvedprogramme->institute->nber_name_2))
                                                    {{strtoupper($candidate->approvedprogramme->institute->nber_name_2)}}
                                                @else
                                                    {{strtoupper($candidate->approvedprogramme->institute->rci_name).','}} {{strtoupper($candidate->approvedprogramme->institute->rci_district).','}} {{$candidate->approvedprogramme->institute->rci_pin_code}}
                                                @endif
                                            @endif
                                            @if($candidate->approvedprogramme->programme->nber_id == 1)
                                                @if(!is_null($candidate->approvedprogramme->institute->nber_name_1))
                                                    {{strtoupper($candidate->approvedprogramme->institute->nber_name_1).','}} {{strtoupper($candidate->approvedprogramme->institute->rci_district).','}}  {{$candidate->approvedprogramme->institute->rci_pin_code}}
                                                @else
                                                    {{strtoupper($candidate->approvedprogramme->institute->rci_name).','}} {{strtoupper($candidate->approvedprogramme->institute->rci_district).','}} {{$candidate->approvedprogramme->institute->rci_pin_code}}
                                                @endif
                                            @endif
                                            @if($candidate->approvedprogramme->programme->nber_id == 3)
                                                {{strtoupper($candidate->approvedprogramme->institute->rci_name).','}} {{strtoupper($candidate->approvedprogramme->institute->rci_district).','}}  {{$candidate->approvedprogramme->institute->rci_pin_code}}
                                            @endif
                                        @endif
                                    @endif
                                    
                                    
                                </td>
                                <td>Course Code</td>
                                <td> : {{$candidate->approvedprogramme->programme->code}}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding-top:5px;">
                        
                        <table border="1" cellpadding="0" cellspacing="0" width="100%" class="h7-text">
                            <tr>
                                <td class="center-text blue-text bold-text" width=".5%" rowspan="2">S.No.</td>
                                <td class="center-text blue-text bold-text" width="3.5%" rowspan="2">Subjet Code</td>
                                <td class="center-text blue-text bold-text" width="78%" rowspan="2">Subject</td>
                                <td class="center-text blue-text bold-text" width="6%" colspan="3">External</td>
                                <td class="center-text blue-text bold-text" width="6%" colspan="3">Internal</td>
                                <td class="center-text blue-text bold-text" width="6%" colspan="2">Total</td>
                                <td class="center-text blue-text bold-text" width="2%" rowspan="2"> Result</td>
                            </tr>
                            <tr>
                            <td class="center-text blue-text bold-text" width="2%" colspan="1">Max. <br> Marks</td>
                            <td class="center-text blue-text bold-text" width="2%" colspan="1">Min. <br> Marks</td>
                            <td class="center-text blue-text bold-text" width="2%" colspan="1">Marks <br> Obtained</td>
                            <td class="center-text blue-text bold-text" width="2%" colspan="1">Max. <br> Marks</td>
                            <td class="center-text blue-text bold-text" width="2%" colspan="1">Min. <br> Marks</td>
                            <td class="center-text blue-text bold-text" width="2%" colspan="1">Marks <br> Obtained</td>
                            <td class="center-text blue-text bold-text" width="2%" colspan="1">Max. <br> Marks</td>
                            <td class="center-text blue-text bold-text" width="2%" colspan="1">Marks <br> Obtained</td>
                            </tr>

                            @php $sno = '1'; $total = 0; $maxtotal = 0; $result = 'Pass'; @endphp
                            <tr>
                                <td class="blue-text bold-text" width="100%" colspan="12">  &nbsp;&nbsp;Theory</td>
                            </tr>
                            @foreach($applications->sortBy('subject.sortorder') as $application)
                                @php 
                                    $subject = $application->subject;
                                @endphp
                                @if($subject->subjecttype_id==1 )
                                    <tr>
                                        <td class="center-text blue-text  small-text">{{ $sno }}</td>
                                        <td class="center-text blue-text  small-text">{{ $subject->scode }}</td>
                                        <td class="blue-text bold-text  small-text" style="padding-left:2px;">
                                            {{$subject->sname}}
                                        </td>
                                        
                                        <td class="center-text blue-text  small-text">
                                            {{$subject->emax_marks}}
                                        </td>
                                        <td class="center-text blue-text small-text">
                                            {{$subject->emin_marks}}
                                        </td>
                                        <td class="center-text blue-text  small-text">
                                            @if($application->externalattendance_id == 1)
                                                {{$application->reevaluation_mark + $application->grace}}
                                            @endif
                                            @if($application->externalattendance_id == 2 )
                                                <?php   $subjectresult = 'Absent'; ?>
                                                AB
                                            @endif
                                        </td>
                                        @if($subject->is_internal == 0)
                                            <td class="center-text blue-text  small-text">
                                                --
                                            </td>
                                            <td class="center-text blue-text  small-text">
                                                --
                                            </td>
                                            <td class="center-text blue-text  small-text">
                                                --
                                            </td>
                                            <?php 
                                                $stotal = $application->reevaluation_mark + $application->grace; 
                                                if(($application->reevaluation_mark + $application->grace )< $subject->emin_marks){
                                                    $result = 'Fail';
                                                }
                                            ?>
                                           
                                        @else
                                        <?php 
                                            $stotal = $application->internal_mark + $application->reevaluation_mark + $application->grace; 
                                            $subjectresult = 'Pass';
                                            if($application->internal_mark < $subject->imin_marks){
                                                $result = 'Fail';
                                                $subjectresult = 'Fail';
                                            }
                                            if(($application->reevaluation_mark + $application->grace) < $subject->emin_marks){
                                                $result = 'Fail';
                                                $subjectresult = 'Fail';
                                            }
                                        ?>
                                        <td class="center-text blue-text  small-text">
                                            {{$subject->imax_marks}}
                                        </td>
                                        <td class="center-text blue-text  small-text">
                                            {{$subject->imin_marks}}
                                        </td>
                                        <td class="center-text blue-text  small-text">
                                            @if($application->internalattendance_id == 1)
                                                {{$application->internal_mark}}
                                            @endif
                                            @if($application->internalattendance_id == 2)
                                            <?php   $subjectresult = 'Absent'; ?>

                                                AB
                                            @endif
                                        </td>
                                        
                                        @endif
                                        <td class="center-text blue-text small-text">
                                            {{$subject->imax_marks + $subject->emax_marks}}
                                        </td>
                                        <td class="center-text blue-text small-text">
                                            {{$stotal}}
                                            @php $sno++; $maxtotal += $subject->imax_marks + $subject->emax_marks;  $total += $stotal; @endphp
                                        </td>
                                        @if($subject->is_internal == 1)
                                            @if($application->internalattendance_id == 2)
                                                <?php   $subjectresult = 'Absent'; ?>
                                            @endif
                                        @endif
                                        @if($application->externalattendance_id == 2)
                                            <?php   $subjectresult = 'Absent'; ?>
                                        @endif
                                        <td class="center-text blue-text small-text">
                                            {{$subjectresult}}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach


                            @php $sno = '1'; @endphp
                            <tr>
                                <td class=" blue-text bold-text;padding-left:20%;" width="100%" colspan="12"> &nbsp; &nbsp;Practical</td>
                            </tr>
                            @foreach($applications as $application)
                                @php 
                                    $subject = $application->subject;
                                @endphp
                                @if($subject->subjecttype_id==2 )
                                <tr>
                                    <td class="center-text blue-text small-text">{{ $sno }}</td>
                                    <td class="center-text blue-text  small-text">{{ $subject->scode }}</td>
                                    <td class="blue-text bold-text small-text" style="padding-left:2px;">
                                    {{$subject->sname}}
                                    </td>
                                    @if($subject->is_external == 0)
                                        <td class="center-text blue-text  small-text">
                                            --
                                        </td>
                                        <td class="center-text blue-text  small-text">
                                            --
                                        </td>
                                        <td class="center-text blue-text  small-text">
                                            --
                                        </td>
                                        <?php 
                                         $subjectresult = 'Pass';
                                            $stotal = $application->internal_mark; 
                                            if($application->internal_mark < $subject->imin_marks){
                                                $result = 'Fail';
                                            }
                                        ?>
                                    @else
                                        <?php 
                                            $stotal = $application->internal_mark + $application->reevaluation_mark + $application->grace ;
                                            $subjectresult = 'Pass';
                                            if($application->internal_mark < $subject->imin_marks){
                                                $result = 'Fail';
                                                $subjectresult = 'Fail';
                                            }
                                            if(($application->reevaluation_mark + $application->grace) < $subject->emin_marks){
                                                $result = 'Fail';
                                                $subjectresult = 'Fail';
                                            }
                                        ?>
                                        <td class="center-text blue-text  small-text">
                                            {{$subject->emax_marks}}
                                        </td>
                                        <td class="center-text blue-text  small-text">
                                            {{$subject->emin_marks}}
                                        </td>
                                        <td class="center-text blue-text  small-text" >

                                            @if($application->externalattendance_id == 1)
                                                {{$application->reevaluation_mark + $application->grace}}
                                            @endif

                                            @if($application->externalattendance_id == 2)
                                                AB
                                                <?php   $subjectresult = 'Absent'; ?>
                                            @endif
                                        </td>
                                    @endif
                                    <td class="center-text blue-text  small-text">
                                        {{$subject->imax_marks}}
                                    </td>
                                    <td class="center-text blue-text  small-text">
                                        {{$subject->imin_marks}}
                                    </td>
                                    <td class="center-text blue-text small-text">
                                        @if($application->internalattendance_id == 1)
                                            {{$application->internal_mark}}
                                        @endif
                                        @if($application->internalattendance_id == 2)
                                            AB
                                          <?php   $subjectresult = 'Absent'; ?>
                                        @endif
                                    </td>
                                    <td class="center-text blue-text  small-text">
                                        {{$subject->imax_marks + $subject->emax_marks}}
                                    </td>
                                    <td class="center-text blue-text  small-text">
                                        
                                    @php 
                                            $sno++; $maxtotal += $subject->imax_marks + $subject->emax_marks;  $total += $stotal; 
                                          
                                        @endphp
                                        {{$stotal}}
                                    </td>
                                    <td class="center-text blue-text small-text">
                                            {{$subjectresult}}
                                        </td>
                                   
                                </tr>
                                @endif
                            @endforeach
                            <tr>
                                <td colspan="9">
                                    <?php 
                                       // $digit = new \NumberFormatter("en", NumberFormatter::SPELLOUT);
                                    ?>
            
                                            <?php if($term==1)    {
                                                $total = $candidate->currentapplicant->reevaluation_first_year_total;
                                            }else{
                                                $total = $candidate->currentapplicant->reevaluation_second_year_total;
                                            }
                                            $totalinword = $application->numbertoword($total);
                                            ?>
                                &nbsp;&nbsp;Total marks obtained in words  : {{$totalinword}}
                                </td>
                                <td class="center-text blue-text">
                                    {{$maxtotal}}
                                </td>
                                <td class="center-text blue-text" colspan="1">
                                <b>
                                            {{$total}}
                                            </b>
                                </td>
                                <td></td>
                            </tr>
                        </table>
                        <div style="float:right">Result: 
                        <?php 
                            if($term==1){
                                $r = $candidate->currentapplicant->reevaluation_term_one_result_id;
                            }else{
                                $r = $candidate->currentapplicant->reevaluation_term_two_result_id;
                            }
                            if($r==1){
                                $result = 'Pass';
                            }else{
                                $result = 'Fail';
                            }
                        ?>
                        
                        {{$result}}
                        </div>
                        
                    </td>
                </tr>
                <tr>
                    <td>
                        <br /> <br />
                        
                    </td>    
                </tr>
            </table>
            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="h7-text fixed-bottom">
                        <tr>
                        <td class="left-text blue-text"  style="width: 70px; height: 70px !important">
                                <img src="/var/www/html/rcinber/public/files/rci-seal.png" style="width: 70px; height: 70px !important"   class="img" />
                            </td>
                            <td class="text-center" width="">
                                    <img src="/var/www/html/rcinber/public/files/signs/{{$nber_id}}_p.png" style="height:40px;"> <br>
                                    Prepared By:
                            </td>
                            <td class="text-center" width="">
                                    <img src="/var/www/html/rcinber/public/files/signs/{{$nber_id}}_c.png" style="height:40px;"><br>
                                    Checked By:
                            </td>
                            <td class="text-center" width="">
                                    <img src="/var/www/html/rcinber/public/files/signs/{{$nber_id}}_v.png" style="height:40px;"><br>
                                    Verified By:
                            </td>
                            <td class="text-center" width="">
                                    <img src="/var/www/html/rcinber/public/files/signs/{{$nber_id}}_e.png" style="height:40px;"><br>
                                    Incharge - NBER:
                            </td>
                            <td class="text-center" width="">
                                    <img src="/var/www/html/rcinber/public/files/signs/{{$nber_id}}_d.png" style="height:40px;"><br>
                                    Director:
                            </td>
                            <td style="height:72.5px;width:80.5px;padding-right:4px">
                                <div style="">
                                    {!! $barcode !!}
                                </div>
                            </td>
                            
                        </tr>
                        <tr>
                            <td colspan="4" style="padding-top:5px;font-size:12px;">
                            <br>
                            <b>
                            Month & Year of Exam: 
                            </b>
                                Sept. / Oct. 2023
                            </td>
                            <td style="text-align:right;padding-top:5px;font-size:12px;padding-right:12px;"  colspan="3">
                            <b>
                                <br>
                            Issued Date: 
                            </b>
                             {{\Carbon\Carbon::parse($candidate->currentapplicant->reevaluation_marksheetissuded_date)->format('d-m-Y')}}
                            </td>
                        </tr>
                        </table>
        </div>
        
