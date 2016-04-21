
var point     = false; // graphical representation of created node
var line      = false; // - - - - - - - - - - - - - - created link
var lineMark  = false; // Representation when line has only 1 point
var update    = false; // Function to call when the map is clicked (add point to line or move node?)
var select    = false; // The <select> element
var geomField = false; // The geometry field
var wkt       = new Wkt.Wkt; // The converter between leaflet objects and WKT strings

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
			map.panTo(e.latlng, {animate:true});
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
		update = updatePoint;
		map.removeLayer(line);
		line = false;
		break;
	case "RoadLink":
		getPage(Routing.generate("transport_link_add", {}), function(){
			geomField = document.getElementById("road_link_centrelineGeometry");
			initForm();
		});
		update = addPointToLine;
		map.removeLayer(point);
		point = false;
		break;
	}
}

function updatePoint(position) {
	if (point === false) {
		// On l'ajoute
		point = L.marker(position).addTo(map);
	} else {
		// On le déplace
		point.setLatLng(position);
	}
	// On met à jour le champs :
	geomField.value = wkt.fromObject(point).write();
}

function addPointToLine(position) {
	if (line === false) {
		line     = L.polyline([position]).addTo(map);
		lineMark = L.marker(position).addTo(map);
	} else {
		if(lineMark) {
			map.removeLayer(lineMark);
			lineMark = false;
		}
		line.addLatLng(position);
		geomField.value = wkt.fromObject(line).write(); // wicket throws if line with only one point.
	}
}
