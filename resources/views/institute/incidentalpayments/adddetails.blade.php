@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb col-md-12">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li><a href="{{url('/payment')}}">Payments</a></li>
                    <li><a href="{{url('/institute/incidentalpayments')}}">Affiliation fee Payments</a></li>
                    <li>{{ $academicyear->year }}</li>
                </ul>
            </div>
        </div>
    </div>
@endsection