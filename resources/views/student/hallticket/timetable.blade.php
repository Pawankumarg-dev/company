@extends('layouts.app')

@section('content')

<div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">


<table class="table" style="width:100%">
	<tr>
		<td>
			Exam Center
		</td>
		<td>
			<?php
		//	if($candidate->approvedprogramme->institute->examcenter('2')->count()>0){
		//		$ec = $candidate->approvedprogramme->institute->examcenter('2')->examcenter;
		//	}else{
				$ec = $candidate->approvedprogramme->institute->examcenter('2');
		//	}
			?>
			{{$ec->name}} &nbsp;
			({{$ec->user->username}})
			<br />
			{{$ec->address}} &nbsp;
			{{$ec->pincode}}
		</td>
	</tr>
</table>
{!! $timetable !!}
                    		</div>
						</div>
					</div>
@endsection