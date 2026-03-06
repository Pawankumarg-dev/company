@extends('layouts.smalltable')
@section('fields')
	{!! Form::bsSelect('exam_id',$exams,'name','Exam') !!}
	{!! Form::bsSelect('programme_id',$programmes,'coursename','Programme') !!}
	{!! Form::bsSelect('subject_id',$subjects,'scode','Subject') !!}
	{!! Form::bsDateTime('startdate','Start Date Time (24Hr Format)') !!}
	{!! Form::bsDateTime('enddate','End Date Time (24Hr Format)') !!}
@endsection
@section ('content')
 <div class="container-fluid">
                <div class="row">
                    <ul class="breadcrumb col-md-12">

                    	@if(app('request')->has('day'))
                    		<li><a href="{{url('questionpapers')}}?exam={{app('request')->input('exam')}}">Today</a></li>
                    		@if(app('request')->input('day')=='tomorrow')
                    			<li><label class="label label-default">Tomorrow</label></li>
                    		@else
								<li><a href="{{url('questionpapers')}}?exam={{app('request')->input('exam')}}&day=tomorrow">Tomorrow</a></li>
                    		@endif
                    		@if(app('request')->input('day')=='all')
                    			<li><label class="label label-default">All</label></li>
                    		@else
                    			<li><a href="{{url('questionpapers')}}?exam={{app('request')->input('exam')}}&day=all">All</a></li>
                    		@endif
                    		@foreach($startdates as $sd)
                    			@if(app('request')->input('day')==$sd)
                    			<li><label class="label label-default">{{$sd}}</label></li>
                    			@else
                    				<li><a href="{{url('questionpapers')}}?exam={{app('request')->input('exam')}}&day={{$sd}}">{{$sd}}</a></li>
                    			@endif
                    		@endforeach

                    	@else
                    		<li><label class="label label-default">Today</label></li>
                    		<li><a href="{{url('questionpapers')}}?exam={{app('request')->input('exam')}}&day=tomorrow">Tomorrow</a></li>
                    		<li><a href="{{url('questionpapers')}}?exam={{app('request')->input('exam')}}&day=all">All</a></li>
                    		@foreach($startdates as $sd)
                    			<li><a href="{{url('questionpapers')}}?exam={{app('request')->input('exam')}}&day={{$sd}}">{{$sd}}</a></li>
                    		@endforeach

                    	@endif
                    </ul>
                </div>
            </div>
@endsection
@section('table')
	<tr>
		<td>Exam</td>
		<!--<td>Exam Academic Yr</td>
		<td>Exam Type</td>-->
		<td>Programme</td>
		<td>Subject Code</td>
		<td>Subject</td>
		<td>Starting  Date Time</td>
		<td>Ending Date Time</td>
		<td>Questoinpaper</td>
	</tr>
	@foreach($collections as $c)
		<tr>
            @if($c)
			{!! Form::tbText('name',$c->exam) !!}
        	<!--
            {!! Form::tbText('year',$c->exam->academicyear) !!} 
        	{!! Form::tbText('name',$c->exam->examtype) !!} 
            -->
            @if($c->subject)
        	{!! Form::tbText('coursename',$c->subject->programme) !!} 
        	{!! Form::tbText('scode',$c->subject) !!} 
        	{!! Form::tbText('sname',$c->subject) !!} 
            @endif
        	{!! Form::tbText('startdate',$c) !!}
        	{!! Form::tbText('enddate',$c) !!}
            @endif
        	<td> 
        	@if($c->questionpaper)
        		<a target="_blank" href="{{asset('files/questionpapers')}}/{{$c->questionpaper}}"> <i class="fa fa-download"></i> {{$c->questionpaper}} </a> &nbsp;&nbsp;

        	@endif
        		<button id='upload_{{$c->id}}' onclick="javascript:clickinputfile({{$c->id}})" class="btn btn-info btn-xs" >Upload</button>
        		<form class="form-horizontal" action="{{url('uploadquestionpaper')}}" enctype="multipart/form-data" method='post' id='form_{{$c->id}}' >
					{!! csrf_field() !!}
        			<input type="file" class="hidden inputfile" name='inputfile'  id='inputfile_{{$c->id}}' onchange='javascript:uploadfile({{$c->id}})'>
        			<input type="hidden" name='id' value="{{$c->id}}" />
        		</form>
        		
        	</td>
		</tr>
    @endforeach
@endsection
@section('editscript')
	{!! Form::tbEditscript('startdate',$link,'input') !!}
	{!! Form::tbEditscript('enddate',$link,'input') !!}
	{!! Form::tbEditscript('subject_id',$link,'input') !!}
	{!! Form::tbEditscript('exam_id',$link,'input') !!}
@endsection
@section('script')
<script>
	function clickinputfile(etid){
		$('#inputfile_'+etid).click();
	}
	function uploadfile(etid){
		$('#form_'+etid).submit();
	}
</script>
@endsection
@section('style')
<link rel="stylesheet" href="{{asset('css/chosen.min.css')}}">
@endsection