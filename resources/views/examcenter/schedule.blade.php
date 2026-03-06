@extends('layouts.app')
@section('content')
<script>
    function goto(id,format){
        // swal({
        //     type: 'success',
        //     title: "Downloading...",
        //     text: "Please wait",
        //     showConfirmButton: true,
        //     timer: 3500
        // });
        
        var url  = $('.goto_'+id).data('url');
        
        if(format=='pdf'){
            var url = url +"&format=pdf";
            window.open(url) || window.location.replace(url);
        }else{
            var url = url +"&format=html";
            window.open(url) || window.location.replace(url);
        }
    }
</script>
<div class="container">
	<div class="row">
		<div class="col-12">
            @include('common.errorandmsg')
            <div class="alert alert-danger">
                <b>Important Notice:</b>
                <ul>
                    <li>
                        ⁠Question Paper download link will be accessible only <b>one time</b> to download the Question Paper. 
                    </li>
                    <li>
                    ⁠Do not use the portal password to download QP from multiple computers or devices.
                    </li>
                    <li>
                         ⁠Link will not be working once QP is downloaded or logged into the portal from another computer or other devices.
                    </li>
                    <li>
                         ⁠QP can be downloaded only from one computer.
                    </li>
                    <li>
                        ⁠Each QP can be downloaded only once.
                    </li>
                    <li class="hidden">
                        ⁠Password for the portal is reset and emailed to the CS’s email ID for few exam centers where QP was accessed from multiple devices / IP address. Please keep the confidentiality of the password.
                    </li>
                </ul>
            </div>

            <div class="alert alert-success ">
               <ul>
                <li>
                    <p>
                    Kindly read the <a target="_blank" href="{{url('files/examcenter/guidelines.pdf')}}"> guide lines</a> for using the portal.
                </p>
                </li>
               
                <li>Click <a target="_blank" href="{{ url('/files/examcenter/evalutioncenter.pdf') }}"><b>here</b> </a>to download the address of <b>evaluation centers </b> where answer booklets to be sent by end of the day.  </li>

                
               </ul>
                


            </div>
            <div class="alert alert-danger" style="display:none;">
                
                <p>
                    D.Ed Spl Ed.(HI) students having hearing impairment are eligible to choose alternative paper for the Subject <b>RP01-T05</b> (for all the batches).
                    You may provide alternative papers if any student with hearing impariment requests for the same. Students having disabilies are marked as PwD in the seating plan, next to their name.
                    Kindly take a note of this for today's (14/6/2024) morning exam.
                </p>
                <p>
                    <b>FAQ:</b> <br>
                    <ul>
                        <li>If student has not choosen alternative paper in the exam application and not reflected in the hallticket, are they eligible to write alternative paper? <b>Yes</b>, if student is having hearing impairment</li>
                        
                    </ul>
                    <b>Following are the subject titile for paper RP01-T05</b>
                    <table class="table  table-bordered table-condensed">
                        <tr>
                            <th>Main Paper</th>
                            <td>Fundamentals of Speech and Speech Teaching	</td>
                        </tr>
                        <tr>
                            <th>Alternative Paper</th>
                            <td>
                                Receptive & Expressive Language
                            </td>
                        </tr>
                    </table>
                </p>
            </div>
            <table class="table table-bordered  table-hover">
                <tr>
                    <th>
                        SlNo
                    </th>
                    <th>
                        Description
                    </th>
                    
                    <th>
                        Start Time
                    </th>
                    <th>
                        End Time
                    </th>
                    <th>
                        No of Students
                    </th>
                    <th class="bg-danger text-center">
                        Attendance Sheet
                    </th>
                    <th class="bg-danger text-center">
                        Room Allocation
                    </th>
                 
                    <th class="bg-danger text-center">
                        Question Paper
                    </th>
                    <th class="bg-danger text-center">
                        Upload Attendance
                    </th>
                </tr>
                <?php $slno = 1; $examdate = null; ?>
                @foreach ( $schedules->sortBy('examdate') as $s )
                @if($s->examdate != $examdate)
                <tr>
                    <th colspan='9' style="background-color:#F39532;">
                        {{\Carbon\Carbon::parse($s->examdate)->format('d-M-Y')}}
                    </th>
                </tr>
                @endif
                <?php $examdate = $s->examdate ?>
                <tr>
                    <td>{{$slno}} <?php $slno++; ?></td>
                    <td>
                        {{$s->description}}
                    </td>
                    <td>
                        {{\Carbon\Carbon::parse($s->starttime)->format('h:i A')}}
                    </td>
                    <td>
                        {{\Carbon\Carbon::parse($s->endtime)->format('h:i A')}}
                    </td>
                    <td class="text-center ">
                        <span  class="">
                            {{$s->count}}
                        </span>
                        
                    </td>
                    @php
                        $now = Carbon\Carbon::now();
                        $examdatem1 =  \Carbon\Carbon::parse($examdate)->subDays(2)->toDateString();
                    @endphp
                    <td class="text-center bg-danger">
                       
                          {{-- <a href="javascript:goto('attn_'+{{$s->id}},'html')" class="btn btn-primary btn-xs hidden ">Print Attendance Sheet</a> --}}
                          
                          <a href="javascript:goto('attn_'+{{$s->id}},'html')" class="btn btn-primary btn-xs  ">Print Attendance Sheet</a>
                        <span class="goto_attn_{{$s->id}} " data-url="{{url('examcenter/schedule')}}/{{$s->id}}?"></span>
                    </td>
                    <td class="text-center bg-danger">
                            {{-- <span class=" hidden  btn btn-xs btn-primary goto_{{$s->id}}" data-url="{{url('examcenter/schedule')}}/{{$s->id}}?roomallocation=yes"> </span> --}}
                            {{-- <a class="  btn btn-xs btn-success"  href="javascript:goto({{$s->id}},'pdf')">Print Room Allocation Sheet</a> --}}
                        
                            <span class=" hidden  btn btn-xs btn-primary goto_{{$s->id}}" data-url="{{url('examcenter/schedule')}}/{{$s->id}}?roomallocation=yes"> </span>
                            <a class="btn btn-xs btn-primary  " href="javascript:goto({{$s->id}},'html')">Print Room Allocation Sheet</a>
                    </td>
                    <td class="text-center bg-danger">
                        {{-- @if($s->description == 'Mock Drill'  || Auth::user()->id == 134579 || (  $s->qpset > 0  && ($s->id == 54   )))
                                <a style=""  class="btn btn-xs btn-primary  " href="{{url('examcenter/questionpaper')}}?examschedule_id={{$s->id}}">Download</a> 
                        @endif --}}

                        {{-- @if(
                              ($s->id == 69 || $s->id == 70 ) 
                            ) --}}

                            <?php 
                            $date = \Carbon\Carbon::now()->toDateString();
                            $sdate = \Carbon\Carbon::parse($s->examdate)->toDateString();
                            $time = \Carbon\Carbon::now()->toTimeString();
                            $opentime  = \Carbon\Carbon::parse($s->starttime)->subHours(1)->toTimeString();
                            if($s->count < 100){
                                $opentime  = \Carbon\Carbon::parse($s->starttime)->subMinutes(45)->toTimeString();
                            }
                            if($s->count < 50){
                                $opentime  = \Carbon\Carbon::parse($s->starttime)->subMinutes(35)->toTimeString();
                            }
                            $attendancetime = \Carbon\Carbon::parse($s->starttime)->addHours(1)->toTimeString();
                            $closetime  = \Carbon\Carbon::parse($s->starttime)->addHours(3)->toTimeString();

                            //REMOVE THIS LINE
                            //$opentime  = \Carbon\Carbon::parse($s->starttime)->subHours(4)->toTimeString();

                        ?>
                        
                            @if(
                                $date  == $sdate 
                                && 
                                $time > $opentime && 
                                $time < $closetime 
                                           &&    
                                             (  $s->id == 89 )

                                )
                                <a   class="btn btn-xs btn-primary    " href="{{url('examcenter/questionpaper')}}?examschedule_id={{$s->id}}">Download</a> 
                                @endif
                        {{-- @endif --}}
                    </td>
                    <td class="text-center bg-danger">
                        
                        {{-- @if(   ($now->toTimeString() >= \Carbon\Carbon::parse($s->starttime)->toTimeString() && ($now->toDateString() == $examdate) )|| $now->subDays(1) > $examdate )
                            <a style="" href="{{url('examcenter/attendance?examschedule_id=')}}{{$s->id}}" class="btn btn-xs btn-success @if($s->description == 'Mock Drill') hidden @endif  ">Upload</a>
                        @endif --}}

                        @if(
                               (
                                    $date  == $sdate  && $attendancetime < $time
                               )
                               || 
                               $date > $sdate                                                       

                            )
                            <a  href="{{url('examcenter/attendance?examschedule_id=')}}{{$s->id}}" class="btn btn-xs btn-primary    ">Upload</a>
                        @endif 
                        {{-- <a style="" href="{{url('examcenter/attendance?examschedule_id=')}}{{$s->id}}" class="btn btn-xs btn-success hidden">Upload</a> --}}

                    </td>
                   
                   
                </tr>
                    
                @endforeach
                    
        </div>
    </div>
</div>
@endsection
