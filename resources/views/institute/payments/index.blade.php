@extends('layouts.app')

@section('content')

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">

				<ul class="breadcrumb col-md-12">
					<li><a href="{{url('/')}}">Home</a></li>
					<li> Payments </li>
					{{--
					<div class="dropdown pull-right">
						<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Generate Acknowledgement Form
							<span class="caret"></span></button>
						<ul class="dropdown-menu">
							<li>
								<a  href="{{url('payments/create?form=exam&exam_id=5')}}">December 2018 Supplementary Examination</a>
							</li>
						</ul>
					</div>
					--}}
				</ul>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="panel-title">
							Payments
						</div>
					</div>

					<div class="panel-body">
						<div class="row">
							<div class="col-sm-3">
								<div class="panel panel-primary">
									<div class="panel-heading">
										<div class="panel-title text-center">
											<a href="{{url('/institute/incidentalpayments')}}">Incidental Charge Payment</a>
										</div>
									</div>
								</div>
							</div>

							<div class="col-sm-3">
								<div class="panel panel-primary">
									<div class="panel-heading">
										<div class="panel-title text-center">
											<a href="{{url('/institute/enrolmentpayments')}}">Enrolment Payment</a>
										</div>
									</div>
								</div>
							</div>

							<div class="col-sm-3">
								<div class="panel panel-primary">
									<div class="panel-heading">
										<div class="panel-title text-center">
											<a href="{{url('/institute/examinationpayments')}}">Examination Payment</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				@if($payments->count()>0)
					<table class="table table-striped">
						<tr>
							<td>Type</td>
							<td>Year</td>
							<td>Amount</td>
							<td>Date</td>
							<td>Transaction ID</td>
							<td>Status</td>
							<td>Remarks</td>
							<td>Links</td>
						</tr>
						@foreach($payments as $p)
							<tr>
								<td>{{$p->type}}</td>
								<td>2017</td>
								<td>{{$p->totalamount}}</td>
								<td>{{$p->date}}</td>
								<td>{{$p->transactionid}}</td>
								<td>{!!$p->status->statushtml()!!}</td>
								<td>{{$p->remark}}</td>
								<td><a href="{{url('payments/pdf')}}/{{$p->id}}" class="btn btn-default"><i class="fa fa-print"></i>&nbsp;Print</a> </td>
							</tr>
						@endforeach
					</table>
				@endif
				<h5>How to Make Payments:</h5>
				<ol>
					<li>Course coordinator has to pay the total amount which has been shown in the box through Online Payment or NEFT/RGTS to our bank account. </li>
					<li> Incase of NEFT Payment, The amount should be paid to the following bank account:
						<table border="1" style="border:#069; border-collapse:collapse;" cellspacing="0" cellpadding="2">
							<tr>
								<td>
									a) Account Holder&lsquo;s Name
								</td>
								<td>
									
									{{$accountname}}
								</td>
							</tr>
							<tr>
								<td>
									b) Name of the Bank
								</td>
								<td>
									{{$bankname}}

								</td>
							</tr>
							<tr>
								<td>
									c) Address of the Bank
								</td>
								<td>
									{{$bankaddress}}
									
								</td>
							</tr>
							<tr>
								<td>
									d) Account Number
								</td>
								<td>
									{{$accountnumber}}
								</td>
							</tr>
							<tr>
								<td>
									e) Type of Account
								</td>
								<td>
									{{$typeofaccount}}
									
								</td>
							</tr>
							<tr>
								<td>
									f) IFSC Code
								</td>
								<td>
									{{$ifsccode}}
									
								</td>
							</tr>
						</table>
					</li>
					{{--<li>All details on the acknowledgement slip must be filled and signed by the course coordinator. Please print the filled acknowledgement slip, make two copies and send both the copies and the bank transaction slip and student details printout from website to the address given below :
						<br /><br />
						<p>Asst. Dy. Controller of Examinations (ADCE)<br />
							NBER-Examination Cell, <br />
							National Institute for Empowerment of Persons with Multiple Disabilities (NIEPMD)<br />
							(Dept. of Empowerment of Persons with Disabilities, Ministry of Social Justice & Empowerment, Govt. of India)<br />
							East Coast Road, Kovalam Post, Muttukadu, Chennai - 603112, Tamil Nadu, India<br />
							Tele-Fax: +91-44-27472389 , Tele-Phone: 044- 27472113, 27472046
						</p>
					</li>--}}
				</ol>
				<br />

			</div>
		</div>
	</div>
@endsection