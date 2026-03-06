@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6" >
            @include('common.errorandmsg')
            <form action="{{ url('institute-details') }}" method="GET" id="form">
                <h3>Diploma and Certificate Level Courses</h3>
                <input type="hidden" name="filter" value="1">
                <div class="form-group">
                    <label for="institute">State</label>
                    <select class="form-control" name="state_id" id="state_id">
                        <option value="0" selected disabled>--Please select -- </option>
                        @foreach ($dropdowndata['states'] as $state)
                            <option  @if($selected['state_id'] == $state->id) selected @endif value="{{ $state->id }}">{{ $state->state_name }}</option>
                        @endforeach
                    </select>
                </div>

                @if(!is_null($dropdowndata['courses']) && $selected['state_id'] != -1 )
                    <div class="form-group">
                        <label for="course">Course </label>
                        <select class="form-control" name="course_id" id="course_id">
                            @if($dropdowndata['courses']->count()>0)
                                <option value="-1" disabled> --Please select --</option>
                                <option value="0">All</option>
                            @else
                                <option value="-1"  selected disabled> --No courses found --</option>
                            @endif
                            @foreach ($dropdowndata['courses'] as $course)
                                    <option value="{{ $course->id }}" @if($selected['course_id'] == $course->id) selected @endif)>{{ $course->name }} <span class="text-muted"> ({{ $course->numberofterms }} Year) </span></option>
                            @endforeach
                        </select>
                    </div>
                @endif

                @if(!is_null($dropdowndata['institutes']) && $selected['state_id'] != -1 && $selected['course_id'] != -1)
                    <div class="form-group">
                        <label for="course">Institute </label>
                        <select class="form-control" name="institute_id" id="institute_id">
                            @if($dropdowndata['institutes']->count()>0)
                                <option value="-1" disabled selected> --Please select --</option>
                            @else
                                <option value="-1"  selected disabled> --No Institute found --</option>
                            @endif
                            @foreach ($dropdowndata['institutes'] as $institute)
                                    <option value="{{ $institute->id }}" @if($selected['institute_id'] == $institute->id) selected @endif)> {{ $institute->rci_code }} - {{ $institute->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                <button type="submit" class="btn btn-primary hidden"      @if($dropdowndata['courses']->count() == 0) disabled @endif>Show</button>
            </form>
        </div>
        <div class="col-md-6">
            <div id="map"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" >
            
        </div>
    </div>
</div>
<style>
    #map {
  height: 100%;
}
</style>
<script
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB41DRUbKWJHPxaFjMAwdrzWzbVKartNGg&callback=initMap&v=weekly"
defer
></script>

<script>
 
    function initMap() {
  const myLatLng = { lat: -25.363, lng: 131.044 };
  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 4,
    center: myLatLng,
  });

  new google.maps.Marker({
    position: myLatLng,
    map,
    title: "Hello World!",
  });
}

window.initMap = initMap;

	$(document).ready(function () {
        
        $('#state_id').on('change',function(){
            var reload = location.protocol + '//' + location.host + location.pathname;
            window.location.replace(reload+"/?filter=1&state_id="+$('#state_id').val());
        });
        $('#course_id').on('change',function(){
            var reload = location.protocol + '//' + location.host + location.pathname;
            window.location.replace(reload+"/?filter=1&state_id="+$('#state_id').val()+"&course_id="+$('#course_id').val());
        });
        $('#institute_id').on('change',function(){
            var reload = location.protocol + '//' + location.host + location.pathname;
            window.location.replace(reload+"/?filter=1&state_id="+$('#state_id').val()+"&course_id="+$('#course_id').val()+"&institute_id="+$('#institute_id').val());
        });
    });

</script>
@endsection
