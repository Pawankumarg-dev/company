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
                                                <a href="{{ url('/nber/theoryexams/'.$exam->id) }}">{{ $exam->name }} Theory</a>
                                            </li>
                                            <li class="active">Nodal Officer</li>
                                        </ul>
                                    </section>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="panel-group">
                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    Nodal Officer
                                                </div>
                                            </div>

                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" role="table">
                                                        <thead>
                                                        <tr>
                                                            <th class="center-text orange-text" width="1%">S.No.</th>
                                                            <th class="center-text orange-text" width="10%">Name</th>
                                                            <th class="center-text orange-text" width="10%">Designation</th>
                                                            <th class="center-text orange-text" width="10%">Organization</th>
                                                            <th class="center-text orange-text" width="10%">Email</th>
                                                            <th class="center-text orange-text" width="5%">Mobile No.</th>
                                                            <th class="center-text orange-text" width="15%">Status</th>
                                                            <th class="center-text orange-text" width="5%">Action</th>
                                                        </tr>
                                                        </thead>

                                                        <tbody>
                                                        @php $sno = 1; $count = 0; @endphp
                                                        @foreach($nodalofficers as $nodalofficer)
                                                            <tr>
                                                                <td class="center-text blue-text">{{ $sno }}</td>
                                                                <td class="center-text blue-text">{{ $nodalofficer->name }}</td>
                                                                <td class="center-text blue-text">{{ $nodalofficer->designation }}</td>
                                                                <td class="center-text blue-text">{{ $nodalofficer->organization }}</td>
                                                                <td class="center-text blue-text">{{ $nodalofficer->email1 }} @if(!is_null($nodalofficer->email2))/ {{ $nodalofficer->email2 }}@endif
                                                                <td class="center-text blue-text">{{ $nodalofficer->contactnumber1 }} @if(!is_null($nodalofficer->contactnumber2))/ {{ $nodalofficer->contactnumber2 }}@endif
                                                                </td>
                                                                <td class="center-text blue-text">
                                                                    @if($nodalofficer->active_status == 1)
                                                                        <span class="label label-success">Active</span>
                                                                    @else
                                                                        <span class="label label-danger">Inactive</span>
                                                                    @endif
                                                                </td>
                                                                <td colspan="center-text blue-text">

                                                                </td>
                                                            </tr>
                                                            @php $sno++; $count++; @endphp
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
            </div>
        </div>
    </main>
@endsection