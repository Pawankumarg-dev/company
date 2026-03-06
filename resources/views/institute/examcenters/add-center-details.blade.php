@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center" style="margin-top: 10px;">DECLARATION / CONSENT FORM </h2>
        <h3 class="text-center" style="margin-top: 10px;">(Declaring Govt. / CBSE direct affiliated School as Examination Center for Certificate & Diploma level examinations to be conducted by NBER-RCI, New Delhi between 15 - 30 June 2025)</h3>
        
    <form action="{{ url('/') }}/institute/examcenters" method="POST" id="schoolForm" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <div class="row">
            <input type="hidden" name="institute_id" value="{{$institute_location->id}}">

            <!-- School Name -->
            <div class="form-group col-md-12">
                <label for="school_name">Name of the Govt. / CBSE direct affiliated school</label>
                <input type="text" class="form-control" required onkeypress="return /[A-Z0-9a-z_ ,.]/.test(event.key)" name="name" id="school_name">
            </div>
            <!-- State -->
            <div class="form-group col-md-4">
                <label for="state">State</label>
                <select name="lgstate_id" class="form-control" id="state_id" required>
                    <option value="">Please Select</option>
                    @foreach ($states as $state)
                        <option value="{{$state->id}}">{{$state->state_name}}</option>
                    @endforeach
                </select>
            </div>

            <!-- District -->
            <div class="form-group col-md-4">
                <label for="district">District</label>
                <select name="district" class="form-control" id="district_id" required>
                    <option value="">Please Select</option>
                    @foreach ($districts as $district)
                        <option value="{{$district->id}}">{{$district->districtName}}</option>
                    @endforeach
                </select>
            </div>

            <!-- Subdistrict -->
            <div class="form-group col-md-4">
                <label for="subdistrict">Subdistrict</label>
                <select name="subdistrict" class="form-control" id="subdistrict_id" required>
                    <option value="">Please Select</option>
                    @foreach ($subdistricts as $subdistrict)
                        <option value="{{$subdistrict->id}}">{{$subdistrict->District_Name}}</option>
                    @endforeach
                </select>
            </div>

            <!-- Village -->
            <div class="form-group col-md-4">
                <label for="village">Village/block</label>
                <select name="village" class="form-control" id="village_id">
                    <option value="">Please Select</option>
                    @foreach ($villages as $village)
                        <option value="{{$village->id}}">{{$village->Block_Name}}</option>
                    @endforeach
                </select>
            </div>

            <!-- Address -->
            <div class="form-group col-md-4">
                <label for="address">Address</label>
                <input type="text" class="form-control" required name="address" onkeypress="return /[A-Z0-9a-z_ ,./-]/.test(event.key)" id="address">
            </div>
            <!-- Pincode -->
            <div class="form-group col-md-4">
                <label for="pincode">Pincode</label>
                <input type="text" class="form-control" required onkeypress="return /[0-9]/.test(event.key)" name="pincode" maxlength="6" id="pincode" oninput="validatePin()">
            </div>  
            
            <!-- Latitude -->
            <div class="form-group col-md-6">
                <label for="latitudeInput" class="form-label">Latitude</label>
                <input type="text" class="form-control" required id="latitudeInput" name="latitude" onkeypress="return /[0-9.]/.test(event.key)" placeholder="Enter latitude (e.g., 40.748817)">
                <small class="form-text text-muted">Enter a value between 8 and 38.</small>
            </div>

            <!-- Longitude -->
            <div class="form-group col-md-6">
                <label for="longitudeInput" class="form-label">Longitude</label>
                <input type="text" class="form-control" required id="longitudeInput" name="longitude" onkeypress="return /[0-9.]/.test(event.key)" placeholder="Enter longitude (e.g., -73.985428)">
                <small class="form-text text-muted">Enter a value between 68 and 98.</small>
            </div> 
          
            <!-- Principal's Name -->
            <div class="form-group col-md-3">
                <label for="principal_name">Principal's Name</label>
                <input type="text" class="form-control" required name="principal_name" onkeypress="return /[A-Za-z_ ,./-]/.test(event.key)" id="principal_name">
            </div>

            <!-- Principal's Email -->
            <div class="form-group col-md-3">
                <label for="principal_email">Principal's Email</label>
                <input type="email" class="form-control" required name="email1" id="principal_email">
            </div><br>

            <!-- Principal's Mobile -->
            <div class="form-group col-md-3">
                <label for="principal_mobile">Principal's Mobile</label>
                <input type="text" class="form-control" required name="principal_mobile" maxlength="10" id="principal_mobile" onkeypress="return /[0-9]/.test(event.key)">
            </div>

            <!-- Principal's WhatsApp -->
            <div class="form-group col-md-3">
                <label for="principal_whatsapp">Principal's WhatsApp</label>
                <input type="text" class="form-control" required name="principal_whatsapp" maxlength="10" id="principal_whatsapp" onkeypress="return /[0-9]/.test(event.key)">
            </div>

            <!-- Alternative Contact Person -->
            <div class="form-group col-md-3">
                <label for="alternative_contact_person">Alternative Contact Person</label>
                <input type="text" class="form-control" required name="contactperson" id="alternative_contact_person">
            </div>

            <!-- Alternative Designation -->
            <div class="form-group col-md-3">
                <label for="alternative_designation">Alternative Contact Person Designation</label>
                <input type="text" class="form-control" required name="alternative_designation" id="alternative_designation">
            </div>

            <!-- Alternative Contact Email -->
            <div class="form-group col-md-3">
                <label for="alternative_contact_email">Alternative Contact Person Email</label>
                <input type="email" class="form-control" required name="email2" id="email2">
            </div>

            <!-- Alternative Contact Mobile -->
            <div class="form-group col-md-3">
                <label for="alternative_contact_mobile">Alternative Contact Person Mobile</label>
                <input type="text" class="form-control" required name="contactnumber1" maxlength="10" onkeypress="return /[0-9]/.test(event.key)" id="alternative_contact_mobile">
            </div>

            <!-- Alternative Contact WhatsApp -->
            <div class="form-group col-md-3">
                <label for="alternative_contact_whatsapp">Alternative Contact Person WhatsApp</label>
                <input type="text" class="form-control" required name="contactnumber2" maxlength="10" onkeypress="return /[0-9]/.test(event.key)" id="alternative_contact_whatsapp">
            </div>

           
            <div class="box">
            <!-- Principal as Superintendent in-Chief -->
            <div class="form-group col-md-6">
                <label for="principal-superintendent"> The school consents that the Principal shall work as the Superintendent in-Chief on all the days of the exam</label><br>
                <input type="radio" id="principal-superintendent-yes" name="superintendent" value="1" onclick="checkSelection()" required>
                <label for="principal-superintendent-yes">Yes</label>
                <input type="radio" id="principal-superintendent-no" name="superintendent" value="0" onclick="checkSelection()" required>
                <label for="principal-superintendent-no">No</label>
            </div>

        <!-- Staff for Exam Centre Superintendent -->
        <div class="form-group col-md-6">
            <label for="exam-centre-superintendent">The school confirms that it has staff to work as the Exam Centre Superintendent to coordinate and monitor all exam activities under Superintendent in-Chief on all the days of the exam</label><br>
            <input type="radio" id="exam-centre-superintendent-yes" name="superintendent_declearation" value="1" onclick="checkSelection()" required>
            <label for="exam-centre-superintendent-yes">Yes</label>
            <input type="radio" id="exam-centre-superintendent-no" name="superintendent_declearation" value="0" onclick="checkSelection()" required>
            <label for="exam-centre-superintendent-no">No</label>
        </div>
        <h4 style="font-weight: bold">If these mandatory provisions are not available, form may not be filled further.</h4>

        </div>
        </div>
        <div class="row" id="checkSelection" style="display:none;">
            <div class="box">
                 <!-- Setting Capacity -->
            <div class="form-group col-md-6">
                <label for="setting_capacity">Seatting Capacity Per Room <small class="form-text text-muted">one student on each bench</small>
                </label>
                <input type="number" class="form-control" required required name="seats_per_room" onkeypress="return /[0-9]/.test(event.key)" id="setting_capacity">
                
            </div>

            <!-- Seats Per Room -->
            <div class="form-group col-md-6">
                <label for="seats_per_room">Number of Avilable Classrooms</label>
                <input type="number" class="form-control" name="classroom_count" onkeypress="return /[0-9]/.test(event.key)"  id="seats_per_room">
            </div>
            <hr style='border: 1'>
        <!-- Examination Session Capacity -->
        <div class="form-group col-md-6">
            <label for="exam-session-capacity"> The school is capable to conduct exam for at a time in one session for minimum</label><br>
            <input type="radio" id="100-students" name="session_min_capacity" value="100" required>
            <label for="100-students">100 students</label>
            <input type="radio" id="300-students" name="session_min_capacity" value="300" required>
            <label for="300-students">300 students</label>
            <input type="radio" id="500-students" name="session_min_capacity" value="500" required>
            <label for="500-students">500 students</label>
            <input type="radio" id="more-than-500-students" name="session_min_capacity" value="more-than-500" required>
            <label for="more-than-500-students">More than 500 students</label>
        </div>
        <!-- Classroom and Invigilator Availability -->
        <div class="form-group col-md-6">
            <label for="classrooms"> The School has classrooms with the capacity of 30 students (one on each bench) and invigilators as per scheme of examination of NERB for the exam.</label><br>
            <input type="radio" id="5-classrooms" name="classrooms" value="5" required>
            <label for="5-classrooms"> 5 classrooms</label>
            <input type="radio" id="15-classrooms" name="classrooms" value="15" required>
            <label for="15-classrooms">15 classrooms</label>
            <input type="radio" id="25-classrooms" name="classrooms" value="25" required>
            <label for="25-classrooms">25 classrooms</label>
        </div>
        <hr style='border: 1'>
        <!-- Separate Washrooms -->
        <div class="form-group col-md-6">
            <label for="washrooms"> The school has separate washrooms for boys and girls</label><br>
            <input type="radio" id="washrooms-yes" name="washrooms" value="1" required>
            <label for="washrooms-yes">Yes</label>
            <input type="radio" id="washrooms-no" name="washrooms" value="0" required>
            <label for="washrooms-no">No</label>
        </div>

        <!-- CCTV Facility -->
        <div class="form-group col-md-6">
            <label for="cctv-facility"> The school has CCTV facilities with recording in working condition in all classrooms</label><br>
            <input type="radio" id="cctv-facility-yes" name="cctv_facility" value="1" required>
            <label for="cctv-facility-yes">Yes</label>
            <input type="radio" id="cctv-facility-no" name="cctv_facility" value="0" required>
            <label for="cctv-facility-no">No</label>
        </div>
        <hr style='border: 1'>
        <!-- Computers for Examination Use -->
        <div class="form-group col-md-6">
            <label for="computers"> The school has computers with Windows 10 & above version with a minimum 50 Mbps Broadband Internet facility for the purpose of exams</label><br>
            <input type="radio" id="2-computers" name="computers" value="2" required>
            <label for="2-computers">2 computers</label>
            <input type="radio" id="3-computers" name="computers" value="3" required>
            <label for="3-computers">3 computers</label>
            <input type="radio" id="5-computers" name="computers" value="5" required>
            <label for="5-computers">5 computers</label>
        </div>

        <!-- Laser Printers for Question Papers -->
        <div class="form-group col-md-6">
            <label for="printers"> The school has laser printers in working condition for printing question papers on the day of the exam</label><br>
            <input type="radio" id="2-printers" name="printers" value="2" required>
            <label for="2-printers">2 printers</label>
            <input type="radio" id="3-printers" name="printers" value="3" required>
            <label for="3-printers">3 printers</label>
            <input type="radio" id="5-printers" name="printers" value="5" required>
            <label for="5-printers">5 printers</label>
        </div>
        <hr style='border: 1'>
        <!-- Photocopy Machines for Question Papers -->
        <div class="form-group col-md-6">
            <label for="photocopiers"> The school has high-density photocopy machines in working condition for making copies of question papers</label>
            <input type="radio" id="1-photocopier" name="photocopiers" value="1" required>
            <label for="1-photocopier">1 photocopier</label>
            <input type="radio" id="2-photocopiers" name="photocopiers" value="2" required>
            <label for="2-photocopiers">2 photocopiers</label>
            <input type="radio" id="4-photocopiers" name="photocopiers" value="4" required>
            <label for="4-photocopiers">4 photocopiers</label>  
        </div>

        <!-- High-Speed Scanners -->
        <div class="form-group col-md-6">
            <label for="scanners"> The school has high-speed scanners in working condition for scanning attendance sheets, etc. on the day of the exam</label><br>
            <input type="radio" id="2-scanners" name="scanners" value="2" required>
            <label for="2-scanners">2 scanners</label>
            <input type="radio" id="3-scanners" name="scanners" value="3" required>
            <label for="3-scanners">3 scanners</label>
            <input type="radio" id="4-scanners" name="scanners" value="4" required>
            <label for="4-scanners">4 scanners</label>
        </div>
        <hr>
        <!-- Support Staff -->
        <div class="form-group col-md-6">
            <label for="support-staff"> The school has support staff available for room cleaning, providing water, courier of answer booklets, etc.</label><br>
            <input type="radio" id="2-support-staff" name="support_staff" value="2" required>
            <label for="2-support-staff">2 staff</label>
            <input type="radio" id="4-support-staff" name="support_staff" value="4" required>
            <label for="4-support-staff">4 staff</label>
            <input type="radio" id="6-support-staff" name="support_staff" value="6" required>
            <label for="6-support-staff">6 staff</label>
            
            
        </div>

        <!-- Technical Staff -->
        <div class="form-group col-md-6">
            <label for="technical-staff">The school has technical staff for computer operating, IT-related work, etc.</label><br>
            <input type="radio" id="2-technical-staff" name="technical_staff" value="2" required>
            <label for="2-technical-staff">2 staff</label>
            <input type="radio" id="4-technical-staff" name="technical_staff" value="4" required>
            <label for="4-technical-staff">4 staff</label>
            <input type="radio" id="6-technical-staff" name="technical_staff" value="6" required>
            <label for="6-technical-staff">6 staff</label>
            
            
        </div>
        <hr>
        <!-- Accessibility Facilities -->
        <div class="form-group col-md-6">
            <label for="accessibility">The school has adequate facilities meeting the accessibility norms for children with special needs</label><br>
            <input type="checkbox" id="ramp" name="accessibility[]" value="Ramp" >
            <label for="ramp">Ramp</label>
            <input type="checkbox" id="disabled-friendly-toilets" name="accessibility[]" value="Disabled-friendly toilets" >
            <label for="disabled-friendly-toilets">Disabled-friendly toilets</label>
            <input type="checkbox" id="lift" name="accessibility[]" value="Lift" >
            <label for="lift">Lift</label>
            <input type="checkbox" id="speaker-system" name="accessibility[]" value="Speaker system" >
            <label for="speaker-system">Speaker system</label>
            <input type="checkbox" id="all" name="accessibility[]" value="All" >
            <label for="all">All</label>
        </div>

        <!-- Drinking Water Facility -->
        <div class="form-group col-md-6">
            <label for="drinking-water">The school has proper and adequate drinking water facilities</label><br>
            <input type="radio" id="ground-floor" name="drinking_water" value="ground-floor" required>
            <label for="ground-floor">At ground floor</label>
            <input type="radio" id="all-floors" name="drinking_water" value="all-floors" required>
            <label for="all-floors">On all floors</label>
        </div>
        <hr style='border: 1'>
        <!-- Security Guards -->
        <div class="form-group col-md-6">
            <label for="security-guards">The school has full-time security/guard</label><br>
            <input type="radio" id="1-guard" name="security_guards" value="1" required>
            <label for="1-guard">1 guard at a time</label>
            <input type="radio" id="2-guards" name="security_guards" value="2" required>
            <label for="2-guards">2 guards at a time</label>
            <input type="radio" id="4-guards" name="security_guards" value="4" required>
            <label for="4-guards">4 guards at a time</label>
        </div>

        <!-- Open Space/Ground Availability -->
        <div class="form-group col-md-6">
            <label for="open-space">The school has an open space/ground attached</label><br>
            <input type="radio" id="open-space-yes" name="open_space" value="1" required>
            <label for="open-space-yes">Yes</label>
            <input type="radio" id="open-space-no" name="open_space" value="0" required>
            <label for="open-space-no">No</label>
        </div>
        <hr style='border: 1'>
        <!-- Special Permissions -->
        <div class="form-group col-md-6">
            <label for="special-permissions">Any special permissions required to access the facilities on the day of the exam?</label><br>
            <input type="radio" id="special-permissions-yes" name="permission" value="1" onclick="checkSelection2()" required>
            <label for="special-permissions-yes">Yes</label>
            <input type="radio" id="special-permissions-no" name="permission" value="0" onclick="checkSelection2()" required>
            <label for="special-permissions-no">No</label><br>
            
        </div>
        <div class="form-group col-md-6" id="checkSelection2" style="display: none">
                <label for="special-permissions-details">If Yes, specify</label><br>
                <textarea id="special-permissions-details" name="special_permissions_details" rows="4" cols="50"></textarea>            
        </div>
        </div>
    </div>
         <!-- Nearest Police Station -->
         <div class="form-group col-md-6">
            <label for="nearest_police_station">Nearest Police Station</label>
            <input type="text" class="form-control" required name="nearest_police_station" onkeypress="return /[A-Z0-9a-z_ ,./-]/.test(event.key)" id="nearest_police_station">
        </div>
       
        <!-- Nearest Post Office -->
        <div class="form-group col-md-6">
            <label for="nearest_post_office">Nearest Post Office</label>
            <input type="text" class="form-control" required name="nearest_post_office" onkeypress="return /[A-Z0-9a-z_ ,./-]/.test(event.key)" id="nearest_post_office">
        </div>
        <h4 style="font-weight: bold">Details of DIOS / District level Officer/ any other govt. officials (jurisdiction of the school):</h4>
            <!-- District Officer's Name -->
            <div class="form-group col-md-6">
                <label for="district_officer_name">DIOS / District level Officer/ any other govt. officials</label>
                <input type="text" class="form-control" required name="district_officer_name" id="district_officer_name">
            </div>

            <!-- District Officer's Mobile -->
            <div class="form-group col-md-6">
                <label for="district_officer_mobile">District Officer's Mobile</label>
                <input type="text" class="form-control" required name="district_officer_mobile" id="district_officer_mobile" maxlength="10" onkeypress="return /[0-9]/.test(event.key)">
            </div>
