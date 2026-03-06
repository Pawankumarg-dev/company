@extends('layouts.app')
@section('content')
 
 <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                    	<label class="label label-default">
                    	Configuration :
                    	</label> &nbsp
                    	 0 = <label class="label label-danger">InActive</label>&nbsp; 1 = <label class="label label-success">Active</label>
                    	 <br />
                    	 <br />
                    	</div>

                    </div>
                   </div>
@endsection
@section('fields')
	{!! Form::bsText('name','Name') !!}
	{!! Form::bsText('enrolment','Enrolment') !!}
	{!! Form::bsText('exam_application','Exam Application') !!}

	{!! Form::bsText('mark_entry_institutes','Mark Entry (Institute)') !!}
	{!! Form::bsText('mark_entry_nber','Mark Entry (NBER)') !!}
	{!! Form::bsText('questionpaper_download','Question Paper Download') !!}
	{!! Form::bsText('hallticket_download','Hall Ticket Download') !!}
	{!! Form::bsText('attendance_upload','Attendance Upload') !!}
	{!! Form::bsText('publish_mark','Publish Marks') !!}

@endsection
@section('table')
	<tr>
		<td>Name</td>		
		<td>Enrolment </td>
		<td>Exam Application</td>
		<td>Mark Entry (Institute)</td>
		<td>Mark Entry (NBER)</td>
		<td>Question Paper Download</td>
		<td>Hall Ticket Download</td>
		<td>Attendance Upload</td>
		<td>Publish Mark</td>
		<td>Action</td>
	</tr>
	@foreach($collections as $c)
		<tr>
        	{!! Form::tbText('name',$c) !!}        	
        	{!! Form::tbText('enrolment',$c) !!}
        	{!! Form::tbText('exam_application',$c) !!}
        	{!! Form::tbText('mark_entry_institutes',$c) !!}        	
			{!! Form::tbText('mark_entry_nber',$c) !!}        	
			{!! Form::tbText('questionpaper_download',$c) !!}        	
			{!! Form::tbText('hallticket_download',$c) !!}        	
			{!! Form::tbText('attendance_upload',$c) !!}        
			{!! Form::tbText('publish_mark',$c) !!}        	
        	{!! Form::tbEdit($link,$c) !!}
		</tr>
    @endforeach
@endsection
@section('editscript')
	{!! Form::tbEditscript('name',$link,'input') !!}
	{!! Form::tbEditscript('enrolment',$link,'input') !!}
	{!! Form::tbEditscript('exam_application',$link,'input') !!}
	{!! Form::tbEditscript('mark_entry_institutes',$link,'input') !!}
	{!! Form::tbEditscript('mark_entry_nber',$link,'input') !!}
	{!! Form::tbEditscript('questionpaper_download',$link,'input') !!}
	{!! Form::tbEditscript('hallticket_download',$link,'input') !!}
	{!! Form::tbEditscript('attendance_upload',$link,'input') !!}
	{!! Form::tbEditscript('publish_mark',$link,'input') !!}
@endsection