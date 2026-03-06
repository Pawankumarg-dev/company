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
                                    Evaluations Centers
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="center-text" width="5%">S.No.</th>
                                            <th class="center-text" width="10%">Evaluation Center Code</th>
                                            <th class="center-text" width="10%">Evaluation Center Password</th>
                                            <th class="center-text">Evaluation Center Name</th>
                                            <th class="center-text">Bundle Numbers</th>
                                        </tr>
                                        </thead>
                                        @php $sno = 1; @endphp
                                        <tbody>
                                        @foreach($evaluationcenters as $evaluationcenter)
                                            <tr>
                                                <td class="center-text">{{ $sno }} @php $sno++; @endphp</td>
                                                <td class="center-text">{{ $evaluationcenter->code }}</td>
                                                <td class="center-text">{{ $evaluationcenter->password }}</td>
                                                <td>{{ $evaluationcenter->name }}</td>
                                                <td class="center-text" width="10%">
                                                    <a href="{{ url('/nber/evaluations/evaluationcenter/bundles/'.$exam->id.'/'.$evaluationcenter->id) }}" class="btn btn-default btn-sm">
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
@endsection


