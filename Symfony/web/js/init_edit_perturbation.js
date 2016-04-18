var marqueur = false;

document.addEventListener("DOMContentLoaded", function() {
	$(document).ready(function() {
		initMap();

		// Récupération de la position formulaire :
		var point = $('#formulation_center').val();
		var regExp = /POINT\((.*) (.*)\)/;
		var result = regExp.exec(point);
		var position = L.latLng(result[2], result[1]);

		map.panTo(position, {animate:true});
		setMarqueur(position);

		map.on('click', function(e) {
			setMarqueur(e.latlng);
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
