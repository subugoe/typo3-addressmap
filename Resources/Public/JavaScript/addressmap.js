// create a map in the "map" div, set the view to a given place and zoom
var map = L.map('map');

// add an OpenStreetMap tile layer
L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
	attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

var digIcon = L.icon({
	iconUrl: '/typo3conf/ext/addressmap/Resources/Public/Images/marker-icon.png',
	iconAnchor: [12, 41],
	popupAnchor: [0, -41]
});

var yourIcon = L.icon({
	iconUrl: '/typo3conf/ext/addressmap/Resources/Public/Images/user.svg',
	iconSize: [20, 20]
});

var markers = L.markerClusterGroup({maxClusterRadius: 40});

var markerArray = [];
for (i in addresses) {
	if (addresses[i].latitude) {
		var coordinates = [addresses[i].latitude, addresses[i].longitude];
		var marker = L.marker(coordinates, {icon: digIcon});
		marker.bindPopup('<strong>' + addresses[i].title + '</strong><br>' + addresses[i].address + '<br>' + addresses[i].zip + ' ' + addresses[i].city);
		markers.addLayer(marker);
	}
}

var yourMarker = function () {
	if ("geolocation" in navigator) {
		navigator.geolocation.getCurrentPosition(function (position) {
			var userMarker = L.marker([position.coords.latitude, position.coords.longitude], {icon: yourIcon});
			userMarker.bindPopup('<strong>Ihr Standort</strong>');
			map.addLayer(userMarker);

		});
	}
};
yourMarker();
map.addLayer(markers);
map.fitBounds(markers.getBounds());
