@extends('layouts.app')
@section('content')
    <style>
        table{
            border-collapse:separate;
            border-spacing: 5px;
        }
    </style>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb col-md-12">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li><a href="{{url('/institute/certifications/')}}">Certifications</a></li>
                    <li><a href="{{url('/institute/marksheets/')}}">Statement of Marks</a></li>
                    <li>{{ $exam->name }} Examinations - Candidates List</li>
                </ul>
            </div>
        </div>
    </div>
@endsection