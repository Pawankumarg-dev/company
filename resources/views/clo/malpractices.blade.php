@extends('layouts.smalltable')
@section('fields')
	{!! Form::bsText('title','Title') !!}
	{!! Form::bsTextarea('description','Description') !!}
	
	
@endsection
@section('content')
<div class="alert alert-success">
	 <i class="fa fa-bullhorn"> </i>&nbsp;	<a hre="#">Click here</a> to download Malpractice reporting form.
	</div>
  @include('common.errorandmsg')
@endsection

@section('table')
	<tr>
		
		<td> Date</td>
		<td>Title</td>
    <td>Details</td>
		<td>Edit</td>
		<td>Documents</td>
	</tr>
	@foreach($collections as $c)
		<tr>
			<td>{{\Carbon\Carbon::parse($c->created_at)->toDateString()}}</td>
        	{!! Form::tbText('title',$c) !!}     
          
          {!! Form::tbText('description',$c) !!}        	
          
        	{!! Form::tbEdit($link,$c) !!}
          <td>
                    @foreach($c->malpracticefiles as $report)
                                          <div class="well">
                                            {{$report->description}}
                                          <a class="pull-right" target="_blank" href="{{asset('files/malpractice/')}}/{{$report->file}}">
                                            <i class="fa fa-download"> </i> &nbsp; {{ \Carbon\Carbon::parse($report->created_at)->toDateString()}} {{$report->file}} </a></div>
                                        @endforeach
                  


                                          <button type="button" class="btn btn-info btn-xs pull-right" data-toggle="modal" data-target="#upload_report_{{$c->id}}"><i class="fa fa-upload"></i>&nbsp;Upload New </button>


                                          <div id="upload_report_{{$c->id}}" class="modal fade modal-xs" role="dialog">
                              <div class="modal-dialog">

                                          <form class="form-horizontal" action="{{url('clo/upload/malpractice/file/'.$c->id)}}" enctype="multipart/form-data" method='post' >
                                                          {!! csrf_field() !!}

                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Upload Document</h4>
                                        <input type="hidden" name='malpractice_id' value="{{$c->id}}" />
                                        
                                      </div>
                                      <div class="modal-body">
                                          


                                          <div class="form-group">
                                            <label class="control-label col-sm-6" for="document"> Document </label>
                                            <div class="col-sm-6">
                                                <input type="file" class="form-control" name="file" />
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-6" for="document"> Description </label>
                                            <div class="col-sm-6">
                                                <textarea class="form-control" name="description" ></textarea>
                                            </div>
                                          </div>
                                          
                                          


                                          

                                          

                                      </div>
                                      <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Upload</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                      </div>
                                    </div>
                                </form>
                            </div></div>
        	</td>
		</tr>
    @endforeach
@endsection
@section('editscript')
	
	{!! Form::tbEditscript('title',$link,'input') !!}
  {!! Form::tbEditscript('description',$link,'input') !!}
	
@endsection