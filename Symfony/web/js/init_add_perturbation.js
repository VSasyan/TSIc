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
