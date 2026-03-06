@extends('layouts.app')
@section('content')

    <main>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="panel-title">
                                Examinations
                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                @foreach($exams as $exam)
                                    <div class="col-sm-2">
                                        <div class="panel panel-default">
                                            <div class="panel-body bg-default">
                                                <div class="center-text">
                                                    <a href="{{ url('/institute/examinations/'.$exam->id) }}"
                                                    >
                                                        <span class="glyphicon glyphicon-th-list icon-text"></span><br>
                                                        {{ $exam->name }}<br> Examinations
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{--
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <tr>
                                                <th width="5%">S.No.</th>
                                                <th width="15%">Exam</th>
                                                <th class="center-text" width="10%">Exam Application</th>
                                                <th class="center-text" width="10%">Mark Entry</th>
                                                <th class="center-text" width="10%">Selection of Practical Examiners</th>
                                                <th class="center-text" width="60%"></th>
                                            </tr>

                                            @php $sno = 1; @endphp
                                            @foreach($exams as $exam)
                                                <tr>
                                                    <td class="center-text">{{ $sno }} @php $sno++; @endphp</td>
                                                    <td class="blue-text">{{ $exam->name }}</td>
                                                    <td class="blue-text center-text">
                                                        @if($exam->status_id === 1)
                                                            @if($exam->exam_application === 1)
                                                                <a href="{{ url('/institute/examinations/applications/showcandidates/'.$exam->id.'/'.$institute->id) }}" class="btn btn-sm btn-success">
                                                                    <span class="glyphicon glyphicon-arrow-right"></span> Apply
                                                                </a>
                                                            @endif
                                                        @else

                                                        @endif
                                                    </td>
                                                    <td class="blue-text center-text">
                                                        @if($exam->status_id === 1)
                                                            @if($exam->institute_markentry === 1)
                                                                <a href="{{ url('/institute/examinations/applications/showcandidates/'.$exam->id.'/'.$institute->id) }}" class="btn btn-sm btn-success">
                                                                    <span class="glyphicon glyphicon-arrow-right"></span> Apply
                                                                </a>
                                                            @endif
                                                        @else

                                                        @endif
                                                    </td>
                                                    <td class="blue-text center-text">
                                                        @if($exam->status_id === 1)
                                                            <a href="{{ url('/institute/examinations/practicalexaminers/'.$exam->id) }}" class="btn btn-sm btn-success">
                                                                <span class="glyphicon glyphicon-arrow-right"></span> Apply
                                                            </a>
                                                        @else

                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        --}}
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