<h4 style="font-weight: bold">Bank Details of the school</h4>


            <!-- Official Bank Name -->
            <div class="form-group col-md-6">
                <label for="bank_name">Official Bank Name</label>
                <select name="bank_name" class="form-control" id="bank_name" required>
                    <option value="">Please Select</option>
                    @foreach ($banks as $bank)
                        <option value="{{$bank->id}}">{{$bank->bankname}}</option>
                    @endforeach
                </select>
            </div>

            <!-- Account Holder's Name -->
            <div class="form-group col-md-6">
                <label for="account_holder_name">Account Holder's Name</label>
                <input type="text" class="form-control" required name="account_holder_name" id="account_holder_name">
            </div>

            <!-- Account Number -->
            <div class="form-group col-md-4">
                <label for="account_number">Account Number</label>
                <input type="text" class="form-control" required name="account_number" id="account_number" onkeypress="return /[0-9]/.test(event.key)">
            </div>

            <!-- Branch -->
            <div class="form-group col-md-4">
                <label for="branch">Branch</label>
                <input type="text" class="form-control" required name="branch" id="branch">
            </div>

            <!-- IFSC Code -->
            <div class="form-group col-md-4">
                <label for="ifsc_code">IFSC Code</label>
                <input type="text" class="form-control" required name="ifsc_code" id="ifsc_code">
            </div>

            {{-- <!-- Hotel Nearby -->
            <div class="form-group col-md-6" >
                <label for="stay">Availability Hotel Nearby For The Center Level Observer</label>
                <select name="stay" class="form-control" required id="stay">
                    <option value="">Please Select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div> --}}

            {{-- <!-- Special Permission -->
            <div class="form-group col-md-6" required>
                <label for="permission">Any Special Permission is Required To Access The facility on The Day of Exam?</label>
                <select name="permission" class="form-control" required id="permission">
                    <option value="">Please Select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div> --}}

            <!-- Consent Form Upload -->
            <div class="form-group col-md-6">
                <label for="consent_form">Upload Declaration / Consent Form with Stamp & Signature (All three pages in a single Pdf file)</label>
                <input type="file" class="form-control" id="consent_form" name="consent_form" required accept=".jpg, .jpeg, .png, .pdf" onchange="validateFile()">

                <div id="error-message" style="color: red; display: none;"></div>
            </div>

            <!-- Submit Button -->
            <div class="col-md-12" id="submit_data" style="display: none">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

        </div>
    </form>
