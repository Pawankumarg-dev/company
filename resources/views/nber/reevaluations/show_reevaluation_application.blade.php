@extends('layouts.app')

@section('content')
<script>
        function addgrace(id, cname, scode){
            swal({
                title: 'Grace Mark for '  + cname + ' (' + scode + ')'  ,
                text: "Enter the grace mark ",
				input: 'text',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Update!',
				inputValidator: (value) => {
					if (value == '' ||  value > 3 || value < 1) 
					{
						return 'Grace marks can only be between 1 to 3'
					}
					else {
						var formData = new FormData();
						var token = $('input[name=_token]');
                        formData.append('id', id);
                        formData.append('grace', value);
                        formData.append('exam_id', {{Session::get('exam_id')}});
						$.ajax({
							url: '{{url("nber/markentry/addgracemark")}}',
							method: 'POST',
							dataType: 'json',
							contentType: false,
							processData: false,
							headers: {
								'X-CSRF-TOKEN': token.val()
							},
							data: formData,
							success: function (data) {
								console.log(data);
								if(data=='success'){
									swal({
										type: 'success',
										title: 'Grace mark Added',
										showConfirmButton: false,
										timer: 3000
									});
									setTimeout(function(){
										location.reload();
									}, 3000); 
								}else{
									swal({
										type: 'warning',
										title: 'Could not update',
										showConfirmButton: false,
										timer: 1500
									});
								}
							},
							error: function (data) {
                                console.log(data);
								swal({
									type: 'warning',
									title: 'Could not update ',
									showConfirmButton: false,
									timer: 1500
								});
							}
						});
					}
				},
            }).then((result) => {
                
            })
        }
    </script>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
            @include('common.errorandmsg')
            {!! csrf_field() !!}
                <table class="table table-bordered table-stripped"> 
                    <tr>
                        <th>Application Number</th>
                        <td>{{$reevaluationapplication->application_number}}</td>
                        <th>Date</th>
                        <td>{{$reevaluationapplication->created_at->format('d/M/Y')}}</td>
                    </tr>
                    <tr>
                        <th>
                            Name
                        </th>
                        <td>
                            
                            <a target="_blank" href="{{url('nber/candidate/')}}/{{$reevaluationapplication->candidate->id}}#marks">{{$reevaluationapplication->candidate->name}}</a>
                        </td>
                        <th>Institute</th>
                        <td>{{$reevaluationapplication->institute->rci_code}} - {{$reevaluationapplication->institute->rci_name}} </td>
                    </tr>
                    <tr>
                        <th>
                            Enrolment No
                        </th>
                        <td>
                        {{$reevaluationapplication->candidate->enrolmentno}}
                        </td>
                        <th>
                            Exam Center
                        </th>
                        <td>
                        <?php 
                            $examcenter = \App\Examcenter::where('exam_id',Session::get('exam_id'))->where('institute_id',$reevaluationapplication->institute_id)->first(); 
                            if(!is_null($examcenter)){
                                $externalexamcenter = $examcenter->externalexamcenter;
                            }
                        ?>
                        @if(!is_null($examcenter))
                        {{ $externalexamcenter->code }} - {{ $externalexamcenter->address }}
                        @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Course</th>
                        <td>{{$reevaluationapplication->candidate->approvedprogramme->programme->course_name}}</td>
                        <th>Evaluation Center</th>
                        <td>
                            @if(!is_null($examcenter))
                                <?php $evaluationcenterdetail = \App\Evaluationcenterdetail::where('exam_id',Session::get('exam_id'))->where('externalexamcenter_id',$examcenter->externalexamcenter_id)->first(); 
                                if(!is_null($evaluationcenterdetail)){
                                    $evaluationcenter = $evaluationcenterdetail->evaluationcenter;
                                }
                                ?>
                                @if(!is_null($evaluationcenterdetail))
                                    {{ $evaluationcenter->code }} - {{ $evaluationcenter->name }}
                                @endif
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Batch</th>
                        <td>{{$reevaluationapplication->candidate->approvedprogramme->academicyear->year}} </td>
                        <th>
                           Student's Email 
                        </th>
                        <td>{{$reevaluationapplication->candidate->email}}</td>
                        
                    </tr>
                </table>

                <table class="table table-bordered table-condensed">
                <tr>
                    <th>
                        Marksheet / Certificate
                    </th>
                    <th>
                        Result
                    </th>
                    <th>
                        Date
                    </th>
                    <th>
                        Download
                    </th>
                </tr>
                <?php
                    $exam_id = Session::get('exam_id');
                     $result=[];
                    if($exam_id == 22){
                        $result = $reevaluationapplication->candidate->currentapplicant;
                        $applicant_id =  $reevaluationapplication->candidate->currentapplicant_id;
                    }
                    if($exam_id == 25){
                        $result = $reevaluationapplication->candidate->newresults()->first();
                        $applicant_id = \App\Newapplicant::where('candidate_id',$reevaluationapplication->candidate_id)->first()->id;
                    }
                ?>
                @if($exam_id == 22 && !is_null($result) && !is_null($result->reevaluation_sl_no_marksheet_term_one) && !is_null($result->reevaluation_term_one_result_id) )
                    <td>
                        Term One Marksheet
                    </td>
                    <td>
                        @if($result->reevaluation_term_one_result_id == 1)
                        <span style="color:green;">Pass</span>
                        @endif
                        @if($result->reevaluation_term_one_result_id == 0)
                        <span style="color:red;">Fail</span>
                        @endif
                    </td>
                    <td>
                    {{\Carbon\Carbon::parse($result->reevaluation_marksheetissuded_date)->toFormattedDateString()}}
                    </td>
                    <td>
                    <a href="{{url('nber/marksheet')}}/re/{{$applicant_id}}/1">Download Term One Marksheet</a>
                    </td>
                    </tr>
                @endif
                @if($exam_id == 22 && !is_null($result) && !is_null($result->reevaluation_sl_no_marksheet_term_two) && !is_null($result->reevaluation_term_two_result_id) )
                    <tr>
                    <td>
                        Term Two Marksheet
                    </td>
                    <td>
                        @if($result->reevaluation_term_two_result_id == 1)
                        <span style="color:green;">Pass</span>
                        @endif
                        @if($result->reevaluation_term_two_result_id == 0)
                        <span style="color:red;">Fail</span>
                        @endif
                    </td>
                    <td>
                        {{\Carbon\Carbon::parse($result->reevaluation_marksheetissuded_date)->toFormattedDateString()}}
                    </td>
                    <td>
                    <a href="{{url('nber/marksheet')}}/re/{{$applicant_id}}/2">Download Term Two Marksheet</a>
                    </td>
                    </tr>
                @endif
                @if($exam_id == 22 && !is_null($result->reevaluation_slno_certificate))
                    <tr>
                    <td>
                        Certificate
                    </td>
                    <th><span style="color:green;">Pass</span></th>
                    <td>
                        {{\Carbon\Carbon::parse($result->reevaluation_certificate_date)->toFormattedDateString()}}
                    </td>
                    <td>
                    <a href="{{url('nber/certificate')}}/re/{{$applicant_id}}">Download Certificate</a>
                    </td>
                    </tr>
                @endif
                </tr>
            </table>
                <table class="table table-bordered table-stripped"> 
                    <tr>
                    <th>Application Number</th>
                    <th>Term</th>
                    <th>Subject Code</th>
                    <th>Subject</th>
                    <th>EX Min Mark</th>
                    <th>EX Max Mark</th>
                    <th>EX Obtained Mark</th>
                    <th>IN Min Mark</th>
                    <th>IN Max Mark</th>
                    <th>IN Obtained Mark</th>
                    <th>Result</th>
                    <th class="center-text">Re-Evaluation</th>
                    <th class="center-text">Re-Totalling</th>
                    <th class="center-text">Photo-Copying</th>
                    <th class="center-text">Bundle Number</th>
                    <th class="center-text">Dummy Number</th>
                    <th> Amount</th>
                    <th>Status</th>
                    <th>Revaluated Mark</th>
                    <th>Grace Mark</th>
                    <th>Reevaluation Result</th>
                    </tr>
                    <?php $refund = 0; $total = 0; ?>
                    @foreach($reevaluationapplication->reevaluationapplicationsubjects as $subject)
                    <tr>
                    <td>
                        {{$subject->id}}
                    </td>
                    <td>
                        {{$subject->subject->syear}}
                    </td>
                    <td>
                        {{$subject->subject->scode}}
                    </td>
                    <td>
                        {{$subject->subject->sname}}
                    </td>
                    <td  class="center-text">
                        {{$subject->subject->emin_marks}}
                    </td>
                    <td class="center-text">
                        {{$subject->subject->emax_marks}}
                    </td>
                    <td class="center-text">

                        <?php
