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

    <form class="form-horizontal" role="form" method="POST"
          action="{{url('/institute/exammarksentry/updateform/')}}" autocomplete="off" accept-charset="UTF-8"
          enctype="multipart/form-data" onsubmit="return ValidateForm()">
        {{ csrf_field() }}

        <input type="hidden" name="exam_id" value="{{ $exam->id }}">
        <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">

        <section class="container-fluid">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="table-responsive">
                        <table class="table table-stripped table-bordered table-condensed">
                            <tr>
                                <td colspan="2">
                                    <img src="{{asset('/files/enrolment/photos')}}/{{$candidate->photo}}"  style="width: 100px;" class="img" />
                                </td>
                                <td colspan="13">
                                    <p>Enrolment: {{ $candidate->enrolmentno }}</p>
                                    <p>Name: {{ $candidate->name }}</p>
                                    <p>DOB: {{ $candidate->dob->format('m-d-Y') }}</p>
                                    <p>Father's Name: {{ $candidate->fathername }}</p>
                                    <p>Course: {{ $candidate->approvedprogramme->programme->course_name }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td rowspan="5" colspan="3"></td>
                                <td class="left-text" colspan="1">
                                    <br>
                                </td>
                                <td class="left-text" colspan="11">Note: </td>
                            </tr>
                            <tr>
                                <td class="center-text">
                                    <input class="center-text" type="text"  size="1"  value="Abs"
                                           readonly style="background-color: yellow; color: black; font-weight: bold"/>
                                </td>
                                <td class="left-text" colspan="11">
                                    represents <b>Absent</b>
                                </td>
                            </tr>
                            <tr>
                                <td class="center-text">
                                    <input class="center-text" type="text"  size="1"  value="P"
                                           readonly style="background-color: green; color: white; font-weight: bold"/>
                                </td>
                                <td class="left-text" colspan="11">
                                    represents <b>Pass Mark </b>
                                </td>
                            </tr>
                            <tr>
                                <td class="center-text">
                                    <input class="center-text" type="text"  size="1"  value="F"
                                           readonly style="background-color: red; color: white; font-weight: bold"/>
                                </td>
                                <td class="left-text" colspan="11">
                                    represents <b>Fail Mark</b>
                                </td>
                            </tr>
                            <tr>
                                <td class="center-text">
                                    <input class="center-text" type="text"  size="1"
                                           readonly style="background-color: red; color: white; font-weight: bold"/>
                                </td>
                                <td class="left-text" colspan="11">
                                    represents <b>without Mark</b>
                                </td>
                            </tr>

                            <tr class="grey-background">
                                <th class="center-text" rowspan="2">
                                    S.<br>No.
                                </th>
                                <th class="center-text" colspan="4">
                                    Subject
                                </th>
                                <th class="center-text" colspan="5">
                                    Internal
                                </th>
                                <th class="center-text" colspan="5">
                                    External
                                </th>
                            </tr>

                            <tr class="grey-background">
                                <th class="center-text">Year</th>
                                <th class="center-text">Type</th>
                                <th class="center-text">Code</th>
                                <th class="center-text">Name</th>
                                <th class="center-text">Present</th>
                                <th class="center-text">Absent</th>
                                <th class="center-text">Min.<br>Marks</th>
                                <th class="center-text">Marks<br>Secured</th>
                                <th class="center-text">Max.<br>Marks</th>
                                <th class="center-text">Present</th>
                                <th class="center-text">Absent</th>
                                <th class="center-text">Min.<br>Marks</th>
                                <th class="center-text">Marks<br>Secured</th>
                                <th class="center-text">Max.<br>Marks</th>
                            </tr>

                            @php $sno='1'; $sno1='0'; $sno2='0' @endphp

                            @foreach($applications as $a)
                                <input type="hidden" name="application_id[]" value="{{ $a->id }}">

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
                                    <td class="center-text">
                                        <input type="radio" name="int_attendance[{{ $sno1 }}]" id="int_attendance1_{{ $sno1 }}" onclick="EnableIntMark({{ $sno1 }})"
                                               @if(!is_null($m))
                                               @if($internal != "Abs") checked @endif
                                               @endif

                                               value="Present"
                                        />
                                    </td>
                                    <td class="center-text">
                                        <input type="radio" name="int_attendance[{{ $sno1 }}]" id="int_attendance2_{{ $sno1 }}" onclick="DisableIntMark({{ $sno1 }})"
                                               @if(!is_null($m))
                                               @if($internal == "Abs") checked @endif
                                               @endif

                                               value="Absent"
                                        />
                                    </td>
                                    <td class="center-text blue-text bold-text">
                                        <input type="hidden" id="imin_mark_{{ $sno1 }}" value="{{ $a->subject->imin_marks }}" />
                                        {{ $a->subject->imin_marks }}
                                    </td>
                                    <td class="center-text" style="background-color: yellow;">
                                        <input type="text" size="1" id="int_mark_{{ $sno1 }}" name="int_mark[]" class="center-text" onblur="ChangeIntMarkColor({{ $sno1 }})"
                                               @if(is_null($m))
                                               disabled
                                               @else
                                               value="{{ $internal }}"
                                               @if($internal == "Abs")
                                               style="background-color: yellow; color: black; font-weight: bold"
                                               readOnly
                                               @else
                                               @if($internal < $a->subject->imin_marks)
                                               style="background-color: red; color: white; font-weight: bold"
                                               @else
                                               style="background-color:green; color: white; font-weight: bold"
                                                @endif
                                                @endif
                                                @endif
                                        />
                                    </td>
                                    <td class="center-text blue-text bold-text">
                                        <input type="hidden" id="imax_mark_{{ $sno1 }}" value="{{ $a->subject->imax_marks }}" />
                                        {{ $a->subject->imax_marks }}
                                    </td>

                                    @if($a->subject->subjecttype_id=="1") {{--Theory Subject--}}
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    @else {{--Practical Subject--}}
                                    <td class="center-text">
                                        <input type="radio" name="ext_attendance[{{ $sno2 }}]" id="ext_attendance1_{{ $sno2 }}" onclick="EnableExtMark({{ $sno2 }})"
                                               @if(!is_null($m))
                                               @if($external != "Abs") checked @endif
                                               @endif

                                               value="Present"
                                        />
                                    </td>
                                    <td class="center-text">
                                        <input type="radio" name="ext_attendance[{{ $sno2 }}]" id="ext_attendance2_{{ $sno2 }}" onclick="DisableExtMark({{ $sno2 }})"
                                               @if(!is_null($m))
                                               @if($external == "Abs") checked @endif
                                               @endif

                                               value="Absent"
                                        />
                                    </td>
                                    <td class="center-text blue-text bold-text">
                                        <input type="hidden" id="emin_mark_{{ $sno2 }}" value="{{ $a->subject->emin_marks }}" />
                                        {{ $a->subject->emin_marks }}
                                    </td>
                                    <td class="center-text" style="background-color: yellow;">
                                        <input type="text" size="1" id="ext_mark_{{ $sno2 }}" name="ext_mark[]" class="center-text" onblur="ChangeExtMarkColor({{ $sno2 }})"
                                               @if(is_null($m))
                                               disabled
                                               @else
                                               value="{{ $external }}"
                                               @if($external == "Abs")
                                               style="background-color: yellow; color: black; font-weight: bold"
                                               readOnly
                                               @else
                                               @if($external < $a->subject->emin_marks)
                                               style="background-color: red; color: white; font-weight: bold"
                                               @else
                                               style="background-color:green; color: white; font-weight: bold"
                                                @endif
                                                @endif
                                                @endif
                                        />
                                    </td>
                                    <td class="center-text blue-text bold-text">
                                        <input type="hidden" id="emax_mark_{{ $sno2 }}" value="{{ $a->subject->emax_marks }}" />
                                        {{ $a->subject->emax_marks }}
                                    </td>
                                    @php $sno2++; @endphp
                                    @endif
                                </tr>

                                @php $sno++; $sno1++; @endphp
                            @endforeach

                            <tr>
                                <td class="center-text" colspan="15">
                                    <a href="{{ url('/institute/exammarksentry/'.$exam->id.'/showlist/'.$candidate->approvedprogramme->id) }}" class="btn btn-info">Go Back</a>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="reset" class="btn btn-danger">Reset</button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </section>

    </form>
    <script>

        function EnableIntMark(sno) {
            var int_mark = document.getElementById('int_mark_'+sno);
            int_mark.style.backgroundColor = "yellow";
            int_mark.style.color = "black";
            int_mark.value = "";
            int_mark.disabled = false;
            int_mark.removeAttribute('readOnly');
            ChangeIntMarkColor(sno);
        }

        function DisableIntMark(sno) {
            var int_mark = document.getElementById('int_mark_'+sno);
            var int_attendance = document.getElementById('int_attendance2_'+sno);

            if(confirm('Are you sure that you are the candidate Absent for this student...?')) {
                int_mark.value = "Abs";
                int_mark.readOnly = true;
                int_mark.disabled = false;
                ChangeIntMarkColor(sno);
            }
            else {
                int_attendance.checked = false;
                int_mark.value = "";
                int_mark.readOnly = true;
            }
        }

        function EnableExtMark(sno) {
            var ext_mark = document.getElementById('ext_mark_'+sno);
            ext_mark.style.backgroundColor = "yellow";
            ext_mark.style.color = "black";
            ext_mark.value = "";
            ext_mark.disabled = false;
            ext_mark.removeAttribute('readOnly');
            ChangeExtMarkColor(sno);
        }

        function DisableExtMark(sno) {
            var ext_mark = document.getElementById('ext_mark_'+sno);
            var ext_attendance = document.getElementById('ext_attendance2_'+sno);

            if(confirm('Are you sure that you are marking Absent for this subject...?')) {
                ext_mark.value = "Abs";
                ext_mark.readOnly = true;
                ext_mark.disabled = false;
                ChangeExtMarkColor(sno);
            }
            else {
                ext_attendance.checked = false;
                ext_mark.value = "";
                ext_mark.readOnly = true;
            }
        }

        function ChangeIntMarkColor(sno) {
            var int_mark = document.getElementById('int_mark_' + sno);
            var imin_mark = document.getElementById('imin_mark_' + sno);
            var imax_mark = document.getElementById('imax_mark_' + sno);
            var int_attendance1 = document.getElementById('int_attendance1_'+sno);
            var int_attendance2 = document.getElementById('int_attendance2_'+sno);

            if(int_attendance1.checked == false && int_attendance2.checked == false) {
                int_attendance1.focus();
                alert('Please Mark Attendance for the respective subject.');
            }
            else {
                if (int_mark.value != 'Abs') {
                    if (isNaN(int_mark.value)) {
                        int_mark.value = "";
                        int_mark.style.backgroundColor = "red";
                        int_mark.style.color = "white";
                        alert("Please enter the valid mark.");
                        int_mark.focus();
                    }
                    else {
                        if(Number(int_mark.value) == "") {
                            int_mark.style.backgroundColor = "red";
                            int_mark.style.color = "white";
                            ext_mark.value = "";
                            ext_mark.focus();
                        }
                        else if (Number(int_mark.value) < Number(imin_mark.value)) {
                            if (confirm('Are you sure that the mark you have entered is less than the minimum mark alloted to the subject?')) {
                                int_mark.style.backgroundColor = "red";
                                int_mark.style.color = "white";
                                int_mark.style.fontWeight = "bold";
                            }
                            else {
                                int_mark.value = "";
                                int_mark.style.backgroundColor = "red";
                                int_mark.style.color = "white";
                                int_mark.style.fontWeight = "bold";
                            }
                        }
                        if (Number(int_mark.value) >= Number(imin_mark.value)) {
                            int_mark.style.backgroundColor = "green";
                            int_mark.style.color = "white";
                        }
                        if (Number(int_mark.value) > Number(imax_mark.value)) {
                            int_mark.value = "";
                            int_mark.style.backgroundColor = "red";
                            int_mark.style.color = "white";
                            alert("The mark that you have entered is more than the maximum mark alloted to the subject.");
                        }

                    }
                }
                if(int_mark.value == 'Abs') {
                    int_mark.style.backgroundColor = "yellow";
                    int_mark.style.color = "black";
                }
            }
        }

        function ChangeExtMarkColor(sno) {
            var ext_mark = document.getElementById('ext_mark_' + sno);
            var emin_mark = document.getElementById('emin_mark_' + sno);
            var emax_mark = document.getElementById('emax_mark_' + sno);
            var ext_attendance1 = document.getElementById('ext_attendance1_'+sno);
            var ext_attendance2 = document.getElementById('ext_attendance2_'+sno);

            if(ext_attendance1.checked == false && ext_attendance2.checked == false) {
                ext_attendance1.focus();
                alert('Please Mark Attendance for the respective subject.');
            }
            else {
                if (ext_mark.value != 'Abs') {
                    if (isNaN(ext_mark.value)) {
                        ext_mark.value = "";
                        ext_mark.style.backgroundColor = "red";
                        ext_mark.style.color = "white";
                        alert("Please enter the valid mark.");
                        ext_mark.focus();
                    }
                    else {
                        if(Number(ext_mark.value) == "") {
                            ext_mark.style.backgroundColor = "red";
                            ext_mark.style.color = "white";
                            ext_mark.value = "";
                            ext_mark.focus();
                        }
                        else if (Number(ext_mark.value) < Number(emin_mark.value)) {
                            if (confirm('Are you sure that the mark you have entered is less than the minimum mark alloted to the subject?')) {
                                ext_mark.style.backgroundColor = "red";
                                ext_mark.style.color = "white";
                                ext_mark.style.fontWeight = "bold";
                            }
                            else {
                                ext_mark.value = "";
                                ext_mark.style.backgroundColor = "red";
                                ext_mark.style.color = "white";
                                ext_mark.style.fontWeight = "bold";
                            }
                        }
                        if (Number(ext_mark.value) >= Number(emin_mark.value)) {
                            ext_mark.style.backgroundColor = "green";
                            ext_mark.style.color = "white";
                        }
                        if (Number(ext_mark.value) > Number(emax_mark.value)) {
                            ext_mark.value = "";
                            ext_mark.style.backgroundColor = "red";
                            ext_mark.style.color = "white";
                            alert("The mark that you have entered is more than the maximum mark alloted to the subject.");
                        }

                    }
                }
                if(ext_mark.value == 'Abs') {
                    ext_mark.style.backgroundColor = "yellow";
                    ext_mark.style.color = "black";
                }
            }
        }
        /*
            Validating Form whether all fields are filled or not
            1. Checks whether all Present / Absent are checked
            2. Checks whether all Mark Entry Fields are filled
         */

        function ValidateForm() {

            for (var i = 0; i < "{{ $sno1 }}"; i++) {
                var int_mark = document.getElementById('int_mark_' + i);

                if (int_mark.value != "Abs") {
                    if (int_mark.value == "") {
                        alert('Please enter the Internal Mark Entry');
                        return false;
                    }
                }

            }

            for (var i = 0; i < "{{ $sno2 }}"; i++) {
                var ext_mark = document.getElementById('ext_mark_' + i);

                if (ext_mark.value == "") {
                    alert('Please enter the External Mark Entry');
                    return false;
                }
            }

            if (confirm('Are you sure that you want to submit the marks?')) {
                return true;
            }
            else {
                return false;
            }
        }
    </script>
@endsection