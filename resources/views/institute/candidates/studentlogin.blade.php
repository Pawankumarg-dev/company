@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">

		<ul class="breadcrumb">
				  <li><a href="{{url('/')}}">Home</a></li>
				  <li> {{$ap->programme->course_name}} </li>
				
		</ul>
		</div>
		
		
			
		</div>
		@include('common.errorandmsg')
		
		<div class="row">
		<div class="col-md-12">

<table class="table table-striped">
	<tr>
		<td>Name</td>
		
		<td>Email</td>
		<td>Contact Number</td>
		<td>Enrolment Number (User Name to login)</td>
		<td>Password</td>
		<td></td>
	</tr>
	@foreach($candidates as $c)
		<tr>
			<td>{{$c->name}}</td>
			<td>{{$c->email}}</td>
			<td>{{$c->contactnumber}}</td>
			<td>{{$c->enrolmentno}}</td>
			
				@if($c->user)				
					<td>{{$c->user->confirmation_code}}</td><td></td>
				@else
				<td></td>
				<td>Login not generated as email Id is not valid or is duplicate</td>

				@endif
			
		</tr>
	@endforeach
</table>

</div>
</div>
</div>
<script>
	function confirm(id,name){
		swal({
  title: 'Are you sure?',
  text: "Delete candidate " + name ,
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#d33',
  cancelButtonColor: '#3085d6',
  confirmButtonText: 'Yes, delete!'
}).then((result) => {
  if (result.value) {
  	window.location.replace("{{url('candidate/delete')}}/"+id);
  
  }
})
	}
</script>

@foreach($candidates as $c)
		@include('institute.candidates.view')
@endforeach
@endsection
