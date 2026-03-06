@extends('layouts.app')

@section('content')
	<style>
		.pagination{
			margin-top:-45px!important;
			float:right!important;
		}
	</style>
	<ul class="breadcrumb" style="margin-top: -20px!important;">
		<li>
			<a href="{{url('/')}}"> Home</a>
		</li>
		<li>
			{{$c->name}}
		</li>
	</ul>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				@include('common.candidates.view')
			</div>
		</div>
	</div>
@endsection