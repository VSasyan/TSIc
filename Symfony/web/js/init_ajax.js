// Functions
function getPage(route, after) {
	var after = after || false;
	return $.get(route, function(data, status) {
		document.title = data.title;
		$('#ajax_loader').html(data.content);
		showMessages(data.messages || '');
		map.invalidateSize();
		if(after != false) { after(); }
	});
}

function getObject(route) {
	$.ajax({
		url : route,
		type : 'GET',
		success : function(data) {
			show_nearestObjetsTerrains(data);
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
	none : function(){},
};

document.addEventListener("DOMContentLoaded", function() {
	//ajout ajax load gif
	$('#ajax_loader').html(HTML_AJAX_LOADING);

	functions[$('#ajax_loader').data('function')]();
});
