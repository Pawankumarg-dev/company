@extends('layouts.app')
@section('content')
    <main>
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
                                                <ul class="breadcrumb">
                                                 {{--   <li class="heading">Quick Links: </li>
                                                    <li>
                                                        <a href="{{ url('/payment') }}">Payments</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ url('/institute/examinationpayments') }}">Exams List</a>
                                                    </li>
                                                    <li class="active">{{ $exam->name }} Exams</li> 
                                                </ul> --}}
                                            </section>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table table-bordered table-condensed table-hover">
                                                <thead>
                                                <tr>
                                                    <th width="5%" class="center-text">S.No</th>
                                                    <th width="15%" class="center-text">Course</th>
                                                    <th width="5%" class="center-text">Batch</th>
                                                    <th class="center-text">No. of Students applied for Exam</th>
                                                    <th class="center-text">No. of Papers applied for Exam</th>
                                                    <th class="center-text">Total Amount</th>
                                                    <th class="center-text">Payment</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @php $sno = 1; @endphp
                                                @foreach($approvedprogrammes as $approvedprogramme)
                                                    <tr>
                                                        <td class="center-text">{{ str_pad($sno, 2, "0", STR_PAD_LEFT) }}@php $sno++; @endphp</td>
                                                        <td>{{ $approvedprogramme->programme->course_name }}</td>
                                                        <td class="center-text">{{ $approvedprogramme->academicyear->year }}</td>
                                                        @php
                                                            $examappliedcandidatecount = $approvedprogramme->examappliedcandidatecount($exam->id, $approvedprogramme->id);
                                                            $examappliedsubjectcount = $approvedprogramme->examappliedsubjectcount($exam->id, $approvedprogramme->id);
                                                        @endphp
                                                        <td class="center-text">{{ $examappliedcandidatecount }}</td>
                                                        @if($examappliedcandidatecount != 0)
                                                            <td class="center-text">
                                                                {{ $examappliedsubjectcount }}
                                                            </td>
                                                            <td>
                                                                {{ $examappliedsubjectcount * 100 }}
                                                            </td>
                                                            <td class="center-text">
                                                            @if($approvedprogramme->programme->nber_id==2 )
                                                                <a href="{{url('/institute/examinationpayments/showstudents/'.$exam->id.'/'.$approvedprogramme->id)}}" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-arrow-right"></span> &nbsp;Offline Payment (DD)</a>
                                                            @endif
                                                            @if($approvedprogramme->programme->nber_id==3 )
                                                                <a href="{{url('/institute/examinationpayments/showstudents/'.$exam->id.'/'.$approvedprogramme->id)}}" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-arrow-right"></span> &nbsp;Offline Payment (NEFT)</a>
                                                            @endif

                                                            </td>
                                                        @else
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                                </tbody>
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
    </main>
@endsection
