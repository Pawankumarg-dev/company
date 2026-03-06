



<!DOCTYPE html>
<html>
<head>
  <title>CBID MarkSheet</title>
     <head>
                                             <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

   <!-- Latest compiled JavaScript -->
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   <link href="https://fonts.googleapis.com/css?family=Song+Myung" rel="stylesheet">
   <link href="https://fonts.googleapis.com/css?family=Bitter" rel="stylesheet">
   
   
   <link rel="stylesheet" href="{{asset('css/3.3.6/font-awesome.min.css')}}">
   <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>  
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>  
    <script src="https://kendo.cdn.telerik.com/2017.2.621/js/jquery.min.js"></script>
 <script src="https://kendo.cdn.telerik.com/2017.2.621/js/jszip.min.js"></script>
 <script src="https://kendo.cdn.telerik.com/2017.2.621/js/kendo.all.min.js"></script>

 
 
 
 
     <script type="text/javascript" src="qrcode.js">
</script>
    <script type="text/javascript" src="html5-qrcode.js">
</script>

<style type="text/css">
  p,h3,h2,h4,h5,h1{
  
}
input{
  border: 2px solid #2C3E50;
  padding: 10px;
    border-radius: 20px;
  text-decoration: none;
  width:150px;
  color: inherit;
  background-color: white;
   outline: none;
}
</style>
</head>


 


<body style="background: #009e3a;">
 <div class="container"id="myCanvas" style="border: 6px solid #163782; padding: 2%;text-align: center;background-color:white;;   margin-top: 2%;border-radius: 0px;background-repeat: no-repeat;
background-position: center;">
  <div class="row" style="border: 2px solid #df0023;margin-top: -24px;margin-right: -4px;margin-left: -4px;">
  <div class="col-md-12" style ="margin-top: 4px;" >
  <table>
  <tr>
  <td  width=10%><img style="width: 94%;height: 158px;transform: translateZ(0);" src="/var/www/html/rcinber/public/files/cbid/cbidheader.png" />
  </td>
  
  
  </tr>
  
  </table>

 </div>
  
 
  
  <div class="col-md-12" style ="margin-top: 3px;">
  </div>
    <h1 align= "center"style="font-size: 22px;color: #3e19a4"><b> STATEMENT OF MARKS</b></h1>
     <h1 align= "center"style="font-size: 23px;color: #3e19a4"><b> Community Based Inclusive Development (CBID)</b></h1>
   <h1 align= "center"style="font-size: 20px;color: #3e19a4;margin-top: 0px;""><b>Jointly Developed by the Rehabilitation Council of India</b></h1>
   <h1 align= "center"style="font-size: 20px;color: #3e19a4;margin-top: -7px"><b>&</b></h1>
    <h1 align= "center"style="font-size: 20px;color: #3e19a4;margin-top: -7px"><b>University Of Melbourne , Australia </b></h1>
