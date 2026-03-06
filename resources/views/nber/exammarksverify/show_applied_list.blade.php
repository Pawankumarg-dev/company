@extends('layouts.app')

@section('content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text">
                    {{ $exam->name }} Exam - Mark Verify
                </div>
            </div>
        </div>
    </section>

    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-condensed blue-text">
                        <tr class="grey-background">
                            <th class="center-text">S. No</th>
                            <th class="center-text">Institute Code</th>
                            <th class="center-text">Course</th>
                            <th class="center-text">Batch</th>
                            <th class="center-text">Verification Links</th>
                        </tr>

                        @php $sno = 1; @endphp
                        @foreach($approvedprogrammes as $ap)
                            <tr>
                                <td>{{ $sno }}</td>
                                <td>{{ $ap->institute->code }}</td>
                                <td>{{ $ap->programme->course_name }}</td>
                                <td class="center-text">
                                    {{ $ap->academicyear->year }}
                                </td>
                                <td class="center-text">
                                     <a href="{{ url('/nber/exams/marks-verify/internal-theory/'.$exam->id.'/'.$ap->id) }}" class="btn btn-xs" target="_blank" style="background-color: darkblue; color: white; font-weight: bold">
                                         <img src="{{asset('images/marks_verify.png')}}" width="40px" height="40px" class="glyphicon glyphicon-picture"/>
                                       Internal Theory
                                    </a>
                                    <a href="{{ url('/nber/exams/marks-verify/external-theory/'.$exam->id.'/'.$ap->id) }}" class="btn btn-xs" target="_blank" style="background-color: darkgreen; color: white; font-weight: bold">
                                        <img src="{{asset('images/marks_verify.png')}}" width="40px" height="40px" class="glyphicon glyphicon-picture"/>
                                        External Theory
                                    </a>

                                    <a href="{{ url('/nber/exams/marks-verify/internal-practical/'.$exam->id.'/'.$ap->id) }}" class="btn btn-xs" target="_blank" style="background-color: darkmagenta; color: white; font-weight: bold">
                                        <img src="{{asset('images/marks_verify.png')}}" width="40px" height="40px" class="glyphicon glyphicon-picture"/>
                                        Internal Practical
                                    </a>
                                    <a href="{{ url('/nber/exams/marks-verify/external-practical/'.$exam->id.'/'.$ap->id) }}" class="btn btn-xs" target="_blank" style="background-color: deeppink; color: white; font-weight: bold">
                                        <img src="{{asset('images/marks_verify.png')}}" width="40px" height="40px" class="glyphicon glyphicon-picture"/>
                                        External Practical
                                    </a>

                                    <a href="{{ url('/nber/exams/marks-verify/'.$exam->id.'/show-marks/'.$ap->id) }}" class="btn btn-xs" target="_blank" style="background-color: red; color: white; font-weight: bold">
                                        <img src="{{asset('images/marks_verify.png')}}" width="40px" height="40px" class="glyphicon glyphicon-picture"/>
                                        Full Marks
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