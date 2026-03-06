@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4>
                {{$exam->name}} Examinations - Exam Application Form
                </h4>
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed">
                        <tr>
                            <td class="center-text" rowspan="4" width="15%">
                                <img src="{{ asset('/files/enrolment/photos/'.$candidate->photo) }}" style="width: 100px;" class="img" />
                            </td>
                            <td width="10%">Enrolment No.</td>
                            <td class="bold-text orange-text">{{ $candidate->enrolmentno }}</td>
                        </tr>
                        <tr>
                            <td width="10%">Name</td>
                            <td class="bold-text orange-text">{{ $candidate->name }}</td>
                        </tr>
                        <tr>
                            <td width="10%">Course</td>
                            <td class="bold-text orange-text">
                                {{ $approvedprogramme->programme->course_name }}
                            </td>
                        </tr>
                        <tr>
                            <td width="10%"> Batch</td>
                            <td class="bold-text orange-text">
                                ({{ $approvedprogramme->academicyear->year }})
                            </td>
                        </tr>
                    </table>
                </div>
                @if(count($subjects) == 0)
                            <div class="alert alert-warning" >
                                If not able to see the backlog subjects, kindly check after few days.
                            </div>
                        @endif
                @if(!is_null($subjects) && count($subjects) != 0)
                    <form class="form-horizontal" action="{{ url('/institute/examinations/applycandidateexamapplication') }}" method="post" onsubmit="return validateForm()" enctype="multipart/form-data">
                        {{csrf_field()}}

                        <input type="hidden" name="examId" id="exam-id" value="{{ $exam->id }}" />
                        <input type="hidden" name="approvedprogrammeId" id="approvedprogramme-id" value="{{ $approvedprogramme->id }}" />
                        <input type="hidden" name="candidateId" id="candidate-id" value="{{ $candidate->id }}" />
                        <input type="hidden" id="is-mobile-number-verified" value="Yes">
                        <input type="hidden" id="mobile-number-verification-code" value="">
                        <input type="hidden" id="is-email-address-verified" value="Yes">
                        <input type="hidden" id="email-address-verification-code" value="">
                        <input type="hidden" id="verifying" value="examapplication">

                    <div class="table-responsive">
                        <table class="table table-bordered table-condensed table-hover">
                            <tr>
                                <th class="center-text orange-text" width="3%">S.No.</th>
                                <th class="center-text orange-text" width="5%">Paper Year</th>
                                <th class="center-text orange-text" width="5%">Paper Type</th>
                                <th class="center-text orange-text" width="7%">Paper Code</th>
                                <th class="center-text orange-text" width="50%">Paper Name</th>
                                <th class="center-text orange-text" width="5%">
                                     All
                                </th>
                             
                                {{--
                                <th class="center-text orange-text" width="5%">Selected Remarks</th>
                                --}}
                            </tr>
                            @if(!is_null($subjects))
                                @php $sno = 1; $count = 0; @endphp
                                @foreach($subjects as $subject)
                                    <input type="hidden" name="subjectId[]" id="subject-Id-{{ $count }}" value="{{ $subject->id }}">
                                    <input type="hidden" name="term[]" id="term-{{ $count }}" value="{{ $subject->syear }}">
                                    <tr>
                                        <td class="center-text blue-text">{{ $sno }}@php $sno++; @endphp</td>
                                        <td class="center-text blue-text">{{ $subject->syear }}</td>
                                        <td class="center-text blue-text">{{ $subject->type }}</td>
                                        <td class="center-text blue-text">{{ $subject->scode }}</td>
                                        <td class="blue-text">{{ $subject->sname }}</td>
                                        <td class="center-text">
                                            <input type="checkbox" class="subjects" name="subjectIdCheckbox[]" id="subject-id-checkbox-{{$count}}" value="0">
                                            <input type="hidden" name="subjectAppliedStatus[]" id="subject-apply-status-{{$count}}" value="0">
                                        </td>
                                      
                                    </tr>
                                    @php $count++; @endphp
                                @endforeach
                
                            @endif
                        </table>
                        
                    </div>

                        <div class="form-group">
                            <div class="text-left blue-text col-sm-2">
                                <label for="language-id" class="control-label">
                                    Preferred Language
                                    <span class="red-text">*</span>
                                </label>
                            </div>

                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <select class="form-control blue-text medium-text" name="languageId" id="language-id" disabled>
                                            <option value="0" selected>Select</option>
                                            @foreach($languages as $language)
                                                <option value="{{ $language->id }}">{{ $language->language }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{--@include('institute.common.otpverificationform') --}}

                        <div class="form-group">
                            <div class="text-left blue-text col-sm-2">
                                <label for="email-address" class="control-label">
                                    Declaration
                                    <span class="red-text">*</span>
                                </label>
                            </div>

                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" id="declaration-checkbox" disabled>
                                            <span class="blue-text">
                                                I here by declare that I have verified my Name, Date of Birth, Father Name, Mobile Number
                                                and Email Address are correct. I shall not claim any corrections in future.
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-5 col-sm-offset-2">
                                <button type="submit" id="btn-sumbmit" class="btn btn-primary btn-sm">
                                    <span class="glyphicon glyphicon-ok"></span>&nbsp;
                                    Submit Exam Application
                                </button>
                                <button type="reset" class="btn btn-danger btn-sm">
                                    <span class="glyphicon glyphicon-remove"></span>&nbsp;
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </form>
                @endif
                                              
            </div>
        </div>
    </div>
    
    @include('institute.common.otpverificationmodel');

    <script>
        $(document).ready(function(){
            $('input[name="subjectIdCheckbox[]"]').change(function(){
                checkSubjectIdCheckboxSelected();
            });
            $('#selectall').on('change',function(){
                $('input[name="subjectIdCheckbox[]"]').prop('checked',$('#selectall').is(':checked'));
                checkSubjectIdCheckboxSelected();
            });
        });

        function checkSubjectIdCheckboxSelected() {
            var selectedCount = 0;
            var count = 0;

            $('input[name="subjectIdCheckbox[]"]').each(function() {

                if($(this).is(':checked') == true) {
                    selectedCount++;

                    $('#subject-id-checkbox-'+count).val('1');
                    $('#subject-apply-status-'+count).val('1');
                }
                else {
                    $('#subject-id-checkbox-'+count).val('0');
                    $('#subject-apply-status-'+count).val('0');
                }

                count++;
            });

            if(selectedCount != 0) {
                $('#language-id').prop('disabled', false);
                $('#mobile-number').prop('readonly', false);
                $('#email-address').prop('readonly', false);
                $('#mobile-number-verify-button').prop('disabled', false);
                $('#email-address-verify-button').prop('disabled', false);
                $('#declaration-checkbox').prop('disabled', false);
            }
            else {
                $('#language-id').val(0).change();
                $('#language-id').prop('disabled', true);
                $('#mobile-number').val('');
                $('#mobile-number').prop('readonly', true);
                $('#is-mobile-number-verified').val('No');
                $('#email-address').val('');
                $('#is-email-address-verified').val('No');
                $('#email-address').prop('readonly', true);
                $('#mobile-number-verify-button').prop('disabled', true);
                $('#email-address-verify-button').prop('disabled', true);
                $('#declaration-checkbox').prop('disabled', true);

                if($('#mobile-number-show-verified-div').hasClass('content-show')) {
                    $('#mobile-number-show-verified-div').removeClass('content-show').addClass('content-hide');
                    $('#mobile-number-verify-button-div').removeClass('content-hide').addClass('content-show');
                }
                if($('#email-address-show-verified-div').hasClass('content-show')) {
                    $('#email-address-show-verified-div').removeClass('content-show').addClass('content-hide');
                    $('#email-address-verify-button-div').removeClass('content-hide').addClass('content-show');
                }
            }
        }

        function validateForm() {
            var selectedCount = 0;

            $('input[name="subjectIdCheckbox[]"]').each(function() {
                if ($(this).is(':checked') == true) {
                    selectedCount++;
                }
            });

            if(selectedCount == 0) {
                swal("Error Occurred!!!", "Please select any Subject(s)", "error");
                return false;
            }

            if($('#language-id').val() == 0) {
                swal("Error Occurred!!!", "Please select Language", "error");
                return false;
            }

            if($('#mobile-number').val() === "") {
                swal("Error Occurred!!!", "Please enter Mobile No.", "error");
                return false;
            }

            if($('#is-mobile-number-verified').val() != "Yes") {
          //      swal("Error Occurred!!!", "Please verify the Mobile No.", "error");
            //    return false;
            }

            if($('#email-address').val() === "") {
             //   swal("Error Occurred!!!", "Please enter Email Address", "error");
              //  return false;
            }

            if($('#is-email-address-verified').val() != "Yes") {
             //   swal("Error Occurred!!!", "Please verify the Email Address", "error");
              //  return false;
            }

            if($('#declaration-checkbox').is(':checked') == false) {
                swal("Error Occurred!!!", "Please select the Declaration", "error");
                return false;
            }
            $('#btn-sumbmit').html('Please wait....');
            $('#btn-sumbmit').attr('disabled',true);
        }
    </script>
    @include('institute.common.otpverificationjs')
@endsection