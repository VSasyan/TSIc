// Functions
function getPage(route, after) {
	var after = after || false;
	$('#ajax_loader').html(HTML_AJAX_LOADING);
	return $.get(route, function(data, status) {
		document.title = data.title;
		$('#ajax_loader').html(data.content);
		showMessages(data.messages || '');
		map.invalidateSize();
		if(after != false) { after(); }
	});
}

function getObject(route, callback) {
	var callback = callback || function(x) {};
	$.ajax({
		url : route,
		type : 'GET',
		success : function(data) {
			callback(data);
		}
	});
}

var functions = {
	listNearest : function() {
		geoloc.init();
		initMap();

		map.on("dragstart", function(e) {
			geoloc.callback = updatePosMarker;
		});

		map.on("zoomstart", function(e) {
			geoloc.callback = updatePosMarker;
		});

		map.on("moveend", function(e) {
			var currentBounds = map.getBounds();

			if(!dataBounds.contains(currentBounds)) {
				// We do not have any data
				listNearest(currentBounds);
			} else {
				//console.log("No update needed.");
			}
		});

		posMarker = L.marker(map.getCenter()).addTo(map);
		listNearest(map.getBounds());

		geoloc.callback = function() {
			updatePosMarker();
			updateView();
		}
		geoloc.callbackError = function(err) {
			geoloc.position = { latitude: 48.8410544, longitude: 2.5873005 };
			geoloc.callback();
		}
	},
	listNearestObjects : function() {
		$('#ajax_loader').html("").parent().hide();
		geoloc.init();
		initMap();
		listNearestObjects(map.getBounds());
	},
	none : function(){},
};

document.addEventListener("DOMContentLoaded", function() {
	//ajout ajax load gif
	$('#ajax_loader').html(HTML_AJAX_LOADING);

	functions[$('#ajax_loader').data('function')]();
});
