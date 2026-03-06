@extends('layouts.smalltable')
@section('style')
<link rel="stylesheet" type="text/css" href="{{ url('css/select2.css') }}" />

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
<script src="{{ url('/js/select2.js') }}"></script>


<script>
	$(document).ready(function() {
		
    	$('.subjecttype').select2({
		});
		$('.subjecttype').val([{{ $subjecttype_ids }}]);
		$('.subjecttype').trigger('change');
    	$('.year').select2({
		});
		$('.year').val([{{ $years }}]);
		$('.year').trigger('change');
	});
</script>
<style>
	.select2-container--default.select2-container--focus .select2-selection--multiple{
		border:solid #ccc 1px;
	}
	.select2-container {
		width: 250px!important;
	}
	.select2-search {
		display: none;
	}
</style>
@endsection
@section('fields')
	<input type='hidden' name='programme_id' value='{{$pid}}' /> 
	
	<input type='hidden' name='syllabus_type' value='New' /> 
	{!! Form::bsText('sortorder','Sort Order') !!}
	{!! Form::bsText('scode','Code') !!}
	{!! Form::bsText('sname','Name') !!}	
	{!! Form::bsSelect('subjecttype_id',$subjecttypes,'type','Type') !!}
	{!! Form::bsText('syear','Term') !!}	
	{!! Form::bsText('imin_marks','Internal Minimum Marks') !!}	
	{!! Form::bsText('imax_marks','Internal Maximum Marks') !!}	
	{!! Form::bsText('emin_marks','External Mimimum Marks') !!}	
	{!! Form::bsText('emax_marks','External Maximum Marks') !!}	
	{!! Form::bsText('is_internal','Is Internal?') !!}	
	{!! Form::bsText('is_external','Is External?') !!}	
@endsection

@section('table')
{{-- <input type="text"  id="myInput" placeholder="Search..."  onkeyup="myFunction()" class="form-control pull-left" style="width:300px;margin-left:10px;" /> --}}
<form action="{{ url('nber/subjects/') }}/{{ $pid }}" method="get">
<div style="width: 400px;">
<select name="subjecttype_id[]" id="subjecttype_id" class="subjecttype js-example-basic-multiple" multiple="multiple">
	<option value="1" selected>Theory</option>
	<option value="2" selected>Practical</option>
</select>
@if($p->numberofterms == 2)
<select name="year[]" id="syear" class="subjecttype js-example-basic-multiple" multiple="multiple">
	<option value="1" selected>Term I</option>
	<option value="2" selected>Term II</option>
</select>
@endif
<button type="submit" class="btn btn-xs btn-primary " style="float:right;margin-top:-35px;">Filter</button>
</div>
</form>
{{-- <table id="dataTable"> --}}
	<?php $slno = 1; ?>
	<tr>
		<th>Slno</th>
		<th>Sort Order</th>
		<th>Code</th>
		<th>Name</th>	
		<th>Type</th>
		<th>Term</th>
		<th>In Min Marks</th>
		<th>In Max Marks</th>
		<th>Ex Min Marks</th>
		<th>Ex Max Marks</th>	
		<th>Alternative Paper?</th>
		<th>Action</th>
	</tr>
	@foreach($collections as $c)
	<tbody id="geeks">
		<tr>
			<td>{{ $slno }}</td> <?php $slno++; ?>
			{!! Form::tbText('sortorder',$c) !!}
        	{!! Form::tbText('scode',$c) !!}
        	{!! Form::tbText('sname',$c) !!}
        	{!! Form::tbSelect('subjecttype','type',$c) !!}         	
        	{!! Form::tbText('syear',$c) !!}
			@if($c->is_internal==1)
        	{!! Form::tbText('imin_marks',$c) !!}
        	{!! Form::tbText('imax_marks',$c) !!}
			@else
				<td>--NA--</td><td>--NA--</td>
			@endif
			@if($c->is_external==1)
        	{!! Form::tbText('emin_marks',$c) !!}
        	{!! Form::tbText('emax_marks',$c) !!}
			@else
				<td>--NA--</td><td>--NA--</td>
			@endif
			<td>
				@if($c->is_alternative == 1)
					Yes
				@endif
			</td>
			{!! Form::tbEdit($link,$c) !!}
			<td class="hidden">
				{!! Form::tbText('is_internal',$c) !!}
			</td>
			<td class="hidden">
				{!! Form::tbText('is_external',$c) !!}
			</td>

		</tr>
	</tbody>
    @endforeach
{{-- </table> --}}
@endsection

@section('editscript')
	{!! Form::tbEditscript('sortorder',$link,'input') !!}
	{!! Form::tbEditscript('scode',$link,'input') !!}
	{!! Form::tbEditscript('sname',$link,'input') !!}	
	{!! Form::tbEditscript('subjecttype_id',$link,'select') !!}
	{!! Form::tbEditscript('syear',$link,'input') !!}	
	{!! Form::tbEditscript('imin_marks',$link,'input') !!}	
	{!! Form::tbEditscript('imax_marks',$link,'input') !!}	
	{!! Form::tbEditscript('emin_marks',$link,'input') !!}	
	{!! Form::tbEditscript('emax_marks',$link,'input') !!}	
	{!! Form::tbEditscript('is_internal',$link,'input') !!}	
	{!! Form::tbEditscript('is_external',$link,'input') !!}	
	{{--{!! Form::tbEditscript('startdate',$link,'input') !!}	
	{!! Form::tbEditscript('starttime',$link,'input') !!}	
	{!! Form::tbEditscript('endtime',$link,'input') !!}	 --}}
@endsection

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
	$(document).ready(function () {
            $("#myInput").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $("#geeks tr").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
</script>