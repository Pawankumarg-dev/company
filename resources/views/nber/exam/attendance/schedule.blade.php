@extends('layouts.app')
@section('content')

<div class="container">
	<div class="row">
		<div class="col-12">
            <h4><b>Exam Attedance and Evaluation Progress Tracker</b></h4>
            @if(is_null($externalexamcenter_id) || $externalexamcenter_id == 0 ) 
                <div class="alert alert-success">
                    Click on the <b>Download Progress</b> below for  the scheduled exam. <br>
                    For scanned copy of attendance sheet and other details, select the exam center and click on <b>Go</b>.
                </div>
            @endif
            <h6>Exam Center</h6>
            <form action="{{url('nber/exam/attendance/')}}" method="get">
                {{ csrf_field() }}
                <div class="form-group mb-3">
                    <div class="input-group">
                        <select name="externalexamcenter_id" class="form-control">
                            <option value="0" > -- All Centers -- </option>
                            @foreach($examcenters as $ec)
                                <option value="{{$ec->externalexamcenter_id}}"
                                    @if($externalexamcenter_id == $ec->externalexamcenter_id)
                                    selected
                                    @endif
                                >{{$ec->externalexamcenter->code}}-{{$ec->externalexamcenter->name}}</option>
                            @endforeach
                        </select>
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-sm btn-primary"> Go </button>
                        </span>
                    </div>
                </div>
                
            </form>
            @if(!is_null($schedules))
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
                 
               
                    <th class="bg-danger text-center">
                         Attendance and Evaluation
                    </th>
                </tr>
                <?php $slno = 1; $examdate = null; ?>

                @foreach ( $schedules as $s )
                @if($s->examdate != $examdate)
                <tr>
                    <th colspan='8' style="background-color:#F39532;">
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
                    <td class="text-center bg-danger">
                        @php
                            $now = Carbon\Carbon::now();
                        @endphp
                        @if(($now->toTimeString() >= \Carbon\Carbon::parse($s->starttime)->toTimeString() && ($now->toDateString() == $examdate) )|| $now->subDays(1) > $examdate )
                        <a href="{{url('nber/exam/attendance/')}}/{{$externalexamcenter_id ? $externalexamcenter_id : 0}}?examschedule_id={{$s->id}}" class="btn btn-xs btn-success">@if(is_null($externalexamcenter_id) || $externalexamcenter_id == 0 ) Download Progress Sheet @else View Details @endif </a>
                        @endif
                    </td>
                   
                </tr>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection