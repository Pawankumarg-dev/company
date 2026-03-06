<style>
    .icon-text {
        font-size: 30px !important;
    }
</style>

@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb col-md-12">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li> <a href="{{url('/payment')}}">Payments</a> </li>
                    <li>Enrolment Payments</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-users"></i> &nbsp;&nbsp;Payment of Enrolment
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            @foreach($academicyears as $ay)
                                <div class="col-sm-2">
                                    <div class="panel panel-primary">
                                        <div class="panel-body text-center">
                                            <a href="{{url('/institute/payment/enrolment/academicyear/'.$ay->id)}}">
                                                <i class="fa fa-rupee icon-text"></i><br />
                                                Enrolment Payment for {{ $ay->year }}
                                            </a>
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