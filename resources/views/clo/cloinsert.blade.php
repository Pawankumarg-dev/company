@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top:30px;">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                <div class="panel panel-primary">

                    <div class="panel-heading text-center">
                        <h2 class="panel-title"> Add Daily  CLO Report</h2>
                    </div>

                    <div class="panel-body">

                        <form id="cloForm" method="POST" action="{{ url('clo/store') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label>Days <span class="text-danger">*<span></label>
                                <select name="day" id="day" class="form-control">
                                    <option value="">--Select Day--</option>
                                    <option value="day1">Day 1</option>
                                    <option value="day2">Day 2</option>
                                    <option value="day3">Day 3</option>
                                    <option value="day4">Day 4</option>
                                    <option value="day5">Day 5</option>
                                    <option value="day6">Day 6</option>
                                    <option value="day7">Day 7</option>
                                </select>
                                <span id="day_error" style="color:red;"></span>
                            </div>

                            <div class="form-group">
                                <label>Title <span class="text-danger">*<span></label>
                                <input type="text" name="title" id="title" class="form-control">
                                <span id="title_error" style="color:red;"></span>
                            </div>
                            <div class="form-group">
                                <label>Description <span class="text-danger">*<span></label>
                                <textarea name="description" id="description" class="form-control" rows="5"></textarea>
                                <span id="description_error" style="color:red;"></span>
                            </div>
                            <div class="form-group">
                                <label> File <span class="text-danger">*<span></label>
                                <input type="file" name="malpractice_report" id="malpractice_report"
                                    class="form-control">
                                <span id="malpractice_report_error" style="color:red;"></span>
                            </div>
                            <div class="form-group">
                                <label>Video </label>
                                <input type="file" name="video" id="video" class="form-control" accept="video/*">
                                <span id="video_error" style="color:red;"></span>
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
        $(document).ready(function() {

            $('#cloForm').submit(function(e) {

                e.preventDefault();

                // Clear old errors
                $('#day_error').html('');
                $('#title_error').html('');
                $('#description_error').html('');
                $('#malpractice_report_error').html('');
                $('#video_error').html('');

                var day = $('#day').val();
                var title = $('#title').val().trim();
                var description = $('#description').val().trim();

                var valid = true;

                
                if (day == '') {
                    $('#day_error').html('Please select day');
                    valid = false;
                }

            
                if (title == '') {
                    $('#title_error').html('Please enter title');
                    valid = false;
                }

                
                if (description == '') {
                    $('#description_error').html('Please enter description');
                    valid = false;
                }

              
                var pdfFile = $('#malpractice_report')[0].files[0];

                if (pdfFile == undefined) {

                    $('#malpractice_report_error')
                        .html('Please upload PDF file');

                    valid = false;

                } else {

                    var pdfExtension = pdfFile.name
                        .split('.')
                        .pop()
                        .toLowerCase();

                    if (pdfExtension != 'pdf') {

                        $('#malpractice_report_error')
                            .html('Only PDF file allowed');

                        valid = false;
                    }

                   
                    if (pdfFile.size > 2097152) {

                        $('#malpractice_report_error')
                            .html('PDF size must be less than 2 MB');

                        valid = false;
                    }
                }

                
                var videoFile = $('#video')[0].files[0];

                if (videoFile) {

                    var allowedVideoExtensions = [
                        'mp4',
                        'avi',
                        'mov',
                        'mkv',
                        'wmv',
                        'mpeg',
                        'webm'
                    ];

                    var videoExtension = videoFile.name
                        .split('.')
                        .pop()
                        .toLowerCase();

                    if ($.inArray(videoExtension, allowedVideoExtensions) === -1) {
                        $('#video_error')
                            .html('Only video files are allowed');
                        valid = false;
                    }

                 
                    if (videoFile.size > 524288000) {

                        $('#video_error')
                            .html('Video size must not exceed 500 MB');

                        valid = false;
                    }
                }

                if (!valid) {
                    return false;
                }

                this.submit();
            });

        });
    </script>
@endsection
