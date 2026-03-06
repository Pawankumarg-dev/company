@extends('layouts.app')
@section('style')
    <script>
        async function init() {
            await customElements.whenDefined('gmp-map');

            const map = document.querySelector('gmp-map');
            const marker = document.querySelector('gmp-advanced-marker');
            const placePicker = document.querySelector('gmpx-place-picker');
            const infowindow = new google.maps.InfoWindow();

            map.innerMap.setOptions({
            mapTypeControl: false
            });

            placePicker.addEventListener('gmpx-placechange', () => {
            const place = placePicker.value;

            if (!place.location) {
                window.alert(
                "No details available for input: '" + place.name + "'"
                );
                infowindow.close();
                marker.position = null;
                return;
            }

            if (place.viewport) {
                map.innerMap.fitBounds(place.viewport);
            } else {
                map.center = place.location;
                map.zoom = 17;
            }

            marker.position = place.location;
            infowindow.setContent(
                `<strong>${place.displayName}</strong><br>
                <span>${place.formattedAddress}</span>
            `);
            infowindow.open(map.innerMap, marker);
            });
        }

        document.addEventListener('DOMContentLoaded', init);
    </script>
    <style>

      .place-picker-container {
        padding: 20px;
      }
    </style>
    <script type="module" src="https://unpkg.com/@googlemaps/extended-component-library@0.6">
    </script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @include('common.errorandmsg')
                {{ csrf_field() }}
                <h3>Profile
                {{--<a href="{{url('institute/edit/profile')}}" class="btn btn-primary btn-xs pull-right">Edit</a>--}}
                </h3>
                <gmpx-api-loader key="AIzaSyD_cYWEO3v93ZQz39qZEnMdVKde_1LYRy0" solution-channel="GMP_GE_mapsandplacesautocomplete_v1">
                </gmpx-api-loader>
                <gmp-map center="40.749933,-73.98633" zoom="13" map-id="DEMO_MAP_ID">
                  <div slot="control-block-start-inline-start" class="place-picker-container">
                    <gmpx-place-picker placeholder="Enter an address"></gmpx-place-picker>
                  </div>
                  <gmp-advanced-marker></gmp-advanced-marker>
                </gmp-map>
                
                @if($institute->is_data_verified !=1 || $institute->is_mobile_verified !=1 || $institute->is_email_verified  !=1 || $institute->is_institute_head_verified  !=1 || $institute->is_institute_head_email_verified  !=1 || $institute->is_institute_head_mobile_verified !=1 || $institute->is_facilities_verified !=1)
                <div class="alert alert-warning" >
                    Cick on Edit to update
                    <ul>
                        @if($institute->is_data_verified !=1 )
                            <li>Institute Adddress</li>
                        @endif
                        @if($institute->is_institute_head_verified !=1 )
                            <li>Details of the head of institute</li>
                        @endif
                        
                        @if($institute->is_facilities_verified !=1 )
                            <li>Facilities</li>
                        @endif
                    </ul>
               {{--     Cick on Get OTP to verify mobile / email
                    <ul>
                        @if($institute->is_mobile_verified !=1 )
                            <li>Verifiy Institute Mobile Number</li>
                        @endif
                        @if($institute->is_email_verified !=1 )
                            <li>Verifiy Institute Email Address</li>
                        @endif
                        @if($institute->is_institute_head_email_verified !=1 )
                            <li>Verify email of the head of institute</li>
                        @endif
                        @if($institute->is_institute_head_mobile_verified !=1 )
                            <li>Verify mobile number of the head of institute</li>
                        @endif
                    </ul> --}}
                </div>
            @endif

            @if($institute->is_data_verified !=1 )
            <div class="alert alert-info" >
                You have not updated the password recently. Click <a href="{{url('/institute/changepassword')}}">here</a> to change password.
            </div>
            @endif
               
                <h4>Institute Details</h4>
                <table class="table table-bordered">
                    <tr>
                        <th>Institute Code</th>
                        <td>{{$institute->rci_code}}</td>
                    </tr>
                    <tr>
                        <th>Institute Name</th>
                        <td>{{$institute->name}}</td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>{{$institute->street_address}}</td>
                    </tr>
                    <tr>
                        <th>City/Village</th>
                        <td>@if($institute->city_id>0){{$institute->city->name}}@endif</td>
                    </tr>
                    <tr>
                        <th>Landmark</th>
                        <td>{{$institute->landmark}}</td>
                    </tr>
                    <tr>
                        <th>State</th>
                        <td>@if($institute->state_id>0){{$institute->state->name}}@endif</td>
                    </tr>
                    <tr>
                        <th>Post Office</th>
                        <td>{{$institute->postoffice}}</td>
                    </tr>
                    <tr>
                        <th>PIN Code</th>
                        <td>{{$institute->pincode}}</td>
                    </tr>
                    <tr>
                        <th>Contact Person</th>
                        <td>{{$institute->contact}}</td>
                    </tr>
                    <tr>
                        <th>Email Address</th>
                        <td>
                            @if($institute->email != '')
                                {{$institute->email}}
                                @if($institute->is_email_verified == 1)
                                <span class="label label-success hidden">Verified</span>
                                @else
                                    <span class="label label-danger hidden">Not Verified</span>
                                    <button class="btn btn-primary btn-xs hidden " style="margin-top:5px;margin-bottom:10px;" id="sendemailotp" >Get OTP</button><br />
                                    <div class="hidden" id="resendemailotp" >OTP Sent. Didn't receive? <a href="javascript:sendemailotp();">Resend</a> <br> </div>
                                @endif
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Mobile Number</th>
                        <td>
                            @if($institute->contactnumber1 != '')
                                {{$institute->contactnumber1}}
                                @if($institute->is_mobile_verified == 1)
                                <span class="label label-success hidden">Verified</span>
                                @else
                                    <span class="label label-danger hidden">Not Verified</span>
                                    <button class="btn btn-primary btn-xs hidden" style="margin-top:5px;margin-bottom:10px;" id="sendotp" >Get OTP</button><br />
                                    <div class="hidden" id="resend" >OTP Sent. Didn't receive? <a href="javascript:sendotp();">Resend</a> <br> </div>
                                @endif
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Alternative Contact Number</th>
                        <td>{{$institute->contactnumber2}}</td>
                    </tr>
                    <tr>
                        <th>Website</th>
                        <td>{{$institute->website}}</td>
                    </tr>
                </table>
                <h4>Institute Head</h4>
                <table class="table table-bordered">
                    <tr>
                        <th>
                            Name
                        </th>
                        <td>
                            {{$institutehead->name}}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Designation
                        </th>
                        <td>
                            {{$institutehead->designation}}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Qualification
                        </th>
                        <td>
                            {{$institutehead->qualification}}
                        </td>
                    </tr>
                    <tr>    
                        <th>
                            CRR Number
                        </th>
                        <td>
                            {{$institutehead->rci_reg_no}}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Email Address
                        </th>
                        <td>
                            @if($institutehead->email != '')
                                {{$institutehead->email}}
                                @if($institute->is_institute_head_email_verified == 1)
                                <span class="label label-success hidden">Verified</span>
                                @else
                                    <span class="label label-danger hidden">Not Verified</span>
                                @endif
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Mobile Number
                        </th>
                        <td>
                            @if($institutehead->contactnumber1 != '')
                                {{$institutehead->contactnumber1}}
                                @if($institute->is_institute_head_mobile_verified == 1)
                                <span class="label label-success hidden">Verified</span>
                                @else
                                    <span class="label label-danger hidden">Not Verified</span>
                                @endif
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Alternative Contact Number
                        </th>
                        <td>
                            {{$institutehead->contactnumber2}}
                        </td>
                    </tr>
                </table>
                <h4>Facilities</h4>
                <table class="table table-bordered">
                    <tr>
                        <th>
                            Buildup Area (Sq Meter)
                        </th>
                        <td>
                            {{$facilities->buildup_area}}
                        </td>
                    </tr>
                    <tr>
                        <th>
                        Land Area (Sq Meter)
                        </th>
                        <td>
                            {{$facilities->landarea}}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Distance to nearest City (in Km)
                        </th>
                        <td>
                            {{$facilities->city_distance}}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Distance to Post Office (in Km)
                        </th>
                        <td>
                            {{$facilities->postoffice_distance}}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Number of Available Rooms
                        </th>
                        <td>
                            {{$facilities->available_rooms}}
                        </td>
                    </tr>
                    <tr>
                        <th>
                        Classroom Size (Sq Meter)
                        </th>
                        <td>
                            {{$facilities->classroom_size}}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Biometric Facility
                        </th>
                        <td>
                            {{$facilities->biometric_facility}}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            CCTV Facility
                        </th>
                        <td>
                            {{$facilities->cctv_facility}}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <script>
        function sendotp(){
            $('#resend').addClass('hidden');
            var token = $('input[name=_token]');
            var formData = new FormData();
            $.ajax({
                url: "{{url('/institute/generateotp')}}",
                method: 'POST',
                dataType: 'json',
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': token.val()
                },
                data: formData,
                success: function (data) {
                    console.log(data);
                    if(data['error']){
                        swal({
                            type: 'warning',
                            title: data['error'],
                            showConfirmButton: true,
                            timer: 3500
                        });
                        $('#sendotp').attr('disabled',false);

                    }else{
                        $('#resend').removeClass('hidden');
                        otppopup();
                    }
                },
                error: function (data) {
                    console.log(data);
                    if (data.status === 200) {
                        $('#resend').removeClass('hidden');
                        otppopup();
                    } else {
                        $('#sendotp').attr('disabled',false);
                    }
                }
            });
        }
        function otppopup(){
            swal({
                title: 'Confirmation Mobile Number'  ,
                text: "Enter the OTP received ",
				input: 'text',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Confirm',
				inputValidator: (value) => {
					if (value == '') 
					{
						return 'OTP cannot be empty!'
					}
					else {
						var formData = new FormData();
						var token = $('input[name=_token]');
						formData.append('otp', value);
						$.ajax({
							url: '{{url("institite/validateotp")}}',
							method: 'POST',
							dataType: 'json',
							contentType: false,
							processData: false,
							headers: {
								'X-CSRF-TOKEN': token.val()
							},
							data: formData,
							success: function (data) {
								console.log(data);
								if(data=='success'){
									swal({
										type: 'success',
										title: 'Mobile Number Verified',
										showConfirmButton: false,
										timer: 3000
									});
									setTimeout(function(){
										location.reload();
									}, 3000); 
								}else{
									swal({
										type: 'warning',
										title: 'Could not verify OTP',
										showConfirmButton: false,
										timer: 1500
									});
								}
							},
							error: function (data) {
								swal({
									type: 'warning',
									title: 'Could not verify OTP',
									showConfirmButton: false,
									timer: 1500
								});
							}
						});
					}
				},
            }).then((result) => {
                
            })
        }
        $(document).ready(function () {
            $("#sendotp").on('click',function(){
                $(this).attr('disabled',true);
                sendotp();
            });
        });
    </script>
@endsection