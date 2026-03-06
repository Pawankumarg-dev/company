@extends('layouts.app')

@section('content')
    <style>
        @media print {
            #printPageButton {
                display: none;
            }
            thead {
                display:table-header-group;
            }

        }

        @page {
            size: A4 landscape;
            margin: 20px;
        }
    </style>


    <input type="hidden" name="exam_id" value="{{ $exam->id }}" />

    @php $count = 0; $markcount = 0; @endphp
    @for($i = '2', $j = '0'; $i > '0'; $i--, $j++)
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
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered table-condensed" width="100%">
                                    <thead>
                                    <tr>
                                        <th colspan="{{ (3 + $subjectcount) }}" class="center-text blue-text">
                                            <div class="center-text">
                                             {{--   <span class="h6-text">National Institute for Empowerment of Persons with Multiple Disabilities (Divyangjan)</span><br>
                                                <span class="h8-text">(Dept. of Empowerment of Persons with Disabilities (Divyangjan), MS&E, Govt. of India)</span><br> --}}
                                                <span class="h6-text">National Board of Examination in Rehabilitation (NBER)</span><br>
                                                {{ $exam->name }} Examination
                                            </div>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="{{ (3 + $subjectcount) }}" class="center-text blue-text">
                                            {{ $approvedprogramme->institute->code }} - {{ $approvedprogramme->institute->name }}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="{{ (3 + $subjectcount) }}" class="center-text blue-text">
                                            {{ $i }}<sup>@if($i == '2') nd @else st @endif</sup> &nbsp;year - {{ $title }} - Online Mark Entry
                                        </th>
                                    </tr>
                                    <tr>
                                        <th rowspan="2" class="center-text blue-text" width="5%">S. No.</th>
                                        <th rowspan="2" class="center-text blue-text" width="7%">Enrolment<br>No</th>
                                        <th rowspan="2" class="center-text blue-text" width="13%">Name</th>
                                        @foreach($subjects as $s)
                                            @if($s->syear == $i)
                                                <th class="center-text blue-text">{{ $s->scode }}</th>
                                            @endif
                                        @endforeach
                                    </tr>
                                    <tr>
                                        @foreach($subjects as $s)
                                            @if($s->syear == $i)
                                                <th class="center-text">
                                                    Min: <span class="center-text"> {{ $s->imin_marks }} </span><br>
                                                    Max: <span class="center-text"> {{ $s->imax_marks }} </span>
                                                </th>
                                            @endif
                                        @endforeach
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $sno = 1; $entrycount = 0; @endphp
                                    @foreach($candidates as $c)
                                        @php $candidatecount = '0'; @endphp
                                        @foreach($applications->where('candidate_id', $c->id) as $app)
                                            @if($app->subject->syear == $i)
                                                @php $candidatecount++ @endphp
                                            @endif
                                        @endforeach

                                        @if($candidatecount > '0')
                                            <tr>
                                                <td class="center-text blue-text">{{ $sno }}</td>
                                                <td class="center-text blue-text">{{ $c->enrolmentno }}</td>
                                                <td class="center-text blue-text">{{ $c->name }}</td>
                                                @foreach($subjects as $s)
                                                    @if($s->syear == $i)
                                                        <td class="center-text">
                                                            @php
                                                                $application = $applications->where('candidate_id', $c->id)->where('subject_id', $s->id)->first();
                                                                $mark = $marks->where('application_id', $application->id)->first();
                                                            @endphp
                                                            @if(!is_null($application))
                                                                @if(is_null($mark))
                                                                    <span class="red-text">Not Entered</span>
                                                                @else
                                                                    <span @if($mark->internal == 'Abs' || (int) $mark->internal < (int) $application->subject->imin_marks) class="red-text bold-text" @else class="green-text bold-text" @endif>
                                                                            {{ $mark->internal }}
                                                                    </span>
                                                                @endif

                                                                @php $count++; @endphp
                                                            @else
                                                                <span class="red-text">&#9587;</span>
                                                            @endif
                                                        </td>
                                                    @endif
                                                @endforeach
                                            </tr>
                                            @php $sno++; @endphp
                                        @endif
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td>h</td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endfor
@endsection

<script>
</script>