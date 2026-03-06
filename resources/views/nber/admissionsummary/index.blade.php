@extends('layouts.app')

@section('content')
	<style>
		thead  { position: sticky; top: 0; z-index: 1; background:burlywood;}
		.table  { border-collapse: collapse; }
		th {border:1px solid #efefef;}
	</style>
	<script src="{{url('js/tableToExcel.js')}}"></script>

	<script>
		$(document).ready(function(){
			$('#btnExport').removeClass('hidden');
			$("#btnExport").click(function() {
				let table = document.getElementById("myTable");
				TableToExcel.convert(table, { // html code may contain multiple tables so here we are refering to 1st table tag
					name: `admission summary.xlsx`, // fileName you could use any name
					sheet: {
						name: 'Sheet 1' // sheetName
					}
				});
			});
		});
	</script>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h4>Admissions 2024 - Summary
					<button id="btnExport" style="margin-left:10px;" class="btn hidden btn-primary btn-xs pull-right">EXPORT REPORT</button>
				</h4>
				<?php $slno = 1; ?>
				<table  id="myTable"  class="table table-bordered">
					<tr>
						<th>
							Sl. No.
						</th>
						<th>
							Institute Code
						</th>
						<th>
							Institute
						</th>
						<th>
							Course
						</th>
						<th>Maximum Intake</th>
						<th>Enrolled</th>
						<th></th>
					</tr>
					@foreach ($summary as $s )
						<tr>
							<td>
								{{$slno}}
								<?php $slno++; ?>
							</td>
							<td>
								{{$s['rci_code']}}
							</td>	
							<td>
								{{$s['name']}}
							</td>
							<td>
								{{$s['coursename']}}
							</td>
							<td>
								{{$s['maxintake']}}
							</td>
							<td>
								{{$s['enrolled']}}
							</td>
							<td>
								<a href="{{url('nber/candidates/')}}/{{$s['id']}}" target="_blank" class="btn btn-xs btn-primary">Show</a>
							</td>
						</tr>						
					@endforeach
				</table>
			</div>
		</div>
	</div>
@endsection