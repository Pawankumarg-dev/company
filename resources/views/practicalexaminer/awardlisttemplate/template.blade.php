<!DOCTYPE html>
<html>
<head>
    <?php $date = Session::get('date'); ?>
    <title>{{$approvedprogramme->programme->common_name}} Term {{$term}} {{$date}}</title>
    <style>
          @media print {
            #printPageButton {
                display: none;
            }
            @page { margin: 15px 20px 20px 20px; }
            body { margin:1.6cm;}
        }

        .page-break {
        }
        .bold-text {
        }
        .blue-text {
            color: black;
        }
        .h6-text {
            font-size: 14px;
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
        .verdana{
            font-family: "Verdana", sans-serif;
        }
        .custom-li-style {
            margin-left: -25px !important;
        }
        .border-table {
            border-left: 1px solid #aaa;
            border-right: 0;
            border-top: 1px solid #aaa;
            border-bottom: 0;
            border-collapse: collapse;
        }
        .border-table td,
        .border-table th {
            border-left: 0;
            border-right: 1px solid #aaa;
            border-top: 0;
            border-bottom: 1px solid #aaa;
            height: 20px;
            padding:0 5px;
        }
        .bt{
            font-weight: 200;
        }
    </style>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        window.print();
    }); 
</script>
</head>
<body>
<div id="printPageButton">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr><td class="center-text">
            <div class="center-text blue-text">
    <a href="{{url('practicalexam/home')}}" style="padding:5px;margin-bottom:10px;border:1px solid #ddd;background-color:#ccc" >Go Back</a>
            </div>
</td></tr>
    </table>
</div>
<div class="page-break verdana">
    
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
                                <span class="h6-text bold-text bt">National Board of Examination in Rehabilitation (NBER)</span><br>
                                
                                <span class="h8-text">
                                (An Adjunct Body of Rehabilitation Council of India, under Ministry of Social Justice and Empowerment)    
                                </span><br>

                                <span class="h7-text bold-text bt">{{$approvedprogramme->programme->nber->name}}</span><br>
                                
                                <span class="h8-text">
                                (Dept of Empowerment of persons with disabilities, (DIVYANGJAN) MSJ & E Govt Of India)

                                </span>
                            </div>
                        </td>
                        <td  width="15%" style="text-align:right;">
                            <img src="{{asset('/images/')}}/{{$approvedprogramme->programme->nber->logo}}"  style="height: 70px;max-width:100px;" class="img" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table border="0" cellpadding="2" cellspacing="0" width="100%" class="h8-text border-table" style="margin-top:15px;">
                    <tr>
                        <td class="h7-text  blue-text" colspan="5" style="border-left:1px solid #aaa;border-top:1px solid #aaa;"><span class="h7-text bold-text bt">EXTERNAL PRACTICAL EXAMINATION MARK ENTRY FORM - JUNE 2024</span></td>
                        <td class="h7-text"> Date: {{$date}}</td>
                    </tr>
                </table>

                <table border="1" cellpadding="2" cellspacing="0" width="100%" class="h8-text border-table" style="margin-top:15px;">
                    <tr>
                        <td class="h7-text blue-text"  >
                            Name of the Institute
                        </td>
                        <td class="h7-text blue-text" colspan="3">
                            <b>{{$approvedprogramme->institute->name}}</b>
                        </td>
                        <td class="h7-text  blue-text" >
                            Center Code
                        </td>
                        <td class="h7-text center-text blue-text" >
                            <b>{{$approvedprogramme->institute->rci_code}}</b>
                        </td>
                    </tr>
                    <tr>
                        <td class="h7-text  blue-text" >Programme</td>
                        <td class="h7-text blue-text" ><b>{{$approvedprogramme->programme->course->name}}</b></td>
                        <td class="h7-text  blue-text" >Batch</td>
                        <?php 
                                            $batch = $approvedprogramme->academicyear->display_year ; 
                                            if($approvedprogramme->programme->numberofterms==1){
                                                $batch = $approvedprogramme->academicyear->display_name_one_year;
                                            }
                                        ?>
                                        
                        <td class="h7-text blue-text" ><b>{{$batch}}</b></td>
                        
                        <td class="h7-text  blue-text" >
                            Year
                        </td>
                        <td class="h7-text center-text blue-text" >
                            <b>@if($term==1) I @else II @endif</b>
                        </td>
                    </tr>
                    
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <br>
                <?php $slno = 1; ?>
                <table border="1" cellpadding="3" cellspacing="0" width="100%" class="h7-text">
                    <tr>
                        <th class="h7-text blue-text"  rowspan="3">
                            SlNo
                        </th>
                        <th class="h7-text  blue-text"  rowspan="3">
                            Enrolment No
                        </th>
                        <th class="h7-text  blue-text"  rowspan="3">
                            Student Name
                        </th>
                        @foreach($template->subjects as $subject)
                            <th style="width:120px;">
                                {{$subject->scode}}
                            </th>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach($template->subjects as $subject)
                        <td style="width:120px;">
                            {{$subject->sname}}
                        </td>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach($template->subjects as $subject)
                        <td style="width:120px;">
                            Min: {{$subject->emin_marks}}, 
                            Max: {{$subject->emax_marks}}
                        </td>
                        @endforeach
                    </tr>
                    @foreach ($candidates as $c)
                        <tr>
                            <td class="center-text">{{$slno}}<?php $slno++; ?></td>
                            <td>{{$c->enrolmentno}}</td>
                            <td>{{$c->name}}</td>
                            @foreach($template->subjects as $subject)
                            <td style="width:120px;">
                                
                            </td>
                            @endforeach
                        </tr>
                    @endforeach
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
                                <br><br><br><br><br>
                                Seal and Signature of the Study Centre
                            </div>
                        </td>
                        <td width="50%"  valign="bottom" colspan="2">
                            <div class="center-text bold-text blue-text" >
                                <br><br><br><br><br>
                                Signature of the External Examiner 
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <br>
                <table border="1" cellpadding="2" cellspacing="0" width="100%" class="h7-text">
                    <tr>
                        <td>
                            Name of the External Examiner:
                        </td>
                        <td>
                            {{$practicalexaminer->name}}
                        </td>
                        <td>
                            Date
                        </td>
                        <td>
                            {{$date}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Email:
                        </td>
                        <td>
                            {{$practicalexaminer->email}}
                        </td>
                        <td>
                            Mobile Number:
                        </td>
                        <td>
                            {{$practicalexaminer->mobileno}}
                        </td>

                    </tr>
                </table>
            </td>
        </tr>
    </table>
    
</div>

</body>
</html>
