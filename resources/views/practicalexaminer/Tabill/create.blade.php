@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Add T.A Bill & CLO Report</h2>
    
    <form action="{{ url('/') }}/faculty/tabill" method="POST" enctype="multipart/form-data" id="schoolForm">
        {!! csrf_field() !!}
        <div class="row">
            <!-- Download Buttons -->
            {{-- <div class="form-group col-md-6">
                <a href="{{ url('/files/examcenter/DailyReportCLO-1.pdf') }}" class="btn btn-primary mb-3">Download CLO Report Form</a>
            </div> --}}
            <div class="form-group col-md-6">
                <a href="{{ url('/files/examcenter/TABILL/tabill.pdf') }}" class="btn btn-primary mb-3">Download TA Bill Request Form</a>
            </div>

            <!-- NBER Selection -->
            <div class="form-group col-md-6">
                <label for="nber_id">NBER</label>
                <select class="form-control" name="nber_id" id="nber_id" required>
                    <option value="" selected disabled>Please select</option>
                    @foreach($nbers as $n)
                        <option value="{{ $n->id }}">{{ $n->name_code }}</option>
                    @endforeach
                </select>
            </div>

             <!-- NBER Selection -->
            <div class="form-group col-md-6">
                <label for="nber_id">Payment For</label>
                <select class="form-control" name="payment_for" id="payment_for" required>
                    <option value="" selected disabled>Please select</option>
                        <option value="Paractical Examiner">Paractical Examiner</option>
                        {{-- <option value="Clo">Clo</option>
                        <option value="Evaluator">Evaluator</option>
                        <option value="Others">Others</option> --}}

                </select>
            </div>
            
            <!-- CLO Report Upload -->
            <div class="form-group col-md-6">
                <label for="clo_report">Report</label>
                <input type="file" class="form-control" id="clo_report" name="clo_report" required accept=".pdf" onchange="validateFile(this)">
                <small class="form-text text-muted">Upload completed Report as a single file.</small>
                <div class="text-danger mt-1" id="clo_report_error" style="display: none;"></div>
            </div>

            <!-- TA Bill Upload -->
            <div class="form-group col-md-6">
                <label for="ta_form">Upload T.A Bill Form</label>
                <input type="file" class="form-control" id="ta_form" name="ta_form" required accept=".jpg, .jpeg, .png, .pdf" onchange="validateFile(this)">
                <small class="form-text text-muted">Upload filled T.A form with receipt as a single file.</small>
                <div class="text-danger mt-1" id="ta_form_error" style="display: none;"></div>
            </div>

            <!-- Submit Button -->
            <div class="form-group col-md-12 mt-3">
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </div>
    </form>
</div>

<!-- File Validation Script -->
<script>
    function validateFile(input) {
        const file = input.files[0];
        const allowedExtensions = /(\.jpg|\.jpeg|\.png|\.pdf)$/i;
        const errorContainer = document.getElementById(`${input.id}_error`);

        errorContainer.style.display = 'none';
        errorContainer.textContent = '';

        if (file) {
            const filePath = input.value;
            const fileSize = file.size;

            // Check extension
            if (!allowedExtensions.exec(filePath)) {
                errorContainer.textContent = 'Only JPG, JPEG, PNG, or PDF files are allowed.';
                errorContainer.style.display = 'block';
                input.value = '';
                return false;
            }

            // Check file size (2MB max)
            if (fileSize > 2 * 1024 * 1024) {
                errorContainer.textContent = 'File size must not exceed 2MB.';
                errorContainer.style.display = 'block';
                input.value = '';
                return false;
            }
        }

        return true;
    }
</script>
@endsection
