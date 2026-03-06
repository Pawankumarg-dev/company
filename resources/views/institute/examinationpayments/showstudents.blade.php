@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    {{ $exam->name }} Examinations
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <section class="hidethis">
                                          {{-- <ul class="breadcrumb">
                                                <li class="heading">Quick Links: </li>
                                                <li>
                                                    <a href="{{ url('/payment') }}">Payments</a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('/institute/examinationpayments') }}">Exams List</a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('/institute/examinationpayments/showcourses/'.$exam->id) }}">{{ $exam->name }} Exams</a>
                                                </li>
                                                <li class="active">{{ $approvedprogramme->programme->course_name }} ( {{ $approvedprogramme->academicyear->year }})</li>
                                            </ul> --}} 
                                        </section>

                                        @include('common.errorandmsg')
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-hover table-condensed">
                                                <tr>
                                                    <th class="center-text blue-text">S.No.</th>
                                                    <th class="center-text blue-text">Batch</th>
                                                    <th class="center-text blue-text">Programme</th>
                                                    <th class="center-text blue-text">Enrolment No</th>
                                                    <th class="center-text blue-text">Name</th>
                                                    {{--<th class="center-text blue-text">Total Subjects Applied</th> --}}
                                                    <th class="center-text blue-text">Amount</th>
                                                    {{-- @if($allowOfflinePaymentLink == "Yes") --}}
                                                        <th class="center-text blue-text">Offline Payment Form</th>
                                                    {{-- @endif --}}
                                                    <th class="center-text blue-text">Online Payment Form</th>
                                                    <th class="center-text blue-text">Payment Status</th>
                                                </tr>

                                                @php $sno = 1; @endphp
                                                @foreach($candidates as $c)
                                                    <tr>
                                                        <td class="blue-text center-text">
                                                            {{ $sno }}
                                                            @php $sno++; @endphp
                                                        </td>
                                                        <td class="blue-text center-text">{{ $c->approvedprogramme->academicyear->year }}</td>
                                                        <td class="blue-text">{{ $c->approvedprogramme->programme->course_name }}</td>
                                                        <td class="blue-text">
                                                            {{ $c->enrolmentno }}
                                                        </td>
                                                        <td class="blue-text">{{ $c->name }}</td>
                                                        <td class="blue-text">
                                                           {{-- @php
                                                                $subjectcount = \App\Http\Controllers\Institute\ExaminationpaymentController::calculatecandidatesubjectcount($exam->id, $c->id);
                                                                $amount = 100 * $subjectcount;
                                                            @endphp
                                                            {{ $subjectcount }} --}}
                                                        </td>
                                                        <td class="blue-text">
                                                            {{ $amount }}
                                                        </td>
                                                        @if($allowOfflinePaymentLink == "Yes")
                                                            <td class="center-text">
                                                                @php
                                                                    $hrefvalue = '/institute/examinationpayments/addpayment/'.$exam->id.'/'.$c->id;
                                                                @endphp
                                                                <a href="javascript:void(0)" onclick="location.href='{{ $hrefvalue }}'" class="btn btn-primary btn-sm">
                                                                    <span class="glyphicon glyphicon-arrow-right white-color bold-text"></span>&nbsp; NEFT
                                                                </a>
                                                            </td>
                                                        @endif
                                                        <td class="center-text">
                                                            {{--
                                                            <span class="label label-danger">
                                                                Link under Maintenance
                                                            </span>
                                                            --}}

                                                            @if($approvedprogramme->programme->nber_id == 2 || $approvedprogramme->programme->nber_id == 3 )
                                                            {{-- Offline Payment Link --}}
                                                            @php
                                                                $hrefvalue = '/institute/examinationpayments/addpayment/'.$exam->id.'/'.$c->id;
                                                            @endphp
                                                            <a href="javascript:void(0)" onclick="location.href='{{ $hrefvalue }}'" class="btn btn-primary btn-sm">
                                                                <span class="glyphicon glyphicon-arrow-right white-color bold-text"></span>&nbsp; Click here
                                                            </a>
                                                            @endif

                                                            {{-- Online Payment Link
                                                            @php
                                                                $hrefvalue = '/institute/examinationpayments/showonlinepaymentform/'.$exam->id.'/'.$c->id;
                                                            @endphp
                                                            <a href="javascript:void(0)" onclick="location.href='{{ $hrefvalue }}'" class="btn btn-primary btn-sm">
                                                                <span class="glyphicon glyphicon-arrow-right white-color bold-text"></span>&nbsp; Gateway
                                                            </a>  --}}
                                                        </td>
                                                        <td class="center-text">
                                                        {{--
                                                            @php
                                                               $checkcandidate = \App\Http\Controllers\Institute\ExaminationpaymentController::checkcandidate($exam->id, $c->id) 

                                                            @endphp

                                                            @if($checkcandidate == 0)

                                                            @else
                                                                @php
                                                                    $hrefvalue = "/institute/examinationpayments/viewstudentpaymentdetails/".$exam->id.'/'.$c->id;
                                                                @endphp
                                                                <a href="javascript:void(0)" onclick="location.href='{{ $hrefvalue }}'" class="btn btn-success btn-sm">
                                                                   <span class="glyphicon glyphicon-eye-open white-color"></span>&nbsp; View
                                                                </a>
                                                            @endif
                                                            --}}
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