<style>
    .modal-dialog {
        width: 98%;
        height: 92%;
        padding: 0;
    }

    .modal-content {
        height: auto;
    }
</style>

{{--
<form class="form-horizontal" role="form" method="POST" action="{{url('/nber/notifications/institute-information/updateStatus')}}" onsubmit="return validateForm()">
    {{ csrf_field() }}

    <input type="hidden" name="institute_id" id="institute_id" value="{{ $institute->id }}" />
    <input type="hidden" name="institute_name" id="institute_name" value="{{ $institute->name }}" />
    <input type="hidden" name="status_id" id="status_id" value="0" />

    <!-- showModal -->
    <div class="modal fade" id="showModal_{{ $institute->id }}" role="dialog" data-backdrop="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <div class="modal-title blue-text center-text">
                        <h3>
                            {{ $institute->code }} - {{ $institute->name }}<br>Institute Information
                        </h3>
                    </div>
                </div>

                <div class="modal-body">
                    <!-- Postal Address -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-condensed">
                                    <tr>
                                        <th colspan="3" class="center-text"><h4>Postal Address</h4></th>
                                    </tr>
                                    <tr>
                                        <th class="green-text" style="width: 15%">Address</th>
                                        <th class="center-text" style="width: 2%">:</th>
                                        <td class="blue-text">
                                            @if($institute->street_address != '') {{$institute->street_address}} @endif
                                            @if(!is_null($institute->postoffice))
                                                <br>{{ $institute->postoffice }} POST OFFICE,
                                            @endif
                                            @if($institute->city_id != 0)
                                                <br>{{ $institute->city->name }} DIST., {{ $institute->city->state->state_name }}
                                            @endif
                                            @if($institute->pincode != '') - {{$institute->pincode}}. @endif
                                            @if($institute->landmark != '') <br>LANDMARK - {{$institute->landmark}} @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="green-text">Email Address</th>
                                        <th class="center-text">:</th>
                                        <td class="blue-text">{{ $institute->email }}</td>
                                    </tr>
                                    <tr>
                                        <th class="green-text">Alternate Email Address</th>
                                        <th class="center-text">:</th>
                                        <td class="blue-text">{{ $institute->email2 }}</td>
                                    </tr>
                                    <tr>
                                        <th class="green-text">Contact Number(s)</th>
                                        <th class="center-text">:</th>
                                        <td class="blue-text">
                                            @if($institute->contactnumber1 != '') {{$institute->contactnumber1}}@endif
                                            @if($institute->contactnumber2 != '')
                                                , {{$institute->contactnumber2}}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="green-text">Website</th>
                                        <td class="center-text">:</td>
                                        <td class="blue-text">@if($institute->website != '') {{$institute->website}} @else NIL @endif</td>
                                    </tr>
                                    <tr>
                                        <th class="green-text">Fax No.</th>
                                        <th class="center-text">:</th>
                                        <td class="blue-text">@if($institute->faxno != '') {{$institute->faxno}} @else NIL @endif</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- ./Postal Address -->

                    <!-- Institute Head -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-condensed">
                                    <tr>
                                        <th colspan="3" class="center-text"><h4>Institute Head Information</h4></th>
                                    </tr>
                                    <tr>
                                        <th class="green-text" style="width: 15%">Name</th>
                                        <th class="center-text" style="width: 2%">:</th>
                                        <td class="blue-text">{{ $institute->institutehead->name }}</td>
                                    </tr>
                                    <tr>
                                        <th class="green-text">Designation</th>
                                        <th class="center-text">:</th>
                                        <td class="blue-text">{{ $institute->institutehead->designation }}</td>
                                    </tr>
                                    <tr>
                                        <th class="green-text">Qualification</th>
                                        <th class="center-text">:</th>
                                        <td class="blue-text">{{ $institute->institutehead->qualification }}</td>
                                    </tr>
                                    <tr>
                                        <th class="green-text">RCI Reg. No.</th>
                                        <th class="center-text">:</th>
                                        <td class="blue-text">{{ $institute->institutehead->rci_reg_no }}</td>
                                    </tr>
                                    <tr>
                                        <th class="green-text">Email Address</th>
                                        <th class="center-text">:</th>
                                        <td class="blue-text">{{ $institute->institutehead->email }}</td>
                                    </tr>
                                    <tr>
                                        <th class="green-text">Contact Number(s)</th>
                                        <th class="center-text">:</th>
                                        <td class="blue-text">
                                            @if($institute->institutehead->contactnumber1 != '') {{$institute->institutehead->contactnumber1}}@endif
                                            @if($institute->institutehead->contactnumber2 != ''), {{$institute->institutehead->contactnumber2}}@endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- ./Institute Head -->

                    <!-- Institute Certificate Incharge -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-condensed">
                                    <tr>
                                        <th colspan="3" class="center-text"><h4>Details of Person Incharge for receiving Certificates / Statement of Marks</h4></th>
                                    </tr>
                                    <tr>
                                        <th class="green-text" style="width: 15%">Name</th>
                                        <th class="center-text" style="width: 2%">:</th>
                                        <td class="blue-text">{{ $institute->institutecertificateincharge->name }}</td>
                                    </tr>
                                    <tr>
                                        <th class="green-text">Designation</th>
                                        <th class="center-text">:</th>
                                        <td class="blue-text">{{ $institute->institutecertificateincharge->designation }}</td>
                                    </tr>
                                    <tr>
                                        <th class="green-text">Email Address</th>
                                        <th class="center-text">:</th>
                                        <td class="blue-text">{{ $institute->institutecertificateincharge->email }}</td>
                                    </tr>
                                    <tr>
                                        <th class="green-text">Contact Number(s)</th>
                                        <th class="center-text">:</th>
                                        <td class="blue-text">
                                            @if($institute->institutecertificateincharge->contactnumber1 != '') {{$institute->institutecertificateincharge->contactnumber1}} @endif
                                            @if($institute->institutecertificateincharge->contactnumber2 != '')
                                                , {{$institute->institutecertificateincharge->contactnumber2}}
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- ./Institute Certificate Incharge -->

                    <!-- Institute Facility -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-condensed">
                                    <tr>
                                        <th colspan="3" class="center-text"><h4>Institute Facilities Information</h4></th>
                                    </tr>
                                    <tr>
                                        <th class="green-text" style="width: 15%">Buildup Area</th>
                                        <th class="center-text" style="width: 2%">:</th>
                                        <td class="blue-text">
                                            @if($institute->institutefacility->buildup_area != '')
                                                {{ $institute->institutefacility->buildup_area }} (in square feet)
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="green-text">Land Area</th>
                                        <th class="center-text">:</th>
                                        <td class="blue-text">
                                            @if($institute->institutefacility->landarea != '')
                                                {{ $institute->institutefacility->landarea }} (in square feet)
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="green-text">Distance from the city (bus stand / railway station)</th>
                                        <th class="center-text">:</th>
                                        <td class="blue-text">
                                            @if($institute->institutefacility->city_distance != '')
                                                {{ $institute->institutefacility->city_distance }} (in kms)
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="green-text">Distance from the nearest Head Post office</th>
                                        <th class="center-text">:</th>
                                        <td class="blue-text">
                                            @if($institute->institutefacility->postoffice_distance != '')
                                                {{ $institute->institutefacility->postoffice_distance }} (in kms)
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="green-text">Available number of rooms</th>
                                        <th class="center-text">:</th>
                                        <td class="blue-text">
                                            @if($institute->institutefacility->available_rooms != '')
                                                {{ $institute->institutefacility->available_rooms }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="green-text">Size of the Classrooms</th>
                                        <th class="center-text">:</th>
                                        <td class="blue-text">
                                            @if($institute->institutefacility->classroom_size != '')
                                                {{ $institute->institutefacility->classroom_size }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="green-text">Biometric Facility Availability</th>
                                        <th class="center-text">:</th>
                                        <td class="blue-text">
                                            @if($institute->institutefacility->biometric_facility != '')
                                                {{ $institute->institutefacility->biometric_facility }}
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <th class="green-text">CCTV Facility Availability</th>
                                        <th class="center-text">:</th>
                                        <td class="blue-text">
                                            @if($institute->institutefacility->cctv_facility != '')
                                                {{ $institute->institutefacility->cctv_facility }}
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- ./Institute Facility -->

                    <!-- Update Remarks -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-condensed">
                                    <tr>
                                        <th colspan="3" class="center-text"><h4>Update Remarks</h4></th>
                                    </tr>
                                    @foreach($institute->instituteinformationupdates as $info)
                                        <tr>
                                            <th class="center-text" style="width: 10%">
                                                {{ $info->created_at->format('d-m-Y') }}<br>
                                                {{ $info->created_at->format('H:i:s A') }}
                                            </th>
                                            <td class="center-text" style="width: 2%">:</td>
                                            @if($info->institute->user_id == $info->user_id)
                                                <td class="blue-text">
                                                <span style="font-size: medium">
                                                    {{ $info->institute->code }} updated : {{ $info->update_remarks }}
                                                </span>
                                                </td>
                                            @else
                                                <td class="green-text">
                                                <span style="font-size: medium">
                                                    {{ $info->user->username }} {{ $info->update_remarks }}
                                                </span>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach

                                    <tr>
                                        <th class="center-text" style="width: 10%">
                                            Remarks
                                        </th>
                                        <td class="center-text" style="width: 2%">:</td>
                                        <td>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- ./Update Remarks -->

                    <!-- Update Remarks -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-condensed">
                                    <tr>
                                        <th colspan="3" class="center-text"><h4>Update Status</h4></th>
                                    </tr>

                                    <tr>
                                        <th class="center-text" style="width: 10%">
                                            Update Status
                                        </th>
                                        <td class="center-text" style="width: 2%">:</td>
                                        <td>
                                            <div class="col-sm-3">
                                                <label class="radio-inline">
                                                    <input type="radio" name="status" id="status1" value="2" onchange="statusValue()"><span class="label label-success" style="font-size: medium">Approve</span>
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="status" id="status2" value="1" onchange="statusValue()"><span class="label label-danger" style="font-size: medium">Reject</span>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr id="rejectDiv">
                                        <th class="center-text" style="width: 10%">
                                            Reject Remarks
                                        </th>
                                        <td class="center-text" style="width: 2%">:</td>
                                        <td>
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
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- ./Update Remarks -->
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok-circle"></span> Update</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove-circle"></span> Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ./showModal -->
</form>

<form class="form-horizontal">
    <div class="modal fade" id="showModal_{{ $institute->id }}" role="dialog" data-backdrop="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <div class="modal-title blue-text center-text">
                        <h3>
                            Institute Information
                        </h3>
                    </div>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="institute_code">Email :</label>
                        <div class="col-sm-10">

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="pwd">Password :</label>
                        <div class="col-sm-10">
                            <input type="password" onpaste="return false;" class="form-control" autocomplete="off" id="pwd" placeholder="Enter password">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <div class="checkbox">
                                <label><input type="checkbox"> Remember me</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-default">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
--}}

<form class="form-horizontal" method="POST" role="form">
    {{ csrf_field() }}


    <div class="modal fade" id="showModal_{{ $institute->id }}" role="dialog" data-backdrop="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <div class="modal-title blue-text center-text">
                        <h3>
                            Institute Information
                        </h3>
                    </div>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="institute_id" value="{{ $institute->id }}" />

                    <div class="form-group">
                        <label class="control-label col-sm-2">Code :</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control blue-text" value="{{ $institute->code }}" readonly />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">Name :</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control blue-text" value="{{ $institute->name }}" readonly />
                        </div>
                    </div>

                    <div class="panel-group">
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