var map_objects = Array();
var wkt         = new Wkt.Wkt; // The converter between leaflet objects and WKT strings

function listNearestObjects(viewBounds) {
	// Request
	var radius = viewBounds.getSouthWest().distanceTo(viewBounds.getNorthEast());
	console.log("Requesting data on " + coordinatesToWKT(viewBounds.getCenter()) + " radius " + radius);

	// Recuperations des Objets :
	getObject(Routing.generate("transport_list_nearest", {
		position : coordinatesToWKT(viewBounds.getCenter()),
		radius : radius
	}), showObjects);
}

function showObjects(data) {
	// On vide les anciennes info :
	$.each(map_objects, function(i,o) {map.removeLayer(o);})

	$.each(data, function(i, o) {
		// Recuperation info :
		var name = o.name;
		wkt.read(o.geometry);
		map_objects.push(wkt.toObject().addTo(map).bindPopup(name));
	});
}