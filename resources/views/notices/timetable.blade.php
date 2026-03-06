@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-6">
            <?php $slno = 1; ?>
            <h3>Time Table - Theory</h3>
            <h4>June 2025 Examinations </h4>
            <br>
            <form action="{{url('/exam-timetable')}}" method="get">
                {{csrf_field()}}
               <div class="form-group mb-3">
                <div class="form-group">
                    <label for="contactnumber" class="control-label">Course </label>
                    <select  id="course_id" name="course_id" class="form-control">
                        <option value="">-- Select Course --</option>
                        @if(!is_null($courses))
                            @foreach($courses as $c)
                                <option value="{{ $c->id }}" @if(!is_null($course) && $c->id == $course->id) selected @endif>{{$c->name}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <label for="contactnumber" class="control-label">Academic Year</label>
                    <select  id="academicyear_id" name="academicyear_id" class="form-control">
                        <option value="">-- Select Academicyear --</option>
                        <option value="9" @if($academicyear_id == 9) selected @endif> 2021</option>
                        <option value="10" @if($academicyear_id == 10) selected @endif> 2022</option>
                        <option value="11" @if($academicyear_id == 11) selected @endif> 2023</option>
                        <option value="12" @if($academicyear_id == 12) selected @endif> 2024</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="contactnumber" class="control-label">Term</label>
                    <select  id="syear" name="syear" class="form-control" style="margin-bottom: 10px;">
                        <option value="">-- Term --</option>
                        <option value="1" @if($syear == 1) selected @endif> I</option>
                        <option value="2" @if($syear == 2) selected @endif> II</option>
                    </select>
                </div>
                <div class="form-group" style="margin-top:10px!important;">
                    <button type="submit" class="btn btn-sm btn-primary"> Show </button>
                </div>
                </div>
            </form>
        </div>
    </div>
            @if(!is_null($timetables))     
                @if($timetables->count()>0)
            	<div class="row">
                    <div class="col-md-12">
                        <table id="examTimetable" class="table table-bordered table-striped table-hover">
                            <tr>
                                <th>
                                    SlNo
                                </th>
                                <th class="hidden">
                                    Revision / Syllubus
                                </th>
                                <th>
                                    Term
                                </th>
                                <th>
                                    Subject Code
                                </th>
                                <th>Subject OMR code</th>
                                <th>
                                    Subject
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
                                {{-- <th>Description</th> --}}
                            
                            </tr>
                            @foreach($timetables->sortBy('examschedule.examdate') as $timetable)
                                @if($timetable->id != 2686 && $timetable->id != 2687 && $timetable->id != 2688 && $timetable->id != 2689 )
                                    <tr>
                                        <td>
                                            {{$slno}} 
                                            <?php $slno++; ?>
                                        </td>
                                        <td class="hidden">
                                            {{ $timetable->subject->programme->revision_year }}
                                        </td>
                                        <td>
                                            {{$timetable->subject->syear}}
                                        </td>
                                        <td>
                                            {{$timetable->subject->scode}}
                                        </td>
                                        <td>
                                            {{ str_pad($timetable->subject->omr_code,5,'0', STR_PAD_LEFT) }}
                                        </td>
                                        <td>
                                            {{$timetable->subject->sname}}
                                        </td>
                                        <td>
                                            @if($timetable->id == 2354)
                                                24-Jun-2025 
                                            @else 
                                                @if($timetable->id == 2421)
                                                    26-Jun-2025 
                                                @else
                                                    @if($timetable->id == 2460)
                                                        27-Jun-2025 
                                                    @else
                                                        @if($timetable->id == 2502)
                                                            27-Jun-2025 
                                                        @else 
                                                            {{\Carbon\Carbon::parse($timetable->examschedule->examdate)->format('d-M-Y')}}
                                                        @endif 
                                                    @endif 
                                                @endif 
                                            @endif
                                        </td>
                                        <td>
                                            {{\Carbon\Carbon::parse($timetable->examschedule->starttime)->format('h:i A')}}
                                        </td>
                                        <td>
                                            {{\Carbon\Carbon::parse($timetable->examschedule->endtime)->format('h:i A')}}
                                        </td>
                                        {{-- <td>
                                            {{$timetable->examschedule->description}}
                                        </td> --}}
                                    </tr>
                                @endif
                            @endforeach
                        </table>
                    </div>
                </div>
                @else
                	<div class="row">
                        <div class=" col-md-12">
                    <div class="alert alert-danger">No schedule found</div>
                </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
<script>
    
</script>
@endsection