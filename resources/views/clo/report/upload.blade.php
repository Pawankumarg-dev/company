@extends('layouts.app')

@section('content')

<ul class="breadcrumb col-md-12">
      <li><a href="{{url('/')}}">Home</a></li>
      <li class="bctext"><i class="fa fa-file"> </i> &nbsp; CLO Reports</li>
</ul>

<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

            	@include('common.errorandmsg')
            	
                
                <h4> <i class="fa fa-upload"> </i> &nbsp; Upload</h4> 
                <?php $programme_ids = Session::get('programme_ids'); ?>     

                @if($exams->count()>0)
                	<table class="table" style="width:100%;">
                		<tr>
                			<td>Exam Date</td>
							<td>Upload</td>
              <td>Files</td>
						</tr>
						@foreach($exams as $qp)
							@if(in_array($qp->subject->programme->id, $programme_ids))
								<tr>
									<td>
										{{$qp->startdate}}

									</td>
									<td>
                                        @foreach($reports as $r)
										  

                                          <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#upload_report_{{$qp->id}}_{{$r->id}}"><i class="fa fa-upload"></i>&nbsp;{{$r->description}} </button>


                                          <div id="upload_report_{{$qp->id}}_{{$r->id}}" class="modal fade modal-xs" role="dialog">
                              <div class="modal-dialog">

                                          <form class="form-horizontal" action="{{url('clo/upload/report/'.$qp->id).'/'.$r->id}}" enctype="multipart/form-data" method='post' >
                                                          {!! csrf_field() !!}

                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Upload CLO Report</h4>
                                        <input type="hidden" name='examtimetable_id' value="{{$qp->id}}" />
                                        <input type="hidden" name='cloreportfile_id' value="{{$r->id}}" />
                                      </div>
                                      <div class="modal-body">
                                          
                                          <div class="form-group">
                                            <label class="control-label col-sm-6" for="document"> {{$r->description}}</label>
                                            <div class="col-sm-6">
                                                <input type="file" class="form-control" name="file" />
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



                                        @endforeach
                                        
									</td>
                  <td>
                    @foreach($qp->cloreports as $cloreport)
                                          @if($cloreport->clo_id===Session::get('clo')->id)
                                          <a target="_blank" href="{{asset('files/cloreport/')}}/{{$cloreport->file}}">
                                            <i class="fa fa-download"> </i> &nbsp; {{ \Carbon\Carbon::parse($cloreport->created_at)->toDateString()}} {{$cloreport->cloreportfile->description}} </a> <br />
                                          @endif
                                        @endforeach
                  </td>
								</tr>
							@endif
						@endforeach
					</table>
                @else
                	<label class="label label-primary">None</label><br />
                @endif




                <br />
                
                
            </div>
        </div>

@endsection