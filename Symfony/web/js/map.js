function initMap() {
	var map = L.map('map').setView([48.856578, 2.351828], 13);
	L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		attribution: 'Map data &copy; <a href="http://www.osm.org">OpenStreetMap</a>'
	}).addTo(map);
}