@extends('layouts.app')

@section('content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text">
                    {{ $exam->name }} Examination - Mark Entry
                </div>
            </div>
        </div>
    </section>

    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="table-responsive">
                    <table class="table table-stripped table-bordered table-condensed">
                        <tr>
                            <td colspan="2">
                                <img src="{{asset('/files/enrolment/photos')}}/{{$candidate->photo}}"  style="width: 100px;" class="img" />
                            </td>
                            <td colspan="9">
                                <p>Enrolment: {{ $candidate->enrolmentno }}</p>
                                <p>Name: {{ $candidate->name }}</p>
                                <p>DOB: {{ $candidate->dob->format('m-d-Y') }}</p>
                                <p>Father's Name: {{ $candidate->fathername }}</p>
                                <p>Course: {{ $candidate->approvedprogramme->programme->course_name }}</p>
                            </td>
                        </tr>

                        <tr class="grey-background">
                            <th class="center-text" rowspan="2">
                                S.<br>No.
                            </th>
                            <th class="center-text" colspan="4">
                                Subject
                            </th>
                            <th class="center-text" colspan="3">
                                Internal
                            </th>
                            <th class="center-text" colspan="3">
                                External
                            </th>
                        </tr>

                        <tr class="grey-background">
                            <th class="center-text">Year</th>
                            <th class="center-text">Type</th>
                            <th class="center-text">Code</th>
                            <th class="center-text">Name</th>
                            <th class="center-text">Min.<br>Marks</th>
                            <th class="center-text">Marks<br>Secured</th>
                            <th class="center-text">Max.<br>Marks</th>
                            <th class="center-text">Min.<br>Marks</th>
                            <th class="center-text">Marks<br>Secured</th>
                            <th class="center-text">Max.<br>Marks</th>
                        </tr>

                        @php $sno='1'; @endphp

                        @foreach($applications as $a)
                            @php
                                $m = $marks->where('application_id', $a->id)->first();
                                if(!is_null($m)) {
                                $internal = $m->internal;
                                $external = $m->external;
                                }
                            @endphp

                            <tr>
                                <td class="center-text blue-text">{{ $sno }}</td>
                                <td class="center-text blue-text">{{ $a->subject->syear }}</td>
                                <td class="center-text blue-text">{{ $a->subject->subjecttype->type }}</td>
                                <td class="center-text blue-text">{{ $a->subject->scode }}</td>
                                <td class="left-text blue-text">{{ $a->subject->sname }}</td>
                                <td class="center-text blue-text">{{ $a->subject->imin_marks }}</td>
                                <td class="center-text bold-text">
                                    @if(!is_null($m))
                                        <span @if($internal == 'Abs' || $internal < $a->subject->imin_marks) class="red-text" @else class="green-text" @endif >
                                            {{ $internal }}
                                        </span>
                                    @endif
                                </td>
                                <td class="center-text blue-text">{{ $a->subject->imax_marks }}</td>
                                @if($a->subject->subjecttype_id == '1')
                                    <td colspan="3" class="grey-background"></td>
                                @else
                                    <td class="center-text blue-text">{{ $a->subject->emin_marks }}</td>
                                    <td class="center-text bold-text">
                                        @if(!is_null($m))
                                            <span @if($external == 'Abs' || $external < $a->subject->emin_marks) class="red-text" @else class="green-text" @endif >
                                                {{ $external }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="center-text blue-text">{{ $a->subject->emax_marks }}</td>
                                @endif
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection