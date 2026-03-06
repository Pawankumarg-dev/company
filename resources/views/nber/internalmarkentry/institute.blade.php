@extends('layouts.app')
@section('content')
  
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h4> {{$institute->rci_code}} - {{$institute->name}}
					<button id="btnExport" style="margin-left:10px;" class="btn hidden btn-primary btn-xs pull-right">EXPORT TO EXCEL</button>
				</h4>
                @include('common.errorandmsg')
				<?php $slno = 1;  ?>
				<table  id="myTable"  class="table table-bordered">
                    <tr>
                        <th>Slno</th>
                        <th>Course</th>
                        <th>Batch</th>
                        <th>Theory</th>
                        <th> Practical</th>
                       
                    </tr>
                    @foreach($courses as $c)
                            <tr>
                                <td>{{$slno}}</td> <?php $slno++; ?>
                                <?php $slno ++ ; ?>
                                <td>{{$c['course']}}</td>
                                <td>{{$c['batch']}}</td>
                                <td>
                                    <?php $subjecttype_id = 1 ; $approvedprogramme = \App\Approvedprogramme::find($c['apid']); ?>
                                    @include('nber.internalmarkentry.markentry._markentrylinks')
                                </td>
                                <td>
                                    <?php $subjecttype_id = 2 ?>
                                    @include('nber.internalmarkentry.markentry._markentrylinks')
                                    
                                </td>
                            </tr>
                    @endforeach
                    
                </table>
            </div>
        </div>
    </div>
@endsection

				
