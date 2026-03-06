@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center">Add T.A Bill & CLO Report</h2>
    <form action="{{url('/')}}/clo/tabill" method="POST" id="schoolForm" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <div class="row">
            <div class="form-group col-md-6">
                
                <a href="{{ url('/files/examcenter/DailyReportCLO-1.pdf') }}" style="bottom:50px;top:10px;" class="btn  mb-2 btn-primary btn-xs pull-left">Clo Report Form</a>
            </div>
            <div class="form-group col-md-6">
                <a href="{{ url('/files/examcenter/TABILL/tabill.pdf') }}"  style="bottom:50px;top:10px;" class="btn  mb-2 btn-primary btn-xs pull-left">Tabill Request Form</a>
            </div>
            

            {{-- <div class="form-group col-md-6">
                <label for="account_number">Total Amount</label>
                <input type="text" class="form-control" required name="demand_amount" id="demand_amount" onkeypress="return /[0-9]/.test(event.key)">
            </div>
            <div class="form-group col-md-6">
                <label for="bank_name">Official Bank Name</label>
                <select name="bank_name" class="form-control" id="bank_name" required>
                    <option value="">Please Select</option>
                    @foreach ($banks as $bank)
                        <option value="{{$bank->id}}">{{$bank->bankname}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="account_holder_name">Account Holder's Name</label>
                <input type="text" class="form-control" required name="account_holder_name" id="account_holder_name">
            </div>
            <div class="form-group col-md-6">
                <label for="account_number">Account Number</label>
                <input type="text" class="form-control" required name="account_number" id="account_number" onkeypress="return /[0-9]/.test(event.key)">
            </div>
            <div class="form-group col-md-6">
                <label for="branch">Branch</label>
                <input type="text" class="form-control" required name="branch" id="branch">
            </div>
            <div class="form-group col-md-6">
                <label for="ifsc_code">IFSC Code</label>
                <input type="text" class="form-control" required name="ifsc_code" id="ifsc_code">
            </div> --}}
            <div class="form-group col-md-6">
                <label for="consent_form">Clo Report</label>
                <input type="file" class="form-control" id="filename" name="clo_report" required accept=".jpg, .jpeg, .png, .pdf" onchange="validateFile()">
                <small class="form-text text-muted">Please fill out the Daily CLO Report Form and upload it in a Single File</small>
                <div id="error-message" style="color: red; display: none;"></div>
            </div>

            <div class="form-group col-md-6">
                <label for="consent_form">Upload T.A Bill Form</label>
                <input type="file" class="form-control" id="filename" name="ta_form" required accept=".jpg, .jpeg, .png, .pdf" onchange="validateFile()">
                <small class="form-text text-muted">Please Fill T.A Form and Upload with Receipt in a Single File</small>

                <div id="error-message" style="color: red; display: none;"></div>
            </div>
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

        </div>
    </form>
</div>

<script>
 function validateFile() {
        var fileInput = document.getElementById('consent_form');
        var filePath = fileInput.value;
        var fileSize = fileInput.files[0] ? fileInput.files[0].size : 0; // Get file size in bytes
        var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.pdf)$/i;
        var errorMessage = document.getElementById('error-message');

        // Check file extension
        if (!allowedExtensions.exec(filePath)) {
            errorMessage.textContent = "Please upload a valid file (JPG, JPEG, PNG, or PDF).";
            errorMessage.style.display = 'block';
            fileInput.value = ''; // Reset the input
            return false;
        }
        
        // Check file size (2MB = 2 * 1024 * 1024 bytes)
        if (fileSize > 2 * 1024 * 1024) {
            errorMessage.textContent = "File size must not exceed 2MB.";
            errorMessage.style.display = 'block';
            fileInput.value = ''; // Reset the input
            return false;
        }

        // If validation passes, clear error message
        errorMessage.style.display = 'none';
        return true;
    }
</script>
@endsection