</div>




<script src="{{asset('packages\jquery\jquery-3.6.0.min.js')}}"></script>

<script>
    function checkSelection() {
    var principalSelected = document.querySelector('input[name="superintendent"]:checked');
    var staffSelected = document.querySelector('input[name="superintendent_declearation"]:checked');

    // Check if both selections are 'Yes'
    if (principalSelected && staffSelected && principalSelected.value === "1" && staffSelected.value === "1") {
        document.getElementById("checkSelection").style.display = "block";
        document.getElementById("submit_data").style.display = "block";

    } else {
        document.getElementById("checkSelection").style.display = "none";
        document.getElementById("submit_data").style.display = "none";

    }
}
function checkSelection2() {
    var permission = document.querySelector('input[name="permission"]:checked');

    // Check if both selections are 'Yes'
    if (permission && permission.value === "1") {
        document.getElementById("checkSelection2").style.display = "block";

        
    } else {

        document.getElementById("checkSelection2").style.display = "none";
    }
}
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
    $(document).ready(function() {
        // Dynamically load districts based on selected state
        $('#state_id').on('change', function() {
            loadDistricts();
        });
        // Function to load districts based on selected state
        function loadDistricts() {
            var formData = new FormData();
            var token = $('input[name=_token]');
            formData.append('state_id', $('#state_id').val());
            $.ajax({
                url: '{{url("getdistricts")}}',
                method: 'POST',
                dataType: 'json',
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': token.val()
                },
                data: formData,
                success: function(data) {
                    console.log(data);
                    if (data == 'nodata' || data.length == 0) {
                        swal({
                            type: 'warning',
                            title: 'No data found',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else {
                        $('#district_id').html('');
                        $('#subdistrict_id').html('');
                        $('#village_id').html('');
                        $('#district_id').append(
                            '<option value="0" selected disabled>Choose district</option>');
                        data.forEach(function(value) {
                            $('#district_id').append('<option value="' + value.id + '">' +
                                value.districtName + '</option>');
                        });
                    }
                },
                error: function() {
                    swal({
                        type: 'warning',
                        title: 'No datass found',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        }
        $('#district_id').on('change', function() {
            var formData = new FormData();
            var token = $('input[name=_token]');
            formData.append('district_id', $('#district_id').val());
            $.ajax({
                url: '{{url("getsubdistricts")}}',
                method: 'POST',
                dataType: 'json',
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': token.val()
                },
                data: formData,
                success: function(data) {
                    console.log(data);
                    if (data == 'nodata' || data.length == 0) {
                        swal({
                            type: 'warning',
                            title: 'No data found',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else {
                        //	$('#subdistrictsdiv').removeClass('hidden');
                        $('#subdistrict_id').html('');
                        //		$('#villagediv').removeClass('hidden');
                        $('#village_id').html('');
                        $('#subdistrict_id').append(
                            '<option value="0" selected disabled>Choose Sub district  / Tehsil / Taluk</option>'
                            );
                        $('#village_id').append(
                            '<option value="0" selected disabled>Choose Block / Village </option>'
                            );
                        if (data['subdistricts'].length == 0) {
                            //	$('#subdistrict_id').attr('disabled',true);
                        } else {
                            //	$('#subdistrict_id').attr('disabled',false);
                            var old = parseInt("{{old('subdistrict_id')}}");
                            data['subdistricts'].forEach(function(value, key) {
                                if (value.id == old) {
                                    $('#subdistrict_id').append(
                                        '<option selected value="' + value.id +
                                        '">' + value.Sub_district_Name +
                                        '</option>');
                                } else {
                                    $('#subdistrict_id').append('<option value="' +
                                        value.id + '">' + value
                                        .Sub_district_Name + '</option>');
                                }
                            });
                        }
                        if (data['blocks'].length == 0) {
                            //	$('#village_id').attr('disabled',true);
                        } else {
                            //	$('#village_id').attr('disabled',false);
                            var old = parseInt("{{old('village_id')}}");
                            data['blocks'].forEach(function(value, key) {
                                if (value.id == old) {
                                    $('#village_id').append(
                                        '<option selected value="' + value.id +
                                        '">' + value.Block_Name + '</option>');
                                } else {
                                    $('#village_id').append('<option value="' +
                                        value.id + '">' + value.Block_Name +
                                        '</option>');
                                }
                            });
                        }
                        if ($('#saa').is(':checked')) {
                            $('#district_id').val($('#district_id').val());
                            loadPSubdistricts(0, 0);
                        }
                    }
                },
                error: function(data) {
                    console.log(data);
                    swal({
                        type: 'warning',
                        title: 'No data found',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        });
        $('#state_id').on('change', function() {
            loadPDistricts(0);
        });

        function loadPSubdistricts(tid, vid) {
            var formData = new FormData();
            var token = $('input[name=_token]');
            formData.append('district_id', $('#district_id').val());
            $.ajax({
                url: '{{url("getsubdistricts")}}',
                method: 'POST',
                dataType: 'json',
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': token.val()
                },
                data: formData,
                success: function(data) {
                    console.log(data);
                    if (data == 'nodata' || data.length == 0) {
                        swal({
                            type: 'warning',
                            title: 'No data found',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else {
                        $('#psubdistrictsdiv').removeClass('hidden');
                        $('#subdistrict_id').html('');
                        $('#pvillagediv').removeClass('hidden');
                        $('#village_id').html('');
                        $('#subdistrict_id').append(
                            '<option value="0" selected disabled>Choose Sub District / Tehsil / Taluk</option>'
                            );
                        $('#village_id').append(
                            '<option value="0" selected disabled>Choose Sub District / Tehsil / Taluk</option>'
                            );
                        if (data['subdistricts'].length == 0) {
                            //	$('#subdistrict_id').attr('disabled',true);
                        } else {
                            if (!$('#saa').is(':checked')) {
                                //	$('#subdistrict_id').attr('disabled',false);
                            }
                            data['subdistricts'].forEach(function(value, key) {
                                if (tid != 0) {
                                    if (tid == value.id) {
                                        $('#subdistrict_id').append(
                                            '<option selected value="' + value.id +
                                            '">' + value.Sub_district_Name + '</option>'
                                            );
                                    } else {
                                        $('#subdistrict_id').append('<option value="' +
                                            value.id + '">' + value.Sub_district_Name +
                                            '</option>');
                                    }
                                } else {
                                    $('#subdistrict_id').append('<option value="' + value
                                        .id + '">' + value.Sub_district_Name +
                                        '</option>');
                                }
                            });
                        }
                        if (data['blocks'].length == 0) {
                            //$('#village_id').attr('disabled',true);
                        } else {
                            if (!$('#saa').is(':checked')) {
                                //	$('#village_id').attr('disabled',false);
                            }
                            data['blocks'].forEach(function(value, key) {
                                if (vid != 0) {
                                    if (vid == value.id) {
                                        $('#village_id').append('<option selected value="' +
                                            value.id + '">' + value.Block_Name +
                                            '</option>');
                                    } else {
                                        $('#village_id').append('<option value="' + value
                                            .id + '">' + value.Block_Name + '</option>');
                                    }
                                } else {
                                    $('#village_id').append('<option value="' + value.id +
                                        '">' + value.Block_Name + '</option>');
                                }
                            });
                        }
                    }
                },
                error: function(data) {
                    swal({
                        type: 'warning',
                        title: 'No data found',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        }
        $('#district_id').on('change', function() {
            loadPSubdistricts(0, 0);
        });
     
    });
</script>
<script>
    document.getElementById("schoolForm").addEventListener("submit", function(event) {
        let valid = true;

        // Validate Government School Name
        let schoolName = document.getElementById("school_name").value;
        if (schoolName.trim() === "") {
            alert("Please enter the Government School Name.");
            valid = false;
        }

        // Validate Setting Capacity
        // let settingCapacity = document.getElementById("setting_capacity").value;
        // if (settingCapacity < 30 || settingCapacity > 5000) {
        //     alert("Please enter a Setting Capacity between 30 and 5000.");
        //     valid = false;
        // }

        // Validate Latitude
        let latitude = document.getElementById("latitudeInput").value;
        if (latitude < 8 || latitude > 38 || !isNumeric(latitude)) {
            alert("Please enter a valid latitude value between 8 and 38.");
            valid = false;
        }

        // Validate Longitude
        let longitude = document.getElementById("longitudeInput").value;
        if (longitude < 68 || longitude > 98 || !isNumeric(longitude)) {
            alert("Please enter a valid longitude value between 68 and 98.");
            valid = false;
        }

        // Validate Pincode
        let pincode = document.getElementById("pincode").value;
        if (pincode.length !== 6 || !/^\d{6}$/.test(pincode)) {
            alert("Please enter a valid 6-digit Pincode.");
            valid = false;
        }

        // Validate Email Fields
        let principalEmail = document.getElementById("principal_email").value;
        let email2 = document.getElementById("email2").value;
        if (!isValidEmail(principalEmail) || !isValidEmail(email2)) {
            alert("Please enter valid email addresses.");
            valid = false;
        }

        // Validate Phone Number Length (10 digits)
        let principalMobile = document.getElementById("principal_mobile").value;
        if (principalMobile.length !== 10 || !/^\d{10}$/.test(principalMobile)) {
            alert("Please enter a valid 10-digit Principal Mobile Number.");
            valid = false;
        }

        let principalWhatsapp = document.getElementById("principal_whatsapp").value;
        if (principalWhatsapp.length !== 10 || !/^\d{10}$/.test(principalWhatsapp)) {
            alert("Please enter a valid 10-digit Principal WhatsApp Number.");
            valid = false;
        }

        let alternativeContactMobile = document.getElementById("alternative_contact_mobile").value;
        if (alternativeContactMobile.length !== 10 || !/^\d{10}$/.test(alternativeContactMobile)) {
            alert("Please enter a valid 10-digit Alternative Contact Mobile Number.");
            valid = false;
        }

        let alternativeContactWhatsapp = document.getElementById("alternative_contact_whatsapp").value;
        if (alternativeContactWhatsapp.length !== 10 || !/^\d{10}$/.test(alternativeContactWhatsapp)) {
            alert("Please enter a valid 10-digit Alternative Contact WhatsApp Number.");
            valid = false;
        }

        // Prevent form submission if validation fails
        if (!valid) {
            event.preventDefault();
        }
    });

    // Helper Functions
    function isValidEmail(email) {
        const re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        return re.test(email);
    }

    function isNumeric(value) {
        return !isNaN(value) && !isNaN(parseFloat(value));
    }
</script>
<style>
    .box {
        display: inline-block;
        width: 98%;
  padding: 10px;
  border: 3px solid gray;
  margin: 13px !important;
}
hr {
    /* margin-top: 1px; */
     border: 1 !important;
    border: 1px solid gray;
    width: 101.9%;
    margin-left: -10px;
}

</style>
@endsection