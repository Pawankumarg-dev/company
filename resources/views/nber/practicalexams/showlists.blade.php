@extends('layouts.app')

@section('content')
    @php set_time_limit(0); @endphp

    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text">
                    {{ $exam->name }} @if($exam->examtype_id == '2') Supplementary @endif - Practical Examination Applied Count<br>
                    Attendance Sheet
                </div>
            </div>
        </div>
    </section>

    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-condensed blue-text">
                        <tr>
                            <th colspan="8">
                                <div class="right-text">
                                    <a href="{{ url('/nber/exams/practical/'.$exam->id.'/showlistsexcel') }}" class="btn btn-success">
                                    <span class="glyphicon glyphicon-download"></span>
                                        Download as Excel
                                    </a>
                                </div>
                            </th>
                        </tr>

                        <tr class="grey-background">
                            <th class="center-text">S. No</th>
                            <th class="center-text">Institute Code</th>
                            <th class="center-text">Institute Name</th>
                            <th class="center-text">Course Code</th>
                            <th class="center-text">Course Name</th>
                            <th class="center-text">Batch</th>
                            <th class="center-text">Candidates Applied Count</th>
                            <th class="center-text">Attendance Link</th>
                        </tr>

                        @php $sno = 1; @endphp
                        @foreach($approvedprogrammes as $ap)
                            <tr>
                                <td class="center-text">{{ $sno }}</td>
                                <td class="center-text">{{ $ap->institute->code }}</td>
                                <td>{{ $ap->institute->name }}</td>
                                <td>{{ $ap->programme->common_code }}</td>
                                <td>{{ $ap->programme->common_name }}</td>
                                <td class="center-text">
                                    {{ $ap->academicyear->year }}
                                </td>
                                <td class="center-text">
                                    {{ $ap->count }}
                                </td>
                                <td class="center-text">
                                    <a href="{{ url('/nber/exams/practical/'.$exam->id.'/showsubjects/'.$ap->id) }}" class="btn btn-primary btn-xs" target="_blank">
                                        <span class="glyphicon glyphicon-eye-open"></span>
                                        View
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