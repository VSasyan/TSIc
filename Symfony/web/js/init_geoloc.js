/* GEOLOCATION HANDLING */

// Default callbacks
function setLocation(pos) {
	geoloc.position = pos.coords;
}


function locationError(error) {
	//console.error("Failed geolocation: " + error.code + " : " + error.message);

	/* Development on a machine without capabilities: simulate success */
	//$('#ajax_loader').load("erreur");
	/* End of development portion */
}

// Prepare data
function coordinatesToWKT(coords) {
	if('latitude' in coords && 'longitude' in coords) {
		return "POINT(" + coords.longitude + " " + coords.latitude + ")";
	} else if('lat' in coords && 'lng' in coords) {
		return "POINT(" + coords.lng + " " + coords.lat + ")";
	} else {
		//console.error("Bad conversion from coordinate object.");
		return false;
	}
}


function Geoloc() {
	// Current position
	this.position = false; // { latitude , longitude }

	// Current callback function
	this.callback = false;

	// Current callback error
	this.callbackError = locationError;

	// Starts the geolocation ; returns false if failed.
	this.init = function() {
		if ("geolocation" in navigator) { /* geolocation is available */
			var that = this;
			var options = {
				enableHighAccuracy : true,
				timeout : 8000, // 8 seconds
				maximumAge : 8000 // 8 seconds
			};
			this._positionWatchID = navigator.geolocation.watchPosition(
				// Success callback
				function(pos) {
					that.position = pos.coords;
					if(that.callback) that.callback(pos);
				},
				// Failure callback
				function(err) {
					if(that.callbackError) that.callbackError(err);
				},
				options);
			return true;
		} else { /* geolocation IS NOT available */
			return false;
		}
	};

	// Ends the geolocation
	this.clear = function() {
		if(this._positionWatchID) {
			navigator.geolocation.clearWatch(this._positionWatchID);
			this._positionWatchID = false;
		} else {
			//console.log("clear : no geolocation running");
		}
	};

	// Returns the position in Well-Known-Text format
	this.toWKT = function() {
		return coordinatesToWKT(this.position);
	};

	// Private attributes and methods
	this._positionWatchID = false;
};

var geoloc = new Geoloc();
