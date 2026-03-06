@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title">
                            Evaluations
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="panel panel-primary">
                                    <div class="panel-body">
                                        Evaluation Centers
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table class="table table-condensed table-bordered">
                                        <thead>
                                        <tr class="bg-info">
                                            <th class="center-text" width="5%">S.No.</th>
                                            <th class="center-text">Exams</th>
                                            <th class="center-text">Evaluation Centers</th>
                                            <th class="center-text">Examination Centers</th>
                                            <th class="center-text">Bundle Numbers</th>
                                            <th class="center-text">Mark Entry</th>
                                        </tr>
                                        </thead>
                                        @php $sno = 1; @endphp
                                        <tbody>
                                        @foreach($exams as $exam)
                                        <tr>
                                            <td class="center-text">{{ $sno }} @php $sno++; @endphp</td>
                                            <td>{{ $exam->name }}</td>
                                            <td class="center-text" width="10%">
                                                <a href="{{ url('/nber/evaluations/evaluationcenterlists/'.$exam->id) }}" class="btn btn-default btn-sm">
                                                    Click here
                                                </a>
                                            </td>
                                            <td class="center-text" width="10%">
                                                <a href="{{ url('/nber/evaluations/examinationcenterlists/'.$exam->id) }}" class="btn btn-default btn-sm">
                                                    Click here
                                                </a>
                                            </td>
                                            <td class="center-text" width="10%">
                                                <a href="#" class="btn btn-default btn-sm">
                                                    Click here
                                                </a>
                                            </td>
                                            <td class="center-text" width="10%">
                                                <a href="#" class="btn btn-default btn-sm">
                                                    Click here
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

    {{--
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb col-md-12">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li>Evaluations</li>
                </ul>
            </div>
        </div>
    </div>

    <section class="container">
        <div class="row">
            <div class="col-sm-3 well well-sm white-background">
                <div class="center-text bold-text">
                    <a href="{{ url('/nber/evaluations/bundles/') }}">
                        Exam Bundles
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text">
                    <a href="{{ url('/nber/evaluations/show-generate-dummy-number-page') }}">
                        Generate Dummy Serial Number
                    </a>
                </div>
            </div>
        </div>
    </section>
        --}}

@endsection