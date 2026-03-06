@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb well white-background">
                        <li><a href="{{ url('nber/payments/') }}">Payments</a></li>
                        <li class="active">Enrolment Payments</li>
                    </ol>
                </nav>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title">
                            Enrolment Payments
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            @foreach($academicyears->sortByDesc('year') as $ay)
                            <div class="col-sm-2">
                                <div class="panel panel-default">
                                    <div class="panel-body text-center">
                                        <a href="{{ url('/nber/payments/enrolment/'.$ay->id) }}">{{ $ay->year }}</a>
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
@endsection