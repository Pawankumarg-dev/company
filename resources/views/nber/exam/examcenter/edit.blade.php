@extends('layouts.app')
@section('content')
    <style>
        .mb-2 {
            margin-bottom: 10px;
        }
		.edit-field{
			width:500px;
			border:1px solid #ccc;
		}
    </style>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4> Exam Center</h4>
				@include('common.errorandmsg')
				<form action="{{ url('nber/exam/examcenter/') }}/{{$examcenter->id}}" method="POST">
					{{ csrf_field() }}
					<input type="hidden" name="_method" value="PUT"> 
                    <button class="btn  mb-2 btn-primary btn-xs pull-right" style="position: absolute;right:15px;top:10px;">Save</button> 
                	<a href="{{ url('nber/exam/examcenter/') }}" style="position: absolute;right:55px;top:10px;"
                    class="btn btn-success btn-xs mb-2 pull-right">Back</a>
					<input type="hidden" name="exam_id" value={{Session::get('exam_id')}}>
					<input type="hidden" name="id" value={{Session::get('exam_id')}}>
					<table class="table table-bordered table-condensed">
						<tr>
							<th>Exam Center</th>
							<td>
								{{$examcenter->externalexamcenter->code}} - {{$examcenter->externalexamcenter->name}}
							</td>
							<input type="hidden" name="externalexamcenter_id" value="{{$examcenter->externalexamcenter_id}}"  >
						</tr>
						<tr>
							<th>
								State(s)
							</th>
							<td>
								@if($examcenter->states->count() > 0)
									@foreach($examcenter->states as $state)
										<div style="width:100%;">
										<span class="badge text-bg-info">
										{{$state->state_name}} 
										</span>
										@if($state->statezones->count()>0)
										Zone/Area: 
										<select name="statezone_id_{{$state->id}}" id="statezone_id_{{$state->id}}" class="edit-field">
											<option value="0" >--Please Select--</option>
											@foreach($state->statezones as $zone)
												<option value="{{$zone->id}}" @if($zone->id==$state->pivot->statezone_id) selected @endif>{{$zone->name}}</option>
											@endforeach
										</select>
										@endif
										
										<span class="">
											<input type="checkbox" name="remove_{{$state->id}}"> <small>Remove</small>
										</span>
										</div>
									@endforeach
								@endif

							</td>
						</tr>
						<tr>
							<th>Add State</th>
							<td>
								<select name="lgstate_id" id="lgstate_id" class="edit-field">
									<option value="0" >--Please Select--</option>
									@foreach($lgstates as $state)
										<option value="{{$state->id}}">{{$state->state_name}}</option>
									@endforeach
								</select>
							</td>
						</tr>
						<tr>
							<th>Evaluation Center</th>
							<td>
								<select name="evaluationcenter_id" id="evaluationcenter_id" class="edit-field">
									<option value="0" >--Please Select--</option>
									@foreach($evaluationcenters as $evc)
										<option value="{{$evc->id}}"
											@if(!is_null($evaluationcenter) && $evc->id == $evaluationcenter->evaluationcenter_id)  
												selected
											@endif	
										>{{$evc->code}} - {{$evc->name}}</option>
									@endforeach
								</select>
							</td>
						</tr>
						<tr>

							<th>Districts <br><small style="font-weight: 100;">(Having Exam Applications)</small></th>
							<td>
								@if($examcenter->states->count() > 0)
									@foreach($examcenter->states as $state)
										<?php 
										if($state->pivot->statezone_id > 0){
											 $districts = \App\Statedistrict::where('statezone_id',$state->pivot->statezone_id)->pluck('name')->toArray(); 
										}
											/*$districts = \App\Institute::whereIn('id',$examsin)
														->where('state_id',$state->id)
														->groupBy('rci_district')
														->pluck('rci_district')
														->toArray(); ?> */
										?>
									@endforeach
								@endif
								

								@if(is_null($districts))
									<span class="badge text-bg-warning">
										Not Assigned
									</span>
								@else
									<?php $count = 1; ?>
									@foreach($districts as $d)
										{{$count}}) {{$d}}  <br />
										<?php $count++; ?>
									@endforeach
								@endif
							</td>
						</tr>
						<tr>
							<th>Institutes <br><small style="font-weight: 100;">(Having Exam Applications)</small></th>
							<td>
								@if($examcenter->states->count() > 0)
								@foreach($examcenter->states as $state)
									<?php 
									if($state->pivot->statezone_id > 0){
										$districts = \App\Statedistrict::where('statezone_id',$state->pivot->statezone_id )->pluck('name')->toArray(); 
									
										$institutes = \App\Institute::whereIn('id',$examsin)
													->where('state_id',$state->id)
													->whereIn('rci_district',$districts)
													->groupBy('rci_district')->get();
									}
									?>
								@endforeach
							@endif
							
								@if($institutes->count() == 0)
									<span class="badge text-bg-warning">
										Not Assigned
									</span>
								@else
									<?php $count = 1; ?> <?php $noofstudents = 0; ?>
									@foreach($institutes->sortBy('rci_code') as $i)
										{{$count}}) {{$i->rci_code}} - {{$i->name}} <br />
										
										<?php 
										$count++; 
										?>
									@endforeach
								@endif
							</td>
						</tr>
					</table>
				</form>
            </div>
        </div>
    </div>
@endsection
