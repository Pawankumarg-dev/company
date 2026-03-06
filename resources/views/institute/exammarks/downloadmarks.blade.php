@extends('layouts.app')

@section('content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text">
                    {{ $exam->name }} Examination - Institute Mark Entry
                </div>
            </div>
        </div>
    </section>

    {{--
    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered table-condensed">
                        <tr>
                            <td rowspan="2" class="center-text">S. No.</td>
                            <td rowspan="2" class="center-text">Enrolment Numbers</td>

                            @foreach($subjects->where('syear', '1') as $s)
                                @if($s->subjecttype->id == '1')
                                    <td colspan="2" class="center-text">{{ $s->scode }}</td>
                                @endif
                            @endforeach
                            <td rowspan="2" class="center-text">Total</td>
                        </tr>
                        <tr>
                            @foreach($subjects->where('syear', '1') as $s)
                                @if($s->subjecttype->id == '1')
                                    <td class="center-text">
                                        <u>Min</u><br> {{ $s->imin_marks }}
                                    </td>
                                    <td class="center-text">
                                        <u>Max</u><br> {{ $s->imax_marks }}
                                    </td>
                                @endif
                            @endforeach
                        </tr>

                        @php $sno='1' @endphp
                        @foreach($candidates as $c)
                            <tr>
                                <td class="center-text">{{ $sno }}</td>
                                <td class="center-text">{{ $c->enrolmentno }}</td>

                                @foreach($subjects->where('syear', '1') as $s)
                                    @if($s->subjecttype->id == '1')
                                        <td class="center-text" colspan="2">
                                            @php
                                            $app = $applications->where('candidate_id', $c->id)->where('subject_id', $s->id)->first();

                                            if(!is_null($app)) {
                                                $mark = \App\Mark::where('application_id', $app->id)->first();

                                                if(!is_null($mark)) {
                                                echo $mark->internal;
                                                }
                                            }
                                            @endphp

                                        </td>
                                    @endif
                                @endforeach
                            </tr>
                            @php $sno++; @endphp
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </section>
    --}}

    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-condensed">
                        <tr>
                            <th colspan="{{ (3 + $subjects->where('syear', '1')->count() * 2) }}"></th>
                        </tr>
                        <tr>
                            <th rowspan="2" class="center-text">S. No.</th>
                            <th rowspan="2" class="center-text">Enrolment Numbers</th>

                            @foreach($subjects->where('syear', '1') as $s)
                                @if($s->subjecttype->id == '1')
                                    <th colspan="2" class="center-text">{{ $s->scode }}</th>
                                @endif
                            @endforeach
                            <th rowspan="2" class="center-text">Total</th>
                        </tr>
                        <tr>
                            @foreach($subjects->where('syear', '1') as $s)
                                @if($s->subjecttype->id == '1')
                                    <td class="center-text">
                                        <u>Min</u><br> <span class="center-text"> {{ $s->imin_marks }} </span>
                                    </td>
                                    <td class="center-text">
                                        <u>Max</u><br> {{ $s->imax_marks }}
                                    </td>
                                @endif
                            @endforeach
                        </tr>

                        @php $sno='1'; @endphp
                        @foreach($candidates as $c)
                            @php $count='0'; @endphp
                            <tr>
                                <td class="center-text">{{ $sno }}</td>
                                <td class="center-text">{{ $c->enrolmentno }}</td>
                                @foreach($subjects->where('syear', '1') as $s)
                                    @if($s->subjecttype->id == '1')
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
                                                        <span @if($mark->internal < $s->imin_marks || $mark->internal == 'Abs') class="red-text" @else class="green-text" @endif> {{ $mark->internal }} </span>

                                                        @if($mark->internal != 'Abs')
                                                            @php $count += $mark->internal  @endphp
                                                        @endif
                                                    @endif
                                                @endif
                                            @else
                                                hai
                                            @endif
                                        </td>
                                    @endif
                                @endforeach
                                <td class="center-text">
                                    @if($count > '0')
                                        {{ $count }}
                                    @endif
                                </td>
                            </tr>
                            @php $sno++; @endphp
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </section>

    @for($i='2'; $i>'0'; $i--)
        @for($j='1'; $j<'3'; $j++)
            @if($applications->where('term', $i)->count()>0)
                @php $subcount='0'; @endphp
                @foreach($subjects as $s)
                    @if($s->syear==$i)
                        @if($s->subjecttype_id==$j)
                            @if($applications->where('subject_id', $s->id)->count()>0)
                                @php $subcount++; @endphp
                            @endif
                        @endif
                    @endif
                @endforeach

                @if($subcount>'0')
                    @foreach($candidates as $c)
                        @foreach($candidates as $c)
                            @php $applicationcount='0'; @endphp
                            @foreach($subjects as $s)
                                @if($s->syear==$i)
                                    @if($s->subjecttype_id==$j)
                                        @if($applications->where('subject_id', $s->id)->where('candidate_id', $c->id)->count()>'0')
                                            @php $applicationcount++; @endphp
                                        @endif
                                    @endif
                                @endif
                            @endforeach

                            @if($applicationcount>'0')
                                <section class="container-fluid">
                                    <div class="row">
                                        <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                                            <div class="table-responsive">
                                                <table class="table table-hover table-bordered table-condensed">


                                                    <tr></tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            @endif
                        @endforeach
                    @endforeach
                @endif
            @endif
        @endfor
    @endfor

@endsection