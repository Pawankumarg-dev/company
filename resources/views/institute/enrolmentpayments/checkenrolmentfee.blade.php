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
                                <div class="panel panel-danger">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            Enrolment Fee - {{ $approvedprogramme->academicyear->year }}
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-condensed table-bordered" role="table">
                                                <tr>
                                                    <th class="center-text" width="5%">S. No.</th>
                                                    <th class="center-text" width="20%">Photo</th>
                                                    <th class="center-text" width="10%">Enrolment No</th>
                                                    <th class="center-text" width="25%">Name</th>
                                                    <th class="center-text" width="10%">Candidate<br>Approval<br>Status</th>
                                                    <th class="center-text" width="10%">Enrolment<br>Fee</th>
                                                    <th class="center-text" width="10%">Amount<br>(without<br>late fee)</th>
                                                    <th class="center-text" width="10%">Late Fee</th>
                                                    <th class="center-text" width="10%">Amount<br>(with late fee)</th>
                                                </tr>
                                                @php $sno = 1; @endphp
                                                @foreach($approvedprogramme->approvedcandidatelist($approvedprogramme->id) as $candidate)
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
                                                        <td class="center-text"><span class="label label-success">Approved</span></td>
                                                        <td class="blue-text center-text">500</td>
                                                        <td class="bold-text center-text green-background">500</td>
                                                        <td class="blue-text center-text">500</td>
                                                        <td class="bold-text red-text center-text red-background">1000</td>
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

