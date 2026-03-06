@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="col-sm-12">
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title">
                            Exam Results
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            @foreach($exams as $e)
                                <div class="col-sm-2">
                                    <div class="panel panel-primary">
                                        <div class="panel-body text-center">
                                            <a href="{{ url("/nber/examresults/".$e->id) }}" class="btn btn-primary" target="_blank">
                                                {{ $e->name }}
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