
// map layer
var tiles = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
   maxZoom: 18,
   attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
      'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
   id: 'mapbox/streets-v11',
   tileSize: 512,
   zoomOffset: -1
});

// map popup layer
var popup = L.popup();

function onMapClick(e) {
   popup
      .setLatLng(e.latlng)
      .setContent("You clicked the map at " + e.latlng.toString())
      .openOn(map);
}

// marker icon pangkalan
var userMarker = L.AwesomeMarkers.icon({
   icon: 'user',
   markerColor: 'red',
   prefix: 'fa'
});

// marker icon pangkalan
var pangkalanMarker = L.AwesomeMarkers.icon({
   icon: 'bus',
   markerColor: 'green',
   prefix: 'fa'
});