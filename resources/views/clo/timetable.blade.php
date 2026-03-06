@extends('layouts.app')

@section('content')
<ul class="breadcrumb col-md-12">
      <li><a href="{{url('/')}}">Home</a></li>
      <li class="bctext"> <i class="fa fa-table"> </i>&nbsp; Time Table </li>
</ul>

<div class="container-fluid">
	<div class="row">
    	<div class="col-md-12">

          
                  <?php $sd = '' ; $count = 0; ?>
                  <?php $programme_ids = Session::get('programme_ids'); ?>                  
                  @if(isset($programme_ids))
                  	@foreach($timetable->sortBy('startdate') as $tt)
                              @if($tt->subject)
                                    @if(in_array($tt->subject->programme->id, $programme_ids))
                                          @if($tt->startdate!=$sd)
                                                @if($sd != '')
                                                        
                                                </table></div></div>              
                                                @endif

                                                <div class=" panel panel-default" style="padding:0;">
                                                        
                                                                <div class="panel-heading" style="padding: 5px 10px;">
                                                        <?php $count += 1; ?>
                              		                  
                                                				<b>{{\Carbon\Carbon::parse($tt->startdate)->toFormattedDateString()}}</b> &nbsp;&nbsp;
                                                			   <span class="">{{\Carbon\Carbon::parse($tt->startdate)->format('h:i A')}} to
                                                                        {{\Carbon\Carbon::parse($tt->enddate)->format('h:i A')}}
                                                                     </span>
                                                				
                                                			
                                                      </div>
                                                      <div class="panel-body" style="padding:0;margin:0;">
                                                            <table class="table  table-bordered table-condensed"  style="padding:0 20px ;margin-bottom: 0;"> 

                                          @endif

                                                   <tr>
                                                      <td style="padding-left: 10px;">
                                                                         
                                                                        @if($tt->subject)
                                                                              {{$tt->subject->programme->course_name}}
                                                                        @endif
                                                                        
                                                                        @if($tt->subject)
                                                                         -      {{$tt->subject->programme->name}}
                                                                        @endif
                                                                  </td>
                                                                  <td>
                                                                       <b> {{$tt->subject->scode}}</b>
                                                                        - 
                                                                        {{$tt->subject->sname}}
                                                                  </td>
                                                </tr>

                                                <?php $sd = $tt->startdate ; ?>
                                    @endif
                                    @endif
                  	@endforeach
                           @if($count!=0)
                                           </div> </table></div></div>

                                        @endif
                  @endif
			
			</table>
		</div>
	</div>
</div>
            
@endsection         
