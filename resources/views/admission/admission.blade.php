@extends('layouts.app')

@section('content')
    <div class="admission-form-page" style="background:#f5f8ff; padding: 30px 0;">
        <div class="container">
            <div class="admission-header text-center"
                style="background:#1f4e79; color:#fff; padding:30px 15px; border-radius:4px 4px 0 0;">
                <h2>Admission Counselling Form</h2>
                <p style="margin-bottom:0;">Please fill in all required fields marked with an asterisk (*)</p>
            </div>

            <form class="admission-form" method="POST" action="{{ url('/admission-save') }}" enctype="multipart/form-data"
                style="background:#fff; border:1px solid #d9e2ec; border-top:none; border-radius:0 0 4px 4px; padding:25px;">
                {{ csrf_field() }}
                <input type="hidden" name="student_id" id="student_id" value="{{$studentDetails->id}}">

                <!-- ===================== PROFESSIONAL STEPPER ===================== -->
                <div class="stepper-wrapper">
                    <div class="stepper-step" data-step="1">
                        <div class="step-circle">1</div>
                        <div class="step-label">Basic Info</div>
                    </div>
                    <div class="stepper-line" data-line="1"></div>

                    <div class="stepper-step" data-step="2">
                        <div class="step-circle">2</div>
                        <div class="step-label">Address</div>
                    </div>
                    <div class="stepper-line" data-line="2"></div>

                    <div class="stepper-step" data-step="3">
                        <div class="step-circle">3</div>
                        <div class="step-label">Education</div>
                    </div>
                    <div class="stepper-line" data-line="3"></div>

                    <div class="stepper-step" data-step="4">
                        <div class="step-circle">4</div>
                        <div class="step-label">Documents</div>
                    </div>
                </div>
                <!-- =================== END PROFESSIONAL STEPPER =================== -->

                <!-- ============================ STEP 1: BASIC INFO ============================ -->
                <div class="form-step" data-step="1">
                    <div class="section-block"
                        style="margin-bottom:20px; background:#f8fbff; border:1px solid #dce6f1; border-radius:4px; padding:18px;">
                        <div class="section-title" style="margin-bottom:18px;">
                            <span class="dot"></span>
                            <h5 style="display:inline-block; margin:0; font-size:16px; font-weight:600;">Basic Information
                            </h5>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Full Name </label>
                                    <input name="student_name" value="{{ $studentDetails->FirstName}}" class="form-control required-field" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email ID</label>
                                    <input name="email" value="{{ $studentDetails->email}}" class="form-control required-field" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Mobile Number</label>
                                    <input name="mobile" value="{{ $studentDetails->mobile}}" class="form-control required-field" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Aadhar Number </label>
                                    <input name="aadhar_number" value="{{ $studentDetails->addharNumber}}" class="form-control required-field"
                                        placeholder="Enter Aadhar number" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Father's Name <span class="text-danger">*</span></label>
                                    <input name="father_name" type="text" class="form-control required-field"
                                        data-error-id="father_name_error" placeholder="Enter father's name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Mother's Name <span class="text-danger">*</span></label>
                                    <input name="mother_name" type="text" class="form-control required-field"
                                        data-error-id="mother_name_error" placeholder="Enter mother's name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group required-radio-group" data-error-id="gender_error">
                                    <label>Gender <span class="text-danger">*</span></label>
                                    <div class="radio">
                                        <label><input name="gender" type="radio" value="1"> Male</label>
                                        <label style="margin-left:15px;"><input name="gender" type="radio" value="2">
                                            Female</label>
                                        <label style="margin-left:15px;"><input name="gender" type="radio"  value="3">Other</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group required-radio-group" data-error-id="pwd_error">
                                    <label>PwD (Person with Disability) <span class="text-danger">*</span></label>
                                    <div class="radio">
                                        <label><input name="pwd" type="radio" value="no"> No</label>
                                        <label style="margin-left:15px;"><input name="pwd" type="radio"
                                                value="yes">
                                            Yes</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date of Birth <span class="text-danger">*</span></label>
                                    <input name="dob" type="date" class="form-control required-field"
                                        data-error-id="dob_error">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nationality <span class="text-danger">*</span></label>
                                    <select name="nationality" class="form-control required-field"
                                        data-error-id="nationality_error">
                                        <option value="">--Please Select Nationality--</option>
                                        <option value="86">Indian</option>
                                        <option value="0">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Category <span class="text-danger">*</span></label>
                                    <select name="category" class="form-control required-field"
                                        data-error-id="category_error">
                                        <option value="">Please select</option>
                                        <option value="GENERAL">GENERAL</option>
                                        <option value="OBC">OBC</option>
                                        <option value="SCHEDULED CASTE (SC)">SCHEDULED CASTE (SC)</option>
                                        <option value="SCHEDULED TRIBE (ST)">SCHEDULED TRIBE (ST)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group required-radio-group" data-error-id="ews_error">
                                    <label>Do You Belong To EWS Category? <span class="text-danger">*</span></label>
                                    <div class="radio">
                                        <label><input name="ews" type="radio" value="no"> No</label>
                                        <label style="margin-left:15px;"><input name="ews" type="radio"
                                                value="yes"> Yes</label>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- ========================== END STEP 1 ========================== -->

                <!-- ============================ STEP 2: ADDRESS ============================ -->
                <div class="form-step" data-step="2">
                    <div class="section-block"
                        style="margin-bottom:20px; background:#f8fbff; border:1px solid #dce6f1; border-radius:4px; padding:18px;">
                        <div class="section-title" style="margin-bottom:18px;">
                            <span class="dot"></span>
                            <h5 style="display:inline-block; margin:0; font-size:16px; font-weight:600;">Correspondence
                                Address</h5>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Address <span class="text-danger">*</span></label>
                                    <textarea id="corr_address" name="corr_address" class="form-control required-field"
                                        data-error-id="corr_address_error" rows="3" placeholder="Enter correspondence address"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>State <span class="text-danger">*</span></label>
                                    <select id="corr_state" name="corr_state" class="form-control required-field"
                                        data-error-id="corr_state_error">
                                        <option value="">Select state</option>
                                        @foreach (collect($states_disticts)->unique('state_code') as $state)
                                            <option value="{{ $state->state_code }}">{{ $state->state_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>District <span class="text-danger">*</span></label>
                                    <select id="corr_district" name="corr_district" class="form-control required-field"
                                        data-error-id="corr_district_error" disabled>
                                        <option value="">Select district</option>
                                        @foreach (collect($states_disticts)->unique('districtCode') as $district)
                                            <option value="{{ $district->districtCode }}"
                                                data-state="{{ $district->state_code }}">{{ $district->districtName }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Sub District / Tehsil / Taluk <span class="text-danger">*</span></label>
                                    <input id="corr_subdistrict" name="corr_subdistrict" type="text"
                                        class="form-control required-field" data-error-id="corr_subdistrict_error"
                                        placeholder="Enter sub district">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Block/Village <span class="text-danger">*</span></label>
                                    <input id="corr_block" name="corr_block" type="text"
                                        class="form-control required-field" data-error-id="corr_block_error"
                                        placeholder="Enter block / village">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>PIN Code <span class="text-danger">*</span></label>
                                    <input id="corr_pin" name="corr_pin" type="text"
                                        class="form-control required-field" data-error-id="corr_pin_error"
                                        placeholder="Enter PIN code">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="section-block"
                        style="margin-bottom:20px; background:#f8fbff; border:1px solid #dce6f1; border-radius:4px; padding:18px;">
                        <div class="section-title" style="margin-bottom:18px;">
                            <span class="dot"></span>
                            <h5 style="display:inline-block; margin:0; font-size:16px; font-weight:600;">Permanent Address
                            </h5>
                        </div>
                        <div class="checkbox" style="margin-bottom:18px;">
                            <label><input type="checkbox" id="sameAddress"> Same as Correspondence Address</label>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Address <span class="text-danger">*</span></label>
                                    <textarea id="perm_address" name="perm_address" class="form-control required-field"
                                        data-error-id="perm_address_error" rows="3" placeholder="Enter permanent address"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>State <span class="text-danger">*</span></label>
                                    <select id="perm_state" name="perm_state" class="form-control required-field"
                                        data-error-id="perm_state_error">
                                        <option value="">Select state</option>
                                        @foreach (collect($states_disticts)->unique('state_code') as $state)
                                            <option value="{{ $state->state_code }}">{{ $state->state_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>District <span class="text-danger">*</span></label>
                                    <select id="perm_district" name="perm_district" class="form-control required-field"
                                        data-error-id="perm_district_error" disabled>
                                        <option value="">Select district</option>
                                        @foreach (collect($states_disticts)->unique('districtCode') as $district)
                                            <option value="{{ $district->districtCode }}"
                                                data-state="{{ $district->state_code }}">{{ $district->districtName }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Sub District / Tehsil / Taluk <span class="text-danger">*</span></label>
                                    <input id="perm_subdistrict" name="perm_subdistrict" type="text"
                                        class="form-control required-field" data-error-id="perm_subdistrict_error"
                                        placeholder="Enter sub district">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Block/Village<span class="text-danger">*</span></label>
                                    <input id="perm_block" name="perm_block" type="text"
                                        class="form-control required-field" data-error-id="perm_block_error"
                                        placeholder="Enter block / village">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>PIN Code <span class="text-danger">*</span></label>
                                    <input id="perm_pin" name="perm_pin" type="text"
                                        class="form-control required-field" data-error-id="perm_pin_error"
                                        placeholder="Enter PIN code">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ========================== END STEP 2 ========================== -->

                <!-- ============================ STEP 3: EDUCATION ============================ -->
                <div class="form-step" data-step="3">
                    <div class="section-block"
                        style="margin-bottom:20px; background:#f8fbff; border:1px solid #dce6f1; border-radius:4px; padding:18px;">
                        <div class="section-title" style="margin-bottom:18px;">
                            <span class="dot"></span>
                            <h5 style="display:inline-block; margin:0; font-size:16px; font-weight:600;">Education Details
                            </h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" style="margin-bottom:0;">
                                <thead style="background:#1f4e79; color:#fff;">
                                    <tr>
                                        <th>Examination</th>
                                        <th>Board/University</th>
                                        <th>Year of Passing</th>
                                        <th>Total Marks</th>
                                        <th>Marks Obtained</th>
                                        <th>Percentage / CGPA </th>
                                        <th>Subject(s)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="education-row">
                                        <td>10th <span class="text-danger">*</span></td>
                                        <td>
                                            <select name="board10" class="form-control required-field education-board"
                                                data-error-id="board10_error">
                                                <option value="">Select Board</option>
                                                <option value="10_STANDARD_OR_EQUIVALENT">10 STANDARD OR EQUIVALENT
                                                </option>
                                                <option value="CBSE">CBSE</option>
                                                <option value="ICSE">ICSE</option>
                                                <option value="STATE_BOARD">STATE BOARD</option>
                                            </select>
                                        </td>
                                        <td><input name="year10" type="number" min="1950" max="2026"
                                                step="1" class="form-control required-field education-year"
                                                data-error-id="year10_error" placeholder="Year"></td>
                                        <td><input name="total10" type="number" min="1"
                                                class="form-control required-field education-total"
                                                data-error-id="total10_error" placeholder="Total Marks"></td>
                                        <td><input name="marks10" type="number" min="0"
                                                class="form-control required-field education-obtained"
                                                data-error-id="marks10_error" placeholder="Marks Obtained"></td>
                                        <td><input name="percent10" type="number" min="0" max="99.99"
                                                step="any" class="form-control required-field education-percent"
                                                data-error-id="percent10_error" placeholder="Percentage"></td>
                                        <td><input name="subject10" type="text"
                                                class="form-control required-field education-subject"
                                                data-error-id="subject10_error" placeholder="Subject(s)"></td>
                                    </tr>
                                    <tr class="education-row">
                                        <td>12th <span class="text-danger">*</span></td>
                                        <td><select name="board12" class="form-control required-field education-board"
                                                data-error-id="board12_error">
                                                <option value="">Select Board</option>
                                                <option value="10+2_OR_EQUIVALENT">10+2 OR EQUIVALENT</option>
                                                <option value="CBSE">CBSE</option>
                                                <option value="ICSE">ICSE</option>
                                                <option value="STATE_BOARD">STATE BOARD</option>
                                            </select></td>
                                        <td><input name="year12" type="number" min="1950" max="2026"
                                                step="1" class="form-control required-field education-year"
                                                data-error-id="year12_error" placeholder="Year"></td>
                                        <td><input name="total12" type="number" min="1"
                                                class="form-control required-field education-total"
                                                data-error-id="total12_error" placeholder="Total Marks"></td>
                                        <td><input name="marks12" type="number" min="0"
                                                class="form-control required-field education-obtained"
                                                data-error-id="marks12_error" placeholder="Marks Obtained"></td>
                                        <td><input name="percent12" type="number" min="0" max="99.99"
                                                step="any" class="form-control required-field education-percent"
                                                data-error-id="percent12_error" placeholder="Percentage"></td>
                                        <td><input name="subject12" type="text"
                                                class="form-control required-field education-subject"
                                                data-error-id="subject12_error" placeholder="Subject(s)"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- ========================== END STEP 3 ========================== -->

                <!-- ============================ STEP 4: DOCUMENTS ============================ -->
                <div class="form-step" data-step="4">
                    <div class="section-block"
                        style="margin-bottom:20px; background:#f8fbff; border:1px solid #dce6f1; border-radius:4px; padding:18px;">
                        <div class="section-title" style="margin-bottom:18px;">
                            <span class="dot"></span>
                            <h5 style="display:inline-block; margin:0; font-size:16px; font-weight:600;">Documents Upload
                            </h5>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Photo <span class="text-danger">*</span></label>
                                    <input name="photo" type="file" class="form-control required-field"
                                        data-error-id="photo_error" accept="image/jpeg,image/jpg,image/png">
                                    <small style="display:block; color:#6c757d; margin-top:4px;">Only JPEG, JPG, PNG. Max
                                        size:
                                        200KB. Max dimensions: 800x800px</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>10th Marksheet <span class="text-danger">*</span></label>
                                    <input name="marksheet10" type="file" class="form-control required-field"
                                        data-error-id="marksheet10_error" accept="application/pdf">
                                    <small style="display:block; color:#6c757d; margin-top:4px;">Only PDF file. Size: 200KB
                                        to
                                        2048KB</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>12th Marksheet <span class="text-danger">*</span></label>
                                    <input name="marksheet12" type="file" class="form-control required-field"
                                        data-error-id="marksheet12_error" accept="application/pdf">
                                    <small style="display:block; color:#6c757d; ">Only PDF file. Size: 200KB to
                                        2048KB</small>
                                </div>
                            </div>
                            <div class="col-md-6 pwd-certificate-row" style="display:none;">
                                <div class="form-group">
                                    <label>Upload PwD Certificate <span class="text-danger">*</span></label>
                                    <input name="pwd_certificate" type="file" class="form-control required-field"
                                        data-error-id="pwd_certificate_error" accept="application/pdf">
                                    <small style="display:block; color:#6c757d; ">Only PDF file. Size: 200KB to
                                        2048KB</small>
                                </div>
                            </div>
                            <div class="col-md-6 category-certificate-row" style="display:none;">
                                <div class="form-group">
                                    <label>Upload Category Certificate <span class="text-danger">*</span></label>
                                    <input name="category_certificate" type="file" class="form-control required-field"
                                        data-error-id="category_certificate_error" accept="application/pdf">
                                    <small style="display:block; color:#6c757d;">Only PDF file. Size: 200KB to
                                        2048KB</small>
                                </div>
                            </div>

                            <div class="col-md-6 ews-certificate-row" style="display:none;">
                                <div class="form-group">
                                    <label>Upload EWS Certificate <span class="text-danger">*</span></label>
                                    <input name="ews_certificate" type="file" class="form-control required-field"
                                        data-error-id="ews_certificate_error" accept="application/pdf">
                                    <small style="display:block; color:#6c757d; ">Only PDF file. Size: 200KB to
                                        2048KB</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ========================== END STEP 4 ========================== -->

                <div class="stepper-buttons text-right" style="margin-top:20px;">
                    <button type="button" class="btn btn-default btn-lg btn-previous"
                        style="padding:12px 30px; display:none;">Previous</button>
                    <button type="button" class="btn btn-primary btn-lg btn-next"
                        style="padding:12px 38px;">Next</button>
                    <button type="submit" class="btn btn-primary btn-lg btn-submit"
                        style="padding:12px 38px; display:none;">Submit Application</button>
                </div>
                <div class="text-center" style="padding-top:15px;">
                    <button type="reset" class="btn btn-default btn-lg"
                        style="padding:12px 30px; margin-left:10px;">Reset Form</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .admission-form-page {
            font-family: 'Segoe UI', sans-serif;
        }

        .section-title .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #1f4e79;
            display: inline-block;
            margin-right: 10px;
            vertical-align: middle;
        }

        .admission-header h2 {
            font-weight: 600;
        }

        .text-danger {
            color: #a94442;
        }

        .field-error {
            display: block;
            margin-top: 5px;
            font-size: 12px;
        }

        .has-error .form-control,
        .has-error .radio {
            border-color: #a94442;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
        }

        .btn-default {
            color: #333;
            background-color: #fff;
            border-color: #ccc;
        }

        .btn-next[disabled],
        .btn-submit[disabled] {
            opacity: .65;
            cursor: not-allowed;
        }

        .step-save-status {
            font-size: 12px;
            color: #2e7d32;
            margin-top: 10px;
            display: none;
        }

        /* ===================== PROFESSIONAL STEPPER STYLES ===================== */
        .stepper-wrapper {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 35px;
            padding: 0 10px;
        }

        .stepper-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            cursor: pointer;
            position: relative;
            flex: 0 0 auto;
        }

        .stepper-step .step-circle {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #fff;
            border: 2px solid #c7d5e6;
            color: #8a96a3;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
            transition: all 0.25s ease;
        }

        .stepper-step .step-label {
            margin-top: 8px;
            font-size: 13px;
            font-weight: 600;
            color: #8a96a3;
            white-space: nowrap;
            transition: color 0.25s ease;
        }

        .stepper-step.active .step-circle {
            background: #1f4e79;
            border-color: #1f4e79;
            color: #fff;
            box-shadow: 0 0 0 4px rgba(31, 78, 121, 0.15);
        }

        .stepper-step.active .step-label {
            color: #1f4e79;
        }

        .stepper-step.completed .step-circle {
            background: #2e7d32;
            border-color: #2e7d32;
            color: #fff;
        }

        .stepper-step.completed .step-circle::before {
            content: "\2713";
        }

        .stepper-step.completed .step-label {
            color: #2e7d32;
        }

        .stepper-line {
            flex: 1 1 auto;
            height: 3px;
            background: #c7d5e6;
            margin: 20px 8px 0;
            border-radius: 2px;
            transition: background 0.25s ease;
        }

        .stepper-line.completed {
            background: #2e7d32;
        }

        @media (max-width: 767px) {
            .stepper-step .step-label {
                display: none;
            }
        }

        /* =================== END PROFESSIONAL STEPPER STYLES ==================== */
    </style>


    <script>
        $(document).ready(function() {

            function setupErrorSpans() {
                $('.required-field[data-error-id]').each(function() {
                    var field = $(this);
                    var errorId = field.data('error-id');
                    if ($('#' + errorId).length === 0) {
                        $('<span class="text-danger field-error" id="' + errorId + '"></span>').insertAfter(
                            field);
                    }
                });

                $('.required-radio-group[data-error-id]').each(function() {
                    var group = $(this);
                    var errorId = group.data('error-id');
                    if ($('#' + errorId).length === 0) {
                        $('<span class="text-danger field-error" id="' + errorId + '"></span>').appendTo(
                            group);
                    }
                });
            }

            function clearErrors() {
                $('.has-error').removeClass('has-error');
                $('.field-error').text('').hide();
            }

            function validateField(field) {
                var value = '';
                if (field.is('input[type="file"]')) {
                    if (field[0].files.length === 0) {
                        return false;
                    }
                    var file = field[0].files[0];
                    if (field.data('error-id') === 'photo_error') {
                        var validImageTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                        return validImageTypes.indexOf(file.type) !== -1 && file.size <= 204800;
                    }
                    if (field.data('error-id') === 'marksheet10_error' || field.data('error-id') ===
                        'marksheet12_error' || field.data('error-id') === 'pwd_certificate_error' ||
                        field.data('error-id') === 'category_certificate_error' || field.data('error-id') ===
                        'ews_certificate_error') {
                        return file.type === 'application/pdf' && file.size >= 204800 && file.size <= 2097152;
                    }
                    return true;
                } else if (field.is('input[type="radio"]')) {
                    return field.closest('.required-radio-group').find('input[type="radio"]').is(':checked');
                } else {
                    value = field.val();
                }

                if (typeof value === 'string') {
                    value = value.toString().trim();
                }

                if ((field.attr('id') === 'corr_district' && $('#corr_state').val() === '') || (field.attr('id') ===
                        'perm_district' && $('#perm_state').val() === '')) {
                    return true;
                }

                if (field.hasClass('education-year')) {
                    if (value === '' || isNaN(value)) {
                        return false;
                    }
                    var year = parseInt(value, 10);
                    return year >= 1950 && year <= 2026;
                }

                if (field.hasClass('education-total')) {
                    if (value === '' || isNaN(value) || parseFloat(value) <= 0) {
                        return false;
                    }
                    var obtainedField = field.closest('tr').find('.education-obtained');
                    if (obtainedField.length && obtainedField.val().trim() !== '') {
                        return parseFloat(value) > parseFloat(obtainedField.val());
                    }
                    return true;
                }

                if (field.hasClass('education-obtained')) {
                    if (value === '' || isNaN(value) || parseFloat(value) < 0) {
                        return false;
                    }
                    var totalField = field.closest('tr').find('.education-total');
                    if (totalField.length && totalField.val().trim() !== '') {
                        return parseFloat(value) < parseFloat(totalField.val());
                    }
                    return true;
                }

                if (field.hasClass('education-percent')) {
                    if (value === '' || isNaN(value)) {
                        return false;
                    }
                    return parseFloat(value) >= 0 && parseFloat(value) < 100;
                }

                if (!field.is(':visible')) {
                    return true;
                }

                if (field.attr('type') === 'tel' && field.attr('name') === undefined) {
                    var mobilePattern = /^[6-9]\d{9}$/;
                    return mobilePattern.test(value);
                }


                return value !== '';
            }

            function validateForm() {
                clearErrors();
                var isValid = true;

                $('.form-step[data-step="' + currentStep + '"]').find('.required-field').each(function() {
                    var field = $(this);
                    var errorId = field.data('error-id');
                    var isValidField = validateField(field);
                    if (!isValidField) {
                        field.closest('.form-group').addClass('has-error');
                        var message = 'This field is required.';
                        if (field.attr('type') === 'tel' && field.attr('name') === undefined) {
                            message = 'Enter a valid 10-digit mobile number.';
                        }

                        if (field.data('error-id') === 'photo_error') {
                            message = 'Upload a JPEG/JPG/PNG image under 200KB.';
                        }
                        if (field.data('error-id') === 'marksheet10_error' || field.data('error-id') ===
                            'marksheet12_error' || field.data('error-id') === 'pwd_certificate_error' ||
                            field.data('error-id') === 'category_certificate_error' || field.data(
                                'error-id') ===
                            'ews_certificate_error') {
                            message = 'Upload a PDF between 200KB and 2MB.';
                        }
                        if (field.hasClass('education-year')) {
                            message = 'Year must be between 1950 and 2026.';
                        } else if (field.hasClass('education-total')) {
                            var totalValue = field.val().trim();
                            var obtainedValue = field.closest('tr').find('.education-obtained').val()
                        .trim();
                            if (totalValue === '' || parseFloat(totalValue) <= 0) {
                                message = 'Total marks must be greater than 0.';
                            } else if (obtainedValue !== '' && parseFloat(totalValue) <= parseFloat(
                                    obtainedValue)) {
                                message = 'Total marks must be greater than obtained marks.';
                            } else {
                                message = 'This field is required.';
                            }
                        } else if (field.hasClass('education-obtained')) {
                            var obtainedValue = field.val().trim();
                            var totalValue = field.closest('tr').find('.education-total').val().trim();
                            if (obtainedValue === '' || parseFloat(obtainedValue) < 0) {
                                message = 'Marks obtained must be 0 or more.';
                            } else if (totalValue !== '' && parseFloat(obtainedValue) >= parseFloat(
                                    totalValue)) {
                                message = 'Marks obtained must be less than total marks.';
                            } else {
                                message = 'This field is required.';
                            }
                        } else if (field.hasClass('education-percent')) {
                            message = 'Percentage must be less than 100.';
                        } else if (field.hasClass('education-board') || field.hasClass(
                            'education-subject')) {
                            message = 'This field is required.';
                        } else if (field.attr('id') === 'corr_subdistrict' || field.attr('id') ===
                            'perm_subdistrict') {
                            message = 'Sub district / Tehsil / Taluk is required.';
                        } else if (field.attr('id') === 'corr_block' || field.attr('id') === 'perm_block') {
                            message = 'Block/Village is required.';
                        }
                        $('#' + errorId).text(message).show();
                        isValid = false;
                    }
                });

                $('.form-step[data-step="' + currentStep + '"]').find('.required-radio-group').each(function() {
                    var group = $(this);
                    var errorId = group.data('error-id');
                    if (!group.find('input[type="radio"]').is(':checked')) {
                        group.addClass('has-error');
                        $('#' + errorId).text('Please select an option.').show();
                        isValid = false;
                    }
                });

                return isValid;
            }

            setupErrorSpans();

            var currentStep = 1;
            var totalSteps = $('.form-step').length;

            function showStep(step) {
                $('.form-step').hide();
                $('.form-step[data-step="' + step + '"]').show();

                $('.stepper-step').each(function() {
                    var stepIndex = $(this).data('step');
                    $(this).removeClass('active completed');
                    if (stepIndex < step) {
                        $(this).addClass('completed');
                    } else if (stepIndex === step) {
                        $(this).addClass('active');
                    }
                });

                $('.stepper-line').each(function() {
                    var lineIndex = $(this).data('line');
                    $(this).toggleClass('completed', lineIndex < step);
                });

                $('.btn-previous').toggle(step > 1);
                $('.btn-next').toggle(step < totalSteps);
                $('.btn-submit').toggle(step === totalSteps);
            }

            function csrfToken() {
                return $('input[name="_token"]').val();
            }

            function showAjaxError(xhr, fallbackMessage) {
                if (xhr && xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    var errors = xhr.responseJSON.errors;
                    var messages = [];
                    $.each(errors, function(field, fieldMessages) {
                        messages.push(fieldMessages[0]);
                    });
                    alert(messages.join('\n'));
                } else {
                    alert(fallbackMessage);
                }
            }

            // ---- Per-step AJAX save handlers ----

            $('.btn-next').on('click', function() {
                if (!validateForm()) {
                    return;
                }

                var $nextBtn = $(this);
                var originalText = $nextBtn.text();
                $nextBtn.prop('disabled', true).text('Saving...');

                function goNext() {
                    $nextBtn.prop('disabled', false).text(originalText);
                    currentStep++;
                    showStep(currentStep);
                }

                function restoreBtn() {
                    $nextBtn.prop('disabled', false).text(originalText);
                }

                if (currentStep === 1) {
                    saveStep1WithRestore(goNext, restoreBtn);
                } else if (currentStep === 2) {
                    saveStep2WithRestore(goNext, restoreBtn);
                } else if (currentStep === 3) {
                    saveStep3WithRestore(goNext, restoreBtn);
                }
            });

            function saveStep1WithRestore(onSuccess, onError) {
                var data = {
                    _token: csrfToken(),
                    step: 1,
                    student_id: $('#student_id').val(),
                    student_name: $('[name="student_name"]').val(),
                    email: $('[name="email"]').val(),
                    mobile: $('[name="mobile"]').val(),
                    aadhar_number: $('[name="aadhar_number"]').val(),
                    father_name: $('[name="father_name"]').val(),
                    mother_name: $('[name="mother_name"]').val(),
                    gender: $('input[name="gender"]:checked').val(),
                    pwd: $('input[name="pwd"]:checked').val(),
                    dob: $('[name="dob"]').val(),
                    nationality: $('[name="nationality"]').val(),
                    category: $('[name="category"]').val(),
                    ews: $('input[name="ews"]:checked').val()
                };

                $.ajax({
                    url: '{{ url("/admission-save") }}',
                    method: 'POST',
                    dataType: 'json',
                    data: data,
                    success: function(res) {
                        $('#student_id').val(res.student_id);
                        onSuccess();
                    },
                    error: function(xhr) {
                        onError();
                        showAjaxError(xhr, 'Could not save Basic Information. Please try again.');
                    }
                });
            }

            function saveStep2WithRestore(onSuccess, onError) {
                var data = {
                    _token: csrfToken(),
                    step: 2,
                    student_id: $('#student_id').val(),
                    corr_address: $('#corr_address').val(),
                    corr_state: $('#corr_state').val(),
                    corr_district: $('#corr_district').val(),
                    corr_subdistrict: $('#corr_subdistrict').val(),
                    corr_block: $('#corr_block').val(),
                    corr_pin: $('#corr_pin').val(),
                    perm_address: $('#perm_address').val(),
                    perm_state: $('#perm_state').val(),
                    perm_district: $('#perm_district').val(),
                    perm_subdistrict: $('#perm_subdistrict').val(),
                    perm_block: $('#perm_block').val(),
                    perm_pin: $('#perm_pin').val()
                };

                $.ajax({
                    url: '{{ url("/admission-save") }}',
                    method: 'POST',
                    dataType: 'json',
                    data: data,
                    success: function() {
                        onSuccess();
                    },
                    error: function(xhr) {
                        onError();
                        showAjaxError(xhr, 'Could not save Address details. Please try again.');
                    }
                });
            }

            function saveStep3WithRestore(onSuccess, onError) {
                var data = {
                    _token: csrfToken(),
                    step: 3,
                    student_id: $('#student_id').val(),
                    board10: $('[name="board10"]').val(),
                    year10: $('[name="year10"]').val(),
                    total10: $('[name="total10"]').val(),
                    marks10: $('[name="marks10"]').val(),
                    percent10: $('[name="percent10"]').val(),
                    subject10: $('[name="subject10"]').val(),
                    board12: $('[name="board12"]').val(),
                    year12: $('[name="year12"]').val(),
                    total12: $('[name="total12"]').val(),
                    marks12: $('[name="marks12"]').val(),
                    percent12: $('[name="percent12"]').val(),
                    subject12: $('[name="subject12"]').val()
                };

                $.ajax({
                    url: '{{ url("/admission-save") }}',
                    method: 'POST',
                    dataType: 'json',
                    data: data,
                    success: function() {
                        onSuccess();
                    },
                    error: function(xhr) {
                        onError();
                        showAjaxError(xhr, 'Could not save Education details. Please try again.');
                    }
                });
            }

            $('.btn-previous').on('click', function() {
                if (currentStep > 1) {
                    currentStep--;
                    showStep(currentStep);
                }
            });

            $('.stepper-step').on('click', function() {
                var step = $(this).data('step');
                // Only allow jumping backward freely; forward jumps must go through Next (so each step saves)
                if (step && step >= 1 && step <= totalSteps && step < currentStep) {
                    currentStep = step;
                    showStep(currentStep);
                }
            });

            showStep(currentStep);

            function updateDistrictOptions(stateSelectId, districtSelectId) {
                var selectedState = $('#' + stateSelectId).val();
                $('#' + districtSelectId).find('option').each(function() {
                    var $option = $(this);
                    if (!$option.val()) {
                        return true;
                    }
                    $option.toggle($option.data('state') == selectedState);
                });

                if (selectedState) {
                    $('#' + districtSelectId).prop('disabled', false).val('');
                } else {
                    $('#' + districtSelectId).prop('disabled', true).val('');
                }
            }

            function resetFileField($field, errorId) {
                if ($field.length) {
                    $field.val('');
                    $field.closest('.form-group').removeClass('has-error');
                }
                $('#' + errorId).text('').hide();
            }

            function togglePwdCertificate() {
                var isPwd = $('input[name="pwd"]:checked').val() === 'yes';
                if (isPwd) {
                    $('.pwd-certificate-row').show();
                } else {
                    $('.pwd-certificate-row').hide();
                    resetFileField($('[name="pwd_certificate"]'), 'pwd_certificate_error');
                }
            }

            function toggleCategoryCertificate() {
                var category = $('select[name="category"] :selected').val();
                var showCategoryCertificate = category === 'obc' || category === 'sc' || category === 'st';
                if (showCategoryCertificate) {
                    $('.category-certificate-row').show();
                } else {
                    $('.category-certificate-row').hide();
                    resetFileField($('[name="category_certificate"]'), 'category_certificate_error');
                }
            }

            function toggleEwsCertificate() {
                var isEws = $('input[name="ews"]:checked').val() === 'yes';
                if (isEws) {
                    $('.ews-certificate-row').show();
                } else {
                    $('.ews-certificate-row').hide();
                    resetFileField($('[name="ews_certificate"]'), 'ews_certificate_error');
                }
            }

            updateDistrictOptions('corr_state', 'corr_district');
            updateDistrictOptions('perm_state', 'perm_district');
            $('#corr_state').on('change', function() {
                updateDistrictOptions('corr_state', 'corr_district');
            });
            $('#perm_state').on('change', function() {
                updateDistrictOptions('perm_state', 'perm_district');
            });

            $('input[name="pwd"]').on('change', function() {
                togglePwdCertificate();
            });

            $('select[name="category"]').on('change', function() {
                toggleCategoryCertificate();
            });

            $('input[name="ews"]').on('change', function() {
                toggleEwsCertificate();
            });

            togglePwdCertificate();
            toggleCategoryCertificate();
            toggleEwsCertificate();

            $('#sameAddress').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#perm_address').val($('#corr_address').val());
                    $('#perm_state').val($('#corr_state').val());
                    updateDistrictOptions('perm_state', 'perm_district');
                    $('#perm_district').val($('#corr_district').val());
                    $('#perm_subdistrict').val($('#corr_subdistrict').val());
                    $('#perm_block').val($('#corr_block').val());
                    $('#perm_pin').val($('#corr_pin').val());
                } else {
                    $('#perm_address').val('');
                    $('#perm_state').val('');
                    updateDistrictOptions('perm_state', 'perm_district');
                    $('#perm_district').val('');
                    $('#perm_subdistrict').val('');
                    $('#perm_block').val('');
                    $('#perm_pin').val('');
                }
            });

            // Final step (Documents) submit -> AJAX with files -> finalize record
            $('.admission-form').on('submit', function(e) {
                e.preventDefault();

                if (!validateForm()) {
                    $('.has-error').first().find('input, select, textarea').first().focus();
                    return;
                }

                if (!$('#student_id').val()) {
                    alert('Please complete the previous steps first.');
                    return;
                }

                var $submitBtn = $('.btn-submit');
                var originalText = $submitBtn.text();
                $submitBtn.prop('disabled', true).text('Submitting...');

                var formData = new FormData(this);
                formData.append('step', 4);

                $.ajax({
                    url: '{{ url("/admission-save") }}',
                    method: 'POST',
                    dataType: 'json',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        $submitBtn.prop('disabled', false).text(originalText);
                        alert('Admission submitted successfully. Your Registration No is ' + res.registration_no);
                        window.location.href = '{{ url("/admission") }}';
                    },
                    error: function(xhr) {
                        $submitBtn.prop('disabled', false).text(originalText);
                        showAjaxError(xhr, 'Could not submit documents. Please try again.');
                    }
                });
            });

            $('.admission-form').find('input, select, textarea').on('input change', function() {
                var field = $(this);
                if (field.hasClass('required-field')) {
                    var isValidField = validateField(field);
                    if (isValidField || field.val() === '') {
                        field.closest('.form-group').removeClass('has-error');
                        $('#' + field.data('error-id')).text('').hide();
                    }
                }

            });

            $('.admission-form').find('input[type="radio"]').on('change', function() {
                var group = $(this).closest('.required-radio-group');
                if (group.find('input[type="radio"]').is(':checked')) {
                    group.removeClass('has-error');
                    $('#' + group.data('error-id')).text('').hide();
                }
            });
        });
    </script>
@endsection