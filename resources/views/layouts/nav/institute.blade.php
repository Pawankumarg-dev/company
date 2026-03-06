<?php $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; ;?>

<div id="printPageButton">
    <div class="container" style="background:white">
        <div class="row">
            <div class="col-sm-12 ">
                <!-- <img src="{{ url(asset('/images/header.png')) }}" class="img-rounded img-responsive center-block" height="60%"/> -->
                @include('layouts.nav.header')
            </div>
        </div>
    </div>

    <nav class="navbar navbar-default navbar-static-top darkblue-background">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    {{--
                    <li><a href="{{ url('/institute/center-information') }}">Center Information</a></li>
                    --}}

                    <li><a href="{{ url('/notice') }}">Home</a></li>
                    <li><a href="{{ url('/enrolment') }}">Enrolment</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            Examination <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('institute/examinations/applications/22') }}">Sep 2023 Exam </a></li>
                            <li><a href="{{url('/institute/exam/applicants?exam_id=24')}}" style="">April 2024
                                    Supplementary Exam</a></li>
                            <li><a href="{{url('/institute/exam/home/25')}}" style="">June 2024 Exam</a></li>
                            <li><a href="{{url('/institute/exam/home/26')}}" style="">January 2025 Supplementary Exam</a></li>
                            <li><a href="{{url('/institute/exam/home/27')}}" style="">June 2025 Exam</a></li>

                            <li><a class="" href="{{url('/institute/exam/home/28')}}" style="">January 2026 Supplementary Exam</a></li>
                        </ul>
                    </li>

                    <?php $host = request()->getHost(); ?>
                    @if($host=="examcell.niepmdexaminationsnber.com")
                    <li class="dropdown">

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            Payments <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            {{-- <li><a href="{{url('/institute/affiliationfee/')}}">Affiliation Fees</a>
                    </li>
                    <li><a href="{{url('/institute/enrolmentpayments')}}">Enrolment Fees</a></li> --}}
                    <li><a href="{{url('/institute/examinationpayments')}}">Examination Fees</a></li>
                </ul>
                </li>
                @endif

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        Payments <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{url('/institute/affiliationfee/')}}">Affiliation Fee</a></li>
                        {{--<li><a href="{{url('/institute/enrolmentfee')}}">Enrolment Fee</a>
                </li>
                <li><a href="{{url('institute/examinationpayments/22')}}">Examination Fee</a></li>--}}
                </ul>
                </li>

                <li><a href="{{ url('reportissue') }}">Data Correction Requests </a></li>
                <li><a href="{{ url('/institute/faculties') }}">Faculties </a></li>
                <li><a href="{{ url('institute/examcenters') }}">Exam Centers </a></li>

                {{--
                    <li><a href="{{ url('/institute/class-attendance') }}">Class Attendance </a></li>
                <li><a href="{{ url('/institute/certifications') }}">Certifications</a></li>
                <li><a href="{{ url('/institute/exam-centers') }}">Exam Centers</a></li>
                <li><a href="{{ url('institute/coursecoordinators') }}">Course Coordinators <img
                            src="{{ asset('/images/new.gif') }}" /> </a></li>
                --}}

                </ul>

                @if (strpos($url,'enrolment') == true )
                <ul class="nav navbar-nav navbar-right darkblue-background" style="color:white;">
                    <li class="dropdown">
                        <a href="#" style="background:orange!important;" class="dropdown-toggle" data-toggle="dropdown"
                            role="button" aria-expanded="false" style="color:white;">
                            <i class="fa fa-btn fa-eye"></i>
                            Ac.Yr: {{Session::get('academicyear')}} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            @foreach(\App\Academicyear::all()->sortByDesc('year') as $ay)
                            @if($ay->id != Session::get('academicyear_id'))
                            <li><a href="{{ url('/institute/changeayid/') }}/{{$ay->id}}">{{$ay->year}}</a></li>
                            @endif
                            @endforeach
                        </ul>
                    </li>
                </ul>
                @endif
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <form action="{{url('searchcandidates')}}">
                            <div class="input-group" style="width:300px;margin-top:7px;margin-right: 5px;">
                                <input type="text" name='key' class="form-control"
                                    placeholder="Search with Enrolment# or Name">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-primary" type="button"><i
                                            class="fa fa-btn fa-search"></i></button>
                                </span>
                            </div>
                        </form>
                    </li>

                    <!-- Authentication Links -->
                    @if (Auth::guest())
                    <li><a href="{{ url('/logoff') }}">Login</a></li>
                    @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->username }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/institute/profile') }}"><i class="fa fa-btn fa-user"></i>Profile</a>
                            </li>
                            <li><a href="{{ url('/institute/changepassword') }}"><i class="fa fa-btn fa-key"></i>Change
                                    Password</a></li>
                         <li><a href="{{ url('/logoff') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                </ul>
                </li>
                @endif
                </ul>

            </div>
        </div>
    </nav>
    {{--<div class="container-fluid">
        <div class="alert alert-danger">
            Website is currently not operational to accept the candidate enrolment information.
            Please downlod <a href="/UserGuide.pdf">Enrolment Guidelines</a>
        </div>
    </div>--}}
