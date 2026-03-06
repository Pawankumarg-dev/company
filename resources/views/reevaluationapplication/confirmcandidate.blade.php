@extends('layouts.reevaluationapplication')
@section('content')

    <section class="container">
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
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
                        <p class="well well-sm center-text bold-text darkblue-background">
                            {{$title}}
                        </p>

                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <input type="hidden" id="exam_id" name="exam_id" value="{{ $exam->id }}">
                                    Confirm Candidate
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <form role="form" method="POST"
                                              action="{{url('/reevaluationapplication/checkcandidatedetail')}}" autocomplete="off" accept-charset="UTF-8">
                                            {{ csrf_field() }}

                                            <input type="hidden" id="exam_id" name="exam_id" value="{{ $exam->id }}">

                                            <div class="form-group {{ $errors->has('enrolmentno') ? 'has-error' : '' }}">
                                                <div class="col-sm-12">
                                                    @if (count($errors) > 0)
                                                        <div class="alert alert-danger">
                                                            <ul>
                                                                @foreach ($errors->all() as $error)
                                                                    <li>{{ $error }}</li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <label class="blue-text" for="enrolmentno">Candidate Enrolment No.:</label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control" id="enrolmentno" name="enrolmentno" placeholder="Enter Enrolment No."/>
                                                    </div>
                                                </div>
                                                <script>
                                                    $(document).ready(function () {
                                                        $('#enrolmentno').keypress(function (e) {
                                                            //if the letter is not digit, then stop type anything
                                                            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                                                                return false;
                                                            }
                                                        });
                                                    });
                                                </script>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </form>
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
        function getcandidatedetails() {
            var enrolmentnumber = $('#enrolmentnumber').val();
            var token = "{{ csrf_token() }}";
            var exam_id = $('#exam_id').val();

            if(enrolmentnumber == '') {
                alert('Please enter the enrolmentno');
            }
            else {
                $.ajax({
                    url: "{{ url('/reevaluationapplication/ajaxrequest/getcandidatedetails') }}",
                    type: "POST",
                    dataType: "JSON",
                    data: {_token: token, enrolmentnumber: enrolmentnumber, exam_id: exam_id},
                    beforeSend:function() {
                        $("#loadingStatusPanel").show();
                        $('#loadDataPanel').hide();
                    },
                    success:function(data) {
                        if(data != 0) {
                            $('#candidate_id').val(data.candidate_id);
                            $('#candidatenamedata').html(data.candidate_name);
                            $('#candidateenrolmentnodata').html(data.candidate_enrolmentno);
                            $('#candidatefathernamedata').html(data.candidate_fathername);
                            $('#candidatedobdata').html(data.candidate_dob);
                            $('#candidateemaildata').html(data.candidate_email);
                            $('#candidatecontactnumberdata').val(data.candidate_contactnumber);
                            $('#candidatecoursedata').html(data.candidate_course+" - ("+data.candidate_batch+")");
                            $('#candidateinstitutedata').html(data.candidate_institutecode+" - "+data.candidate_institutename);
                        }
                        else {
                            alert("Please enter the valid Enrolment No.");
                        }
                    },
                    complete:function() {
                        $("#loadingStatusPanel").hide();
                        $("#div_confirmenrolmentno").hide();
                        $('#div_newapplicationform').show();
                    }
                });
            }
        }
    </script>
@endsection

