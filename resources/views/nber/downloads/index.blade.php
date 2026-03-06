@extends('layouts.app')

@section('content')
    <section class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    Download Exam Marks
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <section class="hidethis">
                                            <ul class="breadcrumb">
                                                <li class="heading">Quick Links: </li>
                                                <li>
                                                    <a href="{{ url('/nber/exams') }}">Exams</a>
                                                </li>
                                                <li class="active">Exam Marks</li>
                                            </ul>
                                        </section>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="panel panel-info">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        @foreach($exams as $exam)
                                                            @php $sno = 1; @endphp
                                                            <div class="panel panel-info">
                                                                <div class="panel-heading">
                                                                    <div class="panel-title">
                                                                        <div class="center-text red-text bold-text">
                                                                            {{ $exam->name }} Exams
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="panel-body">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-hover table-bordered table-condensed">
                                                                            <tr>
                                                                                <th width="5%">S.No.</th>
                                                                                <th width="15%">Course Code</th>
                                                                                <th>Course Name</th>
                                                                                <th width="5%">Batch</th>
                                                                                <th>Institute-wise Marks</th>
                                                                                <th>Full Marks</th>
                                                                            </tr>

                                                                            @foreach($exambatches as $exambatch)
                                                                                @if($exambatch->exam->id == $exam->id)
                                                                                    <tr>
                                                                                        <td>{{$sno}}@php $sno++; @endphp</td>
                                                                                        <td>{{$exambatch->programme->course_name}}</td>
                                                                                        <td>{{$exambatch->programme->name}}</td>
                                                                                        <td>{{$exambatch->academicyear->year}}</td>
                                                                                        <td>
                                                                                            <a class="btn btn-xs btn-info" href="{{url('/downloads')}}/{{$exam->id}}/{{$exambatch->programme->id}}/{{$exambatch->academicyear->id}}"
                                                                                               target="_blank">
                                                                                                Select
                                                                                            </a>
                                                                                        </td>
                                                                                        <td>
                                                                                            <a class="btn btn-xs btn-info"
                                                                                               href="{{url('/downloads/full-course-marks')}}/{{$exam->id}}/{{$exambatch->programme->id}}/{{$exambatch->academicyear->id}}"
                                                                                               target="_blank">
                                                                                                <span class="glyphicon glyphicon-download-alt"></span>
                                                                                                Download Full Marks
                                                                                            </a>
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif
                                                                            @endforeach
                                                                        </table>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection