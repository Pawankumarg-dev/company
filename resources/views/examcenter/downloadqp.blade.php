@extends('layouts.app')
@section('content')

<div class="container">
	<div class="row">
		<div class="col-12">
            <table class="table table-bordered  table-hover">
                <tr>
                    <th>
                        SlNo
                    </th>
                    <th>NBER</th>
                    <th>Email</th>
                    <th>
                        Course
                    </th>
                    <th>
                        Subject Code
                    </th>
                    
                    <th>
                        Subject Name
                    </th>
                    
                    <th class="bg-danger text-center">
                        Question Paper
                    </th>
                </tr>
                <?php $slno = 1; $examdate = null; ?>
                @foreach($examschedule->examtimetables as $examtimetable)
                <tr>
                    <td>{{$slno}} <?php $slno++; ?></td>
                    <td>{{$examtimetable->subject->programme->nber->name_code}}</td>
                    <td>{{$examtimetable->subject->programme->nber->email}}</td>
                    <td>{{$examtimetable->subject->programme->course_name}}</td>
                    <td>{{$examtimetable->subject->scode}}</td>
                    <td>{{$examtimetable->subject->sname}}</td>
                    <td class="text-center bg-danger">
                        @foreach($examtimetable->languages as $questionpaper)
                            <a href="{{url('sample.pdf')}}" class="btn btn-xs btn-primary" style="margin-right:5px;"> {{$questionpaper->language}} </a>
                        @endforeach
                    </td>
                </tr>
                @endforeach
            </table>
                    
        </div>
    </div>
</div>
@endsection