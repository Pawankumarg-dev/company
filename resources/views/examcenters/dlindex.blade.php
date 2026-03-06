@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-12">
            <?php $slno = 1; ?>
            <h3>Sep-Oct 2023 Examinations</h3>
            <table class="table table-bordered table-striped table-hover">
                <tr>
                    <th>
                        SlNo
                    </th>
                    <th>
                        Date
                    </th>
                    <th>
                        Start Time
                    </th>
                    <th>
                        End Time
                    </th>
                    <th>
                        Seat Allocation
                    </th>
                    <th>
                        Attendance
                    </th>
                 
                </tr>
                @foreach($timetables as $timetable)
                @if($timetable->examdate->format('d-M-Y')=='09-Sep-2023' || $timetable->examdate->format('d-M-Y') == '10-Sep-2023')
                <tr>
                    <td>
                        {{$slno}}
                        <?php $slno++; ?>
                    </td>
                    <td>
                        @if($timetable->examdate->format('d-M-Y') == '09-Sep-2023')
                            23-Sep-2023
                        @endif
                        @if($timetable->examdate->format('d-M-Y') == '10-Sep-2023')
                            30-Sep-2023
                        @endif
                    </td>
                    <td>
                        {{\Carbon\Carbon::parse($timetable->starttime)->format('h:i A')}}
                    </td>
                    <td>
                        {{\Carbon\Carbon::parse($timetable->endtime)->format('h:i A')}}
                    </td>
                    <td>
                        <a href="{{url('examcenter/listofcandidates')}}?examdate={{$timetable->examdate}}&starttime={{$timetable->starttime}}&endtime={{$timetable->endtime}}"  class="btn btn-success btn-sm" style="margin-left:10px;" target="_blank"> <i class="fa fa-print"> </i> &nbsp; Print Seat Allocation </a>
                    </td>
                    <td>
                        <a href="{{url('printstudentlist')}}?examdate={{$timetable->examdate}}&starttime={{$timetable->starttime}}&endtime={{$timetable->endtime}}"  class="btn btn-success btn-sm" style="margin-left:10px;" target="_blank"><i class="fa fa-print"> </i> &nbsp;Print Attendance Sheet</a>
                            <a href="{{url('examcenter/attendance')}}?examdate={{$timetable->examdate}}&starttime={{$timetable->starttime}}&endtime={{$timetable->endtime}}"  class="btn btn-warning btn-sm"  style="margin-left:10px;"> <i class="fa fa-check"></i> Mark  attendance</a>
                    </td>
                    
                </tr>
                @endif
                @endforeach
        </div>
    </div>
</div>
@endsection