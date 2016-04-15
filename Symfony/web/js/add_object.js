var pointMarker = false;
var lineMarkers = [];
var update		= false;
var select      = false;
var geomField   = false;
var pointWKT    = "";
var lineWKT     = "";

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

		select = document.getElementById("transport_class");
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

function initForm() {
	$("#ajax_loader form").submit(function(event) {
		event.preventDefault();
		$.ajax({
			url : $(this).attr("action"),
			type : 'POST',
			data: $(this).serialize(),
			success : function(data) {
				showMessages(data.messages || '');
				$("#ajax_loader").html(data.content);
				initForm();
			}
		})
	});
}

function updateSelect(value) {
	switch(value) {
	case "RoadNode":
		getPage(Routing.generate("transport_node_add", {}), function(){
			geomField = document.getElementById("road_node_geometry");
			initForm();
		});
		$("#ajax_loader").html("");
		update = updatePoint;
		lineMarkers.forEach(function(e, i) {
			map.removeLayer(e);
			lineMarkers[i] = null;
		});
		lineMarkers = [];
		lineWKT = "";
		break;
	case "RoadLink":
		getPage(Routing.generate("transport_link_add", {}), function(){
			geomField = document.getElementById("road_link_centrelineGeometry");
			initForm();
		});
		$("#ajax_loader").html("");
		update = addPointToLine;
		map.removeLayer(pointMarker);
		pointMarker = false;
		pointWKT = "";
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
	pointWKT = position.lng + " " + position.lat;
	geomField.value = "POINT(" + pointWKT + ")";
}

function addPointToLine(position) {
	var mark = L.marker(position);
	mark.addTo(map);
	lineMarkers.push(mark);

	if(lineMarkers.length -1 > 0) {
		lineWKT += ", ";
	}
	lineWKT += position.lng + " " + position.lat;
	geomField.value = "LINESTRING(" + lineWKT + ")";
}
