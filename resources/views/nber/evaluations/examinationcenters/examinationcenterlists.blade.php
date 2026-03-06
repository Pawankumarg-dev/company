@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-primary">
                    <div class="panel-body">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    Evaluations - Examination Centers
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="center-text">S.No.</th>
                                            <th class="center-text">ExamCenter Code</th>
                                            <th class="center-text">ExamCenter Name</th>
                                            <th class="center-text">Online Attendance</th>
                                        </tr>
                                        </thead>
                                        @php $sno = 1; @endphp
                                        <tbody>
                                        @foreach($examcenters as $examcenter)
                                            <tr>
                                                <td class="center-text">{{ $sno }} @php $sno++; @endphp</td>
                                                <td class="center-text">{{ $examcenter->code }}</td>
                                                <td>{{ $examcenter->name }}</td>
                                                <td class="center-text" width="10%">
                                                    <a href="" class="btn btn-default btn-sm">
                                                        Click here
                                                    </a>
                                                </td>
                                                <td class="center-text" width="10%">
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
@endsection