</div>

<?php $institute_location = Session::get('institute_location'); ?>


@if($institute_location->coordinate=='' || $institute_location->coordinate == null || $institute_location->newaddress=='' || $institute_location->newaddress==null)

<div id="myModal" class="modal fade in modal fade show" style="display: block;  background: linear-gradient(white 0%, rgb(231, 233, 221) 90%, white 100%);
" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="mapModalLabel">Update Your Institute Location
                </h3>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div class="modal-body">
                <!-- Form inside the Modal -->
                <div class='alert alert-danger'>
                    <h4>Please install geo camera on your mobile to get Longitude, Lattitude And Geo-tagged Photo of
                        your institute <a
                            href="https://play.google.com/store/apps/details?id=com.gpsmapcamera.geotagginglocationonphoto">Click
                            Here</a> to download and install geo camera app on your mobile</h4>
                </div>

                <form id="locationForm" action="{{url('/')}}/updatelocation" class="container mt-4" method='post'
                    enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <!-- Latitude Input -->
                    <input type="hidden" name='id' value="<?=$institute_location->rci_code ?>">
                    <!-- State -->
                    <div class="mb-3">
                        <label for="state">State</label>
                        <select name="state_id" class="form-control"  id="state_id" <?php if($institute_location->state_id!='' || $institute_location->state_id != null) { echo '';}?>>
                            <?php $states = \App\Lgstate::all();        ?>
                            <option value="">Please Select</option>
                            @foreach ($states as $state)
                            <option value="{{$state->id}}" <?php if($state->id==$institute_location->state_id){echo 'selected';}?>>{{$state->state_name}}</option>
                            @endforeach
                        </select>
                    </div>
                  
                    <!-- District -->
                    <div class="mb-3">
                        <label for="district">District</label>
                        <select name="district_id" class="form-control" id="district_id">
                            <option value="">Please Select</option>
                        </select>
                    </div>

                    <!-- Subdistrict -->
                    <div class="mb-3">
                        <label for="subdistrict">Subdistrict</label>
                        <select name="subdistrict_id" class="form-control" id="subdistrict_id">
                            <option value="">Please Select</option>

                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" name="newaddress"
                            onkeypress=" return /[A-Z0-9a-z_ ,./-]/.test(event.key)" id="address">
                    </div>
                    @if($institute_location->coordinate=='' || $institute_location->coordinate == null)

                    <div class="mb-3">
                        <label for="latitudeInput" class="form-label">Latitude</label>
                        <input type="text" class="form-control" id="latitudeInput" onkeypress=" return /[0-9.]/.test(event.key)" name='latitude'
                            placeholder="Enter latitude (e.g., 30.748817)" required="">
                        <small class="form-text text-muted">Enter a value between 8 and 38.</small>
                    </div>
                    <div class="mb-3">
                        <label for="longitudeInput" class="form-label">Longitude</label>
                        <input type="text" class="form-control" id="longitudeInput" name='longitude' onkeypress=" return /[0-9.]/.test(event.key)"
                            placeholder="Enter longitude (e.g., 73.985428)" required="">
                        <small class="form-text text-muted">Enter a value between 68 and 98.</small>
                    </div>
                    <a id="checklocation" class="btn btn-primary">Check Location</a>
                    <div id="map" style="height: 400px; width: 100%; margin-top: 20px;">
                        <div style="height: 100%; width: 100%;">
                            <div style="overflow: hidden; width: 742px; height: 400px;"><img alt=""
                                    src="https://maps.googleapis.com/maps/api/js/StaticMapService.GetMapImage?1m2&amp;1i747571&amp;2i429858&amp;2e1&amp;3u12&amp;4m2&amp;1u742&amp;2u400&amp;5m6&amp;1e0&amp;5sen-US&amp;6sus&amp;10b1&amp;12b1&amp;14i47083502&amp;key=AIzaSyD_cYWEO3v93ZQz39qZEnMdVKde_1LYRy0&amp;token=69532"
                                    style="width: 742px; height: 400px;"></div>
                        </div>
                    </div>



                    <div class="mb-3">
                        <label for="imageUpload" class="form-label">Upload Institute Building Photo <br />
                            <small>
                                Please click the photo ensuring the complete building and the name of the institute are
                                clearly visible.
                            </small>
                        </label>
                        <input type="file" class="form-control" id="imageUpload" name='image' accept="image/*"
                            required="">
                        <small class="form-text text-muted">Choose an PNG image with Longitude, Latitude and maximum
                            image size is 2 MB.</small>
                    </div>
                    <div class="mb-3 image-frame" id="imageFrame">
                        <div class="d-flex align-items-center">
                            <span id="noImageText" class="text-muted">No image selected</span>
                        </div>
                    </div>
