@extends('layouts.app')

@section('content')
<style>
    .main_div {
        max-width: 800px;
        background: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    h4 {
        font-size: 24px;
        margin-bottom: 20px;
        color: #4A4A4A;
    }
</style>
<div class="container main_div">
    <div class="row">
        <div class="col-md-12">
            @if (Session::has('messages') )
            <div class="alert alert-success">
                <ul>
                    <li>{{Session::get('messages')}}</li>
                </ul>
            </div>
            @endif
            @include('common.errorandmsg')

            <h4 class="text-center"> Grievance</h4>
            <form action="{{url('grievances-save')}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="form-group">
                    <label>Are You a Student?</label><br>
                    <input type="radio" id="is_student_yes" name="is_student" value="1">
                    <label for="is_student_yes">YES</label>
                    <input type="radio" id="is_student_no" name="is_student" value="0">
                    <label for="is_student_no">NO</label><br>
                </div>
                
                <div class="form-group" id="block_display" style="display:none;">
                    <label for="contactperson" class="control-label">PRN No</label>
                    <input type="text" maxlength="20" name="prn" class="form-control"placeholder="Enter Permanent Registation No">
                </div>
                
                <script>
                    // Get all the radio buttons by name
                    var studentRadios = document.querySelectorAll('input[name="is_student"]');
                    
                    studentRadios.forEach(function(radio) {
                        radio.addEventListener('change', function() {
                            var otherReasonField = document.getElementById('block_display');
                            var selectedValue = this.value;
                            
                            // Show or hide the input field based on selection
                            if (selectedValue === '1') {
                                otherReasonField.style.display = 'block'; // Show input field for other reason
                            } else {
                                otherReasonField.style.display = 'none'; // Hide input field for other reason
                            }
                        });
                    });
                </script>
                <div class="form-group">
                    <label for="contactperson" class="control-label">Name</label>
                    <input type="text" name="contactperson" class="form-control"
                        placeholder="Enter contact person name" maxlength="50" required>
                </div>
               


                {{-- <div class="form-group">
                    <label for="contactperson" class="control-label">Contact Person</label>
                    <input type="text" name="contactperson" class="form-control"
                        placeholder="Enter contact person name">
                </div> --}}

                <div class="form-group">
                    <label for="contactnumber" class="control-label">Contact Number</label>
                    <input type="text" name="contactnumber" class="form-control"  maxlength="10" placeholder="Enter contact number"
                        required>
                </div>
                <div class="form-group">
                    <label for="issuetype" class="control-label">Grievance Type</label>
                    <select class="form-control" name="issuetype" id="issuetype" required>
                        <option value="0" selected disabled>Please choose a grievance type...</option>
                        <option value="Personal_details">Personal Details Correction</option>
                        <option value="Marks_and_certificate">Marks & Certificate Related Issue</option>
                        <option value="Payment">Payment Related Issues</option>
                        <option value="AdmitCard">Admit Card Related Issues</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                
                <div class="form-group" id="otherReasonField" style="display:none;">
                    <label for="otherReason" class="control-label">Please specify the Grievance</label>
                    <input type="text" class="form-control" name="otherreason" id="otherreason" />
                </div>



                <script>
                    document.getElementById('issuetype').addEventListener('change', function() {
                        var otherReasonField = document.getElementById('otherReasonField');
                        var selectedValue = this.value;
                        
                        if (selectedValue === 'Other') {
                            otherReasonField.style.display = 'block'; // Show input field for other reason
                        } else {
                            otherReasonField.style.display = 'none'; // Hide input field for other reason
                        }
                    });
                    
                </script>


                <div class="form-group">
                    <label for="nber_id" class="control-label">NBER</label>
                    <select class="form-control" name="nber_id" required id="nber_id">
                        <option value="" selected disabled>Please select</option>
                        @foreach($nbers as $n)
                        <option value="{{$n->id}}">{{$n->name_code}}</option>
                        @endforeach
                        <option value="0">NBER Delhi</option>

                    </select>
                </div>
                <div class="form-group">
                    <label for="academicyear_id" class="control-label">Batch</label>
                    <select class="form-control" name="academicyear_id" required id="academicyear_id">
                        <option value="" selected disabled>Please select</option>
                        @foreach($academicyear as $n)
                        <option value="{{$n->id}}">{{$n->year}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="issuetype" class="control-label">Institute Name</label>
                    <select class="form-control js-states" id="institute_id" name="institute_id" required>
                        <option value="">Please choose a grievance type...</option>
                        @foreach($institute as $n)
                        <option value="{{$n->id}}">{{$n->name}} {{$n->rci_code}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="programme_id" class="control-label">Programme</label>
                    <select class="form-control" name="programme_id" required id="programme_id">
                        <option value="" selected disabled>Please select</option>
                        {{-- @foreach($prgms as $p)
                            <option value="{{$p->id}}">{{$p->course_name}}</option>
                        @endforeach --}}
                    </select>
                </div>

                <div class="form-group">
                    <label for="comment" class="control-label">Issue Description</label>
                    <small>Not Exceed 500 Characters</small>
                    <textarea name="comment" class="form-control" maxlength="500"
                        placeholder="Enter your comment or details here..."></textarea>
                </div>

                {{-- <div class="form-group">
                    <label for="attachment" class="control-label">Attachment</label>
                    <input type="file" name="attachment" class="form-control" required accept=".pdf,.doc,.docx,.jpg,.jpeg">
                    <small id="fileHelp" class="form-text text-muted"></small>

                </div> --}}

                <div class="text-right">
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>

            </form>
        </div>
    </div>
</div>
{{-- <script>
    document.getElementById('attachment').addEventListener('change', function () {
        const file = this.files[0];
        const allowedTypes = ['application/pdf', 'application/msword', 
                              'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                              'image/jpeg'];
        const maxSize = 1 * 1024 * 1024; // 5 MB
        const helpText = document.getElementById('fileHelp');

        if (!allowedTypes.includes(file.type)) {
            helpText.textContent = 'Invalid file type. Allowed: PDF, DOC, DOCX, JPG, PNG.';
            this.value = ''; // Clear the input
        } else if (file.size > maxSize) {
            helpText.textContent = 'File is too large. Maximum size is 1MB.';
            this.value = '';
        } else {
            helpText.textContent = '';
        }
    });
</script> --}}
<!-- Select2 CSS -->
{{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

<!-- Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="{{asset('packages\jquery\jquery-3.6.0.min.js')}}"></script> --}}

<script>
    $("#institute_id").select2({
        placeholder: "Please Select",
        allowClear: true
    });
</script>
<script>
    $(document).ready(function() {
        //         $('#nber_id,academicyear_id').change(function() {
        //     var nberId = $('#nber_id').val();
        //     var academicYearId = $('#academicyear_id').val();
        // if (nberId && academicYearId) {
        //     $.ajax({
        //         url: '{{url('/get-institute')}}',  
        //         method: 'POST',
        //         data: { 
        //             academic_year_id: academicYearId,
        //             nber_id: nberId
        //         },
        //         headers: {
        //         'X-CSRF-TOKEN': '{{ csrf_token() }}'  // Pass CSRF token
        //     },
        //         success: function(response) {
        //             $('#institute_id').empty();
        //             $('#institute_id').append('<option value="" selected disabled>Please select</option>');
        //             $.each(response.institute, function(index, programme) {
        //                 $('#institute_id').append('<option value="'+institute.id+'">'+institute.name+'</option>');
        //             });
        //         },
        //         error: function() {
        //             alert('Error fetching institute');
        //         }
        //     });
        // } else {
        //     // If not both selected, clear the programme dropdown
        //     $('#institute_id').empty();
        //     $('#institute_id').append('<option value="" selected disabled>Please select</option>');
        // }
        // });
        $('#academicyear_id, #nber_id, #institute_id').change(function() {
            var institute_id = $('#institute_id').val();
            var academicYearId = $('#academicyear_id').val();
            var nberId = $('#nber_id').val();
            if (academicYearId && nberId && institute_id) {
                $.ajax({
                    url: '{{url('/get-programmes')}}',
                    method: 'POST',
                    data: {
                        academic_year_id: academicYearId,
                        nber_id: nberId,
                        institute_id: institute_id
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Pass CSRF token
                    },
                    success: function(response) {
                        $('#programme_id').empty();
                        $('#programme_id').append(
                            '<option value="" selected disabled>Please select</option>');
                        $.each(response.programmes, function(index, programme) {
                            $('#programme_id').append('<option value="' + programme
                                .id + '">' + programme.abbreviation +
                                '</option>');
                        });
                    },
                    error: function() {
                        alert('Error fetching programmes');
                    }
                });
            } else {
                // If not both selected, clear the programme dropdown
                $('#programme_id').empty();
                $('#programme_id').append('<option value="" selected disabled>Please select</option>');
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#nber_id, #academicyear_id').change(function() {
            var nberId = $('#nber_id').val();
            var academicYearId = $('#academicyear_id').val();
            if (nberId && academicYearId) {
                $.ajax({
                    url: '{{url('/get-institute')}}',
                    method: 'POST',
                    data: {
                        academic_year_id: academicYearId,
                        nber_id: nberId
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Pass CSRF token
                    },
                    success: function(response) {
                        $('#institute_id').empty();
                        $('#institute_id').append(
                            '<option value="" selected disabled>Please select</option>');
                        $.each(response.institute, function(index, institute) {
                            $('#institute_id').append('<option value="' + institute
                                .id + '">' + institute.name + '</option>');
                        });
                    },
                    error: function() {
                        alert('Error fetching institute');
                    }
                });
            } else {
                // If not both selected, clear the programme dropdown
                $('#institute_id').empty();
                $('#institute_id').append('<option value="" selected disabled>Please select</option>');
            }
        });
    });
</script>
@endsection