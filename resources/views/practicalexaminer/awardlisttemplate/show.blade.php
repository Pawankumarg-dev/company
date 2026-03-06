@extends('layouts.app')
@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-12">
            @include('common.errorandmsg')
            @include('institute.exam.markentry._scripts')

            
            <?php $slno = 1; ?>
            <h4>Practical Exams - Mark Entry</h4>
            <h5>{{$ap->programme->course_name}}</h5>
            <h5>{{$subject->scode}} - {{$subject->sname}}</h5>
            <h6> Min: {{$subject->emin_marks}}, Max: {{$subject->emax_marks}} </h6>
            <form action="{{url('/practicalexam/home')}}/{{$template->id}}" method="POST" >
                <input type="hidden" name="_method" value="PUT"> 
                <input type="hidden" name="subject_id" value="{{$subject->id}}">
                {{ csrf_field() }}
                @include('practicalexaminer.awardlisttemplate._script')
                @include('practicalexaminer.awardlisttemplate._savebtn')
                <table class="table table-bordered">
                    <tr>
                        <th>SlNo</th>
                        <th>Enrolmentno</th>
                        <th>Name</th>
                        <th>Obtained marks</th>
                    </tr>
                    @foreach($applications->sortBy('candidate.enrolmentno') as $application)
                        <tr>
                            <td>
                                {{$slno}} <?php $slno++; ?>
                            </td>
                            <td>
                                {{$application->candidate->enrolmentno}}
                            </td>
                            <td>
                                {{$application->candidate->name}}
                            </td>
                            <td>
                                <input 
                                    name="mark_{{$application->id}}" 
                                    type="text" style="width: 30px;border:solid 1px #ccc;" 
                                    value="{{$application->mark_ex}}"
                                    onkeypress='return event.charCode >= 48 && event.charCode <= 57'   
                                    onkeyup="this.value = minmax(this.value, 0, {{$subject->emax_marks}})"
                                >
                                <input name="absent_{{ $application->id }}" @if($application->attendance_ex == 2)  checked @endif type="checkbox"> Absent
                            </td>
                        </tr>
                        
                    @endforeach
                </table>
                @include('practicalexaminer.awardlisttemplate._savebtn')
            </form>
            
        </div>
    </div>
</div>
@endsection