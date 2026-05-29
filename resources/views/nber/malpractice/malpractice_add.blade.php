@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top:30px;">

        <div class="row">

            <div class="col-md-8 col-md-offset-2">

                <div class="panel panel-primary">

                    <div class="panel-heading text-center">
                        <h3 class="panel-title">Add Malpractice</h3>
                    </div>

                    <div class="panel-body">

                        <form id="malpracticeForm" method="POST" enctype="multipart/form-data">

                            {{ csrf_field() }}

                            <div class="form-group">

                                <label>Title</label>

                                <input type="text" name="title" id="title" class="form-control">

                                <span id="title_error" style="color:red;"></span>

                            </div>

                            <div class="form-group">

                                <label>Description</label>

                                <textarea name="description" id="description" class="form-control" rows="4"></textarea>

                                <span id="description_error" style="color:red;"></span>

                            </div>

                            <div class="form-group">

                                <label>Exam Name</label>
                                <select name="exam_id" id="exam_id" class="form-control">

                                    <option value="">Select Exam</option>

                                    @foreach ($exams as $exam)
                                        <option value="{{ $exam->id }}"
                                            @if ($exam->id == session('exam_id')) selected @endif>{{ $exam->name }}</option>
                                    @endforeach
                                </select>

                                {{-- <input type="hidden" name="exam_id" value="{{ session('exam_id') }}">

                                <input type="text" class="form-control" value="{{ session('examname') }}" readonly> --}}

                            </div>

                            <div class="form-group">

                                <label>
                                    Candidate Enrollment Number
                                </label>

                                <input type="text" name="candidate_enrolment" id="candidate_enrolment"
                                    class="form-control">

                                <span id="candidate_enrolment_error" style="color:red;"></span>

                            </div>

                            <div class="form-group">

                                <label>Malpractice Report</label>

                                <input type="file" name="malpractice_report" id="malpractice_report"
                                    class="form-control">

                                <span id="malpractice_report_error" style="color:red;"></span>

                            </div>
                            <div class="form-group">

                                <input type="submit" value="Submit" class="btn btn-primary btn-block">

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>



    <script>
        $('#malpracticeForm').submit(function(e) {

            e.preventDefault();

            // Remove old errors
            $('#title_error').html('');
            $('#description_error').html('');
            $('#candidate_enrolment_error').html('');
            $('#malpractice_report_error').html('');
          

            var title = $('#title').val();

            var description = $('#description').val();

            var enrolment = $('#candidate_enrolment').val();

            var report = $('#malpractice_report').val();

           

            var valid = true;

          
            if (title == '') {
                $('#title_error').html('Please enter title');
                valid = false;
            }

         
            if (description == '') {
                $('#description_error').html('Please enter description');
                valid = false;
            }

         
            if (enrolment == '') {
                $('#candidate_enrolment_error')
                    .html('Please enter enrolment number');

                valid = false;
            }


            // File Validation
            var file = $('#malpractice_report')[0].files[0];

            if (file == undefined) {
                $('#malpractice_report_error')
                    .html('Please upload malpractice report');

                valid = false;
            } else {
              
                var extension = file.name.split('.').pop().toLowerCase();

                if (extension != 'pdf') {
                    $('#malpractice_report_error')
                        .html('Only PDF file allowed');

                    valid = false;
                }

                if (file.size > 2097152) {
                    $('#malpractice_report_error')
                        .html('File size must be less than 2 MB');

                    valid = false;
                }
            }

            

            if (valid == false) {
                return false;
            }

            var formData = new FormData(this);

            $.ajax({
                url: "{{ url('/nber/malpractice/store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // Wrong enrolment number
                    if (response.status == false) {
                        $('#candidate_enrolment_error')
                            .html(response.errors.candidate_enrolment);
                    } else {
                        window.location.href =
                            "/nber/malpractice/view?success=Malpractice Added Successfully";
                    }

                }

            });

        });
    </script>
@endsection
