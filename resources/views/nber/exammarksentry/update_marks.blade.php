@extends('layouts.app')

@section('content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text">
                    {{ $exam->name }} Exam - Mark Entry
                </div>
            </div>
        </div>
    </section>

    <form class="form-horizontal" role="form" method="POST"
          action="{{url('/nber/exams/marks-entry/updateform/')}}" autocomplete="off" accept-charset="UTF-8"
          enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="exam_id" value="{{ $exam->id }}">
        <input type="hidden" name="approvedprogramme_id" value="{{ $approvedprogramme->id }}">
        <input type="hidden" name="subject_id" value="{{ $subject->id }}">

        <section class="container-fluid">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-condensed blue-text">
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
                                <th class="center-text" rowspan="2">Language</th>
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
                                    <td class="center-text">{{ $app->language->language }}</td>
                                    <td class="center-text">
                                        <input type="hidden" id="imin_mark_{{ $count }}" value="{{ $app->subject->imin_marks }}" />
                                        {{ $app->subject->imin_marks }}
                                    </td>
                                    <td class="center-text">
                                        <input type="text" class="center-text" size="1" id="int_mark_{{ $count }}" name="int_mark[]" tabindex="{{ $sno*100 }}"
                                                 @if(is_null($m))
                                                 style="background-color:white; color: darkblue; font-weight: bold"
                                                 @else
                                                 @if($internal == '')
                                                 @else
                                                 @if($internal == 'Abs')
                                                 style="background-color: yellow; color: red; font-weight: bold"
                                                 readOnly
                                                 @else
                                                 @if((int)$internal < $app->subject->imin_marks)
                                                 style="background-color: red; color: white; font-weight: bold"
                                                 @else
                                                 style="background-color:green; color: white; font-weight: bold"
                                                 @endif
                                                 @endif
                                                 value="{{ $internal }}"
                                                 @endif
                                                 @endif

                                                 onblur="CheckIntMarkValue({{ $count }})"
                                        />

                                        @if(is_null($m))
                                            <button type="button" id="btn_int_clear_absent_{{ $count }}" class="btn btn-sm btn-primary" onclick="IntClearAbsent({{ $count }})" style="display: none">Clear Absent</button>
                                            <button type="button" id="btn_int_mark_absent_{{ $count }}" class="btn btn-sm btn-danger" onclick="IntMarkAbsent({{ $count }})" style="display: inline">Mark Absent</button>
                                        @else
                                            @if($internal == 'Abs')
                                                <button type="button" id="btn_int_clear_absent_{{ $count }}" class="btn btn-sm btn-primary" onclick="IntClearAbsent({{ $count }})" style="display: inline">Clear Absent</button>
                                                <button type="button" id="btn_int_mark_absent_{{ $count }}" class="btn btn-sm btn-danger" onclick="IntMarkAbsent({{ $count }})" style="display: none">Mark Absent</button>
                                            @else
                                                <button type="button" id="btn_int_clear_absent_{{ $count }}" class="btn btn-sm btn-primary" onclick="IntClearAbsent({{ $count }})" style="display: none">Clear Absent</button>
                                                <button type="button" id="btn_int_mark_absent_{{ $count }}" class="btn btn-sm btn-danger" onclick="IntMarkAbsent({{ $count }})" style="display: inline">Mark Absent</button>
                                            @endif
                                        @endif


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
                                                            readOnly
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

                                        />
                                    </td>
                                    <td class="center-text">
                                        <input type="text" class="center-text" size="1" id="ext_mark_{{ $count }}" name="ext_mark[]" tabindex="{{ $sno }}"
                                               @if(is_null($m))
                                               style="background-color:white; color: darkblue; font-weight: bold"
                                               @else
                                                   @if($external == '')
                                                   @else
                                                   @if($external == 'Abs')
                                                   style="background-color: yellow; color: red; font-weight: bold"
                                                   readOnly
                                                   @else
                                                   @if($external < $app->subject->emin_marks)
                                                   style="background-color: red; color: white; font-weight: bold"
                                                   @else
                                                   style="background-color:green; color: white; font-weight: bold"
                                                   @endif
                                                   @endif
                                                   value="{{ $external }}"
                                                   @endif
                                               @endif



                                               onblur="CheckExtMarkValue({{ $count }})"
                                        />
                                        @if(is_null($m))
                                            <button type="button" id="btn_ext_clear_absent_{{ $count }}" class="btn btn-sm btn-primary" onclick="ExtClearAbsent({{ $count }})" style="display: none">Clear Absent</button>
                                            <button type="button" id="btn_ext_mark_absent_{{ $count }}" class="btn btn-sm btn-danger" onclick="ExtMarkAbsent({{ $count }})" style="display: inline">Mark Absent</button>
                                        @else
                                            @if($external == 'Abs')
                                                <button type="button" id="btn_ext_clear_absent_{{ $count }}" class="btn btn-sm btn-primary" onclick="ExtClearAbsent({{ $count }})" style="display: inline">Clear Absent</button>
                                                <button type="button" id="btn_ext_mark_absent_{{ $count }}" class="btn btn-sm btn-danger" onclick="ExtMarkAbsent({{ $count }})" style="display: none">Mark Absent</button>
                                            @else
                                                <button type="button" id="btn_ext_clear_absent_{{ $count }}" class="btn btn-sm btn-primary" onclick="ExtClearAbsent({{ $count }})" style="display: none">Clear Absent</button>
                                                <button type="button" id="btn_ext_mark_absent_{{ $count }}" class="btn btn-sm btn-danger" onclick="ExtMarkAbsent({{ $count }})" style="display: inline">Mark Absent</button>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="center-text">
                                        <input type="hidden" id="emax_mark_{{ $count }}" value="{{ $app->subject->emax_marks }}" />
                                        {{ $app->subject->emax_marks }}
                                    </td>
                                    <td class="center-text"></td>
                                    <td class="center-text"></td>
                                </tr>
                                @php $sno++; $count++; @endphp
                            @endforeach

                            <tr>
                                <td colspan="13" class="center-text">
                                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                                    <button type="reset" class="btn btn-sm btn-danger">Reset</button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </form>
    <script>
        function IntMarkAbsent(count) {
            var int_mark = document.getElementById('int_mark_'+count);
            var btn_int_clear_absent = document.getElementById('btn_int_clear_absent_'+count);
            var btn_int_mark_absent = document.getElementById('btn_int_mark_absent_'+count);

            int_mark.value = 'Abs';
            CheckIntMarkValue(count);

            btn_int_mark_absent.style.display = 'none';
            btn_int_clear_absent.style.display = 'inline';
        }

        function IntClearAbsent(count) {
            var int_mark = document.getElementById('int_mark_'+count);
            var btn_int_clear_absent = document.getElementById('btn_int_clear_absent_'+count);
            var btn_int_mark_absent = document.getElementById('btn_int_mark_absent_'+count);

            int_mark.value = '';
            CheckIntMarkValue(count);

            btn_int_mark_absent.style.display = 'inline';
            btn_int_clear_absent.style.display = 'none';
            int_mark.focus();
        }

        function CheckIntMarkValue(count) {
            var int_mark = document.getElementById('int_mark_'+count);
            var imin_mark = document.getElementById('imin_mark_'+count);
            var imax_mark = document.getElementById('imax_mark_'+count);

            if(int_mark.value == 'Abs') {
                int_mark.style.backgroundColor = 'yellow';
                int_mark.style.color = 'red';
                int_mark.style.fontWeight = 'bold';
                int_mark.setAttribute('readOnly', true);
            }
            else if(isNaN(int_mark.value)) {
                alert("Please enter a Valid Internal Mark");
                int_mark.focus();
                int_mark.value = '';
            }
            else {
                if (int_mark.value == '') {
                    int_mark.style.backgroundColor = 'red';
                    int_mark.style.color = 'white';
                    int_mark.style.fontWeight = 'bold';
                    int_mark.removeAttribute('readOnly');
                }
                else {
                    if (Number(int_mark.value) < Number(imin_mark.value)) {
                        int_mark.style.backgroundColor = 'red';
                        int_mark.style.color = 'white';
                        int_mark.style.fontWeight = 'bold';
                    }
                    if (Number(int_mark.value) >= Number(imin_mark.value)) {
                        int_mark.style.backgroundColor = 'green';
                        int_mark.style.color = 'white';
                        int_mark.style.fontWeight = 'bold';
                    }
                    if (Number(int_mark.value > Number(imax_mark.value))) {
                        alert("The mark that you have entered is more than the maximum mark alloted to the subject.");
                        int_mark.focus();
                        int_mark.value = '';
                    }
                }
            }
        }

        function ExtMarkAbsent(count) {
            var ext_mark = document.getElementById('ext_mark_'+count);
            var btn_ext_clear_absent = document.getElementById('btn_ext_clear_absent_'+count);
            var btn_ext_mark_absent = document.getElementById('btn_ext_mark_absent_'+count);
            var grace_mark = document.getElementById('grace_mark_' + count);

            ext_mark.value = 'Abs';
            CheckExtMarkValue(count);

            grace_mark.value = 0;
            grace_mark.setAttribute('readOnly', true);
            btn_ext_mark_absent.style.display = 'none';
            btn_ext_clear_absent.style.display = 'inline';
        }

        function ExtClearAbsent(count) {
            var ext_mark = document.getElementById('ext_mark_'+count);
            var btn_ext_clear_absent = document.getElementById('btn_ext_clear_absent_'+count);
            var btn_ext_mark_absent = document.getElementById('btn_ext_mark_absent_'+count);
            var grace_mark = document.getElementById('grace_mark_' + count);

            ext_mark.value = '';
            CheckExtMarkValue(count);

            btn_ext_mark_absent.style.display = 'inline';
            btn_ext_clear_absent.style.display = 'none';
            grace_mark.value = 0;
            ext_mark.focus();
        }

        function CheckExtMarkValue(count) {
            var ext_mark = document.getElementById('ext_mark_'+count);
            var grace_mark = document.getElementById('grace_mark_'+count);
            var emin_mark = document.getElementById('emin_mark_'+count);
            var emax_mark = document.getElementById('emax_mark_'+count);

            if(ext_mark.value == 'Abs') {
                ext_mark.style.backgroundColor = 'yellow';
                ext_mark.style.color = 'red';
                ext_mark.style.fontWeight = 'bold';
                ext_mark.setAttribute('readOnly', true);
            }
            else if(isNaN(ext_mark.value)) {
                alert("Please enter a Valid Internal Mark");
                ext_mark.focus();
                ext_mark.value = '';
            }
            else if(Number.isInteger(+ext_mark.value) == false) {
                alert("Please enter a Valid Internal Mark");
                ext_mark.focus();
                ext_mark.value = '';
            }

            else {
                if (ext_mark.value == '') {
                    ext_mark.style.backgroundColor = 'red';
                    ext_mark.style.color = 'white';
                    ext_mark.style.fontWeight = 'bold';
                    ext_mark.removeAttribute('readOnly');
                }
                else {
                    if (Number(ext_mark.value) + Number(grace_mark.value) < Number(emin_mark.value)) {
                        ext_mark.style.backgroundColor = 'red';
                        ext_mark.style.color = 'white';
                        ext_mark.style.fontWeight = 'bold';
                        grace_mark.removeAttribute('readOnly');
                    }
                    if (Number(ext_mark.value) + Number(grace_mark.value) >= Number(emin_mark.value)) {
                        ext_mark.style.backgroundColor = 'green';
                        ext_mark.style.color = 'white';
                        ext_mark.style.fontWeight = 'bold';
                        grace_mark.removeAttribute('readOnly');
                    }
                    if (Number(ext_mark.value > Number(emax_mark.value))) {
                        alert("The mark that you have entered is more than the maximum mark alloted to the subject.");
                        ext_mark.focus();
                        ext_mark.value = '';
                    }
                }
            }
        }

        function CheckGraceMarkValue(count) {
            var grace_mark = document.getElementById('grace_mark_' + count);
            var ext_mark = document.getElementById('ext_mark_' + count);

            if(ext_mark.value == '' || ext_mark.value == 'Abs') {
                grace_mark.value = 0;
                grace_mark.style.backgroundColor = 'darkblue';
                grace_mark.style.color = 'white';
                grace_mark.style.fontWeight = 'bold';
                grace_mark.setAttribute('readOnly', true);
            }
            else {
                if(grace_mark.value == 0) {
                    grace_mark.style.backgroundColor = 'darkblue';
                    grace_mark.style.color = 'white';
                    grace_mark.style.fontWeight = 'bold';
                }
                else if(isNaN(grace_mark.value)) {
                    alert("Please enter a Valid Grace Mark");
                    grace_mark.value = 0;
                    grace_mark.style.backgroundColor = 'darkblue';
                    grace_mark.style.color = 'white';
                    grace_mark.style.fontWeight = 'bold';
                    grace_mark.focus();
                }
                else if(Number.isInteger(+grace_mark.value) == false) {
                    alert("Please enter a Valid Grace Mark");
                    grace_mark.value = 0;
                    grace_mark.style.backgroundColor = 'darkblue';
                    grace_mark.style.color = 'white';
                    grace_mark.style.fontWeight = 'bold';
                    grace_mark.focus();
                }
                else {
                    if (grace_mark.value > 3) {
                        alert('The Grace Mark entered exceeds 3 Marks. Please check the grace mark and enter');
                        grace_mark.value = 0;
                        grace_mark.style.backgroundColor = 'darkblue';
                        grace_mark.style.color = 'white';
                        grace_mark.style.fontWeight = 'bold';
                        grace_mark.focus();
                    }
                    if (grace_mark.value >= 1 || gracemark.value < 4) {
                        grace_mark.style.backgroundColor = 'deeppink';
                        grace_mark.style.color = 'white';
                        grace_mark.style.fontWeight = 'bold';
                    }
                }
            }
        }
    </script>
@endsection