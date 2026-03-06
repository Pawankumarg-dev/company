@extends('layouts.reevaluationapplication')
@section('content')

<section class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title">
                        <div class="center-text">
                            <span class="h4-text">National Institute for Empowerment of Persons with Multiple Disabilities (Divyangjan)</span><br>
                            <span class="h8-text">(Dept. of Empowerment of Persons with Disabilities (Divyangjan), MS&E, Govt. of India)</span><br>
                            <span class="h4-text">National Board of Examination in Rehabilitation (NBER)</span><br>
                            <span class="h8-text">(An Adjunct Body of Rehabilitation Council of India, under Ministry of Social Justice and Empowerment)</span>
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        Online Re-Evaluation Application Details - {{ $reevaluationapplication->application_number }}
                                    </div>
                                </div>

                                <div class="panel-body">
                                    <div class="table-responsive col-sm-12">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td>Application No.</td>
                                                <td class="red-text bold-text" colspan="2">{{ $reevaluationapplication->application_number }}</td>
                                            </tr>
                                            <tr>
                                                <td class="center-text" width="15%" rowspan="4">
                                                    <img src="{{asset('/files/enrolment/photos')}}/{{$reevaluationapplication->candidate->photo}}"  style="width: 100px; height: 100px !important" class="img" />
                                                </td>
                                                <td width="11%">Enrolment No</td>
                                                <td class="red-text bold-text" width="74%">{{ $reevaluationapplication->candidate->enrolmentno }}</td>
                                            </tr>
                                            <tr>
                                                <td>Name</td>
                                                <td class="red-text bold-text">{{ $reevaluationapplication->candidate->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Course</td>
                                                <td class="red-text bold-text">{{ $reevaluationapplication->candidate->approvedprogramme->programme->course_name }} - ({{ $reevaluationapplication->candidate->approvedprogramme->academicyear->year }})</td>
                                            </tr>
                                            <tr>
                                                <td>Institute</td>
                                                <td class="red-text bold-text">{{ $reevaluationapplication->candidate->approvedprogramme->institute->code }} - {{ $reevaluationapplication->candidate->approvedprogramme->institute->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Mobile Number</td>
                                                <td class="red-text bold-text" colspan="2">
                                                    {{ $reevaluationapplication->contactnumber }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Email Id</td>
                                                <td class="red-text bold-text" colspan="2">
                                                    {{ $reevaluationapplication->email }}
                                                </td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="panel panel-info">
                                                <div class="panel-heading">
                                                    <div class="panel-title">
                                                        Re-Evaluation Subjects Details
                                                    </div>
                                                </div>

                                                <div class="panel-body">
                                                    <form id="reevaluationform" class="form-horizontal"
                                                          action="{{ url('/reevaluationapplication/login/addsubjectdetail/') }}"
                                                          method="post" onsubmit="return validateForm()" enctype="multipart/form-data">
                                                        
                                                          <input type="hidden" name="reevaluationapplication_id" value="{{ $reevaluationapplication->id }}">
                                                          {{csrf_field()}}

                                                        <div class="table-responsive">
                                                            <table class="table table-bordered">
                                                                <tr>
                                                                    <td colspan="7">
                                                                        <p class="center-text red-text bold-text"><u>Instructions</u></p>
                                                                        <ul class="red-text">
                                                                            <li>
                                                                                No request shall be accepted for change of Papers after final submission. Candidates
                                                                                are advised to carefully check all the relevant details before final submission.
                                                                            </li>
                                                                            <li>
                                                                                The results of Re-Evaluation / Re-Totalling will be displayed in the NIEPMD-NBER
                                                                                web portal <a href="{{ url('http://www.niepmdexaminationsnber.com/') }}" target="_blank"> www.niepmdexaminationsnber.com</a>
                                                                            </li>
                                                                            <li>
                                                                                The photocopy of Answer Scripts applied will be sent to the registered email id.
                                                                            </li>
                                                                            <li>
                                                                                The result of Re-Evaluation / Re-Totalling, shall be binding on the candidate. Hence, no
                                                                                calls / representations will be entertained.
                                                                            </li>
                                                                            <li>
                                                                                If any discrepancy found in the photocopy of the Answer Scripts, it need to be
                                                                                communicated to the NIEPMD-NBER, Chennai, immediately.
                                                                            </li>
                                                                        </ul>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="center-text" rowspan="2" width="3%">#</th>
                                                                    <th class="center-text" colspan="2">Paper</th>
                                                                    <th class="center-text" rowspan="3" width="2%">Marks<br>Obtained</th>
                                                                    <th class="center-text" colspan="3" width="15%">Re-Evaluation Options</th>
                                                                </tr>
                                                                <tr>
                                                                    <th class="center-text" width="5%">Code</th>
                                                                    <th class="center-text"  width="25%">Name</th>
                                                                    <th class="center-text">Re-Evaluation</th>
                                                                    <th class="center-text">Re-Totalling</th>
                                                                    <th class="center-text">Photo-Copying</th>
                                                                </tr>
    
                                                                <tbody>
                                                                @php $sno = 1; $count = 0; @endphp
                                                                @foreach($marks as $mark)
                                                                    <tr>
                                                                        <td class="center-text">
                                                                            <input type="checkbox" name="mark_checkbox[]" id="mark_checkbox{{$count}}" value="{{$count}}" onclick="enabledisablefield({{$count}})">
                                                                            <input type="hidden" name="mark_id[]" id="mark_id{{$count}}" value="{{$mark->id}}">
                                                                        </td>
                                                                        <td>{{ $mark->application->subject->scode }}</td>
                                                                        <td>{{ $mark->application->subject->sname }}</td>
                                                                        <td class="center-text">{{ trim($mark->external + $mark->grace) }}</td>
                                                                        <td class="center-text">
                                                                            <input type="checkbox" name="reevaluation_checkbox[]" id="reevaluation_checkbox{{$count}}" value="0" onclick="updateremarks({{$count}})">
                                                                            <input type="hidden" name="reevaluation_applystatus[]" id="reevaluation_applystatus{{$count}}" value="0">
                                                                        </td>
                                                                        <td class="center-text">
                                                                            <input type="checkbox" name="retotalling_checkbox[]" id="retotalling_checkbox{{$count}}" value="0" onclick="updateremarks({{$count}})">
                                                                            <input type="hidden" name="retotalling_applystatus[]" id="retotalling_applystatus{{$count}}" value="0">
                                                                        </td>
                                                                        <td class="center-text">
                                                                            <input type="checkbox" name="photocopying_checkbox[]" id="photocopying_checkbox{{$count}}" value="0" onclick="updateremarks({{$count}})">
                                                                            <input type="hidden" name="photocopying_applystatus[]" id="photocopying_applystatus{{$count}}" value="0">
                                                                        </td>
                                                                    </tr>
                                                                    @php $sno++; $count++; @endphp
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="col-sm-5">
                                                                <button type="submit" class="btn btn-success">
                                                                    <span class="glyphicon glyphicon-ok-sign"></span>
                                                                    Submit Application
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel-footer">
                    Please contact NIEPMD-NBER in case of any queries
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function () {
        $('input[name="reevaluation_checkbox[]"]').attr('disabled', true);
        $('input[name="retotalling_checkbox[]"]').attr('disabled', true);
        $('input[name="photocopying_checkbox[]"]').attr('disabled', true);
    });

    function enabledisablefield(count) {
        if($('#mark_checkbox'+count).prop("checked") == true) {
            $('#reevaluation_checkbox'+count).attr('disabled', false);
            $('#retotalling_checkbox'+count).attr('disabled', false);
            $('#photocopying_checkbox'+count).attr('disabled', false);
        }
        else {
            $('#reevaluation_checkbox'+count).prop("checked", false);
            $('#reevaluation_checkbox'+count).attr('disabled', true);
            $('#retotalling_checkbox'+count).prop("checked", false);
            $('#retotalling_checkbox'+count).attr('disabled', true);
            $('#photocopying_checkbox'+count).prop("checked", false);
            $('#photocopying_checkbox'+count).attr('disabled', true);
        }
    }

    function updateremarks(count) {
        var remarks = '';

        if($('#reevaluation_checkbox'+count).is(":checked")) {
            $('#reevaluation_applystatus'+count).val('1');
        }
        else {
            $('#reevaluation_applystatus'+count).val('0');
        }
        if($('#retotalling_checkbox'+count).is(":checked")) {
            $('#retotalling_applystatus'+count).val('1');
        }
        else {
            $('#retotalling_applystatus'+count).val('0');
        }
        if($('#photocopying_checkbox'+count).is(":checked")) {
            $('#photocopying_applystatus'+count).val('1');
        }
        else {
            $('#photocopying_applystatus'+count).val('0');
        }
    }

    function validateForm() {
        var count = 0;

        for(var i=0; i<"{{$count}}"; i++) {
            if($('#mark_checkbox'+i).prop("checked") == true){
                if($('#reevaluation_checkbox'+i).prop("checked") == true || $('#retotalling_checkbox'+i).prop("checked") == true || $('#photocopying_checkbox'+i).prop("checked") == true) {
                    count++;
                }
                else {
                    swal("Error Occurred!!!", "Please select atleast any one RE-Evaluation Options", "error");
                    return false;
                }
            }
        }

        if(count == 0) {
            swal("Error Occurred!!!", "Please select atleast any one Paper", "error");
            return false;
        }
        for(var i=0; i<"{{$sno}}"; i++) {
            if($('#mark_checkbox'+i).prop("checked") == true) {
                var el = '<input type="hidden" name="markid_select[]" value="1">';
                $('#reevaluationform').append(el);
            }
            else {
                var el = '<input type="hidden" name="markid_select[]" value="0">';
                $('#reevaluationform').append(el);
            }
        }
    }
</script>
@endsection