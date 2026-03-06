@extends('layouts.app')

@section('content')

    {{-- Breadcrumb --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <ul class="breadcrumb col-md-12">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li><b>{{$exam->name}} - Examination</b></li>
                    <li><b>Result</b></li>
                    <li><b>{{$approvedprogramme->programme->course_name}} ({{$approvedprogramme->academicyear->year}})</b></li>
                </ul>

            </div>
        </div>
    </div>
    {{-- ./Breadcrumb --}}

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="well well-lg">
                    <h1>Nothing Found</h1>
                </div>
            </div>
        </div>
    </div>

@endsection