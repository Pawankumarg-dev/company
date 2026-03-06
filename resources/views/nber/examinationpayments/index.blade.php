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
                                    Examination Payments
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    @foreach($exams as $exam)
                                    <div class="col-md-3 col-sm-4">
                                        <div class="wrimagecard wrimagecard-topimage">
                                            <a href="{{ url('/nber/examinationpayments/showverificationstatus/'.$exam->id) }}">
                                                <div class="wrimagecard-topimage_header" style="background-color: rgba(213, 15, 37, 0.1)">
                                                    <center>
                                                        <img src="{{ asset('/images/icon_examinationfee.png') }}" class="img-responsive" width="35%">
                                                    </center>
                                                </div>
                                                <div class="wrimagecard-topimage_title">
                                                    <h4 class="text-center">
                                                        {{ $exam->name }}
                                                    </h4>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                {{--
                                @foreach($institutes as $institute)
                                    <div class="row">
                                        <div class="col-sm-1 bg-info">
                                            {{ $institute->code }}
                                        </div>
                                        <div class="col-sm-11">
                                            {{ $institute->name }}
                                        </div>
                                    </div>
                                @endforeach
                                --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-info">
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
                                                        <li class="active">Examination</li>
                                                    </ol>
                                                </nav>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-condensed">
                                                        <tr>
                                                            <th class="center-text" width="">S. No.</th>
                                                            <th class="center-text">Exams</th>
                                                            <th class="center-text">Payment Link</th>
                                                            <th class="center-text">Examination Fee</th>
                                                        </tr>

                                                        @php $sno = 1; @endphp
                                                        @foreach($exams as $exam)
                                                            <tr>
                                                                <td class="center-text">{{ $sno }} @php $sno++; @endphp</td>
                                                                <td>{{ $exam->name }}</td>
                                                                <td class="center-text">
                                                                    <a href="{{ url('/nber/examinationpayments/'.$exam->id) }}" class="btn btn-info btn-sm">
                                                                        <span class="glyphicon glyphicon-hand-right"></span>
                                                                    </a>
                                                                    <a href="{{ url('/nber/examinationpayments/showverificationstatus/'.$exam->id) }}" class="btn btn-info btn-sm">
                                                                        <span class="glyphicon glyphicon-hand-right"></span>
                                                                    </a>
                                                                </td>
                                                                <td class="center-text">
                                                                    <a href="#" class="btn btn-info btn-sm">
                                                                        <span class="glyphicon glyphicon-hand-right"></span>
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
                </div>
            </div>
        </div>
    </div>
@endsection