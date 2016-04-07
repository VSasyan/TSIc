/* GEOLOCATION HANDLING */

var position = false; // type Coordinate
var positionWatchID = false;

function coordinatesToWKT(coords) {
    if('latitude' in coords && 'longitude' in coords) {
	return "POINT(" + coords.longitude + " " + coords.latitude + ")";
    } else {
	console.error("Bad conversion from coordinate object.");
	return false;
    }
}

function setLocation(pos) {
    position = pos.coords;
}

function locationError(error) {
    console.error("Failed geolocation: " + error.code + " : " + error.message);

    /* Development on a machine without capabilities: simulate success */
    //$('#ajax_loader').load("erreur");
    listNearest({ coords: { latitude: 42.3521, longitude: -72.1235 },});
    /* End of development portion */
}

function geolocation(callback) {
    if ("geolocation" in navigator) {
	/* geolocation is available */
	var options = {
	    enableHighAccuracy : true,
	    timeout : 60000, // 1 minute
	    maximumAge : 60000 // 1 minute
	};
	positionWatchID = navigator.geolocation.watchPosition(callback, locationError, options);
	return true;
    } else {
	/* geolocation IS NOT available */
	return false;
    }
}


// Functions
function getPage(route) {
    return $.get(route, function(data, status) {
	document.title = data.title;
	$('#ajax_loader').html(data.content);
    });
}


function listNearest(pos) {
    getPage(
	Routing.generate("perturbation_list_nearest", { position : coordinatesToWKT(pos.coords), radius : 1000 })
    );
    navigator.geolocation.clearWatch(positionWatchID);
    positionWatchID = false;
}

var functions = {
    listNearest : function() { geolocation(listNearest); },
};

document.addEventListener("DOMContentLoaded", function() {
    functions[$('#ajax_loader').data('function')]();
});
