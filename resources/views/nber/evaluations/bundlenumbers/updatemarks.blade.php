@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb col-md-12">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li><a href="{{url('/nber/evaluations')}}">Evaluations</a></li>
                    <li><a href="{{url('/nber/evaluations/bundles')}}">Exam Bundles</a></li>
                    <li><a href="{{url('/nber/evaluations/bundles/'.$exam->id)}}">{{ $exam->name }} Examinations</a></li>
                    <li><a href="{{url('/nber/evaluations/showmarks/'.$exam->id.'/'.$bundle_number)}}">{{ $bundle_number }}</a></li>
                    <li><span class="bold-text blue-text">Update Marks</span></li>
                </ul>
            </div>
        </div>
    </div>

    <form class="form-horizontal" role="form" method="POST"
          action="{{url('/nber/evaluations/bundles/updatemarksdata/')}}" autocomplete="off" accept-charset="UTF-8"
          enctype="multipart/form-data">
        {{ csrf_field() }}

        <input type="hidden" name="exam_id" value="{{ $exam->id }}">
        <input type="hidden" name="bundle_number" value="{{ $bundle_number }}">

    <section class="container">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr class="green-background">
                            <th rowspan="2" width="3%">S.No.</th>
                            <th rowspan="2" width="10%">Dummy Number</th>
                            <th rowspan="2" width="3%">Inst. Code</th>
                            <th rowspan="2" width="10%">Enrolment No</th>
                            <th rowspan="2">Name</th>
                            <th rowspan="2" width="10%">Subject Code</th>
                            <th colspan="3" class="center-text">External</th>
                        </tr>
                        <tr class="green-background">
                            <th class="center-text">Mini.<br>Marks</th>
                            <th class="center-text">Marks<br>Obtained</th>
                            <th class="center-text">Maxi.<br>Marks</th>
                        </tr>
                        </thead>

                        @php $sno = 1; $count = 0; @endphp
                        @foreach($applications as $application)
                            <input type="hidden" name="application_id[]" value="{{ $application->id }}">
                            @php
                                $m = $marks->where('application_id', $application->id)->first();
                                if(!is_null($m)) {
                                $external = $m->external;
                                }
                            @endphp

                            <tbody>
                            <tr>
                                @php
                                    $mark = \App\Mark::where('application_id', $application->id)->first();
                                @endphp
                                <td class="blue-text">{{ $sno }}</td>
                                <td class="red-text bold-text">{{ $application->dummy_number }}</td>
                                <td class="blue-text">{{ $application->candidate->approvedprogramme->institute->code }}</td>
                                <td class="red-text bold-text">{{ $application->candidate->enrolmentno }}</td>
                                <td class="blue-text">{{ $application->candidate->name }}</td>
                                <td class="brown-text bold-text">{{ $application->subject->scode }}</td>
                                <td class="blue-text center-text bold-text">
                                    <input type="hidden" id="emin_mark_{{ $count }}" value="{{ $application->subject->emin_marks }}" />
                                    {{ $application->subject->emin_marks }}
                                </td>

                                <td class="center-text bold-text">
                                    <input type="text" class="center-text" size="1" id="ext_mark_{{ $count }}" name="ext_mark[]" tabindex="{{ $sno }}"
                                           @if(is_null($m))
                                               style="background-color:white; color: darkblue; font-weight: bold"
                                           @else
                                               @if($external == '')
                                               @else
                                                   @if($external == 'Abs')
                                                   style="background-color: yellow; color: red; font-weight: bold"
                                                   @else
                                                       @if($external < $application->subject->emin_marks)
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
                                </td>
                                <td class="blue-text center-text bold-text">
                                    <input type="hidden" id="emax_mark_{{ $count }}" value="{{ $application->subject->emax_marks }}" />
                                    {{ $application->subject->emax_marks }}
                                </td>
                            </tr>
                            </tbody>
                            @php $sno++; $count++; @endphp
                        @endforeach
                        <tr>
                            <td colspan="9" class="center-text">
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
        function CheckExtMarkValue(count) {
            var ext_mark = document.getElementById('ext_mark_' + count);
            var emin_mark = document.getElementById('emin_mark_' + count);
            var emax_mark = document.getElementById('emax_mark_' + count);

            if (isNaN(ext_mark.value)) {
                alert("Please enter a Valid Internal Mark");
                ext_mark.focus();
                ext_mark.value = '';
            }
            else if (Number.isInteger(+ext_mark.value) == false) {
                alert("Please enter a Valid Internal Mark");
                ext_mark.focus();
                ext_mark.value = '';
            }
            else {
                if (ext_mark.value == '') {
                    ext_mark.style.backgroundColor = 'red';
                    ext_mark.style.color = 'white';
                    ext_mark.style.fontWeight = 'bold';
                }
                else {
                    if (Number(ext_mark.value > Number(emax_mark.value))) {
                        alert("The mark that you have entered is more than the maximum mark alloted to the subject.");
                        ext_mark.focus();
                        ext_mark.value = '';
                    }
                    else if (Number(ext_mark.value) < Number(emin_mark.value)) {
                        ext_mark.style.backgroundColor = 'red';
                        ext_mark.style.color = 'white';
                        ext_mark.style.fontWeight = 'bold';
                    }
                    else {
                        ext_mark.style.backgroundColor = 'green';
                        ext_mark.style.color = 'white';
                        ext_mark.style.fontWeight = 'bold';
                    }
                }
            }
        }
    </script>
@endsection