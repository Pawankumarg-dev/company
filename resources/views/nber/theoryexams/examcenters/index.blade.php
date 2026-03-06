@extends('layouts.app')
@section('content')
    <main>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-primary">
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
                                            <li class="heading">Quick Links: </li>
                                            <li>
                                                <a href="{{ url('/nber/exams') }}">Exams</a>
                                            </li>
                                            <li>
                                                <a href="{{ url('nber/theoryexams/'.$exam->id) }}">{{ $exam->name }} Theory</a>
                                            </li>
                                            <li class="active">Exam Centers</li>
                                        </ul>
                                    </section>
                                </div>
                            </div>

                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        List of Exam Centers
                                    </div>
                                </div>

                                <div class="panel-body">
                                    {{-- table --}}
                                    @foreach($states as $state)
                                        <div class="panel panel-warning">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    State: {{ $state->state }}
                                                </div>
                                            </div>

                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-condensed" role="table">
                                                        <thead>
                                                        <tr>
                                                            <th class="right-text" colspan="8">
                                                                <a href="{{ url('/nber/theoryexams/examcenters/add/'.$exam->id) }}" class="btn btn-info">
                                                                    <span class="glyphicon glyphicon-plus"></span> Add Exam Center
                                                                </a>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th class="center-text" width="5%">#</th>
                                                            <th class="center-text" width="5%">Code</th>
                                                            <th class="center-text" width="10%">Password</th>
                                                            <th class="center-text" width="20%">Name</th>
                                                            <th class="center-text" width="20%">Address</th>
                                                            <th class="center-text" width="10%">Zone Code</th>
                                                            <th class="center-text" width="5%">Status</th>
                                                            <th class="center-text" width="10%">Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @php $sno = 1; @endphp
                                                        @foreach($externalexamcenters->where('state', $state->state) as $externalexamcenter)
                                                            <tr>
                                                                <td class="center-text">{{ $sno }}@php $sno++; @endphp</td>
                                                                <td class="center-text">{{ $externalexamcenter->code }}</td>
                                                                <td class="center-text">{{ $externalexamcenter->password }}</td>
                                                                <td class="center-text">{{ $externalexamcenter->name }}</td>
                                                                <td class="left-text">
                                                                    {{ $externalexamcenter->address }}
                                                                    @if($externalexamcenter->district != ''), {{ $externalexamcenter->district }} @endif
                                                                    @if($externalexamcenter->state != ''), {{ $externalexamcenter->state }} @endif
                                                                    @if($externalexamcenter->pincode != '')- {{ $externalexamcenter->pincode }} @endif<br>
                                                                    Contact No.: {{ $externalexamcenter->contactnumber1 }} @if($externalexamcenter->contactnumber2 != '')/ {{ $externalexamcenter->contactnumber2 }} @endif<br>
                                                                    Email: {{ $externalexamcenter->email1 }}@if($externalexamcenter->email2 != '')/ {{ $externalexamcenter->email2 }} @endif
                                                                </td>
                                                                <td class="center-text">
                                                                    @if($externalexamcenter->zone_id != 0)
                                                                        {{ $externalexamcenter->zone->code }}
                                                                    @endif
                                                                </td>
                                                                <td class="center-text">
                                                                    @if($externalexamcenter->active_status == 1)
                                                                        <span class="label label-success">Active</span>
                                                                    @else
                                                                        <span class="label label-danger">Not Active</span>
                                                                    @endif
                                                                </td>
                                                                <td class="center-text">
                                                                    <a href="{{ url('/nber/theoryexams/examcenters/edit/'.$exam->id.'/'.$externalexamcenter->id) }}">
                                                                        <span class="glyphicon glyphicon-edit"></span> Edit
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach


                                    {{-- ./table --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
