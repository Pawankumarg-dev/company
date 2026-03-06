@extends('layouts.app')
@section('content')
    <section class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title">
                            {{ $exam->name }} Exams - Consolidated Class Attendance
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
                                            <a href="{{ url('/institute/examinations') }}">Examinations</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('/institute/examinations/'.$exam->id) }}">{{ $exam->name }} Exams</a>
                                        </li>
                                        <li class="active">Class Attendance Percentage</li>
                                    </ul>
                                </section>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            Class Attendance Percentage
                                        </div>
                                    </div>

                                    <div class="panel-body">
                                        <div class="row center-div">
                                            <div class="col-sm-10">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped table-hover table-condensed" role="table">
                                                        <thead>
                                                        <tr>
                                                            <th class="center-text orange-text" width="5%">S.No.</th>
                                                            <th class="center-text orange-text" width="25%">Course</th>
                                                            <th class="center-text orange-text" width="5%">Batch</th>
                                                            <th class="center-text orange-text" width="5%">Term</th>
                                                            <th class="center-text orange-text" width="10%">Type</th>
                                                            <th class="center-text orange-text" colspan="2">Update Attendance Percentage</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @php $serialNumber = 1; @endphp
                                                        @foreach($collections as $collection)
                                                            <tr>
                                                                <td class="center-text blue-text">{{ $serialNumber }} @php $serialNumber++; @endphp</td>
                                                                <td class="blue-text">{{ $collection->courseCode }}</td>
                                                                <td class="center-text blue-text">{{ $collection->year }}</td>
                                                                <td class="center-text blue-text">{{ $collection->term }}</td>
                                                                <td class="blue-text">{{ $collection->type }}</td>
                                                                <td class="center-text">
                                                                    <a href="{{ url('/institute/consolidatedclassattendance/'.strtolower($collection->type).'/updateform/'.$exam->id.'/'.$collection->approvedprogrammeId.'/'.$collection->term) }}" class="btn btn-success btn-sm">
                                                                        Theory &nbsp;
                                                                        <span class="glyphicon glyphicon-share-alt"></span>
                                                                    </a>
                                                                </td>
                                                                <td class="center-text">
                                                                    <a href="" class="btn btn-info btn-sm">
                                                                        Practical &nbsp;
                                                                        <span class="glyphicon glyphicon-share-alt"></span>
                                                                    </a>
                                                                </td>
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
            </div>
        </div>
    </section>
@endsection
