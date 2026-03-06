@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title">
                            Enrolment Payment for {{ $approvedprogramme->academicyear->year }}
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <section class="hidethis">
                                    <ul class="breadcrumb">
                                        <li class="heading">Quick Links: </li>
                                        <li>
                                            <a href="{{ url('/institute/dashboard/home') }}">Home</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('/institute/enrolmentpayments/') }}">Enrolment Payments</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('/institute/enrolmentpayments/'.$approvedprogramme->academicyear->id) }}">{{ $approvedprogramme->academicyear->year }}</a>
                                        </li>
                                        <li class="active">{{ $approvedprogramme->programme->course_name }}</li>
                                    </ul>
                                </section>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            Approved Students List
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        @php
                                            $sno = 1; //serial number
                                            $paymentStatusIdForPayment = array(1, 3, 5); //allowed paymentstatus_id for payment
                                            $paymentStatusIdForAcknowledgement = array(2, 3, 4, 5); //allowed paymentstatus_id for acknowledgement
                                        @endphp

                                        <div class="table-responsive">
                                            <table class="table table-condensed table-bordered" role="table">
                                                <tr>
                                                    <th class="center-text" width="5%">S. No.</th>
                                                    <th class="center-text" width="15%">Photo</th>
                                                    <th class="center-text" width="10%">Enrolment No</th>
                                                    <th class="center-text" width="25%">Name</th>
                                                    <th class="center-text" width="10%">Enrolment<br>Fee</th>
                                                    <th class="center-text" width="10%">NEFT Payment</th>
                                                    <th class="center-text" width="10%">Gateway Payment</th>
                                                    <th class="center-text" width="10%">Acknowledgment<br>Receipt</th>
                                                </tr>

                                                @foreach($candidates as $candidate)
                                                    <tr>
                                                        <td class="center-text">{{ $sno }}@php $sno++; @endphp</td>
                                                        <td class="center-text">
                                                            <img src="{{asset('/files/enrolment/photos')}}/{{$candidate->photo}}"  style="width: 100px;" class="img" />
                                                        </td>
                                                        <td class="center-text">
                                                            @if(is_null($candidate->enrolmentno))
                                                                <span class="label label-danger">NOT GENERATED</span>
                                                            @else
                                                                <span class="blue-text">{{ $candidate->enrolmentno }}</span>
                                                            @endif
                                                        </td>
                                                        <td class="blue-text">{{ strtoupper($candidate->name) }}</td>
                                                        <td class="blue-text center-text">500</td>
                                                        @if(in_array($candidate->paymentstatus_id, $paymentStatusIdForPayment))
                                                            <td class="center-text">
                                                                @php
                                                                    $hrefvalue = '/institute/enrolmentpayments/student/'.$candidate->id;
                                                                @endphp
                                                                <a href="javascript:void(0)" onclick="location.href='{{ $hrefvalue }}'" class="btn btn-primary btn-sm">
                                                                    <span class="glyphicon glyphicon-share-alt"></span>&nbsp;&nbsp;NEFT
                                                                </a>
                                                            </td>
                                                            <td class="center-text">
                                                                @php
                                                                    $hrefvalue = '/institute/enrolmentpayments/showonlinepaymentform/'.$candidate->id;
                                                                @endphp
                                                                <a href="javascript:void(0)" onclick="location.href='{{ $hrefvalue }}'" class="btn btn-primary btn-sm">
                                                                    <span class="glyphicon glyphicon-share-alt"></span>&nbsp;&nbsp;Gateway
                                                                </a>
                                                            </td>
                                                        @else
                                                            <td class="center-text">
                                                                <h3 class="red-text">
                                                                    <span class="glyphicon glyphicon-remove"></span>
                                                                </h3>
                                                            </td>
                                                            <td class="center-text">
                                                                <h3 class="red-text">
                                                                    <span class="glyphicon glyphicon-remove"></span>
                                                                </h3>
                                                            </td>
                                                        @endif
                                                        <td class="center-text">
                                                            @if(in_array($candidate->paymentstatus_id, $paymentStatusIdForAcknowledgement))
                                                                <a href="{{ url('/institute/enrolmentpayments/viewstudentpaymentdetails/'.$candidate->id) }}" class="btn btn-primary btn-sm">
                                                                    <span class="glyphicon glyphicon-eye-open"></span>&nbsp; view
                                                                </a>
                                                            @else
                                                                <h3 class="red-text">
                                                                    <span class="glyphicon glyphicon-remove-sign"></span>
                                                                </h3>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
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
@endsection

