@extends('layouts.app')

@section('content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text">
                    {{ $exam->name }} Exam - Mark Entry Verification
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
                            <td colspan="13" class="center-text">
                                <a href="{{ url('/nber/exams/marks-entry/'.$exam->id.'/update-marks/'.$approvedprogramme->id.'/subject/'.$subject->id) }}" class="btn btn-primary btn-sm">Edit Marks</a>
                                <a href="{{ url('/nber/exams/marks-entry/'.$exam->id.'/show-applied-list') }}" class="btn btn-success btn-sm">Add New Marks</a>
                            </td>
                        </tr>

                        <tr class="grey-background">
                            <th class="center-text" colspan="3">Institute Code & Name</th>
                            <th class="left-text" colspan="11">
                                {{ $approvedprogramme->institute->code }} - {{ $approvedprogramme->institute->name }}
                            </th>
                        </tr>
                        <tr class="grey-background">
                            <th class="center-text" colspan="3">Course Code & Batch</th>
                            <th class="left-text" colspan="15">
                                {{ $approvedprogramme->programme->course_name }} - {{ $approvedprogramme->academicyear->year }} Batch
                            </th>
                        </tr>
                        <tr class="grey-background">
                            <th class="center-text" colspan="3">Subject Code & Name</th>
                            <th class="left-text" colspan="15">
                                {{ $subject->scode }} - {{ $subject->sname }}
                            </th>
                        </tr>
                        <tr class="grey-background">
                            <th class="center-text" rowspan="2">S. No</th>
                            <th class="center-text" rowspan="2">Enrolment</th>
                            <th class="center-text" rowspan="2">Name</th>
                            <th class="center-text" colspan="3">
                                Internal
                            </th>
                            <th class="center-text" rowspan="2"></th>
                            <th class="center-text" colspan="4">External</th>
                            <th class="center-text" rowspan="2">Total</th>
                            <th class="center-text" rowspan="2">Mark Updates</th>
                        </tr>
                        <tr class="grey-background">
                            <th class="center-text">Min. Mark</th>
                            <th class="center-text">Mark Secured</th>
                            <th class="center-text">Max. Mark</th>
                            <th class="center-text">Min. Mark</th>
                            <th class="center-text">Grace Mark</th>
                            <th class="center-text">Mark Secured</th>
                            <th class="center-text">Max. Mark</th>
                        </tr>

                        @php $sno = 1; $count = 0; @endphp
                        @foreach($applications as $app)
                            <input type="hidden" name="application_id[]" value="{{ $app->id }}">

                            @php
                                $m = $marks->where('application_id', $app->id)->first();
                                $total = 0; $fail_count = 0;
                                if(!is_null($m)) {
                                $internal = $m->internal;
                                $external = $m->external;
                                $grace = $m->grace;
                                }
                            @endphp

                            <tr>
                                <td class="center-text">{{ $sno }}</td>
                                <td class="center-text">{{ $app->candidate->enrolmentno }}</td>
                                <td class="left-text">{{ $app->candidate->name }}</td>
                                <td class="center-text">
                                    <input type="hidden" id="imin_mark_{{ $count }}" value="{{ $app->subject->imin_marks }}" />
                                    {{ $app->subject->imin_marks }}
                                </td>
                                <td class="center-text">
                                    <input type="text" class="center-text" size="1" id="int_mark_{{ $count }}" name="int_mark[]"
                                           @if(is_null($m))
                                           @php $fail_count++; @endphp
                                           @else
                                               @if($internal == '')
                                                    @php $fail_count++; @endphp
                                               @else
                                                   @if($internal == 'Abs')
                                                       style="background-color: yellow; color: red; font-weight: bold"
                                                       @php $fail_count++; @endphp
                                                   @else
                                                       @if($internal < $app->subject->imin_marks)
                                                           style="background-color: red; color: white; font-weight: bold"
                                                           @php $fail_count++; @endphp
                                                       @else
                                                           style="background-color:green; color: white; font-weight: bold"
                                                        @endif
                                                    @endif
                                                   value="{{ $internal }}"
                                               @endif
                                               readonly
                                           @endif
                                    />
                                </td>
                                <td class="center-text">
                                    <input type="hidden" id="imax_mark_{{ $count }}" value="{{ $app->subject->imax_marks }}" />
                                    {{ $app->subject->imax_marks }}
                                </td>
                                <td class="center-text">

                                </td>
                                <td class="center-text">
                                    <input type="hidden" id="emin_mark_{{ $count }}" value="{{ $app->subject->emin_marks }}" />
                                    {{ $app->subject->emin_marks }}
                                </td>
                                <td class="center-text">
                                    <input type="text" class="center-text" size="1" id="grace_mark_{{ $count }}" name="grace_mark[]" onblur="CheckGraceMarkValue({{ $count }})"
                                           @if($m == '' || is_null($m))
                                           value="0"
                                           style="background-color: darkblue; color: white; font-weight: bold"
                                           @else
                                           @if($external != '')
                                           @if($external == 'Abs')
                                           @endif
                                           @else
                                           readonly
                                           @endif
                                           @if($grace == 0)
                                           style="background-color: darkblue; color: white; font-weight: bold"
                                           @else
                                           style="background-color: deeppink; color: white; font-weight: bold"
                                           @endif
                                           value="{{ $grace }}"
                                            @endif
                                           readOnly

                                    />
                                </td>
                                <td class="center-text">
                                    <input type="text" class="center-text" size="1" id="ext_mark_{{ $count }}" name="ext_mark[]"
                                           @if(is_null($m))
                                           @php $fail_count++; @endphp
                                           @else
                                               @if($external == '')
                                                    @php $fail_count++; @endphp
                                               @else
                                                   @if($external == 'Abs')
                                                   style="background-color: yellow; color: red; font-weight: bold"
                                                   @php $fail_count++; @endphp
                                                   @else
                                                   @if($external < $app->subject->emin_marks)
                                                   style="background-color: red; color: white; font-weight: bold"
                                                   @php $fail_count++; @endphp
                                                   @else
                                                   style="background-color:green; color: white; font-weight: bold"
                                                   @endif
                                                   @endif
                                                    value="{{ $external }}"
                                               @endif
                                               readOnly
                                           @endif
                                    />
                                </td>
                                <td class="center-text">
                                    <input type="hidden" id="emax_mark_{{ $count }}" value="{{ $app->subject->emax_marks }}" />
                                    {{ $app->subject->emax_marks }}
                                </td>
                                <td class="center-text">
                                    @if(is_null($m))
                                        @php $total = 0; @endphp
                                    @else
                                        @if($internal != '' || $internal != 'Abs')
                                            @php $total += (int) $internal; @endphp
                                        @endif

                                        @if($external != '' || $external != 'Abs')
                                            @php $total += (int) $external + (int) $grace; @endphp
                                        @endif
                                    @endif

                                    <input type="text" size="1" readonly value="{{ $total }}"
                                           class="bold-text center-text"
                                           @if($fail_count == 0)
                                           style="background-color: darkgreen; color: white; font-weight: bold"
                                           @else
                                           style="background-color: red; color: white; font-weight: bold"
                                            @endif
                                    />
                                </td>
                                <td class="center-text"></td>
                            </tr>
                            @php $sno++; $count++; @endphp
                        @endforeach


                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection