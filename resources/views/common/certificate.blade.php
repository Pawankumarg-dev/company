<style>
  
  @import url('https://fonts.googleapis.com/css2?family=Edu+TAS+Beginner&family=Playpen+Sans&display=swap');

    #watermark{
            position: fixed;
            bottom:   8.5cm;
            left:     4cm;
            z-index:  -1000;
            width:    12cm;
            height:   7cm;
            opacity: .3;
        }
    .page-break{
        padding:80px;
        font-family: 'Playpen Sans', cursive;

    }
    #border{
        position: fixed;
        width: 700px;
        height: 1000px;
        top: 12px;
        left: 6px;
    }
    
</style>
<div class="page-break">
    <div id="watermark">
        <img src="/var/www/html/rcinber/public/images/rci.jpg" height="100%" width="100%" />
    </div>
    <div id="border">
        <img src="/var/www/html/rcinber/public/files/border.png" height="100%" width="100%" />
    </div>
    <center>
    <img src="/var/www/html/rcinber/public/images/nber_logo.png"  style="width: 120px; height: 120px !important" class="img" /> <br>
    <span class="h7-text bold-text" style="font-size:18px;"><b>National Board of Examination in Rehabilitation (NBER)</b></span><br>
    <span class="h8-text" style="font-size:16px;">
    <b>
    (An Adjunct Body of Rehabilitation Council of India)   
    </b> 
    </span><br>
    <span class="h8-text" style="font-size:12px;">
    B-22, Qutab Institutional Area, New Delhi-110016
    </span>
    <br>
    <span class="h8-text" style="font-size:12px;">
    (Department of Empowerment of Persons with Disabilities (Divyangjan),<br> Ministry of Social Justice & Empowerment, Govt.of India)
    </span>
    <hr />
    </center>
    <table style="width:100%">
        <tr>
            <td style="font-size:12px;">
                Serial No. :
                <?php $aslno = str_pad($candidate->currentapplicant->slno_certificate,5,'0',STR_PAD_LEFT) ?>                                   
                @if($candidate->approvedprogramme->programme->nber_id == 1)
                    {{"CH23".$aslno}} 
                @endif
                @if($candidate->approvedprogramme->programme->nber_id == 2)
                    {{"MU23".$aslno}} 
                @endif
                @if($candidate->approvedprogramme->programme->nber_id == 3)
                    {{"DE23".$aslno}} 
                @endif
                
                
                <br />
                PRN No.: {{$candidate->enrolmentno}}
            </td>
            <td>
            <td style="text-align:center;vertical-align:bottom;">
            <span class="h6-text bold-text" style="font-family: 'Edu TAS Beginner', cursive;font-size:20px;">
                <b>Certificate</b>
            </span>
            </td>
            </td>
            <td style="text-align:right;">
                <img src="/var/www/html/rcinber/public/files/enrolment/photos/{{$candidate->photo}}"  style="width: 90px;max-height:120px;" class="img" />
            </td
        </tr>
    </table>
    <p style="font-size:13px;  text-align: justify;">
    <br>
        This is to certify that @if($candidate->gender_id == 1) Mr. @else Ms. @endif 
        <span><b>
        {{strtoupper($candidate->name)}}
        </b></span>  
        @if($candidate->gender_id == 1)S/o @else D/o @endif
         Shri.  <b>{{strtoupper($candidate->fathername)}}</b>
          has been passed the examination of <b>
          {{$candidate->approvedprogramme->programme->name}}
          </b>
            - {{$candidate->approvedprogramme->programme->display_code}} 
           during the academic batch
           <b>
           @if($candidate->approvedprogramme->programme->numberofterms == 1)
           {{$candidate->approvedprogramme->academicyear->display_name_one_year}}
           @else
           {{$candidate->approvedprogramme->academicyear->display_year}}
           @endif
           </b>, from <b>
           @if($candidate->approvedprogramme->academicyear_id == 10)
                                        {{ucwords($candidate->approvedprogramme->institute->rci_name).','}} {{ucfirst($candidate->approvedprogramme->institute->rci_district).','}} {{$candidate->approvedprogramme->institute->rci_pin_code}}
                                    @else
                                        @if($candidate->approvedprogramme->programme->numberofterms == 1)
                                            {{ucwords($candidate->approvedprogramme->institute->rci_name).','}} {{ucfirst($candidate->approvedprogramme->institute->rci_district).','}}  {{$candidate->approvedprogramme->institute->rci_pin_code}}
                                        @else
                                            @if($candidate->approvedprogramme->programme->nber_id == 2)
                                                @if(!is_null($candidate->approvedprogramme->institute->nber_name_2))
                                                    {{ucwords($candidate->approvedprogramme->institute->nber_name_2)}}
                                                @else
                                                    {{ucwords($candidate->approvedprogramme->institute->rci_name).','}} {{ucfirst($candidate->approvedprogramme->institute->rci_district).','}} {{$candidate->approvedprogramme->institute->rci_pin_code}}
                                                @endif
                                            @endif
                                            @if($candidate->approvedprogramme->programme->nber_id == 1)
                                                @if(!is_null($candidate->approvedprogramme->institute->nber_name_1))
                                                    {{ucwords($candidate->approvedprogramme->institute->nber_name_1).','}} {{ucfirst($candidate->approvedprogramme->institute->rci_district).','}}  {{$candidate->approvedprogramme->institute->rci_pin_code}}
                                                @else
                                                    {{ucwords($candidate->approvedprogramme->institute->rci_name).','}} {{ucfirst($candidate->approvedprogramme->institute->rci_district).','}} {{$candidate->approvedprogramme->institute->rci_pin_code}}
                                                @endif
                                            @endif
                                            @if($candidate->approvedprogramme->programme->nber_id == 3)
                                                {{ucwords($candidate->approvedprogramme->institute->rci_name).','}} {{ucfirst($candidate->approvedprogramme->institute->rci_district).','}}  {{$candidate->approvedprogramme->institute->rci_pin_code}}
                                            @endif
                                        @endif
                                    @endif


                                
                                </b>
           conducted by the National Board of Examination in Rehabilitation - {{$candidate->approvedprogramme->programme->nber->name_code}} in<?php $percentage = $candidate->currentapplicant->result_percentage; ?>
           <b>
           @if($percentage > 74.99  )
           First Division with Distinction
           @endif
           @if($percentage > 59.99 && $percentage < 75)
           First Division
           @endif
           @if($percentage > 49.99 &&  $percentage < 60)
           Second Division
           @endif
           </b>
            with <b>
            {{number_format($percentage,2)}}%
            </b> of Marks.
    </p>
    <br>
    <br>
    <p>
        <table style="width:100%">
            <tr>
            <td style="height:72.5px;width:80.5px;">
                                <div style="">
                                    {!! $barcode !!}
                                </div>
                            </td>
                <td style="text-align:center">
                <img src="/var/www/html/rcinber/public/files/rci-seal.png" style="width: 70px; height: 70px !important"   class="img" />
                </td>
                <td style="text-align:center;width:220px;">
                
                    <img src="/var/www/html/rcinber/public/files/signs/msnew.png" style="height:60px;">
                    <br>
                    Secretary - NBER
                    <br>
                    Date: {{\Carbon\Carbon::parse($candidate->currentapplicant->certificate_date)->format('d-m-Y')}}
                </td>
            </tr>
        </table>
        
    </p>
</div>
