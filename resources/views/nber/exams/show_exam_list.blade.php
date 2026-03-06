
@extends('layouts.app')

@section('content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text">
                    Exams
                </div>
            </div>
        </div>
    </section>

    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-condensed">
                        <tr class="grey-background">
                            <th class="center-text col-sm-1">S. No</th>
                            <th class="center-text col-sm-2">Exam Name</th>
                            <th class="center-text" colspan="9">Links</th>
                        </tr>

                        @php $sno = 1; @endphp
                        @foreach($exams as $e)
                            <tr>
                                <td>{{ $sno }}</td>
                                <td>{{ $e->name }}</td>
                                <td class="center-text">
                                    <a href="{{url('/nber/examapplications/'.$e->id)}}" class="btn btn-sm btn-primary">
                                        <b>Exam applications</b>
                                    </a>
                                </td>
                                <td class="center-text">
                                    <a href="{{ url('/nber/practicalexams/'.$e->id) }}" class="btn btn-sm btn-success">
                                        <b>Practical Exams</b>
                                    </a>
                                    {{--
                                    <a href="{{ url('/nber/exams/practical/'.$e->id.'/showlists') }}" class="btn btn-sm btn-success">
                                        <b>Practical Exams</b>
                                    </a>
                                    --}}
                                </td>
                                <td class="center-text">
                                    <a href="{{ url('/nber/theoryexams/'.$e->id) }}" class="btn btn-sm btn-success">
                                        <b>Theory Exams</b>
                                    </a>
                                    {{--
                                    <a href="{{ url('/nber/exams/theory/'.$e->id.'/showlists') }}" class="btn btn-sm btn-success">
                                        <b>Theory Exams</b>
                                    </a>
                                    --}}
                                </td>
                                <td class="center-text">
                                    @if($e->nber_markentry == 1)
                                        <a href="{{ url('/nber/exams/marks-entry/'.$e->id.'/show-applied-list') }}" class="btn btn-sm btn-primary"><b>Marks Entry</b></a>
                                    @else

                                    @endif
                                </td>
                                <td class="center-text">
                                    <a href="{{ url('/nber/exams/marks-verify/'.$e->id.'/show-applied-list') }}" class="btn btn-sm btn-primary">
                                        <b>Marks Verify</b>
                                    </a>
                                </td>
                                <td class="center-text">
                                    <a href="{{ url('/nber/examtimetables/'.$e->id) }}" class="btn btn-sm btn-primary">
                                        <b>Exam Timetable</b>
                                    </a>
                                </td>
                                <td class="center-text">
                                    <a href="{{ url('/nber/examquestionpapers/'.$e->id) }}" class="btn btn-sm btn-primary">
                                        <b>Question Paper Upload</b>
                                    </a>
                                </td>
                                <td class="center-text">
                                    <a href="{{ url('/nber/examresults/'.$e->id) }}" class="btn btn-sm btn-primary" target="_blank">
                                        <b>Result</b>
                                    </a>
                                </td>
                                <td class="center-text">
                                    <a href="{{ url('/nber/reevaluation/'.$e->id) }}" class="btn btn-sm btn-primary" target="_blank">
                                        <b>Re-Evaluation</b>
                                    </a>
                                </td>
                            </tr>
                            @php $sno++; @endphp
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </section>

@endsection