<script>
     let map, marker;

function initMap() {
    const defaultLatLng = {
        lat: 28.536961600277813,
        lng: 77.18240993930122
    };
    map = new google.maps.Map(document.getElementById("map"), {
        zoom: 12,
        center: defaultLatLng
    });
    marker = new google.maps.Marker({
        position: defaultLatLng,
        map: map,
        title: "Default Location"
    });
}
document.getElementById("checklocation").addEventListener("click", function(event) {
    const latitude = parseFloat(document.getElementById("latitudeInput").value);
    const longitude = parseFloat(document.getElementById("longitudeInput").value);

    if (isNaN(latitude) || latitude > 38 || latitude < 8 || isNaN(longitude) || longitude > 98 ||
        longitude < 68) {
        alert('Please enter valid latitude and longitude values.');
        return;
    }

    
    const latLng = {
        lat: latitude,
        lng: longitude
    };
    map.setCenter(latLng);
    marker.setPosition(latLng);
});
document.getElementById("imageUpload").addEventListener("change", function(event) {
    const file = event.target.files[0];
    const imageFrame = document.getElementById("imageFrame");
    if (file) {
        var fileType = file.type;
        // Check if the file is a PNG
        if (file.type !== "image/png" || file.size > 2 * 1024 * 1024) {
            alert('Please upload png and file maximum size is 2MB');
            location.reload();
        }
        const reader = new FileReader();
        reader.onload = function(e) {
            const imgElement = document.createElement("img");
            imgElement.src = e.target.result;
            imageFrame.innerHTML = "";
            imageFrame.appendChild(imgElement);
        };
        reader.readAsDataURL(file);
    } else {
        imageFrame.innerHTML = "<span>No image selected</span>";
    }
});

</script>




                    @endif
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <!-- <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="closeModalBtn">Close</button>
                    </div> -->
        </div>

    </div>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD_cYWEO3v93ZQz39qZEnMdVKde_1LYRy0&callback=initMap&v=weekly"
    async defer></script>

