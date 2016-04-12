var map = false;

function initMap() {
	// Your IGN Géoportail Api Key
	var ignApiKey = "68siq9vlm4baf7h8bs9k9qbs" ;

	// The id of map container ex <div id="map"></div>
	var mapId = "map" ;

	// OpenStreet Map Layer
	var OSM	= L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a>'});

	// IGN Topo Scan Express Standard
	var scanWmtsUrl	= "http://gpp3-wxs.ign.fr/"+ignApiKey + "/wmts?LAYER=GEOGRAPHICALGRIDSYSTEMS.MAPS&EXCEPTIONS=text/xml&FORMAT=image/jpeg&SERVICE=WMTS&VERSION=1.0.0&REQUEST=GetTile&STYLE=normal&TILEMATRIXSET=PM&&TILEMATRIX={z}&TILECOL={x}&TILEROW={y}" ;
	var SCAN25= L.tileLayer(scanWmtsUrl, {attribution: '&copy; <a href="http://www.ign.fr/">IGN</a>'});

	// IGN Topo
	// var ignWmtsUrl	= "http://gpp3-wxs.ign.fr/"+ ignApiKey + "/wmts?LAYER=GEOGRAPHICALGRIDSYSTEMS.MAPS&EXCEPTIONS=text/xml&FORMAT=image/jpeg&SERVICE=WMTS&VERSION=1.0.0&REQUEST=GetTile&STYLE=normal&TILEMATRIXSET=PM&&TILEMATRIX={z}&TILECOL={x}&TILEROW={y}" ;

	map = L.map(mapId, {
		center: [48.856578, 2.351828],
		zoom: 13,
		layers: [SCAN25]
	});

	var baseMap = {"Ign Topo":SCAN25, "OpenStreetMap":OSM};
	L.control.layers(baseMap).addTo(map);

	return map;
}


var dataBounds = false; // type LatLngBounds

function listNearest(viewBounds) {
	// Request
	var radius = viewBounds.getSouthWest().distanceTo(viewBounds.getNorthEast());
	console.log("Requesting data on " + coordinatesToWKT(viewBounds.getCenter()) + " radius " + radius);
	getPage(
		Routing.generate("perturbation_list_nearest", {
			position : coordinatesToWKT(viewBounds.getCenter()),
			radius : radius
		})
	);

	dataBounds = viewBounds.pad(1);
}


var posMarker = false;
function updatePosMarker() {
	var position = L.latLng(geoloc.position.latitude, geoloc.position.longitude);
	posMarker.setLatLng(position);
}

function updateView() {
	var position = L.latLng(geoloc.position.latitude, geoloc.position.longitude);
	map.setView(position, 13, {animate:true});
}
