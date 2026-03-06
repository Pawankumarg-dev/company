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
                        Question Paper
                    </th>
                </tr>
                @foreach($timetables as $timetable)
                <tr>
                    <td>
                        {{$slno}}
                        <?php $slno++; ?>
                    </td>
                    <td>
                        {{$timetable->examdate->format('d-M-Y')}}
                    </td>
                    <td>
                        {{\Carbon\Carbon::parse($timetable->starttime)->format('h:i A')}}
                    </td>
                    <td>
                        {{\Carbon\Carbon::parse($timetable->endtime)->format('h:i A')}}
                    </td>
                    <td>
                    <a href="{{url('nber/questionpapers')}}?examdate={{$timetable->examdate}}&starttime={{$timetable->starttime}}&endtime={{$timetable->endtime}}"  class="btn btn-warning btn-sm"  style="margin-left:10px;"> Question Paper Upload</a>
                    </td>
                </tr>
                @endforeach
        </div>
    </div>
</div>
@endsection