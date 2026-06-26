@extends('layouts.app')
@section('content')
  
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h4> Institutes for Internal Mark Entry
					<button id="btnExport" style="margin-left:10px;" class="btn hidden btn-primary btn-xs pull-right">EXPORT TO EXCEL</button>
				</h4>
                @include('common.errorandmsg')
				<?php $slno = 1;  ?>
				<table  id="myTable"  class="table table-bordered">
                    <tr>
                        <th>Slno</th>
                        <th>Institute Code</th>
                        <th>Institute Name</th>
                        <th>Link</th>
                       
                    </tr>
                    @foreach($institutes as $i)
                            <tr>
                                <td>{{$slno}}</td> <?php $slno++; ?>
                                <td>{{$i['rci_code']}}</td>
                                <td>{{$i['name']}}</td>
                                <td>
                                    <a href="{{url('/nber/internalmarkentry')}}?institute_id={{$i['id']}}" class="btn btn-xs btn-primary">Mark Entry </a>
                                </td>
                            </tr>
                    @endforeach
                    
                </table>
            </div>
        </div>
    </div>
@endsection

				
