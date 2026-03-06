<!DOCTYPE html>
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
            bottom:   7cm;
            left:     7cm;
            z-index:  -1000;
            width:    12cm;
            height:   7cm;
            opacity: .3;
        }
    </style>

        <div class="page-break">
            <div id="watermark">
                <img src="{{url('images/rci.jpg')}}" height="100%" width="100%" />
            </div>
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
                                        <span class="h7-text bold-text" style="font-size:15px;"><b>National Board of Examination in Rehabilitation (NBER)</b></span><br>
                                        <span class="h8-text">
                                        (An Adjunct Body of Rehabilitation Council of India)    
                                        </span><br>
                                        <span class="h8-text">
                                        B-22, Qutub Institutional Area, New Delhi-110016
                                        </span>
                                        <br>
                                        <span class="h8-text">
                                        (Department of Empowerment of Persons with Disabilities (Divyangjan), Ministry of Social Justice & Empowerment, Govt.of India)
                                        </span>
                                    </div>
                                </td>
                                <td  width="15%">
                                    <?php $nber_id = $candidate->approvedprogramme->programme->nber_id; ?>
                                    <img src="{{asset('/images/')}}/{{$candidate->approvedprogramme->programme->nber->logo}}"  style="height: 70px;float:right;" class="img" />
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <hr />
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="h7-text">
                            <tr>
                                <td class="center-text blue-text" colspan="6"><span class="h6-text bold-text">Statement of Marks</span> <br> <br> 
                             </td>
                            </tr>
                            <tr>
                                <td class="left-text blue-text"  >Name of the Candidate:</td>
                                <td class="left-text blue-text bold-text" >{{ $candidate->name }}</td>
                                <td class="left-text blue-text" >Sl.No:</td>
                                <td class="left-text blue-text bold-text" > {{$term}}{{$applicantid}} </td>
                            </tr>
                            <tr>
                                <td class="left-text blue-text" >Father/Mother/Spouse Name:</td>
                                <td class="left-text blue-text bold-text" >{{ $candidate->fathername }}</td>
                                <td class="left-text blue-text" >Name of the Course:</td>
                                <td class="left-text blue-text bold-text"  >{{ $candidate->approvedprogramme->programme->name }}</td>
                                
                            </tr>
                            <tr>
                                <td class="left-text blue-text" >Date of Birth:</td>
                                <td class="left-text blue-text bold-text" >{{ $candidate->dob->format('d-m-Y') }}</td>
                                <td class="left-text blue-text" > Course Code:</td>
                                <td class="left-text blue-text bold-text" >{{ $candidate->approvedprogramme->programme->display_code }}</td>
                            </tr>
                            <tr>
                                <td class="left-text blue-text" >Name of the Training Institute:</td>
                                <td class="left-text blue-text bold-text" >
                                    {{ $candidate->approvedprogramme->institute->name }}
                                </td>
                                
                            </tr>
                            <tr>
                                <td class="left-text blue-text"  >Session:</td>
                                <td class="left-text blue-text bold-text" > 
                                    @if($candidate->approvedprogramme->programme->numberofterms == 2)
                                        {{$candidate->approvedprogramme->academicyear->display_year}}
                                    @else
                                        {{$candidate->approvedprogramme->academicyear->year}}
                                    @endif
                                </td>
                                <td class="left-text blue-text" >Year:</td>
                                <td class="left-text blue-text bold-text" >{{  $term  }}</td>
                            </tr>
                            <tr>
                                <td class="left-text blue-text" >Enrollment/PRN No:</td>
                                <td class="left-text blue-text bold-text" >{{ $candidate->enrolmentno }}</td>
                                <td class="left-text blue-text" > Date of Issue:</td>
                                <td class="left-text blue-text bold-text" >{{ \Carbon\Carbon::parse($dateofissue)->format('d-m-Y')}}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <br>
                        <table border="1" cellpadding="0" cellspacing="0" width="100%" class="h7-text">
                            <tr>
                                <td class="center-text blue-text bold-text" width="2%" rowspan="2">S.No.</td>
                                <td class="center-text blue-text bold-text" width="82%" rowspan="2">Subject</td>
                                <td class="center-text blue-text bold-text" width="6%" colspan="3">External</td>
                                <td class="center-text blue-text bold-text" width="6%" colspan="3">Internal</td>
                                <td class="center-text blue-text bold-text" width="4%" colspan="2">Total</td>
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
                                <td class="blue-text bold-text" width="100%" colspan="10">  &nbsp;&nbsp;Theory</td>
                            </tr>
                            @foreach($applications as $application)
                                @php 
                                    $subject = $application->subject;
                                @endphp
                                @if($subject->subjecttype_id==1 )
                                    <tr>
                                        <td class="center-text blue-text">{{ $sno }}</td>
                                        <td class="blue-text bold-text" style="padding-left:2px;">
                                            {{$subject->sname}}
                                        </td>
                                        <td class="center-text blue-text">
                                            {{$subject->emax_marks}}
                                        </td>
                                        <td class="center-text blue-text">
                                            {{$subject->emin_marks}}
                                        </td>
                                        <td class="center-text blue-text">
                                            @if($application->externalattendance_id == 1)
                                                {{$application->external_mark}}
                                            @endif
                                            @if($application->externalattendance_id == 2)
                                                AB
                                            @endif
                                        </td>
                                        <td class="center-text blue-text">
                                            {{$subject->imax_marks}}
                                        </td>
                                        <td class="center-text blue-text">
                                            {{$subject->imin_marks}}
                                        </td>
                                        <td class="center-text blue-text">
                                            @if($application->internalattendance_id == 1)
                                                {{$application->internal_mark}}
                                            @endif
                                            @if($application->internalattendance_id == 2)
                                                AB
                                            @endif
                                        </td>
                                        <td class="center-text blue-text">
                                            {{$subject->imax_marks + $subject->emax_marks}}
                                        </td>
                                        <td class="center-text blue-text">
                                            <?php 
                                            $stotal = $application->internal_mark + $application->external_mark; 
                                            if($application->internal_mark < $subject->imin_marks){
                                                $result = 'Fail';
                                            }
                                            if($application->external_mark < $subject->emin_marks){
                                                $result = 'Fail';
                                            }
                                            ?>
                                            {{$stotal}}
                                            @php $sno++; $maxtotal += $subject->imax_marks + $subject->emax_marks;  $total += $stotal; @endphp
                                        </td>
                                        
                                    </tr>
                                @endif
                            @endforeach


                            @php $sno = '1'; @endphp
                            <tr>
                                <td class=" blue-text bold-text" width="100%" colspan="10"> &nbsp; &nbsp;Practical</td>
                            </tr>
                            @foreach($applications as $application)
                                @php 
                                    $subject = $application->subject;
                                @endphp
                                @if($subject->subjecttype_id==2 )
                                <tr>
                                    <td class="center-text blue-text">{{ $sno }}</td>
                                    <td class="blue-text bold-text" style="padding-left:2px;">
                                    {{$subject->sname}}
                                    </td>
                                    <td class="center-text blue-text">
                                        {{$subject->emax_marks}}
                                    </td>
                                    <td class="center-text blue-text">
                                        {{$subject->emin_marks}}
                                    </td>
                                    <td class="center-text blue-text">
                                        @if($application->externalattendance_id == 1)
                                            {{$application->external_mark}}
                                        @endif
                                        @if($application->externalattendance_id == 2)
                                            AB
                                        @endif
                                    </td>
                                    <td class="center-text blue-text">
                                        {{$subject->imax_marks}}
                                    </td>
                                    <td class="center-text blue-text">
                                        {{$subject->imin_marks}}
                                    </td>
                                    <td class="center-text blue-text">
                                        @if($application->internalattendance_id == 1)
                                            {{$application->internal_mark}}
                                        @endif
                                        @if($application->internalattendance_id == 2)
                                            AB
                                        @endif
                                    </td>
                                    <td class="center-text blue-text">
                                        {{$subject->imax_marks + $subject->emax_marks}}
                                    </td>
                                    <td class="center-text blue-text">
                                        <?php 
                                        $stotal = $application->internal_mark + $application->external_mark; 
                                        if($application->internal_mark < $subject->imin_marks){
                                            $result = 'Fail';
                                        }
                                        if($application->external_mark < $subject->emin_marks){
                                            $result = 'Fail';
                                        }
                                        ?>
                                        {{$stotal}}
                                        @php 
                                            $sno++; $maxtotal += $subject->imax_marks + $subject->emax_marks;  $total += $stotal; 
                                            $totalinword = $application->numbertoword($total);
                                        @endphp
                                    </td>
                                   
                                </tr>
                                @endif
                            @endforeach
                            <tr>
                                <td colspan="8">
                                    <?php 
                                       // $digit = new \NumberFormatter("en", NumberFormatter::SPELLOUT);
                                    ?>

                                &nbsp;&nbsp;Total marks obtained in words  : {{$totalinword}}
                                </td>
                                <td class="center-text blue-text">
                                    {{$maxtotal}}
                                </td>
                                <td class="center-text blue-text">
                                    {{$total}}
                                </td>
                            </tr>
                        </table>
                        <div style="float:right">Result: {{$result}}
                        </div>
                        
                    </td>
                </tr>
                <tr>
                    <td>
                        <br /> <br />
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="h7-text">
                        <tr>
                            
                            <td class="text-center" width="">
                                    <img src="{{url('files/signs/')}}/{{$nber_id}}_p.png" style="height:40px;"> <br>
                                    Prepared By:
                            </td>
                            <td class="text-center" width="">
                                    <img src="{{url('files/signs/')}}/{{$nber_id}}_c.png" style="height:40px;"><br>
                                    Checked By:
                            </td>
                            <td class="text-center" width="">
                                    <img src="{{url('files/signs/')}}/{{$nber_id}}_v.png" style="height:40px;"><br>
                                    Verified By:
                            </td>
                            <td class="text-center" width="">
                                    <img src="{{url('files/signs/')}}/{{$nber_id}}_e.png" style="height:40px;"><br>
                                    Exam In Charge:
                            </td>
                            <td class="text-center" width="">
                                    <img src="{{url('files/signs/')}}/{{$nber_id}}_d.png" style="height:40px;"><br>
                                    Director:
                            </td>
                            <td style="height:72.5px;width:72.5px;">
                                <div style="">
                                    {!! $barcode !!}
                                </div>
                            </td>
                            
                        </tr>
                        </table>
                    </td>    
                </tr>
            </table>
        </div>
