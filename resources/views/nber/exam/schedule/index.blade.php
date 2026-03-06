@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-12">
            <?php $slno = 1; ?>
            <h3>{{$exam->name}} Examinations</h3>
            @include('common.errorandmsg')
            <a href="{{url('nber/exam/schedules/create')}}" class="btn btn-primary btn-xs pull-right">Add</a>
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
                    <th>Description</th>
                    <th>Links</th>
                </tr>
                @foreach($schedules as $schedule)
                <tr>
                    <td>
                        {{$slno}}
                        <?php $slno++; ?>
                    </td>
                    <td>
                        {{\Carbon\Carbon::parse($schedule->examdate)->format('d-M-Y')}}
                    </td>
                    <td>
                        {{\Carbon\Carbon::parse($schedule->starttime)->format('h:i A')}}
                    </td>
                    <td>
                        {{\Carbon\Carbon::parse($schedule->endtime)->format('h:i A')}}
                    </td>
                    <td>
                        {{$schedule->description}}
                    </td>
                    <td>
                        <a href="{{url('/nber/exam/schedules/')}}/{{$schedule->id}}" class="btn btn-xs btn-primary " >QP Pattern, Answer Keys & Evaluators</a>
                    </td>
                </tr>
                @endforeach
        </div>
    </div>
</div>
@endsection