<div id="qrcode" style="text-align: start;margin-top:-121px;margin-left: 40px;">
	{!! $barcode !!}
	</div>
    <p style="text-align: left;margin-left: 39px;font-weight: bold;margin-top: 26px;">Sl. No.:<u><span id="certifcateno">
        <?php $aslo = str_pad($candidate->allresults()->first()->marksheet_sl_no_first_year,5,'0',STR_PAD_LEFT); ?>
        {{'SB25'.$aslo}}
    </span></u></p>
    <p style="text-align: center;font-weight: bold;margin-top: -35px;">Session : {{$candidate->approvedprogramme->academicyear->term_one_name}}</p>
    <p style="text-align: right;font-weight: bold;margin-top: -25px;margin-right: 27px;">PRN : <span id="prn"> {{ $candidate->enrolmentno }}</p> 
    <!-- Second row   -->
       <p style="text-align: left;margin-left: 39px;font-weight: bold;margin-top: 13px;">Name of the Candidate: <span id="name">{{ strtoupper($candidate->name) }}</span></p>
    <p style="text-align: right;font-weight: bold;margin-top: -35px;margin-right: 27px;">DOB : <span id="dob">{{ \Carbon\Carbon::parse($candidate->dob)->format('d-m-Y') }}</p>
     <!-- third row   -->
       <p style="text-align: left;margin-left: 39px;font-weight: bold;margin-top: 10px;">Father's Name: <span id="fname"> {{ strtoupper($candidate->fathername) }}</span></p>
        <!-- fourth row   -->
       <p style="text-align: left;margin-left: 39px;font-weight: bold;margin-top: 8px;">Name of the Training Institute: <span id="instname">{{strtoupper($candidate->approvedprogramme->institute->rci_name).','}} {{strtoupper($candidate->approvedprogramme->institute->rci_district).','}}  {{$candidate->approvedprogramme->institute->rci_pin_code}}</span></p>
    
   <table style="width :94% ; margin-left:40px; margin-right:40px;border: 1px solid black;margin-top: 8px;">
   <tr style="border: 1px solid black;">
   <th style="border: 1px solid black;text-align: center;font-size: 12px;width: 10%;">Paper No.</th>
   <th style="border: 1px solid black;text-align: center;font-size: 12px;width: 10%;"> Paper Code</th>
   <th style="border: 1px solid black;text-align: center;font-size: 12px;width: 40%;"> Paper</th>
   <th style="border: 1px solid black;text-align: center;font-size: 12px;width: 10%;"> Min.Marks </th>
   <th style="border: 1px solid black;text-align: center;font-size: 12px;width: 10%;"> Max.Marks </th>
   <th style="border: 1px solid black;text-align: center;font-size: 12px;width: 10%;">Marks Obtained </th>
   <th style="border: 1px solid black;text-align: center;font-size: 12px;width: 10%;">Results <br> Pass/Fail/Absent </th>
   </tr>
   <tr style="border: 1px solid black;">
       <td style="text-align: center;font-size: 12px;"><b>Theory</b>
       </td> 
       <td></td>
       <td></td>
       <td style="border: 1px solid black;text-align: center;font-size: 12px;border-top-style: hidden;"></td>
       <td style="border: 1px solid black;text-align: center;font-size: 12px;border-top-style: hidden;"></td>
       <td style="border: 1px solid black;text-align: center;font-size: 12px;border-top-style: hidden;"></td>
       <td style="border: 1px solid black;text-align: center;font-size: 12px;border-top-style: hidden;"></td>
   </tr>
   <?php $slno = 1; ?>
   @foreach($applications->sortBy('subject.sortorder') as $application)
        @php 
            $subject = $application->subject;
        @endphp
        @if($subject->subjecttype_id==1 )
            <tr style="border: 1px solid black;">
                <td style="border: 1px solid black;text-align: center;font-size: 12px;">{{ $slno }}<?php $slno++; ?></td>
                <td style="border: 1px solid black;text-align: center;font-size: 12px;">{{$subject->scode}}</td>
                <td style="border: 1px solid black;text-align: center;font-size: 12px;">{{$subject->sname}}</td>
                <td style="border: 1px solid black;text-align: center;font-size: 12px;">{{$subject->emin_marks}}</td>
                <td style="border: 1px solid black;text-align: center;font-size: 12px;">{{$subject->emax_marks}}</td>
                <td style="border: 1px solid black;text-align: center;font-size: 12px;">
                    @if($application->attendance_ex == 1)
                        {{$application->mark_ex + $application->grace}}
                    @endif
                    @if($application->attendance_ex == 2 )
                        AB
                    @endif
                </td>
                <td style="border: 1px solid black;text-align: center;font-size: 12px;">
                    <b>
                        <?php 
                            $stotal = $application->mark_ex; 
                            $subjectresult = 'Pass';
                            if(($application->mark_ex + $application->grace) < $subject->emin_marks){
                                $result = 'Fail';
                                $subjectresult = 'Fail';
                            }
                        ?>
                             @if($application->attendance_ex == 2 )
                                <?php   $subjectresult = 'Absent'; ?>
                            @endif
                         {{ $subjectresult }}
                    </b>
                </td>
            </tr>
        @endif
    @endforeach
    <tr style="border: 1px solid black;">
        <td style="text-align: center;font-size: 12px;"><b>Practical</b>
        </td> 
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    
    <?php $slno = 1; ?>
   @foreach($applications->sortBy('subject.sortorder') as $application)
        @php 
            $subject = $application->subject;
        @endphp
        @if($subject->subjecttype_id==1 )
            <tr style="border: 1px solid black;">
                <td style="border: 1px solid black;text-align: center;font-size: 12px;">{{ $slno }}<?php $slno++; ?></td>
                <td style="border: 1px solid black;text-align: center;font-size: 12px;">{{$subject->scode}}</td>
                <td style="border: 1px solid black;text-align: center;font-size: 12px;">{{$subject->sname}}</td>
                <td style="border: 1px solid black;text-align: center;font-size: 12px;">{{$subject->emin_marks}}</td>
                <td style="border: 1px solid black;text-align: center;font-size: 12px;">{{$subject->emax_marks}}</td>
                <td style="border: 1px solid black;text-align: center;font-size: 12px;">
                    @if($application->attendance_ex == 1)
                        {{$application->mark_ex + $application->grace}}
                    @endif
                    @if($application->attendance_ex == 2 )
                        AB
                    @endif
                </td>
                <td style="border: 1px solid black;text-align: center;font-size: 12px;">
                    <b>
                        <?php 
                            $stotal = $application->mark_ex; 
                            $subjectresult = 'Pass';
                            if(($application->mark_ex + $application->grace) < $subject->emin_marks){
                                $result = 'Fail';
                                $subjectresult = 'Fail';
                            }
                        ?>
                        @if($application->attendance_ex == 2 )
                            <?php   $subjectresult = 'Absent'; ?>
                        @endif
                        {{ $subjectresult }}
                    </b>
                </td>
            </tr>
        @endif
    @endforeach
   <?php                                             $total = $candidate->allresults()->first()->first_year_total;   $totalinword = $candidate->numbertoword($total); ?>
   <tr style="border: 1px solid black;">
   <td style="text-align: right;" >In Words: </td>
   <td style="text-align: left;font-size: 12px;" ><b>  {{$totalinword}}</b></td>
   <td style="text-align: right;"><b>Total Marks Obtained</b></td>
   <td style="border: 1px solid black;text-align: center;font-size: 12px;">184</td>
   <td style="border: 1px solid black;text-align: center;font-size: 12px;">400</td>
   <td style="border: 1px solid black;text-align: center;font-size: 12px;">{{$total}}</td>
   <td style="border: 1px solid black;text-align: center;font-size: 12px;"><b>
    <?php 
        $r = $candidate->allresults()->first()->first_year_result;
    if($r==1){
        $result = 'Pass';
    }else{
        $result = 'Fail';
    }
