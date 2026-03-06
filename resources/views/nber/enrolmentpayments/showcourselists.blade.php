@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body">
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
                                                    <a href="{{ url('nber/payments/enrolment/') }}">Enrolment Payments</a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('nber/payments/enrolment/'.$academicyear->id) }}">{{ $academicyear->year }}</a>
                                                </li>
                                                <li class="active">{{ $institute->code }}</li>
                                            </ul>
                                        </section>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="panel panel-danger">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    Enrolment Payment Fee - {{ $academicyear->year }}
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
                                                            <th class="center-text" width="15%">Verify Payment Details</th>
                                                        </tr>
                                                        @php $sno = 1; @endphp
                                                        @foreach($approvedprogrammes as $approvedprogramme)
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
                                                                    {{ $approvedprogramme->approvedcandidatecount($approvedprogramme->id) }}
                                                                </td>
                                                                @if($approvedprogramme->approvedcandidatecount($approvedprogramme->id) > 0)
                                                                    <td class="center-text">
                                                                        <a href="{{ url('/nber/payments/enrolment/showstudentlists/'.$academicyear->id.'/'.$approvedprogramme->id) }}" class="btn btn-primary btn-sm">
                                                                            <span class="glyphicon glyphicon-hand-right"></span>&nbsp; Click Here
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
        </div>
    </div>
@endsection
