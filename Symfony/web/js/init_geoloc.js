/* GEOLOCATION HANDLING */

var position = false; // type Coordinate
var positionWatchID = false;
var marker = false;
var markerMoved = false;

// Prepare data
function coordinatesToWKT(coords) {
	if('latitude' in coords && 'longitude' in coords) {
		return "POINT(" + coords.longitude + " " + coords.latitude + ")";
	} else {
		console.error("Bad conversion from coordinate object.");
		return false;
	}
}


// Default callbacks
function setLocation(pos) {
	position = pos.coords;
}


function locationError(error) {
	console.error("Failed geolocation: " + error.code + " : " + error.message);

	/* Development on a machine without capabilities: simulate success */
	//$('#ajax_loader').load("erreur");
	listNearest({ coords: { latitude: 48.8410544, longitude: 2.5873005 },});
	/* End of development portion */
}


/* Require geolocation updates ; each time a new location is found, call `callback` */
function geolocation(callback) {
	if ("geolocation" in navigator) { /* geolocation is available */
		var options = {
			enableHighAccuracy : true,
			timeout : 8000, // 8 seconds
			maximumAge : 8000 // 8 seconds
		};
		positionWatchID = navigator.geolocation.watchPosition(callback, locationError, options);
		return true;
	} else { /* geolocation IS NOT available */
		return false;
	}
}

/* Cancel location updates */
function endLocation() {
	navigator.geolocation.clearWatch(positionWatchID);
	positionWatchID = false;
}