?>

{{$result}}
    </b></td>
   </tr>
   </table>
  
       <p style="text-align: left;margin-left: 39px;font-weight: bold;margin-top: 26px;"><b>Result : {{$result}}</b></p>
       <?php $percentage = $candidate->allresults()->first()->final_percentage; ?>
       <p style="text-align: center;font-weight: bold;margin-top: -35px;">Percentage : <u>{{number_format($percentage,2)}}%</u></p>
       <p style="text-align: right;font-weight: bold;margin-top: -25px;margin-right: 27px;">Grade: <u><span id="grade">
        @if($percentage > 59.99  )
            A
        @else
            @if($percentage < 60 && $percentage > 49.99)
                B
            @else
                C
            @endif
        @endif
    </span></u></p> 
  
       
       <p style="text-align: left;margin-left: 39px;font-weight: bold;margin-top: 25px;"><b>Date of Issue :</b><u>{{\Carbon\Carbon::parse($candidate->allresults()->first()->marksheetissuded_date)->format('d-m-Y')}}</u></p> 
       <p style="text-align: left;margin-left: 39px;font-weight: bold;margin-top: 5px;"><b>Date of declaration of Result :</b><u>{{\Carbon\Carbon::parse($candidate->allresults()->first()->marksheetissuded_date)->format('d-m-Y')}}</u></p>
       
     <div style="margin-top: -76px;margin-bottom: 33px;">
   <div style="text-align: center;margin-right: 65px;margin-top: 0px;">
       <p><img src="/var/www/html/rcinber/public/files/signs/ss.png" style="width: 133px;transform: translateZ(0);"oncontextmenu="return false;"></p>   
</div> 
<h1 align= "center"style="font-size: 16px;margin-top: -14px;margin-right: 56px;"><b>( Dr.Subodh Kumar )</b></h1>
    <h1 align= "center"style="font-size: 16px;margin-top: -10px;;margin-right: 56px;"><b>Deputy Director RCI</b></h1>   
</div>
   
   <div style="margin-top: -134px;margin-bottom: 25px;">
   <div style="text-align: right;margin-right: 65px;margin-top: 0px;">
       <p><img src="/var/www/html/rcinber/public/files/cbid/cbidheader.png" style="width: 133px;transform: translateZ(0);"oncontextmenu="return false;"></p>   
</div> 
<h1 align= "right"style="font-size: 16px;margin-top: -14px;margin-right: 56px;"><b>(  Dr.Honnareddy N  )</b></h1>
    <h1 align= "right"style="font-size: 16px;margin-top: -10px;;margin-right: 56px;"><b>Secretary,NBER</b></h1>   
</div>
 <p style="text-align: left;margin-left: 39px;font-weight: bold;margin-top: -21px;"><b>* Denotes Grace Marks Allotted</b></p>
  <p style="text-align: left;margin-left: 39px;font-weight: bold;margin-top: 0px;"><b>Note : 60% and above - A ,50% to 59% - B,49% and below - C.</b></p>
  </div>
 </div>
<br>
<br>

</body>
</html>