<script>
   
    $(document).ready(function() {
        
window.onload = function() {
    loadDistricts();
};  
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
                        $('#district_id').append('<option value="0" selected disabled>Choose district</option>');
                        data.forEach(function(value) {
                            $('#district_id').append('<option value="' + value.id + '">' + value.districtName + '</option>');
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


        $('#district_id').on('change',function(){
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
					success: function (data) {
						console.log(data);
						if(data =='nodata' || data.length == 0 ){
							swal({
								type: 'warning',
								title: 'No data found',
								showConfirmButton: false,
								timer: 1500
							});
						}else{
						//	$('#subdistrictsdiv').removeClass('hidden');
							$('#subdistrict_id').html('');
					//		$('#villagediv').removeClass('hidden');
							$('#village_id').html('');
							$('#subdistrict_id').append('<option value="0" selected disabled>Choose Sub district  / Tehsil / Taluk</option>');
							$('#village_id').append('<option value="0" selected disabled>Choose Block / Village </option>');
							if(data['subdistricts'].length == 0){
							//	$('#subdistrict_id').attr('disabled',true);
							}else{
							//	$('#subdistrict_id').attr('disabled',false);
							var old = parseInt("{{old('subdistrict_id')}}");

								data['subdistricts'].forEach(function (value,key) {
									if(value.id==old){
										$('#subdistrict_id').append('<option selected value="'+value.id+'">'+ value.Sub_district_Name  +'</option>');
									}else{
										$('#subdistrict_id').append('<option value="'+value.id+'">'+ value.Sub_district_Name  +'</option>');
									}
								});
							}
							if(data['blocks'].length == 0){
							//	$('#village_id').attr('disabled',true);
							}else{
							//	$('#village_id').attr('disabled',false);
							var old = parseInt("{{old('village_id')}}");

								data['blocks'].forEach(function (value,key) {
									if(value.id==old){
										$('#village_id').append('<option selected value="'+value.id+'">'+ value.Block_Name  +'</option>');
									}else{
										$('#village_id').append('<option value="'+value.id+'">'+ value.Block_Name  +'</option>');
									}
								}); 
							}
							if($('#saa').is(':checked')){
								$('#district_id').val($('#district_id').val());
								loadPSubdistricts(0,0);
							}
							
						}
					},
					error: function (data) {
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

			$('#state_id').on('change',function(){
				loadPDistricts(0);
			});

            function loadPSubdistricts(tid,vid){
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
					success: function (data) {
						console.log(data);
						if(data =='nodata' || data.length == 0 ){
							swal({
								type: 'warning',
								title: 'No data found',
								showConfirmButton: false,
								timer: 1500
							});
						}else{
							$('#psubdistrictsdiv').removeClass('hidden');
							$('#subdistrict_id').html('');
							$('#pvillagediv').removeClass('hidden');
							$('#village_id').html('');
							$('#subdistrict_id').append('<option value="0" selected disabled>Choose Sub District / Tehsil / Taluk</option>');
							$('#village_id').append('<option value="0" selected disabled>Choose Sub District / Tehsil / Taluk</option>');
							if(data['subdistricts'].length == 0){
								//	$('#subdistrict_id').attr('disabled',true);
								
							}else{
								if(!$('#saa').is(':checked')){
								//	$('#subdistrict_id').attr('disabled',false);
								}
								data['subdistricts'].forEach(function (value,key) {
									if(tid!=0){
										if(tid==value.id){
											$('#subdistrict_id').append('<option selected value="'+value.id+'">'+ value.Sub_district_Name  +'</option>');
										}else{
											$('#subdistrict_id').append('<option value="'+value.id+'">'+ value.Sub_district_Name  +'</option>');
										}
									}else{
											$('#subdistrict_id').append('<option value="'+value.id+'">'+ value.Sub_district_Name  +'</option>');
									}
								});
							}
							if(data['blocks'].length == 0){
								//$('#village_id').attr('disabled',true);
							}else{
								if(!$('#saa').is(':checked')){
								//	$('#village_id').attr('disabled',false);
								}
								data['blocks'].forEach(function (value,key) {
									if(vid!=0){
										if(vid==value.id){
											$('#village_id').append('<option selected value="'+value.id+'">'+ value.Block_Name  +'</option>');
										}else{
											$('#village_id').append('<option value="'+value.id+'">'+ value.Block_Name  +'</option>');
										}
									}else{
										$('#village_id').append('<option value="'+value.id+'">'+ value.Block_Name  +'</option>');
									}
								});
							}
							
						}
					},
					error: function (data) {
						swal({
								type: 'warning',
								title: 'No data found',
								showConfirmButton: false,
								timer: 1500
							});
					}
				});
			}

            $('#district_id').on('change',function(){
				loadPSubdistricts(0,0);
			});
        });
</script>
<style>
    .image-frame {
        border: 2px solid #ccc;
        min-width: 500px;
        min-height: 500px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 20px;
        background-color: #f7f7f7;
    }

    .image-frame img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .mb-3 {
        font-size: 14px !important
    }
</style>
@endif