@extends('layouts.app')
@section('content')
 
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php $institute = $institute[0]; ?>
                <h3> Verify GPS Coordinate and Geo Tagged Photo
                    <a href="{{ url('nber/verify/gpscoorinates') }}" class="btn btn-xs btn-secondary pull-right">Back</a>    
                </h3>
                @include('common.errorandmsg')
     
                <form action="{{ url('/nber/verify/gpscoorinates/') }}/{{ $institute->id }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="PUT"> 
                    <input type="hidden" name="verified"  value="{{ $institute->verified }}">
                    <table class="table  table-bordered">
                        <tr>
                            <th>Institute Code</th>
                            <td> {{ $institute->rci_code }}</td>
                        </tr>
                        <tr>
                            <th>Institute Code</th>
                            <td> {{ $institute->name }}</td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>
                                {{ $institute->address }} <br />
                                {{ $institute->subDistrict }} <br />
                                {{ $institute->district }} <br />
                                {{ $institute->state }} <br />
                                {{ $institute->pincode }} 

                            </td>
                        </tr>
                        <tr>
                            <th>Latitute</th>
                            <td>{{ $institute->latitude }}</td>
                        </tr>
                        <tr>
                            <th>Longitude</th>
                            <td>{{ $institute->longitude }}</td>
                        </tr>
                        <tr>
                            <th>
                                Map
                            </th>
                            <td  @if($institute->latitude > 0) style="height:600px;" @endif>
                                @if($institute->latitude > 0)
                                    <div id="map"></div>
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
                                            const myLatLng = { lat: {{$institute->latitude}}, lng: {{$institute->longitude}} };
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
                                            title: "{{$institute->rci_code}} - {{$institute->name}}",
                                            });
                                        }
                                        window.initMap = initMap;
                                    </script>
                                @endif
                            </td>
                        </tr>
                    </table>
                    <button type="submit" class="btn btn-xs btn-primary">
                        @if($institute->verified == 0)
                            Verify
                        @else
                            Remove Verification
                        @endif
                    </button>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('select').selectpicker();
        });
        function handleError(image){
            image.onerror = "";
            image.src = "{{ url('/images/dummy.jpg') }}";
            return true;
        }
    </script>
@endsection