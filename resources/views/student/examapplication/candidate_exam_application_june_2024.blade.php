@extends('layouts.app')
@section('script')
    <script>
        $('#declare').on('click',function(){
        if($('#declare')[0].checked){
            $('#pay').prop('disabled',false);
        }else{
            $('#pay').prop('disabled',true);
        }
    });
    $('#showpayment').on('click',function(){
        let INR = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'INR',
        });
        var totalfee = {{$na->amount}};
        $('#total_fee').html(INR.format(totalfee));
        $('#amount').val(totalfee);
        if(totalfee>0){
            $('#declare').prop('checked', false);
            $('#pay').prop('disabled',true);
            $('#myModal').modal('show');
        }else{
            swal({
                type: 'warning',
                title: 'Please choose the papers',
                showConfirmButton: false,
                timer: 1500
            });
        }
        return false;
    });
    </script>
    <script>
        function cancelApplication(id){
            swal({
                    title: 'Are you sure?',
                    text: "This action cannot be undone",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes!'
                }).then((result) => {
                    if (result.value) {
                        window.location.replace("{{url('student/delete/newexam')}}/"+id);
                    }
                });
        }
        function updateEmail(){
            swal({
                title: 'Update your Email Address'  ,
                text: "Enter the Email Address",
                input: 'text',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Update',
                inputValidator: (value) => {
                    if (value == '') 
                    {
                        return 'Email Cannot be empty'
                    }
                    else {
                        
                        window.location.replace("{{url('generateemailotp')}}?email="+value);
                  /*      var token = $('input[name=_token]');
                        var formData = new FormData();
						formData.append('email', value);
                        $.ajax({
                            //url: 'https://rciregistration.nic.in/rehabcouncil/api/findbycrrno.jsp?id='+value,
                            url: "{{url('generateemailotp')}}",
                            method: 'GET',
                            dataType: 'json',
                            contentType: false,
                            processData: false,
                            headers: {
                                'X-CSRF-TOKEN': token.val()
                            },
							data: formData,
                            success: function (data) {
                                console.log(data);
                                if(data!=0){
                                    swal({
                                        type: 'success',
                                        title: 'Email Updated',
                                        showConfirmButton: false,
                                        timer: 3000
                                    });
                                  //  savefaculty();
                                    setTimeout(function(){
                                        location.reload();
                                    }, 3000); 
                                }else{
                                    $('#alert').removeClass('hidden');
                                }
                            },
                            error: function (data) {
                                $('#alert').removeClass('hidden');
                            }
                        }); */
                    }
                },
            }).then((result) => {
                
            });
        }
    </script>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                {{-- 
                <h4>Exam @if($exam->publish_result != 1) Application @else Result @endif - {{$exam->name}}</h4> --}}
                <h4>Exam Result {{  $exam->name }}</h4>
                @include('common.errorandmsg')
                @if($exam->publish_result != 1)
                <ul>
                    <li class="hidden">
                    No request shall be accepted for change of Papers after final submission. Candidates are advised to carefully check all the relevant details before final submission.
                    </li>
                </ul>
                @endif

                
                <?php $slno = 1; ?>
                @if(!is_null($na))
                    <?php $applicant = $na; ?>
                    @if($na->additional_amount == 0)
                    <div class="alert alert-danger" style="display: none;">
                        Missed to apply for practical papers? Click <a href="{{url('examapplication/25')}}?additional=yes">here</a> to apply.
                    </div>
                    @endif
                    @if($na->payment_status == 1)
                        <a target="_blank" style="margin-bottom:5px;display:none;" href="{{url('student/reevaluation/receipt')}}/{{$na->id}}" class="btn btn-sm btn-primary pull-right">Print Receipt</a>
                    @endif
                    <?php $cfy = 0; $csy =0; ?>
                    <?php $msg = false; ?>
                    @if($applicant->payment_status != 1)
                       <?php $msg = "Result pending due to payment verification."; ?>
                    @endif
                    @if($applicant->block == 1)
                       <?php $msg = "Result pending due to technical reasons. Will be released at the earliest."; ?>
                    @endif
                    @if($applicant->attendance == 0)
                       <?php $msg = "Result not declared due to less attendance."; ?>
                    @endif
                    @if($applicant->malpractice == 1)
                       <?php $msg = "Result withheld due to administrative reasons."; ?>
                    @endif
                    @if($msg != false)
                       <div class="alert alert-danger">
                           {{ $msg }}
                       </div>
                    @endif 
                    <table class="table table-bordered table-stripped"> 
                        <tr>
                        <th>Sl No</th>
                        <th>Subject Code</th>
                        <th>Subject</th>
                        <th>Term</th>
                        <th>Fee</th>
                       @if($applicant->payment_status == 1 && $applicant->block != 1  && $applicant->malpractice != 1 && $applicant->attendance == 1)

                            <th class="text-center">Internal Mark</th>
                            <th class="text-center">External Mark</th>
                            <th class="text-center">Grace Mark</th>
                            <th class="text-center">Result</th>
                        @endif
                        </tr>
                            <?php 
                                $additional = 0; 
                                $payment_status = $na->payment_status;
                                $total = $na->amount;
                            ?>
                            @include('student.examapplication._subjects')
                            
                            @if($na->additional_amount > 0)
                                <?php 
                                    $additional = 1; 
                                    $payment_status = $na->additional_payment_status;
                                    $total = $na->additional_amount;
                                ?>
                                @include('student.examapplication._subjects')
                            @endif

                    </table>
                        @if($na->block != 1 && $exam->publish_result != 1)
                                <table class="table table-bordered table-stripped" style="display:none;"> 
                                    <tr>
                                        <th>Hallticket</th>
                                        <th>Download</th>
                                    </tr>
                                    @if($cfy>0)
                                        <tr>
                                            <td>
                                                First Year
                                            </td>
                                            <td>
                                                <a href="{{url('student/exam/applicants')}}/{{$na->candidate_id}}/{{$na->id}}/1"  class="btn btn-primary btn-xs">Download</a>
                                            </td>
                                        </tr>
                                    @endif
                                    @if($csy>0)
                                        <tr>
                                            <td>
                                                Second Year
                                            </td>
                                            <td>
                                                <a href="{{url('student/exam/applicants')}}/{{$na->candidate_id}}/{{$na->id}}/2" class="btn btn-primary btn-xs">Download</a>
                                            </td>
                                        </tr>
                                    @endif
                                </table>
                                @if($na->payment_status != 1)
                                The declaration of result will be done only after receiving the pending payment for the examination.
                                @endif
                        @endif
                    <?php $successorders = 0; ?>
                    @if($na->orders->count() > 0)
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
                                    @foreach($na->orders as $order)
                                        <tr>
                                            <td>
                                                {{$order->order_number}}
                                            </td>
                                            <td>
                                                {{$order->ccavenue_referencenumber}}
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
                                                        <?php $successorders += 1; ?>
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
                                               <!-- <a href="{{url('student/recheckStatus')}}/{{$candidate->approvedprogramme->programme->nber_id}}/{{$order->id}}">Refresh</a> -->
                                            @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
@endsection