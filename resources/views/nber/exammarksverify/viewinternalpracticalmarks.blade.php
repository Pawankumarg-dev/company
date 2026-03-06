@extends('layouts.app')

@section('content')
    <style>
        @media print {
            #printPageButton {
                display: none;
            }
        }
    </style>
    <div  id="printPageButton">
        <section class="container-fluid">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="col-sm-12">
                        <button class="btn btn-primary btn-sm pull-right" onclick="window.print();return false;">
                            <span class="glyphicon glyphicon-print"></span> Print Internal Practical Marks
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @for($i = '2'; $i > '0'; $i--)
        @php $applicationcount = '0'; @endphp
        @foreach($applications as $app)
            @if($app->subject->syear == $i)
                @php $applicationcount++; @endphp
            @endif
        @endforeach

        @if($applicationcount > '0')
            @php $subjectcount = '0'; @endphp
            @foreach($subjects as $s)
                @if($s->syear == $i)
                    @php $subjectcount++; @endphp
                @endif
            @endforeach
            <br>
            <section class="container-fluid">
                <div class="row">
                    <div class="page-break">
                        <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                            <table class="table table-hover table-bordered table-condensed">
                                <thead>
                                <tr>
                                    <th colspan="{{ (3 + $subjectcount * 2) }}" class="center-text blue-text">
                                        <div class="center-text">
                                            <span class="h6-text">National Institute for Empowerment of Persons with Multiple Disabilities (Divyangjan)</span><br>
                                            <span class="h8-text">(Dept. of Empowerment of Persons with Disabilities (Divyangjan), MS&E, Govt. of India)</span><br>
                                            <span class="h6-text">National Board of Examination in Rehabilitation (NBER)</span><br>
                                            {{ $exam->name }} Examination
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="{{ (3 + $subjectcount * 2) }}" class="center-text blue-text">
                                        {{ $approvedprogramme->institute->code }} - {{ $approvedprogramme->institute->name }}
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="{{ (3 + $subjectcount * 2) }}" class="center-text blue-text">
                                        {{ $i }}<sup>@if($i == '2') nd @else st @endif</sup> &nbsp;year - {{ $title }} - Online Mark Entry
                                    </th>
                                </tr>
                                <tr>
                                    <th rowspan="2" class="center-text blue-text">S. No.</th>
                                    <th rowspan="2" class="center-text blue-text">Enrolment<br>Numbers</th>


                                    @foreach($subjects as $s)
                                        @if($s->syear == $i)
                                            <th colspan="2" class="center-text blue-text">{{ $s->scode }}</th>
                                        @endif
                                    @endforeach

                                    <th rowspan="2" class="center-text blue-text">Total</th>
                                </tr>
                                <tr>
                                    @foreach($subjects as $s)
                                        @if($s->syear == $i)
                                            <th class="center-text">
                                                <u>Min</u><br> <span class="center-text"> {{ $s->imin_marks }} </span>
                                            </th>
                                            <th class="center-text">
                                                <u>Max</u><br> {{ $s->imax_marks }}
                                            </th>
                                        @endif
                                    @endforeach
                                </tr>
                                </thead>
                                <tbody>
                                @php $sno = '1'; @endphp
                                @foreach($candidates as $c)
                                    @php $candidatecount = '0'; @endphp
                                    @foreach($applications->where('candidate_id', $c->id) as $app)
                                        @if($app->subject->syear == $i)
                                            @php $candidatecount++ @endphp
                                        @endif
                                    @endforeach

                                    @if($candidatecount > '0')
                                        @php $count = '0'; $failcount = '0'; @endphp
                                        <tr>
                                            <td class="center-text blue-text">{{ $sno }}</td>
                                            <td class="center-text blue-text">{{ $c->enrolmentno }}</td>
                                            @foreach($subjects as $s)
                                                @if($s->syear == $i)
                                                    <td colspan="2" class="center-text">
                                                        @php
                                                            $app = $applications->where('candidate_id', $c->id)->where('subject_id', $s->id)->first();
                                                        @endphp
                                                        @if(!is_null($app))
                                                            @php
                                                                $mark = $marks->where('application_id', $app->id)->first();
                                                            @endphp

                                                            @if(!is_null($mark))
                                                                @if(!is_null($mark->internal))
                                                                    <span @if($mark->internal < $s->imin_marks || $mark->internal == 'Abs') class="red-text" @php $failcount++ @endphp @else class="green-text" @endif>
                                                                        {{ $mark->internal }}
                                                                    </span>

                                                                    @if($mark->internal != 'Abs')
                                                                        @php $count += $mark->internal  @endphp
                                                                    @endif
                                                                @endif
                                                            @else
                                                                <span class="red-text">
                                                                No Marks Entered
                                                                </span>
                                                            @endif
                                                        @else
                                                            Not Applied
                                                        @endif
                                                    </td>
                                                @endif
                                            @endforeach
                                            <td class="center-text bold-text">
                                                @if($count > '0')
                                                    <span @if($failcount > '0') class="red-text" @else class="green-text" @endif>
                                                    {{ $count }}
                                                    </span>
                                                @else
                                                    <span class="red-text">
                                                        ---
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                        @php $sno++; @endphp
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endfor
@endsection