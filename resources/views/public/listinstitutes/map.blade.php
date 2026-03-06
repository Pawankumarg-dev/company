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
  const myLatLng = { lat: {{$data['institute'][0]->latitude}}, lng: {{$data['institute'][0]->longitude}} };
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
    title: "{{$data['institute'][0]->rci_code}} - {{$data['institute'][0]->name}}",
  });
}

window.initMap = initMap;

	

</script>
