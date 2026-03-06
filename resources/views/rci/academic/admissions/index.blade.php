@extends('layouts.smalltable')
@section('fields')
<input type="hidden" name="institute_id" id="institute_id">	
    
		<label for=""> 
		</label>
		<select name="programme_id" id="programme_id" class="form-control">
			@foreach($programmes as $programme)
				<option value="{{ $programme->id }}">{{ $programme->course_name }} - {{ $programme->nber->short_name_code }}</option>
			@endforeach
		</select>
		
	{!! Form::bsText('maxintake','Maximum Intake') !!}
	<input type="checkbox" name="enable_admission"> Enable Admission
	{{ Form::bsDate('enable_admission_till',"Enable Till") }}

@endsection
@section('content')
<?php 
$search_text ='';
if (isset($_GET['search'])) {
    $search_text = $_GET['search'];
}
?>
<script>
	$('#academics').attr('disabled',true);
	$('#academics').addClass('hidden');
	function addnew(id){
		$('select[name="programme_id"]').attr('disabled',false);
		var existing = JSON.parse($('#already_'+id).val());
		$("#programme_id > option").each(function() {
			if(existing.indexOf(parseInt(this.value)) > -1){
				$(this).attr('disabled',true);
			}
		});
		$('input[name="maxintake"]').val(35);
		$('#academics_new_modal').modal('show');
		$('#institute_id').val(id);
		$('input[name="enable_admission"]').attr('checked',false);
	}
</script>
<div class="container-fluid">
	
	<div class="row">
		<div class="col-12">
			<form action="{{url('/rci/admissions')}}" method="get">
			<input type="text" placeholder="Search with Insititue code, name or address" value="{{$search_text}}" name="search" class="form-control pull-left" style="width:300px;margin-left:10px;" /> 
			<button class="btn btn-xm btn-primary pull-left">Search</button>
			
			<a href="{{url('/rci/admissions')}}" class="btn  pull-left btn-info">Clear</a>
			</form>
		</div>
	</div>
</div>
@endsection
@section('table')
	<?php $open = $currentacademicyear->id == $academicyear_id && $enrolment == 1; ?>
	<tr>
		<td>Institue Code (Provided by RCI)</td>
		<td>Institue Code (Provided by NI)</td>
		<td>Name</td>
		<td>Programmes</td>
	</tr>
	@foreach($collections as $c)
		<?php $approvedprogrammes = \App\Approvedprogramme::where('institute_id',$c->id)->where('academicyear_id',$academicyear_id)->withTrashed()->get(); ?>
		
		<tr>
        	{!! Form::tbText('rci_code',$c) !!}
			<td>
				<input type="hidden" id="username_{{$c->id}}" value="{{$c->user->username}}" />
				{{$c->user->username}}
			</td>
        	{!! Form::tbText('name',$c) !!}
			<td>
				<a href="javascript:addnew({{$c->id}});" class="btn btn-xs btn-primary" style="margin-bottom:3px;">Add Programme</a>
				<input type="hidden" id="already_{{$c->id}}" value="{{$approvedprogrammes->pluck('programme_id')}}">
				@if($approvedprogrammes->count() > 0)
					<table class="table table-bordered admission_{{$c->id}}" style="width:500px;">
						<tr>
							<th>Course</th>
							<th>Exam Handled By</th>
							<th>Maximum Intake</th>
							<th>Intake</th>
							@if($open)
							<th>Action</th>
							<th>Admission Exception</th>
							@endif
						</tr>
						@foreach( $approvedprogrammes as $course)
							<tr>
								<td>
									<input type="hidden" id="programme_id_{{$course->id}}" value="{{$course->programme_id}}">
									{{$course->programme->course_name}} @if(!is_null($course->deleted_at)) <span class="btn btn-xs btn-danger">deleted</span> @endif
								</td>
								<td>
									{{$course->programme->nber->name_code}}
								</td>
								<td>
								<input type="hidden" id="maxintake_{{$course->id}}" value="{{$course->maxintake}}">
									{{$course->maxintake}}
								</td>

								<td>{{$course->registered_count}}</td>	
								{!! Form::tbEditDelete($link,$course) !!}

								<td>
									<input type="hidden" id="enable_admission_{{$course->id}}" value="{{$course->enable_admission}}">
									<input type="hidden" id="enable_admission_till_{{$course->id}}" value="{{$course->enable_admission_till}}">

									@if($course->enable_admission == 1)
										Enabled 
									@endif
									@if(!is_null($course->enable_admission_till))
									    till 
										{{  \Carbon\Carbon::parse($course->enable_admission_till)->format('d-M-Y') }} 
									@endif
								</td>

							</tr>
						@endforeach
					</table>
				@endif
			</td>
		</tr>
    @endforeach
@endsection
@section('editscript')
	{!! Form::tbEditscript('programme_id',$link,'select') !!}
	{!! Form::tbEditscript('maxintake',$link,'input') !!}
	{!! Form::tbEditscript('maxintake',$link,'input') !!}
	{!! Form::tbEditscript('enable_admission_till',$link,'input') !!}

	if($('#enable_admission_'+id).val() === '1'){
		$('input[name="enable_admission"]').prop('checked',true);
	}else{
		$('input[name="enable_admission"]').prop('checked',false);

	}
	
@endsection
