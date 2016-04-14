var pointMarker = false;
var lineMarkers = [];
var update		= false;

document.addEventListener("DOMContentLoaded", function() {
	$(document).ready(function() {
		geoloc.init();
		initMap();

		geoloc.callback = updateView;

		map.on("dragstart", function(e) { // drop updating view
			geoloc.callback = false;
		});

		map.on('click', function(e) {
			geoloc.callback = false;
			if(update) {
				update(e.latlng);
			}
			map.setView(e.latlng, 13, {animate:true});
		});
	});
});

function updateSelect(value) {
	switch(value) {
	case "RoadNode":
		update = updatePoint;
		lineMarkers = [];
		break;
	case "RoadLink":
		update = addPointToLine;
		pointMarker = false;
		break;
	}
}

function updatePoint(position) {
	if (pointMarker === false) {
		// On l'ajoute
		pointMarker = L.marker(position).addTo(map);
	} else {
		// On le déplace
		marker.setLatLng(position);
	}
	// On met à jour le champs :
	//$('#formulation_center').val("SRID=4326;POINT(" + position.lng + " " + position.lat + ")");
	$('#geometry').val("POINT(" + position.lng + " " + position.lat + ")");
}

function addPointToLine(position) {
	if(lineMarkers.length === 0) {
		$('#centrelineGeometry').val(coordinatesToWKT(position));
	} else {
		$('#centrelineGeometry').append(", " + coordinatesToWKT(position));
	}
	var mark = L.marker(position);
	mark.addTo(map);
	lineMarkers.push(mark);
}
