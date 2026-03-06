@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-info">
                    <div class="panel-body">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    Course Coordinator Details
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <section class="hidethis">
                                            <ul class="breadcrumb">
                                                <li class="heading">Quick Links: </li>
                                                <li>
                                                    <a href="{{ url('/institutes') }}">Institute</a>
                                                </li>
                                                <li class="active">Course Coordinators</li>
                                            </ul>
                                        </section>
                                    </div>

                                    <div class="col-sm-12">
                                        @include('nber.institutes.common')
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="panel panel-info">
                                            <div class="panel-body">
                                                <div class="panel panel-info">
                                                    <div class="panel-heading">
                                                        <div class="panel-title">
                                                            Details of Course Coordinators
                                                        </div>
                                                    </div>

                                                    <div class="panel-body">
                                                        @foreach($institutes as $institute)
                                                            <div class="panel panel-warning">
                                                                <div class="panel-heading">
                                                                    <div class="panel-title">
                                                                        {{ $institute->code }} - {{ $institute->name }}
                                                                    </div>
                                                                </div>

                                                                <div class="panel-body">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-bordered table-hover table-condensed" role="table">
                                                                            <thead>
                                                                            <tr>
                                                                                <th class="red-text center-text" width="5%">S.No.</th>
                                                                                <th class="red-text center-text" width="15%">Name</th>
                                                                                <th class="red-text center-text" width="10%">Course(s)<br>Handling</th>
                                                                                <th class="red-text center-text" width="40%">Contact Details</th>
                                                                                <th class="red-text center-text" width="5%">CRR No.</th>
                                                                                <th class="red-text center-text" width="10%">RCI<br>Qualifications</th>
                                                                                <th class="red-text center-text" width="10%">Other<br>Qualifications</th>
                                                                                <th class="red-text center-text" width="5%">Teaching<br>Experience</th>
                                                                            </tr>
                                                                            </thead>

                                                                            <tbody>
                                                                            @if($coursecoordinators->where('institute_id', $institute->id)->count() == 0)
                                                                                <tr>
                                                                                    <td class="center-text" colspan="9">
                                                                                        <span class="label label-danger">No Records Found</span>
                                                                                    </td>
                                                                                </tr>
                                                                            @else
                                                                                @php $sno = 1; @endphp
                                                                                @foreach($coursecoordinators->where('institute_id', $institute->id) as $coursecoordinator)
                                                                                    <tr>
                                                                                        <td class="blue-text center-text">{{ $sno }} @php $sno++; @endphp</td>
                                                                                        <td class="blue-text">{{ $coursecoordinator->title->title }} {{ $coursecoordinator->name  }}</td>
                                                                                        <td class="blue-text">{{ $coursecoordinator->courses_handling }}</td>
                                                                                        <td class="blue-text">
                                                                                            {{ $coursecoordinator->address }},<br>
                                                                                            @if($coursecoordinator->city_id != 0)
                                                                                                {{ $coursecoordinator->city->name }},
                                                                                                {{ $coursecoordinator->city->state->state_name }} - {{ $coursecoordinator->pincode }}
                                                                                            @endif
                                                                                        </td>
                                                                                        <td class="blue-text center-text">{{ $coursecoordinator->registration_number }}</td>
                                                                                        <td class="blue-text center-text">{{ $coursecoordinator->rci_qualifications }}</td>
                                                                                        <td class="blue-text center-text">{{ $coursecoordinator->other_qualifications }}</td>
                                                                                        <td class="blue-text center-text">{{ $coursecoordinator->teaching_experience }}</td>
                                                                                    </tr>
                                                                                @endforeach
                                                                            @endif
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
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
    </div>
@endsection
