@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
            <h3>{{$exam->name}} Examinations</h3>
            @include('common.errorandmsg')
            <form class="form-horizontal"  action="{{url('nber/exam/schedules')}}"  method="POST">
                <input type="hidden" name="exam_id" value="{{Session::get('exam_id')}}">
                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                {{ csrf_field() }}
               <div class="col-md-4">
                <div class="form-group ">
                    <label for="examdate">Exam Date</label>
                    <input  type="date" name="examdate" id="examdate" placeholder="Exam Date" value="{{old('examdate')}}"   class="form-control" >
                </div>
                <div class="form-group ">
                    <label for="starttime">Start Time</label>
                    <input  type="time" name="starttime" id="starttime" placeholder="Start Time" value="{{old('starttime')}}" class="form-control" >
                </div>
                <div class="form-group ">
                    <label for="starttime">End Time</label>
                    <input  type="time" name="endtime" id="endtime" placeholder="End Time" class="form-control" value="{{old('endtime')}}">
                </div>
                <div class="form-group ">
                    <label for="starttime">Description <small> (For Reference) Ex: Day 1 Afternoon</small></label>
                    <input  type="text" name="description" id="description" placeholder="Description " class="form-control" value="{{old('name')}}">
                </div>
                <div class="form-group ">
                    <button class="btn btn-primary " style="margin-top:5px;margin-bottom:10px;" id="save" >Save</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection