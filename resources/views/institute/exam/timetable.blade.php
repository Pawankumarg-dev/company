<style>
.timetable .modal-dialog {
  width: 100%;
  height: 100%;
  margin: 0;
  padding: 0;
  font-size:12px;
}

.timetable .modal-content {
  height: auto;
  min-height: 100%;
  border-radius: 0;
}
</style>

                                          <div id="timetable" class="modal fade timetable" role="dialog">
                              <div class="modal-dialog">

                                          

                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Time Table - June 2018</h4>
                                        
                                      </div>
                                      <div class="modal-body">
                                          

<table class="table" >
            	<tr>
            		<td>Date</td>
            		<td>From</td>
            		<td>To</td>
            		<td>Programme Code</td>
            		
            		<td>Subject Code</td>
            		<td>Subject</td>
            	</tr>
               
                  @if(isset($programme_ids))
                  	@foreach($timetable->sortBy('startdate') as $tt)
                              @if($tt->subject)
                                    @if(in_array($tt->subject->programme->id, $programme_ids))
                              		<tr>
                              			<td>
                              				{{\Carbon\Carbon::parse($tt->startdate)->toFormattedDateString()}}
                              			</td>
                              			<td>
                              				{{\Carbon\Carbon::parse($tt->startdate)->format('h:i A')}}
                              			</td>
                              			<td>
                              				{{\Carbon\Carbon::parse($tt->enddate)->format('h:i A')}}
                              			</td>
                              			<td>
                              				@if($tt->subject)
                              					{{$tt->subject->programme->course_name}}
                              				@endif
                              			</td>
                              			
                                                <td>
                                                      {{$tt->subject->scode}}
                                                </td>
                                                <td>
                                                      {{$tt->subject->sname}}
                                                </td>
                              		</tr>
                                    @endif
                                    @endif
                  	@endforeach
                  @endif
			
			</table>
            </div>
      </div>
</div>