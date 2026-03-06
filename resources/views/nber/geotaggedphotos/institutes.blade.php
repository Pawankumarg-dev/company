
@extends('layouts.app')

@section('content')
    <style>
        th, td {
            
            vertical-align: top;
        }
    </style>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
                <h4> Geotagged Photos </h4>
            
				<table class="table table-boarded">
					<tr>
						<th>SlNo</th>
                        <th>Institute Code</th>
						<th>Institute Name</th>
					</tr>
					<?php $slno = 1; ?>
					@foreach($institutes as $i)
                        <tr>
                            <td class="align-top">
                                {{$slno}}
                                <?php $slno++; ?>
                            </td>
                            <td>
                                {{$i['rci_code']}}
                            </td>
                            
                            <td>
                                <a href="{{url('/nber/practicalexaminer/geotaggedphotos')}}/{{$i['id']}}?institute=yes&photos=yes" target="_blank">
                                    {{$i['name']}}
                                </a>
                            </td>
                        </tr>
					@endforeach
				</table>				
			</div>
		</div>
	</div>
@endsection