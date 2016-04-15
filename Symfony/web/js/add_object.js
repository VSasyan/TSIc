var pointMarker = false;
var lineMarkers = [];
var update		= false;
var select      = false;

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

		if(select) {
			updateSelect(select.value);
			select.onchange = function(){
				updateSelect(select.value);
			};
		} else {
			console.error("Select not found");
		}
	});
});

function updateSelect(value) {
	switch(value) {
	case "RoadNode":
		update = updatePoint;
		lineMarkers.forEach(function(e, i) {
			map.removeLayer(e);
			lineMarkers[i] = null;
		});
		lineMarkers = [];
		break;
	case "RoadLink":
		update = addPointToLine;
		map.removeLayer(pointMarker);
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
		pointMarker.setLatLng(position);
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
