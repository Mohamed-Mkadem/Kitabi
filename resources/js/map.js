const coordinates = [36.80690392165838, 10.180831539456086];
var map = L.map('map').setView(coordinates, 15);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {

}).addTo(map);

L.marker(coordinates).addTo(map)
    .bindPopup('مقرّ كتابي')
    .openPopup();
map.attributionControl.setPrefix('')