@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title">
                            Examination Payments
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb well white-background">
                                        <li><a href="{{ url('nber/payments/') }}">Payments</a></li>
                                        <li class="active">Re-Evaluation Payments</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-condensed">
                                        <tr>
                                            <th width="5%">S.No.</th>
                                            <th>Exam</th>
                                            <th>Link</th>
                                        </tr>

                                        @php $sno = 1; @endphp
                                        @foreach($reevaluations as $reevaluation)
                                            <tr>
                                                <td>{{ $sno }} @php $sno++; @endphp</td>
                                                <td>{{ $reevaluation->exam->name }} Examinations</td>
                                                <td class="center-text">
                                                    <a href="{{ url('/nber/payments/reevaluation/'.$reevaluation->exam_id) }}" class="btn btn-info btn-sm">
                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                    </a>
                                                </td>
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
@endsection
