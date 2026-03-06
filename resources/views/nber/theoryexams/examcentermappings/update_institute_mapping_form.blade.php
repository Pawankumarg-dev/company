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
                                    {{ $exam->name }} Examinations - Exam Center Mappings
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
                                                    <a href="{{ url('/nber/theoryexams/'.$exam->id) }}">{{ $exam->name }} Theory</a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('/nber/theoryexams/examcentermapping/'.$exam->id) }}">Exam Centers Mappings</a>
                                                </li>
                                                <li class="active">Add Institute Mapping</li>
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
                                                        <p class="center-text">
                                                            <a href="{{ url('/nber/theoryexams/examcentermapping/updateinstitutemappingform/'.$exam->id) }}" class="btn btn-sm btn-primary">
                                                                <span class="glyphicon glyphicon-edit"></span>&nbsp;Institute Mapping
                                                            </a>
                                                            <a href="" class="btn btn-sm btn-primary">
                                                                <span class="glyphicon glyphicon-edit"></span>&nbsp;Candidate Mapping
                                                            </a>
                                                            <a href="{{ url('/nber/theoryexams/examcentermapping/'.$exam->id) }}" class="btn btn-sm btn-success">
                                                                <span class="glyphicon glyphicon-eye-open"></span>&nbsp;Mapped Exam Centers
                                                            </a>
                                                            <a href="{{ url('/nber/theoryexams/examcentermapping/showmappedinstitutes/'.$exam->id) }}" class="btn btn-sm btn-success">
                                                                <span class="glyphicon glyphicon-eye-open"></span>&nbsp;Mapped Institutes
                                                            </a>
                                                            <a href="{{ url('/nber/theoryexams/examcentermapping/showmappedcandidates/'.$exam->id) }}" class="btn btn-sm btn-success">
                                                                <span class="glyphicon glyphicon-eye-open"></span>&nbsp;Mapped Candidates
                                                            </a>
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="panel panel-info">
                                                            <div class="panel-heading">
                                                                <div class="panel-title">
                                                                    Add Institute Mapping Form
                                                                </div>
                                                            </div>

                                                            <div class="panel-body">
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <form class="form-horizontal" action="{{ url('/nber/theoryexams/examcentermapping/updateinstitutemappingdetails/') }}" method="POST"
                                                                              onsubmit="return validateForm()" role="form">
                                                                            {{ csrf_field() }}
                                                                            <input type="hidden" name="examId" value="{{ $exam->id }}" />

                                                                            <div class="form-group">
                                                                                <div class="text-left blue-text col-sm-3">
                                                                                    <label for="gender" class="control-label">
                                                                                        Exam Center Code :
                                                                                        <span class="red-text">*</span>
                                                                                    </label>
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <select class="form-control blue-text" name="examcenterId" id="examcenter-id">
                                                                                        <option value="0">0</option>
                                                                                        @foreach($examcenters as $examcenter)
                                                                                            <option value="{{ $examcenter->id }}" >{{ $examcenter->code }}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <div class="text-left blue-text col-sm-3">
                                                                                    <label for="gender" class="control-label">
                                                                                        Institute Code :
                                                                                        <span class="red-text">*</span>
                                                                                    </label>
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <select class="form-control blue-text" name="instituteId" id="institute-id">
                                                                                        @foreach($institutes as $institute)
                                                                                            <option value="{{ $institute->id }}" >{{ $institute->code }}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <div class="col-sm-10 col-sm-offset-3">
                                                                                    <button class="btn btn-primary btn-sm" type="submit"><span class="glyphicon glyphicon-ok-sign"></span>&nbsp;Submit</button>
                                                                                    <button class="btn btn-danger btn-sm" type="reset"><span class="glyphicon glyphicon-remove-sign"></span>&nbsp;Reset</button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
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
