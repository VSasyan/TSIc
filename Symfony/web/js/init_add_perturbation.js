var marqueur = false;

function updateMarqueur() {
	var position = {lat : geoloc.position.latitude, lng : geoloc.position.longitude};
	setMarqueur(position);
}

document.addEventListener("DOMContentLoaded", function() {
	$(document).ready(function() {
		geoloc.init();
		initMap();
		posMarker = L.marker(map.getCenter()).addTo(map); // mark the vehicle

		geoloc.callback = function() { // update both markers
			updatePosMarker();
			updateView();
			updateMarqueur();
		};

		map.on("dragstart", function(e) { // drop updating view
			geoloc.callback = function() {
				updatePosMarker();
				updateMarqueur();
			};
		});

		map.on('click', function(e) {
			geoloc.callback = updatePosMarker;
			setMarqueur(e.latlng);
			map.setView(e.latlng, 13, {animate:true});
		});
	});
});

function setMarqueur(position) {
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
