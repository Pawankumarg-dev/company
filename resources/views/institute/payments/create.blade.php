@extends('layouts.app')

@section('content')

	<form action="{{url('payments/store')}}" enctype="multipart/form-data" method="post">
		{!! csrf_field() !!}
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<ul class="breadcrumb col-md-12">
						<li><a href="{{url('/')}}">Home</a></li>
						<li> <a href="{{url('payments')}}">Payments</a> </li>
						<li>New
							(
                            <?php
                            $form = $_GET['form'];
                            echo $form;
                            if($form == 'exam'){
                                echo $examid = $_GET['exam_id'];
                                $examname = $exam->name;
                            }
                            ?>
							)
						</li>
						<button type="submit" class="btn btn-primary pull-right btn-bc">Save</button>
					</ul>
				</div>
				<div class="col-md-2"></div>
				<div class="col-md-8">
					<div class="panel panel-default">
						<div class="panel-heading">
							Generate Acknowldegement form - {{$form}}
						</div>
						<div class="panel-body">
							@if($form=='exam')
								{{ Form::bsText('academicyear_id','Examination',$examname,['disabled']) }}
							@else
								{{ Form::bsText('academicyear_id','Year','2017',['disabled']) }}
							@endif
							<table class="table table-striped">
								<tr>
									<th>Course</th>
									<th>(Batch)</th>
									<th>Max Intake</th>
									<th>Number of Students</th>
									@if($form=='exam')
										<th>Number of Students (Applied)</th>
										<th>Number of Subjects (Applications)</th>
										<th>Fee Remarks</th>
									@endif
								</tr>
                                <?php
                                $total = 0;
                                $totalsubs = 0;
                                $fee_ex_subs = 0; // fee excemption subjects
                                $total_amount = 0;
                                ?>


								@foreach($ap as $p)

                                    <?php $allow = true ?>
									@if($form=='enrolment')
										@if($p->academicyear_id != 1)
                                            <?php $allow = false; ?>
										@endif
									@endif
									@if($allow)
										@php
											$amount = 0;
										@endphp

										<tr>
											<td>
												{{$p->programme->course_name}}
											</td>
											<td>
												{{$p->academicyear->year}}
											</td>
											<td>
												{{$p->maxintake}}
											</td>
											<td>
                                                <?php
                                                $applied = $p->candidates->count();
                                                $total += $applied;
                                                ?>
												{{$applied}}
											</td>
											@if($form=='exam')
												<td>
													{{$p->applications->where('exam_id', $exam->id)->groupby('candidate_id')->count()}}

												</td>
												<td>
                                                    <?php
                                                    $subs =  $p->applications->where('exam_id', $exam->id)->count();

                                                    /*
                                                    if($p->programme->id=='9')
                                                        $fee_ex_subs += $subs;
                                                    */

                                                    $totalsubs += $subs;
                                                    echo $subs;
                                                    ?>
												</td>
												<td>
													@if($exam->id == '5')
														@if($p->programme->id=='9')
															@php
																$amount = $subs * 1000;
															@endphp
														@else
															@php
																$amount = $subs * 150;
															@endphp
														@endif

														{{ $amount }}

															@php $total_amount += $amount @endphp
													@endif

													{{--
													@if($p->programme->id=='9')
														No Exam fee
													@endif
													--}}
												</td>
											@endif
										</tr>
									@endif
								@endforeach
							</table>
							<input type="hidden" name='institute_id' value="{{$instituteid}}"  />
							<input type="hidden" name='academicyear_id' value="1"  />
							<input type='hidden' name='status_id' value="1" />
							@if($form=='exam')

									{{ Form::bsText('totalsubs','Total Number of Applications',$totalsubs,['disabled']) }}
									{{ Form::bsNumber('totalamount','Total Amount',0,null,$total_amount) }}

								{{--
								@if($p->programme->id=='9')
									{{ Form::bsText('totalsubs','Total Number of Applications',$totalsubs,['disabled']) }}
                                    {{ Form::bsText('totalsubs','Total Number of Applications (to be paid)',$totalsubs,['disabled']) }}

									{{ Form::bsNumber('totalamount','Total Amount',0,null,$totalsubs * 1000) }}
								@else
									{{ Form::bsText('totalsubs','Total Number of Applications',$totalsubs,['disabled']) }}
									{{ Form::bsNumber('totalamount','Total Amount',0,null,$totalsubs * 150) }}
								@endif
								--}}
							@else
								{{ Form::bsText('total','Total Number of Students',$total,['disabled']) }}
								{{ Form::bsNumber('totalamount','Total Amount',0,null,$total * 500) }}
							@endif

							{{ Form::bsText('transactionid','Transaction ID') }}
							{{ Form::bsDate('date','Date of Transaction') }}
							{{ Form::bsText('bank','Bank Name') }}
							{{ Form::bsText('remark','Remarks') }}
							<input type='hidden' name='type' value="{{$form}}" />
						</div>
						<div class="panel-footer" style='min-height: 45px!important;'>
							<button type="submit" class="btn btn-primary pull-right btn-bc" style="display:inline!important;">Save</button>

						</div>
					</div>
				</div>
			</div>
		</div>
	</form>


@endsection
