@extends('layouts.smalltable')

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
	}
</script>
<div class="container">
	<div class="row">
		<div class="col-12" >
			<form action="{{url('/nber/admissions')}}" method="get" style="margin-botton:3px;">
			<input type="text" placeholder="Search with Insititue code, name or address" value="{{$search_text}}" name="search" class="form-control pull-left" style="width:300px;margin-left:10px;" /> 
			<button class="btn btn-xm btn-primary pull-left">Search</button>
			<a href="{{url('/nber/admissions')}}" class="btn  pull-left btn-info">Clear</a>
			</form>
		</div>
		<br />
	</div>
</div>
@endsection
@section('table')
	<?php $open = $currentacademicyear->id == $academicyear_id && $enrolment == 1; ?>
	<tr>
		<td>Institue Code (Provided by RCI)</td>
		<td>Institue Code (Provided by NI)</td>
		<td>Name</td>
		<th>Address</th>
		<td>Programmes</td>
		<td>Enrolment Fee</td>
	{{--	<td>KV</td> --}}
	</tr>
	@foreach($collections as $c)
		<?php $approvedprogrammes = \App\Approvedprogramme::where('institute_id',$c->id)->where('academicyear_id',$academicyear_id)->get(); ?>
		@if($approvedprogrammes->count() > 0  )
			<tr>
				{!! Form::tbText('username',$c->user) !!}
				<td>
					<input type="hidden" id="username_{{$c->id}}" value="{{$c->user->username}}" />
					{{$c->user->username}}
				</td>
				{!! Form::tbText('name',$c) !!}
				<td style="width:180px;">
					{{$c->address}}
				</td>
				<td>
					@if($approvedprogrammes->count() > 0)
						<table class="table table-bordered admission_{{$c->id}}" style="width:500px;">
							<tr>
								<th>Course</th>
								<th>Course Code</th>
								<th>Maximum Intake</th>
								<th>Applied</th>
								<th>Applications</th>
							</tr>
							@foreach( $approvedprogrammes as $course)
								@if($course->programme->nber_id == $nber_id)
									<tr>
										<td>
											<input type="hidden" id="programme_id_{{$course->id}}" value="{{$course->programme_id}}">
											{{$course->programme->course_name}}
										</td>
										<td>
											{{$course->programme->code}}
										</td>
										<td>
										<input type="hidden" id="maxintake_{{$course->id}}" value="{{$course->maxintake}}">
											{{$course->maxintake}}
										</td>
										<td>
											{{$course->candidates->count()}}
										</td>
										<td>
											<a href="{{url('nber/candidates/')}}/{{$course->id}}" class="btn btn-xs btn-primary">Candidates</a>
										</td>

									</tr>
								@endif
							@endforeach
						</table>
					@endif
				</td>
				<td>
					<a href="{{url('institute/enrolmentfee/')}}/{{$c->id}}">Enrolment Fee</a>
				</td>
			</tr>
		@endif
    @endforeach
@endsection
