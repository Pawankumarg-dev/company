@extends('layouts.smalltable')
@section('fields')
	{!! Form::bsText('code','Code') !!}
	{!! Form::bsText('coursename','coursename') !!}
	{!! Form::bsText('name','Name') !!}
	{!! Form::bsSelect('programmegroup_id',$programmegroups,'name','Programme Group') !!}
	{!! Form::bsText('enrolmentcode','Enrolment Code') !!}			
	{!! Form::bsText('numberofterms','Number of Terms') !!}		
	<div class="showhidenber">
		{!! Form::bsSelect('nber_id',$nbers,'name','Exams Handled By') !!}			
	</div>
    {!! Form::bsSelect('active_status',$status,'value','Status') !!}			
    {!! Form::bsSelect('recognised_by',$authority,'value','Recognize By') !!}			
    {!! Form::bsSelect('approval_letter_required',$approval,'value','RCI Approval') !!}			

@endsection
@section('table')
	<tr>
	<th>Code</th>
		<th>Abbreviation</th>
		<th>Name</th>
		<th>Programme Group</th>
		<th>Enrolment Code</th>
		<th>Number of Terms</th>
		<th>Exams Handled By</th>
		<th>Recognize By</th>
		<th>Status</th>
		<th>Links</th>
		<th>Action</th>
	</tr>
	@foreach($collections as $c)
		<tr>
        	{!! Form::tbText('code',$c) !!}
        	{!! Form::tbText('coursename',$c) !!}
        	{!! Form::tbText('name',$c) !!}
        	{!! Form::tbSelect('programmegroup','name',$c) !!} 
        	{!! Form::tbText('enrolmentcode',$c) !!}
        	{!! Form::tbText('numberofterms',$c) !!}
        	{!! Form::tbSelect('nber','name_code',$c) !!} 
        	{!! Form::tbText('recognised_by',$c) !!}
			<td>@if($c->active_status == 1) <span class="btn btn-xs btn-success" > Active </span> @else <span class="btn btn-xs btn-danger" > Discontinued </span>  @endif 
                <input type="hidden" id="active_status_{{$c->id}}" value="{{$c->active_status}}">
            </td>
			
			<td> 
        		<a href="{{url('subjects')}}/{{$c->id}}" class="btn btn-xs btn-info" > Subjects </a> 
        		<!--<a href="{{url('programmeapplications')}}?p={{$c->id}}" class="btn btn-xs btn-info" > Institutes </a> 
        		<a href="{{url('candidateapplications')}}?c={{$c->id}}" class="btn btn-xs btn-info" > Candidates </a>  -->
        	</td>
        	{!! Form::tbEdit($link,$c) !!}
		</tr>
    @endforeach
@endsection
@section('createscript')
$('.showhidenber').removeClass('hidden');
@endsection

@section('editscript')
	{!! Form::tbEditscript('code',$link,'input') !!}
	{!! Form::tbEditscript('coursename',$link,'input') !!}
	{!! Form::tbEditscript('name',$link,'input') !!}
	{!! Form::tbEditscript('enrolmentcode',$link,'input') !!}
	{!! Form::tbEditscript('numberofterms',$link,'input') !!}
	{!! Form::tbEditscript('recognised_by',$link,'select') !!}
	{!! Form::tbEditscript('programmegroup_id',$link,'select') !!}
	{!! Form::tbEditscript('nber_id',$link,'select') !!}
	{!! Form::tbEditscript('active_status',$link,'select') !!}
	{!! Form::tbEditscript('approval_letter_required',$link,'select') !!}
	$('.showhidenber').addClass('hidden');
@endsection