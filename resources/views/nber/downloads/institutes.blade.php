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
                                    {{ $exam->name }} Exams - Download Exam Marks
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
                                                <li>
                                                    <a href="{{ url('/downloads') }}">Exams Marks</a>
                                                </li>
                                                <li class="active">{{ $programme->course_name }} ({{ $academicyear->year }})</li>
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
                                                        <div class="panel panel-info">
                                                            <div class="panel-heading">
                                                                <div class="panel-title">
                                                                    <div class="center-text red-text bold-text">
                                                                        {{ $exam->name }} Exams - Download Exam Marks
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="panel-body">
                                                                @php $sno = 1; @endphp
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-hover table-bordered table-condensed">
                                                                                <tr>
                                                                                    <th width="5%">S.No.</th>
                                                                                    <th width="10%">Institute Code</th>
                                                                                    <th>Institute Name</th>
                                                                                    <th width="10%">Marks</th>
                                                                                    <th width="10%">Photos</th>
                                                                                </tr>

                                                                                @foreach($institutes as $institute)
                                                                                    @foreach($approvedprogrammes as $approvedprogramme)
                                                                                        @if($approvedprogramme->institute->id == $institute->id)
                                                                                            <tr>
                                                                                                <td>{{$sno}}@php $sno++; @endphp</td>
                                                                                                <td>{{ $institute->code }}</td>
                                                                                                <td>{{ $institute->name }}</td>
                                                                                                <td>
                                                                                                    <a class="btn btn-xs btn-success" href="{{url('downloads')}}/{{$exam->id}}/{{$approvedprogramme->id}}"
                                                                                                       target="_blank"> <i class="fa fa-arrow-circle-o-down"></i> <i class="fa fa-file-excel-o"></i> Download Marks
                                                                                                    </a>
                                                                                                </td>
                                                                                                <td>
                                                                                                    <a class="btn btn-xs btn-primary" href="{{url('download-photos')}}/{{$exam->id}}/{{$approvedprogramme->id}}"
                                                                                                       target="_blank"> Select Photos <i class="fa fa-arrow-circle-right"></i>
                                                                                                    </a>
                                                                                                </td>
                                                                                            </tr>
                                                                                        @endif
                                                                                    @endforeach
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection