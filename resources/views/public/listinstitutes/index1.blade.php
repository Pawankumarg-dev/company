@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-6" >
                @include('common.errorandmsg')
                           
<form action="{{ url('institute-details-show') }}" method="POST" id="form">
                {{ csrf_field() }}

    <h3>Diploma and Certificate Level Courses</h3>

    <label>
        <input type="radio" name="type" value="state" 
            {{ $selected == 'state' ? 'checked' : '' }}
            onchange="this.form.submit()"> State-wise
    </label>

    <label>
        <input type="radio" name="type" value="course"
            {{ $selected == 'course' ? 'checked' : '' }} 
            onchange="this.form.submit()"> Course-wise
    </label>

    <br><br>

    {{-- STATE --}}
    @if($selected == 'state')
    <label for="course">State </label>
        <select name="state_id" class="form-control" onchange="this.form.submit()">
            <option value="">Select State</option>
            @foreach ($states as $state)
                <option value="{{ $state->id }}" {{ $state_id == $state->id ? 'selected' : '' }}>
                    {{ $state->state_name }}
                </option>
            @endforeach
        </select>
    @endif

    {{-- COURSE --}}
    @if($selected == 'course' || $state_id)
    <label for="course">Course </label>
        <select name="course_id" class="form-control" onchange="this.form.submit()">
            <option value="">Select Course</option>
            @foreach ($courses as $course)
                <option value="{{ $course->id }}" {{ $course_id == $course->id ? 'selected' : '' }}>
                    {{ $course->name }}
                </option>
            @endforeach
        </select>
    @endif

    {{-- INSTITUTE --}}
    @if($course_id)
        <label for="course">Institute </label>

        <select name="institute_id" class="form-control" onchange="this.form.submit()">
            <option value="">Select Institute</option>
            @foreach ($institutes as $inst)
                <option value="{{ $inst->id }}" {{ $institute_id == $inst->id ? 'selected' : '' }}>
                    {{ $inst->rci_code }} - {{ $inst->name }}
                </option>
            @endforeach
        </select>

        {{-- ACADEMIC YEAR --}}
                <label for="course">Academic Years </label>

        <select name="academicyear_id" class="form-control" onchange="this.form.submit()">
            <option value="">All Years</option>
            @foreach ($academicyear as $year)
                <option value="{{ $year->id }}" {{ $academicyear_id == $year->id ? 'selected' : '' }}>
                    {{ $year->year }}
                </option>
            @endforeach
        </select>
    @endif
</form>


 </div>

 @if(!empty($institute_data))

@if(!empty($institute_data) && !empty($institute_data->latitude) && $institute_data->latitude > 0)
                <div class="col-md-6" style="height: 450px;padding-top:50px;padding-bottom:10px;">
                    <div id="map"></div>
                </div>
            @endif
        </div>
<div class="row">
            <div class="col-md-12" >
              
        
        <?php $slno = 1; ?>
        <div class="tab-content">
            
                <div id="d-{{$course->id}}" class="tab-pane fade in  @if($slno==1) active @endif">
                        @include('public.listinstitutes.data.faculties')

                        @include('public.listinstitutes.data.candidates')
                </div>
                <?php $slno++; ?>
        </div>

            </div>
        </div>
    </div>
@if(!empty($institute_data) && !empty($institute_data->latitude) && $institute_data->latitude > 0)    
<style>
      #map {
        height: 100%;
      }
    </style>
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD_cYWEO3v93ZQz39qZEnMdVKde_1LYRy0&callback=initMap&v=weekly"
      defer
    ></script>
    <script>
      function initMap() {
        const myLatLng = { lat: {{$institute_data->latitude}}, lng: {{$institute_data->longitude}} };
        const map = new google.maps.Map(document.getElementById("map"), {
          zoom: 12,
          center: myLatLng,
          mapTypeControl: false,
          scaleControl: false,
          controlSize: 22
        });
        new google.maps.Marker({
          position: myLatLng,
          map,
          title: "{{$institute_data->rci_code}} - {{$institute_data->name}}",
        });
      }
      window.initMap = initMap;
    </script>
@endif


    @include('public.listinstitutes.js.loadfilter')
 @endif

@endsection