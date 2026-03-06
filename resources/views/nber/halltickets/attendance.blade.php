@extends('layouts.approvaltable')
@section('fields')
	{!! Form::bsText('exemption','Exemption') !!}
@endsection
@section('table')
	<tr>
		<td>Name</td>
		<td>Enrolment#</td>
		<td>Course</td>
		<td>Institute</td>
		<td>Exemption Doc</td>
        <td>Attendance Docs</td>
		<td>Status</td>
		<td>Action</td>
	</tr>
	@foreach($collections as $c)
		<tr>
        	{!! Form::tbText('name',$c->candidate) !!}
        	{!! Form::tbText('enrolmentno',$c->candidate) !!}
        	{!! Form::tbText('coursename',$c->candidate->approvedprogramme->programme) !!}
        	<td>
                <a href="#" data-toggle="tooltip" title="{{$c->candidate->approvedprogramme->institute->name}}">{{$c->candidate->approvedprogramme->institute->user->username}}
                </a>

                
            </td>
        	<td>
        		<a target="_blank" href="{{asset('/files/attendance/')}}/{{$c->document_exemption}}" class="btn btn-xs btn-link"> <i class="fa fa-eye"> </i> Exemption </a> 
            </td>
            <td>
                 <a target="_blank" href="{{asset('/files/attendance/')}}/{{$c->document_t}}" class="btn btn-xs btn-link"> <i class="fa fa-eye"> </i>Theory-{{$c->attendance_t}}%</a>
                 <a target="_blank" href="{{asset('/files/attendance/')}}/{{$c->document_p}}" class="btn btn-xs btn-link"><i class="fa fa-eye"> </i> Practical-{{$c->attendance_p}}%</a>
        		
        	</td>
        	
            <td>
                {!! $c->status->statushtml() !!}
            </td>
            <td>
                                    @if($c->exemption != '2')
                                    <a href="{{url('/changeexemption/2/')}}?id={{$c->id}}" class="btn btn-success btn-xs">Approve</a>
                                    @endif
                                    @if($c->exemption != '3')
                                    <a href="{{url('/changeexemption/3/')}}?id={{$c->id}}" class="btn btn-danger btn-xs">Reject</a>
                                    @endif
                                    @if($c->exemption != '1')
                                    <a href="{{url('/changeexemption/1/')}}?id={{$c->id}}" class="btn btn-warning btn-xs">Hold</a>
                                    @endif
            </td>


		</tr>
    @endforeach
@endsection
@section('editscript')
	<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});
</script>
@endsection