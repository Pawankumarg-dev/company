@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{url('mapexamcenters')}}" method="get">
        <div class="row">
            <div class="form-group">
                <div class="col-md-4">
                    <label for="institute">Institute</label>
                    <select name="institutes" id="institutes" class="form-control">
                        <option value="all" @if($institutes=="all") selected @endif>All</option>
                        <option value="district" @if($institutes=="district") selected @endif>District wise</option>
                        <option value="state" @if($institutes=="state") selected @endif>State wise</option>
                        <option value="none" @if($institutes=="none") selected @endif>Hide</option>
                    </select>
                    <label for="ec">Institute Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="all" @if($status=="all") selected @endif>All</option>
                        <option value="mapped"  @if($status=="mapped") selected @endif>Mapped</option>
                        <option value="pending" @if($status=="pending") selected @endif>Not Mapped</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="ec">Exam Centers</label>
                    <select name="examcenters" id="examcenters" class="form-control">
                        <option value="all" @if($examcenters=="all") selected @endif>All</option>
                        <option value="district" @if($examcenters=="district") selected @endif>District wise</option>
                        <option value="state" @if($examcenters=="state") selected @endif>State wise</option>
                        <option value="none" @if($examcenters=="none") selected @endif>Hide</option>
                    </select>
                    <label for="ec">Exam Center Status</label>
                    <select name="ecstatus" id="ecstatus" class="form-control">
                        <option value="all" @if($ecstatus=="all") selected @endif>All</option>
                        <option value="mapped"  @if($ecstatus=="mapped") selected @endif>Mapped</option>
                        <option value="pending" @if($ecstatus=="pending") selected @endif>Not Mapped</option>
                    </select>
                </div>
              
                <div class="col-md-4">
                    <label for="ec">Filter Districts</label>
                    <select name="filter" id="filter" class="form-control">
                        <option value="all" @if($filter=="all") selected @endif>All</option>
                        <option value="available"  @if($filter=="available") selected @endif>Has Exam Center</option>
                        <option value="noec" @if($filter=="noec") selected @endif>Do not have Exam Center</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top:10px;margin-bottom:10px;">
          
            <div class="col-md-12">
                <div class="alert alert-success">
                     @if(!is_null($instituteList)) Institutes: {{ $instituteList->count() }}  @endif
                     @if(!is_null($examcenterList)) Exam Centers: {{ $examcenterList->count() }} @endif
                </div>
                <button type="submit" class="form-control btn btn-primary btnxs">
                    Submit 
                </button>
            </div>
        </div>
    </form>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div id="map"></div>
        </div>
        <div class="col-md-12">
            <form action="{{url('mapexamcenters')}}" method="get">
                <input type="hidden" name="refresh" id="refresh">
                <button type="submit" class="form-control btn btn-primary btnxs">
                        Refresh Data
                </button>
            </form>
        </div>
    </div>
</div>
<style>
    #map {
    height: 100vh;
    }
</style>
<script
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD_cYWEO3v93ZQz39qZEnMdVKde_1LYRy0&callback=initMap&v=weekly"
defer
></script>
<script>

    function initMap() {
        var myLatLng = { lat:18, lng: 80 };
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 5,
            center: myLatLng,
            mapTypeControl: false,
            scaleControl: false,
            controlSize: 22
        });
        var iicon ="{{url('images/institute.png')}}";

        var ecicon ="{{url('images/examcenter.png')}}";
        @if(!is_null($instituteList) && $instituteList->count() > 0)
            @foreach($instituteList as $i)
                @if(!is_null($i->latitude) && $i->latitude != '')
                    myLatLng = { lat: {{$i->latitude}}, lng: {{$i->longitude}} };
                    
                    new google.maps.Marker({
                        position: myLatLng,
                        map,
                        title: "{{$i->text}}",
                    });
                @endif
            @endforeach
        @endif
        @if(!is_null($examcenterList) && $examcenterList->count() > 0)
            @foreach($examcenterList as $i)
                @if(!is_null($i->latitude))
                    myLatLng = { lat: {{$i->latitude}}, lng: {{$i->longitude}} };
                    
                    new google.maps.Marker({
                        position: myLatLng,
                        map,
                        icon: ecicon,
                        title: "{{$i->text}}",
                    });
                @endif
            @endforeach
        @endif
        }

        window.initMap = initMap;
    

</script>
@endsection