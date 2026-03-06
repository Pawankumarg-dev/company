@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-6">
            <?php $slno = 1; ?>
            <h3>{{$exam->name}} Examinations</h3>
            <h4> {{$programme->course_name}} - Create Exam Timetable</h4>
            @include('common.errorandmsg')

            <br>
            <form action="{{url('/nber/exam/timetable')}}" method="post">
                {{csrf_field()}}
                    <input type="hidden" name="exam_id" value="{{$exam->id}}">
                    <input type="hidden" name="programme_id" value="{{$programme->id}}">
                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                    <div class="form-group mb-3 ">
                        <label for="examdate">Subject</label>
                        <select  id="subject_id" name="subject_id" class="form-control">
                            <option value="">-- Select Subject --</option>
                            @foreach($subjects as $s)
                                <option value="{{ $s->id }}">{{ $s->scode }} - {{$s->sname}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3 ">
                        <label for="examdate">Date and Time</label>
                        <select  id="examschedule_id" name="examschedule_id" class="form-control">
                            <option value="">-- Exam Date --</option>
                            @foreach($schedules as $s)
                                <option value="{{ $s->id }}">{{ $s->examdate }} - {{$s->starttime}} to {{$s->endtime}} ( {{$s->description}} ) </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3 ">
                            <button type="submit" class="btn btn-sm btn-primary"> Save </button>
                            <a href="{{url('nber/exam/timetable?programme_id=')}}{{$programme->id}}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection