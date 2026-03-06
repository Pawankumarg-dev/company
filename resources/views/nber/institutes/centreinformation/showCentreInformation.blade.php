@extends('layouts.app')

@section('content')
    <form class="form-horizontal" method="POST" role="form">
        {{ csrf_field() }}

        <input type="hidden" name="institute_id" value="{{ $institute->id }}" />

        <div class="panel panel-default">
            <div class="panel-body">
                <div class="panel-group">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/nber/notifications/institute-information/show-institute-lists/') }}">Institute Centre Information Notification</a></li>
                        <li class="active">{{ $institute->code }} - {{ $institute->name }}</li>
                    </ol>

                    {{-- Display of Institute's Details--}}
                    <div class="panel panel-info">
                        <div class="panel-heading"><div class="blue-text center-text large-text">Institute's Details</div></div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="control-label col-sm-2">Code :</label>
                                <div class="col-sm-1">
                                    <input type="text" class="form-control blue-text" value="{{ strtoupper($institute->code) }}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-2">Name :</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control blue-text" value="{{ strtoupper($institute->name) }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- ./Display of Institute's Details--}}

                    {{-- Display of Institute's Postal Address Details--}}
                    <div class="panel panel-info">
                        <div class="panel-heading"><div class="blue-text center-text large-text">Institute's Postal Address Details</div></div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="control-label col-sm-2">Street Address :</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control blue-text" name="street_address" id="street_address"  @if($institute->street_address != '') value="{{ strtoupper($institute->street_address) }}" @endif />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-2">Post Office :</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control blue-text" name="postoffice" id="postoffice" @if(!is_null($institute->postoffice)) value="{{ strtoupper($institute->postoffice) }}" @endif />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-2">State :</label>
                                <div class="col-sm-3">
                                    <select class="form-control blue-text" name="state_id" id="state_id">
                                        @if($institute->city_id == 0)
                                            <option value="0" selected>-- Select State --</option>
                                            @foreach($states as $state)
                                                <option value="{{ $state->id }}">{{ strtoupper($state->state_name) }}</option>
                                            @endforeach
                                        @else
                                            <option value="0">-- Select State --</option>
                                            @foreach($states as $state)
                                                <option value="{{ $state->id }}"
                                                        @if($institute->city->state->id == $state->id)
                                                        selected
                                                        @endif
                                                >{{ $state->state_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <label class="control-label col-sm-3">District:</label>
                                <div class="col-sm-3">
                                    <select class="form-control blue-text" name="city_id" id="city_id" onchange="updateRemarks()">
                                        @if($institute->city_id != 0)
                                            <option value="0">-- Select District --</option>
                                            @foreach($cities as $city)
                                                @if($city->state_id == $institute->city->state_id)
                                                    <option value="{{ $city->id }}"
                                                            @if($institute->city_id == $city->id)
                                                            selected
                                                            @endif
                                                    >
                                                        {{ $city->name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-2">Pincode :</label>
                                <div class="col-sm-1">
                                    <input type="number" class="form-control blue-text" name="pincode" id="pincode" @if($institute->pincode != '') value="{{ $institute->pincode }}" @endif />
                                </div>

                                <label class="control-label col-sm-5">Landmark :</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control blue-text" name="landmark" id="landmark"  @if($institute->landmark != '') value="{{ strtoupper($institute->landmark) }}" @endif />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-2">Email address :</label>
                                <div class="col-sm-3">
                                    <input type="email" class="form-control blue-text" name="email" id="email"  @if($institute->email != '') value="{{ $institute->email }}" @endif />
                                </div>

                                <label class="control-label col-sm-3">Alternate Email address :</label>
                                <div class="col-sm-3">
                                    <input type="email" class="form-control blue-text" name="email2" id="email2"  @if($institute->email2 != '') value="{{ $institute->email2 }}" @endif />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-2">Contact Number :</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control blue-text" name="contactnumber1" id="contactnumber1"  @if($institute->contactnumber1 != '') value="{{ $institute->contactnumber1 }}" @endif />
                                </div>

                                <label class="control-label col-sm-3">Alternate Contact Number :</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control blue-text" name="contactnumber2" id="contactnumber2"  @if($institute->contactnumber2 != '') value="{{ $institute->contactnumber2 }}" @endif />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-2">Website :</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control blue-text" name="contactnumber1" id="contactnumber1"  @if($institute->website != '') value="{{ $institute->website }}" @endif />
                                </div>

                                <label class="control-label col-sm-3">Faxno :</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control blue-text" name="contactnumber2" id="contactnumber2"  @if($institute->faxno != '') value="{{ $institute->faxno }}" @endif />
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- ./Display of Institute's Postal Address Details--}}

                    {{-- Display of Institute's Head Details--}}
                    <div class="panel panel-info">
                        <div class="panel-heading"><div class="blue-text center-text large-text">Institute's Head details</div></div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="control-label col-sm-2">Name :</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control blue-text" name="head_name" id="head_name"  @if($institute->institutehead->name != '') value="{{ strtoupper($institute->institutehead->name) }}" @endif />
                                </div>

                                <label class="control-label col-sm-2">Designation :</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control blue-text" name="head_name" id="head_name"  @if($institute->institutehead->designation != '') value="{{ strtoupper($institute->institutehead->designation) }}" @endif />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-2">Qualification :</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control blue-text" name="head_qualification" id="head_qualification"  @if($institute->institutehead->qualification != '') value="{{ $institute->institutehead->qualification }}" @endif />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-2">RCI's CRR No :</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control blue-text" name="head_rci_reg_no" id="head_rci_reg_no"  @if($institute->institutehead->rci_reg_no != '') value="{{ $institute->institutehead->rci_reg_no }}" @endif />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-2">Contact Number :</label>
                                <div class="col-sm-3">
                                    <input type="number" class="form-control blue-text" name="head_contactnumber1" id="head_contactnumber1"  @if($institute->institutehead->contactnumber1 != '') value="{{ $institute->institutehead->contactnumber1 }}" @endif />
                                </div>

                                <label class="control-label col-sm-3">Alternate Contact Number :</label>
                                <div class="col-sm-3">
                                    <input type="number" class="form-control blue-text" name="head_contactnumber2" id="head_contactnumber2"  @if($institute->institutehead->contactnumber2 != '') value="{{ $institute->institutehead->contactnumber2 }}" @endif />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-2">Email address :</label>
                                <div class="col-sm-3">
                                    <input type="email" class="form-control blue-text" name="head_email" id="head_email"  @if($institute->institutehead->email != '') value="{{ $institute->institutehead->email }}" @endif />
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- ./Display of Institute's Head Details--}}

                    {{-- Display of Institute's Certificate Incharge Details--}}
                    <div class="panel panel-info">
                        <div class="panel-heading"><div class="blue-text center-text large-text">Institute's Certificate Incharge details</div></div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="control-label col-sm-2">Name :</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control blue-text" name="certificateincharge_name" id="certificateincharge_name"  @if($institute->institutecertificateincharge->name != '') value="{{ strtoupper($institute->institutecertificateincharge->name) }}" @endif />
                                </div>

                                <label class="control-label col-sm-2">Designation :</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control blue-text" name="certificateincharge_name" id="certificateincharge_name"  @if($institute->institutecertificateincharge->designation != '') value="{{ strtoupper($institute->institutecertificateincharge->designation) }}" @endif />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-2">Contact Number :</label>
                                <div class="col-sm-3">
                                    <input type="number" class="form-control blue-text" name="certificateincharge_contactnumber1" id="certificateincharge_contactnumber1"  @if($institute->institutecertificateincharge->contactnumber1 != '') value="{{ $institute->institutecertificateincharge->contactnumber1 }}" @endif />
                                </div>

                                <label class="control-label col-sm-3">Alternate Contact Number :</label>
                                <div class="col-sm-3">
                                    <input type="number" class="form-control blue-text" name="certificateincharge_contactnumber2" id="certificateincharge_contactnumber2"  @if($institute->institutecertificateincharge->contactnumber2 != '') value="{{ $institute->institutecertificateincharge->contactnumber2 }}" @endif />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-2">Email address :</label>
                                <div class="col-sm-3">
                                    <input type="email" class="form-control blue-text" name="certificateincharge_email" id="certificateincharge_email"  @if($institute->institutecertificateincharge->email != '') value="{{ $institute->institutecertificateincharge->email }}" @endif />
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- ./Display of Institute's Certificate Incharge Details--}}

                    {{-- Display of Institute's Facilities Details--}}
                    <div class="panel panel-info">
                        <div class="panel-heading"><div class="blue-text center-text large-text">Institute's Facilities details</div></div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="control-label col-sm-2">Build up Area :</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control blue-text" name="facility_buildup_area" id="facility_buildup_area"  @if($institute->institutefacility->buildup_area != '') value="{{ $institute->institutefacility->buildup_area }}" @endif />
                                        <span class="input-group-addon">(in sq.ft)</span>
                                    </div>
                                </div>
                                <div class="col-sm-2"></div>
                                <label class="control-label col-sm-2">Land Area :</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control blue-text" name="facility_landarea" id="facility_landarea"  @if($institute->institutefacility->landarea != '') value="{{ $institute->institutefacility->landarea }}" @endif />
                                        <span class="input-group-addon">(in sq.ft)</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-2">Approx. distance from the city (Bus Stand / railway station) :</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control blue-text" name="facility_city_distance" id="facility_city_distance"  @if($institute->institutefacility->city_distance != '') value="{{ $institute->institutefacility->city_distance }}" @endif />
                                        <span class="input-group-addon">(in kms)</span>
                                    </div>
                                </div>
                                <div class="col-sm-2"></div>
                                <label class="control-label col-sm-2">Approx. distance from the nearest Post Office :</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control blue-text" name="facility_postoffice_distance" id="facility_postoffice_distance"  @if($institute->institutefacility->postoffice_distance != '') value="{{ $institute->institutefacility->postoffice_distance }}" @endif />
                                        <span class="input-group-addon">(in kms)</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-2">Available number of rooms :</label>
                                <div class="col-sm-1">
                                    <input type="email" class="form-control blue-text" name="facility_available_rooms" id="facility_available_rooms"  @if($institute->institutefacility->available_rooms != '') value="{{ $institute->institutefacility->available_rooms }}" @endif />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-2">Biometric Facility :</label>
                                <div class="col-sm-4">
                                    <label class="radio-inline">
                                        <input type="radio" name="bimetric_facility" id="bimetric_facility1" value="Yes" onchange="statusValue()" @if($institute->institutefacility->biometric_facility == 'Yes') checked @endif><span class="label label-success medium-text">Yes</span>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="bimetric_facility" id="bimetric_facility2" value="No" onchange="statusValue()" @if($institute->institutefacility->biometric_facility == 'No') checked @endif><span class="label label-danger medium-text">No</span>
                                    </label>
                                </div>

                                <label class="control-label col-sm-2">CCTV Facility :</label>
                                <div class="col-sm-4">
                                    <label class="radio-inline">
                                        <input type="radio" name="cctv_facility" id="cctv_facility1" value="Yes" onchange="statusValue()" @if($institute->institutefacility->cctv_facility == 'Yes') checked @endif><span class="label label-success medium-text">Yes</span>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="cctv_facility" id="cctv_facility2" value="No" onchange="statusValue()" @if($institute->institutefacility->cctv_facility == 'No') checked @endif><span class="label label-danger medium-text">No</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- ./Display of Institute's Facilities Details--}}

                    {{-- Display of Institute's Centre Information Update Remarks Details--}}
                    <div class="panel panel-info">
                        <div class="panel-heading"><div class="blue-text center-text large-text">Institute's Centre Information Update Remarks details</div></div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-condensed" role="table">
                                    <tr class="bg-warning">
                                        <th width="5%" class="text-danger center-text">
                                            S.No.
                                        </th>
                                        <th width="10%" class="text-danger center-text">
                                            Updated on
                                        </th>
                                        <th width="15%" class="text-danger center-text">
                                            Updated by
                                        </th>
                                        <th width="70%" class="text-danger center-text">
                                            Update Remarks
                                        </th>
                                    </tr>

                                    @php $sno = 1; @endphp
                                    @foreach($institute->instituteinformationupdates as $information)
                                        <tr @if($institute->user_id == $information->user_id) class="blue-text" @else class="red-text" @endif>
                                            <td class="text-info center-text">{{ $sno }}</td>
                                            <td class="text-info center-text">{{ $information->created_at->format('d-m-Y') }}<br>{{ $information->created_at->format('H:i:s A') }}</td>
                                            <td class="text-info center-text">{{ $information->user->username }}</td>
                                            <td class="text-info justified-text">{{ $information->update_remarks }}</td>
                                        </tr>
                                        @php $sno++; @endphp
                                    @endforeach
                                </table>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-2">Update Status :</label>
                                <div class="col-sm-4">
                                    <label class="radio-inline">
                                        <input type="radio" name="status_id" id="status_id_2" value="2" onchange="statusValue()"><span class="label label-success medium-text">Approve</span>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="status_id" id="status_id_1" value="1" onchange="statusValue()"><span class="label label-danger medium-text">Reject</span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group" id="updateRemarksDiv">
                                <label class="control-label col-sm-2">Update Remarks :</label>
                                <div class="col-sm-4">
                                    <select class="form-control" id="updateSelect">
                                        <option value="0" selected>Select from Options</option>
                                        <option value="1">Please enter only the name of the Post Office</option>
                                        <option value="2">Please enter proper landmark</option>
                                        <option value="3">Other</option>
                                    </select>
                                </div>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="update_remarks" id="update_remarks" placeholder="Enter Reject Remarks" />
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- ./Display of Institute's Centre Information Update Remarks Details--}}
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </div>
            </div>
        </div>

    </form>

    <script>
        $(document).ready(function () {
            $('#updateRemarksDiv').hide();
            $('#updateSelect').prop('readOnly', true);
            $('#update_remarks').prop('readOnly', true);
            $('#update_remarks').val($("option:selected", $('#updateSelect')).text());
            $('#update_remarks').addClass('red-text');

            $('#updateSelect').on('change', function(){
                if($(this).val() == '0') {
                    $('#update_remarks').removeClass('blue-text');
                    $('#update_remarks').removeClass('green-text');
                    $('#update_remarks').prop('readOnly', true);
                    $('#update_remarks').val($("option:selected", this).text());
                    $('#update_remarks').addClass('red-text');
                }
                else if($(this).val() == '3') {
                    $('#update_remarks').removeClass('red-text');
                    $('#update_remarks').removeClass('green-text');
                    $('#update_remarks').prop('readOnly', false);
                    $('#update_remarks').val('');
                    $('#update_remarks').addClass('blue-text');
                }
                else {
                    $('#update_remarks').removeClass('red-text');
                    $('#update_remarks').removeClass('blue-text');
                    $('#update_remarks').prop('readOnly', true);
                    $('#update_remarks').val($("option:selected", this).text());
                    $('#update_remarks').addClass('green-text');
                }
            });
        });

        function validateForm() {
            if($('#status_id').val() == 0) {
                return false;
            }

            if($('#status_id').val() == 1) {
                if($('#updateSelect').val() == 0) {
                    swal("Error Occurred!!!", "Please enter the Reject Remarks.", "error");
                    return false;
                }
                else if($('#updateSelect').val() == 3) {
                    if(!$('#update_remarks')) {
                        swal("Error Occurred!!!", "Please enter the Reject Remarks.", "error");
                        return false;
                    }
                }

                return false;
            }

            return false;
        }

        function statusValue() {
            var status = $('input[name="status_id"]:checked').val();

            if(status == 1) {
                $('#updateRemarksDiv').show();
                $('#updateSelect').val('0').change();
            }
            else {
                $('#updateRemarksDiv').hide();
            }

            $('#status_id').val(status);
        }
    </script>

@endsection