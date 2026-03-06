@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title">
                            Enrolment Payment for {{ $academicyear->year }}
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
                                        <li class="active">{{ $academicyear->year }}</li>
                                    </ul>
                                </section>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-danger">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            Enrolment Fee - {{ $academicyear->year }}
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-condensed table-bordered" role="table">
                                                <tr>
                                                    <th class="center-text" width="5%">S. No.</th>
                                                    <th class="center-text" width="15%">Course</th>
                                                    <th class="center-text" width="10%">No. of Students entered</th>
                                                    <th class="center-text" width="15%">No. of Students Approved</th>
                                                    <th class="center-text" width="15%">Payment Details Link</th>
                                                </tr>
                                                @php $sno = 1; @endphp
                                                @foreach($approvedprogrammes as $approvedprogramme)
                                                    @php
                                                        $approvedCandidateCount = $approvedprogramme->approvedcandidatecount($approvedprogramme->id);
                                                    @endphp
                                                    <tr>
                                                        <td class="center-text">{{ $sno }} @php $sno++ @endphp</td>
                                                        <td>{{ $approvedprogramme->programme->course_name }}</td>
                                                        <td class="center-text">
                                                            @if($approvedprogramme->registered_count == 0 || is_null($approvedprogramme->registered_count))
                                                                0
                                                            @else
                                                            {{ $approvedprogramme->registered_count }}
                                                            @endif
                                                        </td>
                                                        <td class="center-text">
                                                            {{ $approvedCandidateCount }}
                                                        </td>
                                                        @if($approvedCandidateCount > 0)
                                                            <td class="center-text">
                                                                <a href="{{ url('/institute/enrolmentpayments/showstudents/'.$approvedprogramme->id) }}" class="btn btn-primary btn-sm">
                                                                    <span class="glyphicon glyphicon-pencil"></span>&nbsp; Enter
                                                                </a>
                                                            </td>
                                                        @else
                                                            <td></td>
                                                        @endif
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

