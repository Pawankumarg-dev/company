@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-12">
            <h3>Sept-Oct 2023 Examinations - Time Table</h3>
            <table class="table table-bordered table-striped table-hover">
                <tr>
                    <th style="width:100px;">
                        Date
                    </th>
                    <th style="width:80px;">
                        Start Time
                    </th>
                    <th style="width:80px;">
                        End Time
                    </th>
                    <th>
                        Course Code
                    </th>
                    <th>
                        Course
                    </th>
                    <th>
                        Subject Code
                    </th>
                    <th>
                        Subject
                    </th>
                    <th>
                        NBER
                    </th>
                    
                </tr>
                @foreach($timetables->sortBy('examdate') as $tt)
                <tr>
                    <td style="width:100px;">

                        {{$tt->examdate->format('d-M-Y')}}
                    </td>
                    <td style="width:80px;">
                        {{\Carbon\Carbon::parse($tt->starttime)->format('h:i A')}}
                    </td>
                    <td style="width:80px;">

                        {{\Carbon\Carbon::parse($tt->endtime)->format('h:i A')}}
                    </td>
                    <td>
                        {{$tt->subject->programme->course_name}}
                    </td>
                    <td>
                        {{$tt->subject->programme->name}}
                    </td>
                    <td>
                    {{$tt->subject->scode}}
                    </td>
                    <td>
                    {{$tt->subject->sname}}
                    </td>
                    <td>
                    {{$tt->subject->programme->nber->name_code}}
                    </td>
                
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection