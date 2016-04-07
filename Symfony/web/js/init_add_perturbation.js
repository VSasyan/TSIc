var marqueur = false;
var position = false;
var map = false;

function getLocation(pos) {
	position = {lat : pos.coords.latitude, lng : pos.coords.longitude};
	map.setView(position, 13, {animate:true});
	setMarqueur();
}

document.addEventListener("DOMContentLoaded", function() {
	$(document).ready(function() {
		initMap();
		geolocation(getLocation);
		map.on('click', function(e) {
			position = e.latlng;
			setMarqueur();
		});
	});
});

function setMarqueur() {
	if (marqueur === false) {
		// On l'ajoute
		marqueur = L.marker(position).addTo(map);
	} else {
		// On le déplace
		marqueur.setLatLng(position);
	}
	// On met à jour le champs :
	$('#formulation_center').val("POINT(" + position.lng + " " + position.lat + ")");
}

function coordinatesToWKT(coords) {
	if('latitude' in coords && 'longitude' in coords) {
		return "POINT(" + coords.longitude + " " + coords.latitude + ")";
	} else {
		console.error("Bad conversion from coordinate object.");
		return false;
	}
}

function geolocation(callback) {
	if ("geolocation" in navigator) {
		/* geolocation is available */
		var options = {
			enableHighAccuracy : true,
			timeout : 8000, // 8 sec
			maximumAge : 8000 // 8 sec
		};
		positionWatchID = navigator.geolocation.watchPosition(callback, locationError, options);
		return true;
	} else {
		/* geolocation IS NOT available */
		return false;
	}
}

function locationError(error) {
	console.error("Failed geolocation: " + error.code + " : " + error.message);

	/* Development on a machine without capabilities: simulate success */
	//$('#ajax_loader').load("erreur");
	getLocation({ coords: { latitude: 48.8410544, longitude: 2.5873005 },});
	/* End of development portion */
}
