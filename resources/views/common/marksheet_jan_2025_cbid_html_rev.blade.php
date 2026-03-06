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
            <img src="{{url('images/rci.jpg')}}" height="100%" width="100%" />
        </div>
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td>
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>

                            <td width="15%" style="vertical-align:middle;">
                                <img src="{{url('images/rci.jpg')}}"  style="width: 80px; height: 80px !important" class="img" />
                                <img src="{{url('images/mu.png')}}"  style="width: 80px; height: 80px !important" class="img" />
                                
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
                                <img src="{{url('images/nber_logo.png')}}"  style="width: 80px; height: 80px !important" class="img" />
                                <?php $nber_id = $candidate->approvedprogramme->programme->nber_id; ?>
                                <img src="{{url('images')}}/{{$candidate->approvedprogramme->programme->nber->logo}}"  style="height: 70px;float:right;" class="img" />
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
                            <td class="center-text blue-text" colspan="6"  style="font-family: 'Brush Script MT', cursive;">
                                <span class="h6-text bold-text" style="font-family: 'Edu TAS Beginner', cursive;font-size:18px;">Statement of Marks</span> 
                            <br /> <br >
                            <span class="h8-text"  style="font-size:16px;">
                                Community Based Inclusive Development (CBID)
                                <br>  <br />
                                Jointly Developed by the Rehabilitation Council of India <br />
                                &
                                <br />
                                University Of Melbourne, Australia 
                                </span>
                            <br>
                                <br> 
                            </td>
                        </tr>
                        <tr>
                            <td class="left-text blue-text" width="16%"  style="padding-bottom:2px;">Name of the Candidate</td>
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
                                    <?php $aslo = str_pad($result_data->marksheet_sl_no_first_year_re,5,'0',STR_PAD_LEFT); ?>
                                @else
                                    <?php $aslo = str_pad($result_data->marksheet_sl_no_second_year_re,5,'0',STR_PAD_LEFT); ?>
                                @endif
                                @if($candidate->approvedprogramme->programme->nber_id == 1)
                                    {{'CH25'.$aslo}}
                                @endif
                                @if($candidate->approvedprogramme->programme->nber_id == 2)
                                    {{'MU25'.$aslo}}
                                @endif
                                @if($candidate->approvedprogramme->programme->nber_id == 3)
                                    {{'DE25'.$aslo}}
                                @endif
                                @if($candidate->approvedprogramme->programme->nber_id == 4)
                                    {{'SB25'.$aslo}}
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
                            <td class="left-text blue-text"  style="padding-bottom:2px;">Course Code</td>
                            <td colspan="3" class="left-text blue-text bold-text" style="padding-bottom:2px;" > : {{$candidate->approvedprogramme->programme->code}}
                            
                            </td>
                            <td class="left-text blue-text" style="padding-bottom:2px;">Date of Birth</td>
                            <td class="left-text blue-text bold-text"  style="padding-bottom:2px;"> : {{ \Carbon\Carbon::parse($candidate->dob)->format('d-m-Y') }}</td>
                            
                        </tr>
                        <tr>
                            <td class="left-text blue-text"  style="padding-bottom:2px;">Name of the Training Institute</td>
                            <td class="left-text blue-text bold-text"  colspan="5" style="padding-bottom:2px;"> : 
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
                                         @if($candidate->approvedprogramme->programme->nber_id == 4)
                                            {{strtoupper($candidate->approvedprogramme->institute->rci_name).','}} {{strtoupper($candidate->approvedprogramme->institute->rci_district).','}}  {{$candidate->approvedprogramme->institute->rci_pin_code}}
                                        @endif
                                    @endif
                                @endif
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="padding-top:5px;">
                    
                    <table border="1" cellpadding="0" cellspacing="0" width="100%" class="h7-text">
                        <tr>
                            <td class="center-text blue-text bold-text" width=".5%" rowspan="1">S.No.</td>
                            <td class="center-text blue-text bold-text" width="5.5%" rowspan="1">Subjet Code</td>
                            <td class="center-text blue-text bold-text" width="84%" rowspan="1">Subject</td>
                            <td class="center-text blue-text bold-text" width="2%" colspan="1">Max. <br> Marks</td>
                            <td class="center-text blue-text bold-text" width="2%" colspan="1">Min. <br> Marks</td>
                            <td class="center-text blue-text bold-text" width="2%" colspan="1">Marks <br> Obtained</td>
                            <td class="center-text blue-text bold-text" width="4%" rowspan="1"> Result</td>
                        </tr>
                        
                        @php $sno = '1'; $total = 0; $maxtotal = 0; $result = 'Pass';  @endphp
                        @php
                            $hastheory = \App\Allapplication::where('candidate_id',$candidate->id)->where('exam_id',$result_data->exam_id)->whereHas('subject',function($q) use($term){
                                $q->where('syear',$term);
                                $q->where('subjecttype_id',1);
                            })->count();
                            
                            $haspractical = \App\Allapplication::where('candidate_id',$candidate->id)->where('exam_id',$result_data->exam_id)->whereHas('subject',function($q) use($term){
                                $q->where('syear',$term);
                                $q->where('subjecttype_id',2);
                            })->count();
                        @endphp
                        @if($hastheory > 0)
                            <tr>
                                <td class="blue-text bold-text" width="100%" colspan="7">  &nbsp;&nbsp;Theory</td>
                            </tr>
                            @foreach($applications->sortBy('subject.sortorder') as $application)
                                @php 
                                    $altsubject = null;
                                    $subject = $application->subject;
                                    if(!is_null($application->alternativesubject_id)){
                                        $altsubject  = \App\Alternativesubject::find($application->alternativesubject_id);
                                    }
                                @endphp
                                @if($subject->subjecttype_id==1 )
                                    <tr>
                                        <td class="center-text blue-text  small-text">{{ $sno }}</td>
                                        <td class="center-text blue-text  small-text">
                                            @if(!is_null($application->alternativesubject_id))
                                                {{$altsubject->scode}}
                                            @else
                                                {{$subject->scode}}
                                            @endif
                                        </td>
                                        <td class="blue-text bold-text  small-text" style="padding-left:2px;">
                                            @if(!is_null($application->alternativesubject_id))
                                                {{$altsubject->sname}}
                                            @else
                                                {{$subject->sname}}
                                            @endif
                                        </td>
                                            
                                        @if($subject->is_external==0)
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
                                             if(($application->mark_ex + $application->grace) > ($application->mark_ex_re + $application->grace_re)){
                                                $total_ex=$application->mark_ex + $application->grace;
                                             }else{
                                                $total_ex=$application->mark_ex_re + $application->grace_re;
                                             }




                                                $subjectresult = 'Pass';
                                                if($total_ex < $subject->emin_marks){
                                                    $result = 'Fail';
                                                    $subjectresult = 'Fail';
                                                }

                                            ?>
                                        @else
                                         <?php 
                                          if(($application->mark_ex + $application->grace) > ($application->mark_ex_re + $application->grace_re)){
                                                $total_ex=$application->mark_ex + $application->grace;
                                             }else{
                                                $total_ex=$application->mark_ex_re + $application->grace_re;
                                             }

                                                $subjectresult = 'Pass';
                                                if($total_ex < $subject->emin_marks){
                                                    $result = 'Fail';
                                                    $subjectresult = 'Fail';
                                                }
                                            ?>
                                        <td class="center-text blue-text  small-text">
                                            {{$subject->emax_marks}}
                                        </td>
                                        <td class="center-text blue-text small-text">
                                            {{$subject->emin_marks}}
                                        </td>
                                        <td class="center-text blue-text  small-text">
                                            @if($application->attendance_ex == 1)
                                                {{$total_ex}}
                                            @endif
                                            @if($application->attendance_ex == 2 )
                                                AB
                                            @endif
                                        </td>
                                        @endif
                                        
                                        @if($application->attendance_ex == 2)
                                            <?php   $subjectresult = 'Absent'; ?>
                                        @endif
                                        <td class="center-text blue-text small-text">
                                            {{$subjectresult}}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                        @if($haspractical>0)
                            @php $sno = '1'; @endphp
                            <tr>
                                <td class="blue-text bold-text" width="100%" colspan="7">  &nbsp;&nbsp;Practical</td>
                            </tr>
                            @foreach($applications->sortBy('subject.sortorder') as $application)
                                @php 
                                    $altsubject = null;
                                    $subject = $application->subject;
                                    if(!is_null($application->alternativesubject_id)){
                                        $altsubject  = \App\Alternativesubject::find($application->alternativesubject_id);
                                    }
                                @endphp
                                @if($subject->subjecttype_id==2 )
                                    <tr>
                                        <td class="center-text blue-text  small-text">{{ $sno }}</td>
                                        <td class="center-text blue-text  small-text">
                                            @if(!is_null($application->alternativesubject_id))
                                                {{$altsubject->scode}}
                                            @else
                                                {{$subject->scode}}
                                            @endif
                                        </td>
                                        <td class="blue-text bold-text  small-text" style="padding-left:2px;">
                                            @if(!is_null($application->alternativesubject_id))
                                                {{$altsubject->sname}}
                                            @else
                                                {{$subject->sname}}
                                            @endif
                                        </td>
                                      
                                        @if($subject->is_external==0)
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
                                                if(($application->mark_ex + $application->grace) < $subject->emin_marks){
                                                    $result = 'Fail';
                                                    $subjectresult = 'Fail';
                                                }
                                            ?>
                                        @else
                                        <?php 
                                            $subjectresult = 'Pass';
                                            if(($application->mark_ex + $application->grace) < $subject->emin_marks){
                                                $result = 'Fail';
                                                $subjectresult = 'Fail';
                                            }
                                        ?>
                                            <td class="center-text blue-text  small-text">
                                                {{$subject->emax_marks}}
                                            </td>
                                            <td class="center-text blue-text small-text">
                                                {{$subject->emin_marks}}
                                            </td>
                                            <td class="center-text blue-text  small-text">
                                                @if($application->attendance_ex == 1)
                                                    {{$application->mark_ex + $application->grace}}
                                                @endif
                                                @if($application->attendance_ex == 2 )
                                                    <?php   $subjectresult = 'Absent'; ?>
                                                    AB
                                                @endif
                                            </td>
                                        @endif
                                        
                                        <td class="center-text blue-text small-text">
                                            {{$subjectresult}}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                        <tr>
                            <td colspan="4">
                                <?php 
                                    // $digit = new \NumberFormatter("en", NumberFormatter::SPELLOUT);
                                ?>
        
                                        <?php if($term==1)    {
                                            $total = $result_data->first_year_total_re;
                                        }else{
                                            $total = $result_data->first_year_total_re;
                                        }
                                        $totalinword = $candidate->numbertoword($total);
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
                            $r = $result_data->first_year_result_re;
                        }else{
                            $r = $result_data->second_year_result_re;
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
                    {{ \Carbon\Carbon::parse($result_data->exam->examdate)->format('F Y') }}
                </td>
                <td style="text-align:right;padding-top:5px;font-size:12px;padding-right:12px;"  colspan="3">
                <b>
                    <br />
                Result Declared: 
                </b>
                    {{\Carbon\Carbon::parse($result_data->marksheetissuded_date_re)->format('d-m-Y')}}
                </td>
            </tr>
        </table>
    </div>
        
