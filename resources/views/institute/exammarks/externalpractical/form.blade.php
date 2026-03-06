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
          action="{{ url('/institute/exammarksentry/update-external-practical-marks/') }}" autocomplete="off" accept-charset="UTF-8"
          enctype="multipart/form-data" onsubmit="return validateForm()"
    >
        {{ csrf_field() }}

        <input type="hidden" name="exam_id" value="{{ $exam->id }}" />
        <input type="hidden" name="approvedprogramme_id" value="{{ $approvedprogramme->id }}" />
        <input type="hidden" name="institute_code" value="{{ $approvedprogramme->institute->code }}" />

        @php $count = 0; $markcount = 0; $filecount = 0; @endphp
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
                                                   {{-- <span class="h6-text">National Institute for Empowerment of Persons with Multiple Disabilities (Divyangjan)</span><br>
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
                                                                @endphp
                                                                @if(!is_null($application))
                                                                    @php
                                                                        $mark = $marks->where('application_id', $application->id)->first();
                                                                    @endphp
                                                                    @if(!is_null($mark))
                                                                    @if(is_null($mark->external) || $mark->external == '')
                                                                        <input type="hidden" id="application_id" name="application_id[{{ $count }}]" value="{{ $application->id }}" />
                                                                        <input type="hidden" id="min_mark{{ $count }}" value="{{ $application->subject->emin_marks }}" />
                                                                        <input type="hidden" id="max_mark{{ $count }}" value="{{ $application->subject->emax_marks }}" />

                                                                        <input type="text" size="1" id="external{{ $count }}" name="external[]"
                                                                               class="center-text" onblur="checkMarkValue({{ $count }})"
                                                                        />
                                                                        <button type="button" id="btn_removeAbsent{{ $count }}" class="btn btn-sm btn-primary" onclick="removeAbsent({{ $count }})" style="display: none">Remove<br>Absent</button>
                                                                        <button type="button" id="btn_markAbsent{{ $count }}" class="btn btn-sm btn-danger" onclick="markAbsent({{ $count }})" style="display: inline">Mark<br>Absent</button>

                                                                        @php $count++; $entrycount++; $markcount++; @endphp
                                                                    @else
                                                                        {{ $mark->external }}
                                                                    @endif
                                                                    @endif
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

                                @if($entrycount > 0)
                                    <input type="hidden" id="external_fileterm{{ $j }}" name="external_fileterm[{{ $filecount }}]" value="{{ $i }}" />
                                    <div class="form-group">
                                        <label for="external_file{{ $filecount }}" class="control-label col-sm-5">
                                            <div  class="text-left">
                                                <span class="blue-text">
                                                    Upload Scanned File of External Marks
                                                        <span class="red-text">
                                                        *
                                                    </span><br>
                                                </span>
                                                <span class="red-text">
                                                    (Only .pdf format file is allowed and the filesize should be less than 3 MB)
                                                </span>
                                            </div>
                                        </label>
                                        <div class="col-sm-3">
                                            <div class="col-sm-6">
                                                <input type="file" id="external_file{{ $filecount }}" name="external_file[{{ $filecount }}]" onchange="validateFile({{ $filecount }})">
                                            </div>
                                        </div>
                                    </div>
                                    @php $filecount++; @endphp
                                @endif
                            </div>
                        </div>
                    </div>
                </section>
            @endif
        @endfor

        @if($markcount > 0)
            <section class="container">
                <div class="row">
                    <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                        <button type="submit" class="btn btn-primary">Submit Marks</button>
                        <button type="reset" class="btn btn-danger">Reset Marks</button>
                    </div>
                </div>
            </section>
        @endif
    </form>
@endsection

<script>

    function markAbsent(count) {
        var external = document.getElementById('external'+count);
        var btn_removeAbsent = document.getElementById('btn_removeAbsent'+count);
        var btn_markabsent = document.getElementById('btn_markAbsent'+count);

        swal({
            title: 'Are you sure?',
            text: "You want to mark Absent!!!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, Mark Absent!'
        }).then((result) => {
            if (result.value) {
                swal("Success!!!", "You have marked Absent", "success");
                external.value = 'Abs';
                checkMarkValue(count);
                btn_markabsent.style.display = 'none';
                btn_removeAbsent.style.display = 'inline';
            }
        });
    }

    function removeAbsent(count) {
        var external = document.getElementById('external'+count);
        var btn_removeAbsent = document.getElementById('btn_removeAbsent'+count);
        var btn_markabsent = document.getElementById('btn_markAbsent'+count);

        swal({
            title: 'Are you sure?',
            text: "You want to remove Absent!!!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, remove Absent!'
        }).then((result) => {
            if (result.value) {
                swal("Success!!!", "You have removed Absent", "success");
                external.removeAttribute('readOnly');
                external.value = '';
                checkMarkValue(count);
                btn_markabsent.style.display = 'inline';
                btn_removeAbsent.style.display = 'none';
                external.focus();
            }
        });
    }

    function checkMarkValue(count) {
        var external = document.getElementById('external'+count);
        var min_mark = document.getElementById('min_mark'+count);
        var max_mark = document.getElementById('max_mark'+count);

        if(external.value == 'Abs') {
            external.style.backgroundColor = 'yellow';
            external.style.color = 'red';
            external.style.fontWeight = 'bold';
            external.setAttribute('readOnly', true);
        }
        else if(isNaN(external.value)) {
            external.focus();
            external.value = '';
            swal("Error Occurred!!!", "Please enter a Valid Mark.", "error");
        }
        else if(Number.isInteger(+external.value) == false) {
            external.focus();
            external.value = '';
            swal("Error Occurred!!!", "Please enter a Valid Mark.", "error");
        }
        else {
            if (external.value == '') {

            }
            else {
                if (Number(external.value) < Number(min_mark.value)) {
                    external.style.backgroundColor = 'red';
                    external.style.color = 'white';
                    external.style.fontWeight = 'bold';
                }
                if (Number(external.value) >= Number(min_mark.value)) {
                    external.style.backgroundColor = 'green';
                    external.style.color = 'white';
                    external.style.fontWeight = 'bold';
                }
                if (Number(external.value > Number(max_mark.value))) {
                    external.focus();external.value = '';
                    swal("Error Occurred!!!", "The mark that you have entered is more than the maximum mark alloted to the subject.", "error");
                }
            }
        }
    }

    function validateFile(count) {
        var ext = $("#external_file"+count).val().split('.').pop().toLowerCase();
        if ($.inArray(ext, ['pdf']) == -1){
            swal("Error Occurred!!!", "Please upload the scanned file in .pdf format only.", "error");
            $('#external_file'+count).val(null);
            return false;
        }
        else if ($("#external_file"+count)[0].files[0].size > 3145728) {
            swal("Error Occurred!!!", "Please upload the scanned file less than 3 MB file size.", "error");
            $("#external_file"+count).val(null);
            return false;
        }
        else {
            //$('#filename_link').attr('href', $('#filename').val());
            //$('#filename_display').html($('#filename')[0].files[0].name); //->filename

        }

    }

    function validateForm() {

        for (var i = 0; i < "{{ $count }}"; i++) {
            var external = document.getElementById('external' + i);

            if (external.value == "") {
                external.focus();
                swal("Error Occurred!!!", "Please enter the Mark(s).", "error");
                external.style.backgroundColor = 'yellow';
                external.style.color = 'red';
                external.style.fontWeight = 'bold';
                return false;
            }
        }

        for (var i = 0; i < "{{ $filecount }}"; i++) {
            if($('#external_file' + i).val() == '') {
                swal("Error Occurred!!!", "Please upload the Scanned file of External Marks.", "error");
                return false;
            }
        }
    }
</script>