@extends('layouts.reevaluationapplication')
@section('content')
    <section class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <div class="center-text">
                                <span class="h4-text">National Institute for Empowerment of Persons with Multiple Disabilities (Divyangjan)</span><br>
                                <span class="h8-text">(Dept. of Empowerment of Persons with Disabilities (Divyangjan), MS&E, Govt. of India)</span><br>
                                <span class="h4-text">National Board of Examination in Rehabilitation (NBER)</span><br>
                                <span class="h8-text">(An Adjunct Body of Rehabilitation Council of India, under Ministry of Social Justice and Empowerment)</span>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            Online Re-Evaluation Application Details - {{ $reevaluationapplication->application_number }}
                                        </div>
                                    </div>

                                    <div class="panel-body">
                                        <div class="table-responsive col-sm-12">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <td>Application No.</td>
                                                    <td class="red-text bold-text" colspan="2">{{ $reevaluationapplication->application_number }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="center-text" width="15%" rowspan="4">
                                                        <img src="{{asset('/files/enrolment/photos')}}/{{$reevaluationapplication->candidate->photo}}"  style="width: 100px; height: 100px !important" class="img" />
                                                    </td>
                                                    <td width="11%">Enrolment No</td>
                                                    <td class="red-text bold-text" width="74%">{{ $reevaluationapplication->candidate->enrolmentno }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Name</td>
                                                    <td class="red-text bold-text">{{ $reevaluationapplication->candidate->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Course</td>
                                                    <td class="red-text bold-text">{{ $reevaluationapplication->candidate->approvedprogramme->programme->course_name }} - ({{ $reevaluationapplication->candidate->approvedprogramme->academicyear->year }})</td>
                                                </tr>
                                                <tr>
                                                    <td>Institute</td>
                                                    <td class="red-text bold-text">{{ $reevaluationapplication->candidate->approvedprogramme->institute->code }} - {{ $reevaluationapplication->candidate->approvedprogramme->institute->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Mobile Number</td>
                                                    <td class="red-text bold-text" colspan="2">
                                                        {{ $reevaluationapplication->contactnumber }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Email Id</td>
                                                    <td class="red-text bold-text" colspan="2">
                                                        {{ $reevaluationapplication->email }}
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>                                                                 

                                        @if($reevaluationapplication->reevaluationapplicationsubjects->count() > 0)
                                        <div class="table-responsive col-sm-12">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th class="center-text" colspan="7">Re-Evaluation Options</th>
                                                <tr>
                                                <tr>
                                                    <th class="center-text" rowspan="2" width="3%">S.No.</th>
                                                    <th class="center-text" colspan="2">Paper</th>
                                                    <th class="center-text" rowspan="3" width="2%">Marks<br>Obtained</th>
                                                    <th class="center-text" colspan="3" width="15%">Re-Evaluation Options</th>
                                                </tr>
                                                <tr>
                                                    <th class="center-text" width="5%">Code</th>
                                                    <th class="center-text"  width="25%">Name</th>
                                                    <th class="center-text">Re-Evaluation</th>
                                                    <th class="center-text">Re-Totalling</th>
                                                    <th class="center-text">Photo-Copying</th>
                                                </tr>

                                                <tbody>
                                                @php $sno = 1; @endphp
                                                @foreach($reevaluationapplication->reevaluationapplicationsubjects as $reevaluationapplicationsubject)
                                                    <tr>
                                                        <td class="center-text">{{ $sno }}@php $sno++; @endphp</td>
                                                        <td>{{ $reevaluationapplicationsubject->subject->scode }}</td>
                                                        <td>{{ $reevaluationapplicationsubject->subject->sname }}</td>
                                                        <td class="center-text">{{ $reevaluationapplicationsubject->actual_marks }}</td>
                                                        <td class="center-text">
                                                            @if($reevaluationapplicationsubject->reevaluation_applystatus == 1)
                                                                <span class="blue-text glyphicon glyphicon-ok"></span>
                                                            @else
                                                                <span class="red-text glyphicon glyphicon-remove"></span>
                                                            @endif
                                                        </td>
                                                        <td class="center-text">
                                                            @if($reevaluationapplicationsubject->retotalling_applystatus == 1)
                                                                <span class="blue-text glyphicon glyphicon-ok"></span>
                                                            @else
                                                                <span class="red-text glyphicon glyphicon-remove"></span>
                                                            @endif
                                                        </td>
                                                        <td class="center-text">
                                                            @if($reevaluationapplicationsubject->photocopying_applystatus == 1)
                                                                <span class="blue-text glyphicon glyphicon-ok"></span>
                                                            @else
                                                                <span class="red-text glyphicon glyphicon-remove"></span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>               
                                        @else
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="pull-right">
                                                        <a href="{{ url('/reevaluationapplication/login/showsubjectdetailform/'.$reevaluationapplication->exam_id.'/'.$reevaluationapplication->application_number) }}" class="btn btn-primary">
                                                            Add Reevaluation Subject Details
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if($reevaluationapplication->reevaluationapplicationpayments->count() > 0)
                                            @foreach ($reevaluationapplication->reevaluationapplicationpayments as $reevaluationapplicationpayment)                                            
                                            <div class="table-responsive col-sm-12">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th class="center-text" colspan="4">Payment Details</th>
                                                    </tr>
                                                    <tr>
                                                        <td width="25%">Payment Date: <span class="blue-text bold-text">{{ $reevaluationapplicationpayment->payment_date->format('d-m-Y') }}</span></td>
                                                        <td width="25%">Payment Type: <span class="blue-text bold-text">{{ $reevaluationapplicationpayment->paymenttype->course_name }}</span></td>
                                                        <td width="25%">Amount Paid: Rs. <span class="blue-text bold-text">{{ $reevaluationapplicationpayment->amount_paid }}</span>/-</td>
                                                        <td width="25%">Transaction No.: <span class="blue-text bold-text">{{ $reevaluationapplicationpayment->payment_number }}</span></td>                                                        
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">Payment Bank: <span class="blue-text bold-text">{{ $reevaluationapplicationpayment->paymentbank->bankname }}</span></td>                                           
                                                        <td>Payment File: 
                                                            <a href="{{asset('/files/payments/reevaluation/'.$reevaluationapplicationpayment->filename)}}" target="_blank">
                                                            File
                                                            </a>
                                                        </td>                                           
                                                        <td>Status: <span class="blue-text bold-text">{{ $reevaluationapplicationpayment->status->status }}</span></td>                                           
                                                    </tr>                                                     
                                                    <tr>                                           
                                                        <td>Payment Remark: <span class="blue-text bold-text">{{ $reevaluationapplicationpayment->payment_remark }}</span></td>                                           
                                                    </tr>
                                                    <tr>
                                                        <th class="center-text" colspan="4">Details of Person entered Payment</th>
                                                    </tr>
                                                    <tr>
                                                        <td width="25%">Name: <span class="blue-text bold-text">{{ $reevaluationapplicationpayment->name }}</span></td>
                                                        <td width="25%">Designation: <span class="blue-text bold-text">{{ $reevaluationapplicationpayment->designation }}</span></td>
                                                        <td width="25%">Mobile No.: <span class="blue-text bold-text">{{ $reevaluationapplicationpayment->mobilenumber }}</span></td>
                                                        <td width="25%">Email Id: <span class="blue-text bold-text">{{ $reevaluationapplicationpayment->email }}</span></td>                                                        
                                                    </tr>                                             
                                                </table>
                                            </div>
                                            @endforeach
                                        @else
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="pull-right">
                                                        <a href="{{ url('/reevaluationapplication/login/showpaymentdetailform/'.$reevaluationapplication->exam_id.'/'.$reevaluationapplication->application_number) }}" class="btn btn-primary">
                                                            Add Payment Details
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="pull-right">
                                                    <a href="{{  url('/reevaluationapplication/logout/'.$reevaluationapplication->exam_id) }}" class="btn btn-danger">
                                                    Logout
                                                    </a>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-footer">
                        Please contact NIEPMD-NBER in case of any queries
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

