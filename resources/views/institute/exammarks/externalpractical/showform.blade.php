@extends('layouts.app')

@section('content')
    <style>
        @media print {
            #printPageButton {
                display: none;
            }
        }
    </style>

    <form class="form-horizontal" role="form" method="POST"
          action="{{url('/nber/exams/marks-entry/updateform/')}}" autocomplete="off" accept-charset="UTF-8"
          enctype="multipart/form-data">
        {{ csrf_field() }}

        <input type="hidden" name="exam_id" value="{{ $exam->id }}" />

        @php $count = 0; @endphp
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
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered table-condensed">
                                        <thead>
                                        <tr>
                                            <th colspan="{{ (3 + $subjectcount) }}" class="center-text blue-text">
                                                <div class="center-text">
                                                   {{--<span class="h6-text">National Institute for Empowerment of Persons with Multiple Disabilities (Divyangjan)</span><br>
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
                                                        Min: <span class="center-text"> {{ $s->emin_marks }} </span><br>
                                                        Max: <span class="center-text"> {{ $s->emax_marks }} </span>
                                                    </th>
                                                @endif
                                            @endforeach
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php $sno = 1; @endphp
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

                                                                    if(!is_null($application)) {
                                                                       $mark = $marks->where('application_id', $application->id)->first();

                                                                        $internal = null;
                                                                        $external = null;
                                                                        if(!is_null($mark)) {
                                                                            $internal = $mark->internal;
                                                                            $external = $mark->external;
                                                                        }
                                                                    }
                                                                @endphp
                                                                @if(!is_null($application))

                                                                    <input type="hidden" id="application_id" name="application_id[]" value="{{ $application->id }}" />
                                                                    <input type="hidden" id="min_mark_{{ $count }}" value="{{ $application->subject->emin_marks }}" />
                                                                    <input type="hidden" id="max_mark_{{ $count }}" value="{{ $application->subject->emax_marks }}" />

                                                                    <input type="text" size="1" id="mark_{{ $count }}" name="mark[]" class="center-text" onblur="CheckMarkValue({{ $count }})"
                                                                          @if(is_null($mark))

                                                                             disabled

                                                                          @else

                                                                              @if($internal == '' || is_null($internal) || $internal < $application->subject->imin_marks)

                                                                                  disabled

                                                                              @else

                                                                                   @if(!is_null($external))
                                                                                       @if($external == "Abs")
                                                                                            style="background-color: yellow; color: black; font-weight: bold"
                                                                                       @else
                                                                                       @if($external < $application->subject->imin_marks)
                                                                                            style="background-color: red; color: white; font-weight: bold"

                                                                                       @else
                                                                                           style="background-color:green; color: white; font-weight: bold"
                                                                                           @endif
                                                                                       @endif
                                                                                   value="{{ $external }}"
                                                                                   @endif

                                                                              @endif

                                                                          @endif
                                                                    />

                                                                    @if(is_null($mark))
                                                                    @else
                                                                        @if($external == 'Abs')
                                                                            <button type="button" id="btn_clear_absent_{{ $count }}" class="btn btn-sm btn-primary" onclick="ClearAbsent({{ $count }})" style="display: inline">Clear<br>Absent</button>
                                                                            <button type="button" id="btn_mark_absent_{{ $count }}" class="btn btn-sm btn-danger" onclick="MarkAbsent({{ $count }})" style="display: none">Mark<br>Absent</button>
                                                                        @else
                                                                            <button type="button" id="btn_clear_absent_{{ $count }}" class="btn btn-sm btn-primary" onclick="ClearAbsent({{ $count }})" style="display: none">Clear<br>Absent</button>
                                                                            <button type="button" id="btn_mark_absent_{{ $count }}" class="btn btn-sm btn-danger" onclick="MarkAbsent({{ $count }})" style="display: inline">Mark<br>Absent</button>
                                                                        @endif
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
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @endif
        @endfor

    </form>
@endsection

<script>
    function MarkAbsent(count) {
        var mark = document.getElementById('mark_'+count);
        var btn_clear_absent = document.getElementById('btn_clear_absent_'+count);
        var btn_mark_absent = document.getElementById('btn_mark_absent_'+count);

        mark.value = 'Abs';
        CheckMarkValue(count);

        btn_mark_absent.style.display = 'none';
        btn_clear_absent.style.display = 'inline';
    }

    function ClearAbsent(count) {
        var mark = document.getElementById('mark_'+count);
        var btn_clear_absent = document.getElementById('btn_clear_absent_'+count);
        var btn_mark_absent = document.getElementById('btn_mark_absent_'+count);

        mark.removeAttribute('readOnly');
        mark.value = '';
        CheckMarkValue(count);

        btn_mark_absent.style.display = 'inline';
        btn_clear_absent.style.display = 'none';
        mark.focus();
    }

    function CheckMarkValue(count) {
        var mark = document.getElementById('mark_'+count);
        var min_mark = document.getElementById('min_mark_'+count);
        var max_mark = document.getElementById('max_mark_'+count);

        if(mark.value == 'Abs') {
            mark.style.backgroundColor = 'yellow';
            mark.style.color = 'red';
            mark.style.fontWeight = 'bold';
            mark.setAttribute('readOnly', true);
        }
        else if(isNaN(mark.value)) {
            alert("Please enter a Valid Mark");
            mark.focus();
            mark.value = '';
        }
        else if(Number.isInteger(+mark.value) == false) {
            alert("Please enter a Valid Mark");
            mark.focus();
            mark.value = '';
        }
        else {
            if (mark.value == '') {
                mark.style.backgroundColor = 'red';
                mark.style.color = 'white';
                mark.style.fontWeight = 'bold';
                mark.removeAttribute('readOnly');
            }
            else {
                if (Number(mark.value) < Number(min_mark.value)) {
                    mark.style.backgroundColor = 'red';
                    mark.style.color = 'white';
                    mark.style.fontWeight = 'bold';
                }
                if (Number(mark.value) >= Number(min_mark.value)) {
                    mark.style.backgroundColor = 'green';
                    mark.style.color = 'white';
                    mark.style.fontWeight = 'bold';
                }
                if (Number(mark.value > Number(max_mark.value))) {
                    alert("The mark that you have entered is more than the maximum mark alloted to the subject.");
                    mark.focus();
                    mark.value = '';
                }
            }
        }
    }


</script>