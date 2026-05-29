@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top:30px;">

        <div class="row">

            <div class="col-md-8 col-md-offset-2">

                <div class="panel panel-primary">

                    <div class="panel-heading text-center">
                        <h3 class="panel-title">Committee Decision</h3>
                    </div>

                    <div class="panel-body">

                        <form id="decisionForm" action="{{ url('/nber/malpractice/decision/store/' . $malpractice->id) }}"
                            method="POST" enctype="multipart/form-data">

                            {{ csrf_field() }}

                           
                            <div class="form-group">

                                <label>Committee Decision </label>

                                <textarea name="malpractice_committee_decision" id="malpractice_committee_decision" class="form-control" rows="3"></textarea>

                                <span id="malpractice_committee_decision_error" style="color:red;"></span>

                            </div>

                           
                            <div class="form-group">
                                <label>Committee Action </label>
                                <select name="committee_action" id="committee_decision" class="form-control">
                                    <option value="">Select Decision</option>
                                    <option value="1" {{ old('active', $malpractice->active ?? '') == '1' ? 'selected' : '' }}>Not Clear malpractice</option>
                                    <option value="0" {{ old('active', $malpractice->active ?? '') == '0' ? 'selected' : '' }}>Clear malpractice</option>
                                </select>

                                <span id="committee_decision_error" style="color:red;"></span>

                            </div>

                           
                            <div class="form-group">
                                <label>Committee Decision Report</label>
                                <input type="file" name="committee_decision_report" id="committee_decision_report"
                                    class="form-control">
                                <span id="committee_decision_report_error" style="color:red;"></span>
                            </div>

                            <!-- Submit -->
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
        document.getElementById('decisionForm').addEventListener('submit', function(e) {

            // Clear old errors
            document.getElementById('malpractice_committee_decision_error').innerHTML = '';
            document.getElementById('committee_decision_error').innerHTML = '';
            document.getElementById('committee_decision_report_error').innerHTML = '';

            let isValid = true;

            
            let note = document.getElementById('malpractice_committee_decision').value.trim();
            let decision = document.getElementById('committee_decision').value;
            let fileInput = document.getElementById('committee_decision_report');

            if (note === '') {
                document.getElementById('malpractice_committee_decision_error')
                    .innerHTML = 'Committee decision  is required';
                isValid = false;
            }

           
            if (decision === '') {
                document.getElementById('committee_decision_error')
                    .innerHTML = 'Please select committee decision';
                isValid = false;
            }


            if (fileInput.files.length === 0) {
                document.getElementById('committee_decision_report_error')
                    .innerHTML = 'Please upload committee decision report';
                isValid = false;
            }

            if (fileInput.files.length > 0) {
                let file = fileInput.files[0];
                let allowedExtension = /(\.pdf)$/i;

                if (!allowedExtension.exec(file.name)) {

                    document.getElementById('committee_decision_report_error')
                        .innerHTML = 'Only PDF file is allowed';

                    isValid = false;
                }
                let maxSize = 2 * 1024 * 1024;

                if (file.size > maxSize) {

                    document.getElementById('committee_decision_report_error')
                        .innerHTML = 'File size must be less than 2 MB';

                    isValid = false;
                }
            }

            // Prevent form submit
            if (!isValid) {
                e.preventDefault();
            }

        });
    </script>
@endsection
