@extends('layouts.app')

@section('content')
    @if (Session::has('messages') )
        @include('common.errorandmsg')
    @endif

    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text">
                    {{ $exam->name }} @if($exam->examtype_id == '2') Supplementary @endif - External Practical Examination
                </div>
            </div>
        </div>
    </section>

    @if($applied_count == '0')
        <section class="container-fluid">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="center-text">
                        No candidates have applied for the examinations
                    </div>
                </div>
            </div>
        </section>
    @else
        <section class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-3 well well-sm white-background minus15px-margin-top">
                    <h2 class="center-text">
                        <a href="{{ url('/institute/practicalexam/'.$exam->id.'/showcandidates/'.$approvedprogramme->id) }}">
                            Candidate Hall ticket
                        </a>
                    </h2>
                </div>
                <div class="col-sm-3 well well-sm white-background minus15px-margin-top">
                    <h2 class="center-text">
                        <a href="{{ url('/institute/practicalexam/'.$exam->id.'/showsubjects/'.$approvedprogramme->id) }}">
                            Attendance Sheet
                        </a>
                    </h2>
                </div>
                <div class="col-sm-3"></div>
            </div>
        </section>
    @endif
@endsection