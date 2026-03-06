@extends('layouts.app')
@section('content')
<style>
    input, select{
        width: 100%;
        border: 1px solid #aaa;
    }
</style>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @include('common.errorandmsg')
                <h3>Profile</h3>
                <h4>Institute Details</h4>
                <form action="{{url('institute/profile/update')}}" method="post">
                    {!! csrf_field() !!}
                    <table class="table table-bordered">
                        <tr>
                            <th>Institute Code</th>
                            <td>{{$institute->rci_code}}</td>
                        </tr>
                        <tr>
                            <th>Institute Name</th>
                            <td>
                                <input type="text" value="{{$institute->name}}" name="name">
                            </td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>
                            <input type="text" value="{{$institute->street_address}}" name="street_address">
                            </td>
                        </tr>
                        <tr>
                            <th>City/Village</th>
                            <td>
                                <select name="city_id" id="city_id">
                                    <option value="0" disabled>Please select</option>
                                    @foreach($cities as $city)
                                        <option value="{{$city->id}}" @if($institute->city_id == $city->id) selected @endif>{{$city->name}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Landmark</th>
                            <td>
                            <input type="text" value="{{$institute->landmark}}" name="landmark">
                            </td>
                        </tr>
                        <tr>
                            <th>State</th>
                            <td>
                                <select name="state_id" id="state_id">
                                    <option value="0" disabled>Please select</option>
                                    @foreach($states as $state)
                                        <option value="{{$state->id}}" @if($institute->state_id == $state->id) selected @endif>{{$state->state_name}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Post Office</th>
                            <td>
                            <input type="text" value="{{$institute->postoffice}}" name="postoffice">
                            </td>
                        </tr>
                        <tr>
                            <th>PIN Code</th>
                            <td>
                            <input type="text" value="{{$institute->pincode}}" name="pincode">
                            </td>
                        </tr>
                        <tr>
                            <th>Contact Person</th>
                            <td>
                            <input type="text" value="{{$institute->contact}}" name="contact">
                            </td>
                        </tr>
                        <tr>
                            <th>Email Address</th>
                            <td>
                            <input type="text" value="{{$institute->email}}" name="email">
                            </td>
                        </tr>
                        <tr>
                            <th>Contact Number</th>
                            <td>
                            <input type="text" value="{{$institute->contactnumber1}}" name="contactnumber1">
                            </td>
                        </tr>
                        <tr>
                            <th>Alternative Contact Number</th>
                            <td>
                            <input type="text" value="{{$institute->contactnumber2}}" name="contactnumber2">
                            </td>
                        </tr>
                        <tr>
                            <th>Website</th>
                            <td>
                            <input type="text" value="{{$institute->website}}" name="website">
                            </td>
                        </tr>
                    </table>
                    <button type="submit" class="btn btn-xs btn-primary pull-right">Update</button>
                </form>
                <br>
                <hr>
                <h4>Institute Head</h4>
                <form action="{{url('institute/institutehead/update')}}" method="post">
                {!! csrf_field() !!}
                <table class="table table-bordered">
                    <tr>
                        <th>
                            Name
                        </th>
                        <td>
                        <input type="text" value="{{$institutehead->name}}" name="name">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Designation
                        </th>
                        <td>
                        <input type="text" value="{{$institutehead->designation}}" name="designation">
                        </td>

                    </tr>
                    <tr>
                        <th>
                            Qualification
                        </th>
                        <td>
                        <input type="text" value="{{$institutehead->qualification}}" name="qualification">

                        </td>
                    </tr>
                    <tr>    
                        <th>
                            CRR Number
                        </th>
                        <td>
                        <input type="text" value="{{$institutehead->rci_reg_no}}" name="rci_reg_no">

                        </td>
                    </tr>
                    <tr>
                        <th>
                            Email Address
                        </th>
                        <td>
                        <input type="text" value="{{$institutehead->email}}" name="email">

                        </td>
                    </tr>
                    <tr>
                        <th>
                            Contact Number
                        </th>
                        <td>
                        <input type="text" value="{{$institutehead->contactnumber1}}" name="contactnumber1">

                        </td>
                    </tr>
                    <tr>
                        <th>
                            Alternative Contact Number
                        </th>
                        <td>
                        <input type="text" value="{{$institutehead->contactnumber2}}" name="contactnumber2">

                        </td>
                    </tr>
                </table>
                <button type="submit" class="btn btn-xs btn-primary pull-right">Update</button>
                </form>
                <br>
                <hr>
                <h4>Facilities</h4>
                <form action="{{url('institute/facilities/update')}}" method="post">
                {!! csrf_field() !!}
                <table class="table table-bordered">
                    <tr>
                        <th>
                            Buildup Area (Sq Meter)
                        </th>
                        <td>
                        <input type="text" value="{{$facilities->buildup_area}}" name="buildup_area">

                        </td>
                    </tr>
                    <tr>
                        <th>
                        Land Area (Sq Meter)
                        </th>
                        <td>
                        <input type="text" value="{{$facilities->landarea}}" name="landarea">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Distance to nearest City (in Km)
                        </th>
                        <td>
                        <input type="text" value="{{$facilities->city_distance}}" name="city_distance">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Distance to Post Office (in Km)
                        </th>
                        <td>
                        <input type="text" value="{{$facilities->postoffice_distance}}" name="postoffice_distance">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Number of Available Rooms
                        </th>
                        <td>
                        <input type="text" value="{{$facilities->available_rooms}}" name="available_rooms">
                        </td>
                    </tr>
                    <tr>
                        <th>
                        Classroom Size (Sq Meter)
                        </th>
                        <td>
                        <input type="text" value="{{$facilities->classroom_size}}" name="classroom_size">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Biometric Facility
                        </th>
                        <td>
                        <select name="biometric_facility" id="biometric_facility">
                            <option value="0" disalbed>Please select</option>
                            <option value="Yes" @if($facilities->biometric_facility=='Yes') selected @endif>Yes</option>
                            <option value="No" @if($facilities->biometric_facility=='No') selected @endif>No</option>
                        </select>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            CCTV Facility
                        </th>
                        <td>
                            <select name="cctv_facility" id="cctv_facility">
                                <option value="0" disalbed>Please select</option>
                            <option value="Yes" @if($facilities->cctv_facility=='Yes') selected @endif>Yes</option>
                            <option value="No" @if($facilities->cctv_facility=='No') selected @endif>No</option>
                        </select>
                        </td>
                    </tr>
                </table>
                <button type="submit" class="btn btn-xs btn-primary pull-right">Update</button>
                </form>
                <br>
                <hr>
            </div>
        </div>
    </div>
@endsection