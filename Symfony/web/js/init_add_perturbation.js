var marqueur = false;
var position = false;
var map = false;
var positionCliquee = false;

function getLocation(pos) {
	if (positionCliquee === false) {
		position = {lat : pos.coords.latitude, lng : pos.coords.longitude};
		setMarqueur();
	}
}

document.addEventListener("DOMContentLoaded", function() {
	$(document).ready(function() {
		initMap();
		geolocation(getLocation);
		map.on('click', function(e) {
			positionCliquee = true;
			position = e.latlng;
			setMarqueur();
		});
	});
});

function setMarqueur() {
	map.setView(position, 13, {animate:true});
	if (marqueur === false) {
		// On l'ajoute
		marqueur = L.marker(position).addTo(map);
	} else {
		// On le déplace
		marqueur.setLatLng(position);
	}
	// On met à jour le champs :
	$('#formulation_center').val("SRID=4326;POINT(" + position.lng + " " + position.lat + ")");
	$('#formulation_geoJSON').val("POINT(" + position.lng + " " + position.lat + ")");
}