$allapplication = \App\Allapplication::where('exam_id',$subject->exam_id)->where('candidate_id',$subject->candidate_id)->first();
$allapplicant = \App\Allapplicant::where('exam_id',$subject->exam_id)->where('candidate_id',$subject->candidate_id)->first();

?>
                      
                        @if($allapplication->mark_ex < $subject->subject->emin_marks)
                            <span style="color:red">
                        @else
                        <span style="color:green">
                        @endif
                        {{$allapplication->mark_ex}}
                        </span>
                    </td>
                    <td class="center-text">
                        {{$subject->subject->imin_marks}}
                    </td>
                    <td class="center-text">
                        {{$subject->subject->imax_marks}}
                    </td>
                    <td class="center-text">
                        @if($allapplication->mark_in < $subject->subject->imin_marks)
                            <span style="color:red">
                        @else
                        <span style="color:green">
                        @endif
                        {{$allapplication->mark_in}}
                        </span>
                    </td>
                    <td class="center-text">
                        @if($allapplication->result_id == 1)
                            Pass
                        @endif
                        @if($allapplication->result_id == 0)
                            Fail
                        @endif
                        @if(is_null($allapplication->result_id))
                            Not Declared
                        @endif
                    </td>
                    <td class="center-text">
                        @if($subject->reevaluation_applystatus == 1)
                            <i class="fa fa-check" aria-hidden="true" style="color:green"></i>
                            <?php $refund = $refund + 1; ?>
                        @endif
                    </td>
                    <td class="center-text">
                        @if($subject->retotalling_applystatus == 1)
                            <i class="fa fa-check" aria-hidden="true" style="color:green"></i>
                        @endif
                    </td>
                    <td class="center-text">
                        @if($subject->photocopying_applystatus == 1)
                            <i class="fa fa-check" aria-hidden="true" style="color:green"></i>
                        @endif
                    </td>
                    <td class="center-text">
                        {{$subject->application}}
                    <?php
                        
                           $lcode = $allapplicant->language->code;
                        
                    ?>    
                    {{$reevaluationapplication->candidate->approvedprogramme->id}}-{{$reevaluationapplication->candidate->approvedprogramme->institute->dummy_code}}-{{$reevaluationapplication->candidate->approvedprogramme->programme->id}}-{{$subject->subject->id}}-{{$lcode}}
                    </td>
                    <td class="center-text">
                    {{$allapplication->dummy_number}}
                    </td>
                    <td class="center-text">
                    <?php 
                        $fee = ($subject->reevaluation_applystatus * $reevaluationfee->reevaluation_fee ) + ($subject->retotalling_applystatus * $reevaluationfee->retotalling_fee) + ($subject->photocopying_applystatus * $reevaluationfee->photocopying_fee);
                        $total = $total + $fee;
                    ?>
                    ₹ {{number_format($fee,0)}}
                    </td>
                    <td>
                        @if($subject->active_status == 1)
                        <span style="color:red;">Processing</span>
                        @endif
                        @if($subject->active_status == 0)
                            <span style="color:green;">Reevaluated</span>
                        @endif
                    </td>
                    <td>
                        @if($subject->active_status == 0)
                            @if($subject->no_change== 1) 
                                <span style="color:red">No Change </span>
                            @else
                                @if($allapplication->mark_ex == $subject->reevaluated_marks)
                                    <span style="color:red">No Change </span>
                                @else
                                    
                                    @if($subject->reevaluated_marks < $subject->subject->emin_marks)
                                        <span style="color:red">
                                    @else
                                    <span style="color:green">
                                    @endif
                                        {{$subject->reevaluated_marks}}
                                    </span>
                                @endif 
                            @endif
                        @endif
                    </td>
                    <td>
                        @if($allapplication->grace > 0)
                        <span style="color:green">{{$allapplication->grace}}</span>
                        @else
                            @if($subject->subject->imin_marks >= $allapplication->mark_in && $allapplication->reevaluated_marks < $subject->subject->emin_marks && ($allapplication->reevaluated_marks + 4) > $subject->subject->emin_marks)
                                <a href="javascript:addgrace({{$id}},'{{$a->candidate->name}}','{{$s->scode}}')">+</a>
                            @endif
                        @endif
                    </td>
                    <td>
                        <?php $exmarks = $allapplication->external_mark; ?>
                        @if( $subject->reevaluated_marks > $exmarks)
                            <?php $exmarks = $subject->reevaluated_marks; ?>
                        @endif
                        
                        @if($subject->active_status == 0)
                            @if(
                                $subject->subject->imin_marks <= $subject->$application->internal_mark && 
                                ($exmarks +  $subject->$application->grace ) >= $subject->subject->emin_marks
                                )
                                <span style="color:green">Pass</span>
                            @else
                                <span style="color:red">Fail</span>
                            @endif
                            </span>
                        @endif
                    </td>
                    </tr>
                    @endforeach
                    <tr>
                    <td colspan="16">Total</td>
                    <td class="center-text">₹ {{number_format($reevaluationapplication->amount,0)}}</td>
                    <td>
                        @if($reevaluationapplication->orderstatus_id == 1)
                            Paid
                        @else
                            Not Paid
                            <a href="{{url('nber/recheckStatusall')}}/{{$reevaluationapplication->id}}" class="btn btn-sm btn-primary"  style="margin-top:3px;">Refresh Payment Status</a>
                        @endif
                    </td>
                    </tr>
                </table>
                
                
                @if($reevaluationapplication->orders->count() > 0)
                    <div class="row">
                        <div class="col-12" style="padding-left: 15px;padding-right: 15px;">
                            <h4>Transaction Details</h4>
                            <table class="table  table-bordered">
                                <tr>
                                    <th>Order Number</th>
                                    <th>Reference Number</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                                <?php $successorder = 0; ?>
                                @foreach($reevaluationapplication->orders as $order)
                                    <tr>
                                        <td>
                                            {{$order->order_number}}
                                        </td>
                                        <td>
                                            {{$order->ccavenue_referencenumber}}
                                            @if($order->ccavenue_referencenumber=='')
                                                <a href="javascript:addReference({{$order->id}});">Add Reference Number</a>
                                            @endif
                                        </td>
                                        <td>
                                            
                                            ₹ {{number_format($order->actual_amount,0)}}
                                        </td>
                                        <td>
                                            {{$order->payment_date}}
                                        </td>
                                        <td>
                                            @if($order->order_status == "Success")
                                            <span class="label label-xs label-success"> 
                                                    {{$order->order_status}}
                                                    <?php $successorder += 1; ?>
                                                </span>
                                            @else
                                                @if($order->order_status == "Fail")
                                                <span class="label label-xs label-danger"> 
                                                        {{$order->order_status}}
                                                    </span>
                                                @else
                                                <span class="label label-xs label-warning"> 
                                                        {{$order->order_status}}
                                                    </span>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                        @if($order->order_status != "Success")
                                                <a href="{{url('nber/reevaluation/recheckStatus')}}/{{$reevaluationapplication->candidate->approvedprogramme->programme->nber_id}}/{{$order->id}}/{{$reevaluationapplication->id}}">Refresh</a>

                                                
                                            @endif
                                        </td>
                                        
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                @endif

                @if($reevaluationapplication->orderstatus_id == 1 && !is_null($reevaluationapplication->refund) )
                
                    <div style="margin-bottom:50px;" >
                        <h5>Bank detils for Refund of ₹ {{($reevaluationapplication->amount - $total) + (($successorder-1) * ($reevaluationapplication->amount))}} for Reevaluation Application. </h5>
                        <form action="{{url('nber/reevaluation/refund')}}" method="post">
                            {!! csrf_field() !!}
                            <table class="table table-bordered table-stripped">
                                <tr>
                                    <th>
                                    Name 
                                    </th>
                                    <th>
                                        Bank & Branch
                                    </th>
                                    <th>
                                        IFSC Code
                                    </th>
                                    <th>
                                        Account Number
                                    </th>
                                    <th>
                                        Reference Number
                                    </th>
                                    <th>
                                        Date
                                    </th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>
                                    <input type="hidden" name="reevaluationapplication_id" value="{{$reevaluationapplication->id}}" />
                                        @if(!is_null($reevaluationapplication->refund)) {{$reevaluationapplication->refund->cname}} @endif
                                    </td>
                                    <td>
                                        @if(!is_null($reevaluationapplication->refund)) {{$reevaluationapplication->refund->bank}} @endif
                                    </td>
                                    <td>
                                        @if(!is_null($reevaluationapplication->refund)) {{$reevaluationapplication->refund->ifsccode}} @endif
                                    </td>
                                    <td>
                                        @if(!is_null($reevaluationapplication->refund)) {{$reevaluationapplication->refund->accountno}} @endif
                                    </td>
                                    <td>
                                        <input type="text" name="refno"  value="@if(!is_null($reevaluationapplication->refund)) {{$reevaluationapplication->refund->refno}} @endif" />
                                    </td>
                                    <td>
                                        <input type="date" name="refunddate"  value="@if(!is_null($reevaluationapplication->refund)){{\Carbon\Carbon::parse($reevaluationapplication->refund->refunddate)->format('Y-m-d')}}@endif" />
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary pull-right">Save</button>
                                    </td>
                                </tr>
                            </table>
                            
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

        });

        function updateStatus(count, status_id) {
            var verify_remarks = '';
            var reevaluationpayment_id = $('#reevaluationpayment_id'+count).val();
            var token = "{{ csrf_token() }}";
            var verified_on = moment().format('DD-MM-YYYY');

            if(status_id == 2) {
                verify_remarks = 'Approved';
                ajaxCall();
            }
            else {
                $('#showModal_'+count).modal('show');

                $('#updateButton_'+count).click(function (e) {
                    e.preventDefault();
                    if(!$('#remarks_'+count).val()) {
                        alert('Please enter remarks');
                    }
                    else {
                        verify_remarks = $('#remarks_'+count).val();
                        $('#showModal_'+count).modal('hide');
                        ajaxCall();
                    }
                });
            }
        }
            function ajaxCall() {
                $.ajax({
                    url: "{{url('/nber/payments/reevaluation/updatestatus/') }}",
                    type: "POST",
                    dataType: "JSON",
                    data: {_token: token, reevaluationpayment_id: reevaluationpayment_id, status_id: status_id, verify_remarks: verify_remarks, verified_on: verified_on},
                    beforeSend:function() {
                        $('#displayStatus_'+count).hide();
                        $('#loadingStatus_'+count).show();
                        $('#displayStatus_'+count).empty();
                        $('#displayStatus_'+count).removeClass();
                        $('#displayVerifyRemarks_'+count).html();

                        if(status_id == 1) {
                            $('#displayStatus_'+count).addClass('label label-warning');
                        }
                        else if(status_id == 2) {
                            $('#displayStatus_'+count).addClass('label label-success');
                        }
                        else {
                            $('#displayStatus_'+count).addClass('label label-danger');
                        }
                    },
                    success:function(data) {
                        if(data) {
                            $('#displayVerifiedOn_'+count).html(verified_on);
                            $('#displayVerifyRemarks_'+count).html(verify_remarks);
                            $('#displayStatus_'+count).html(data);
                        }
                    },
                    complete:function() {
                        $('#displayStatus_'+count).show();
                        $('#loadingStatus_'+count).hide();
                    }
                });

            }
        function addReference(order_id){
            console.log('log');
			swal({
                title: 'Add Reference Number',
                text: "Enter the reference number ",
				input: 'text',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Save',
				inputValidator: (value) => {
					//if (!(parseInt(value) > 6000000000 && parseInt(value) < 9999999999)) 
					//{
						//return 'Please enter a valid mobile number'
					//}
					//else {
						var formData = new FormData();
						var token = $('input[name=_token]');
                        console.log(order_id);
                        console.log(value);
						formData.append('id', order_id);
						formData.append('ref_no', value);
						$.ajax({
							url: '{{url("nber/reevaluation/addref")}}',
							method: 'POST',
							dataType: 'json',
							contentType: false,
							processData: false,
							headers: {
								'X-CSRF-TOKEN': token.val()
							},
							data: formData,
							success: function (data) {
								console.log(data);
								if(data=='success'){
									swal({
										type: 'success',
										title: 'Ref no Updated',
										showConfirmButton: false,
										timer: 3000
									});
									setTimeout(function(){
										location.reload();
									}, 3000); 
								}else{

									swal({
                                        type: 'warning',
                                        title: 'Could not update reference number',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
								}
							},
							error: function (data) {
								console.log(data);

									swal({
										type: 'warning',
                                        title: 'Could not update reference number',
										showConfirmButton: false,
										timer: 1500
									});
								}
						});
					//}
				},
            }).then((result) => {
                
            })
		}
    </script>
@endsection
