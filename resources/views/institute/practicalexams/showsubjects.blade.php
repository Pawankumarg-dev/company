@extends('layouts.app')

@section('content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text">
                    {{ $exam->name }} @if($exam->examtype_id == '2') Supplementary @endif - External Practical Examination<br>
                    Candidate Attendance Sheet
                </div>
            </div>
        </div>
    </section>

    <section class="container">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="table-responsive">
                    <table class="table table-condensed table-bordered table-hover" role="table">
                        <tr>
                            <th colspan="2" class="left-text">Institute</th>
                            <td colspan="3" class="left-text blue-text">{{ $approvedprogramme->institute->code }} - {{ $approvedprogramme->institute->name }}</td>
                        </tr>
                        <tr>
                            <th colspan="2" class="left-text">Course</th>
                            <td colspan="3" class="left-text blue-text">{{ $approvedprogramme->programme->course_name }} - {{ $approvedprogramme->programme->name }}</td>
                        </tr>
                        <tr>
                            <th colspan="2" class="left-text">Batch</th>
                            <td colspan="3" class="left-text blue-text">{{ $approvedprogramme->academicyear->year }}</td>
                        </tr>
                        <tr>
                            <th rowspan="2" class="center-text" width="5%">S.No.</th>
                            <th colspan="3" class="center-text">Subject</th>
                            <th rowspan="2" class="center-text" width="20%">Options</th>
                        </tr>
                        <tr>
                            <th class="center-text" width="5%">Year</th>
                            <th class="center-text" width="10%">Code</th>
                            <th class="center-text">Name</th>
                        </tr>
                        @php $sno = '1'; @endphp
                        @foreach($subjects as $s)
                            <tr>
                                <td class="center-text" >{{ $sno }}</td>
                                <td class="center-text" >{{ $s->syear }}</td>
                                <td class="center-text" >{{ $s->scode }}</td>
                                <td class="left-text" >{{ $s->sname }}</td>
                                <td class="center-text" >
                                    <a href="{{ url('/institute/practicalexam/'.$exam->id.'/downloadattendancesheet/'.$approvedprogramme->id.'/'.$s->id) }}" class="btn btn-primary btn-sm" target="_blank">
                                        <span class="glyphicon glyphicon-eye-open"></span>
                                        View Attendance Sheet
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