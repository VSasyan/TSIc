var map = false;
var map_objects = Array();
var map_perturbations = Array();

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
	//console.log("Requesting data on " + coordinatesToWKT(viewBounds.getCenter()) + " radius " + radius);

	// Recuperation des Perturbations :
	getPage(Routing.generate("perturbation_list_nearest", {
		position : coordinatesToWKT(viewBounds.getCenter()),
		radius : radius
	}), function() {init_click_vote(); show_nearestPerturbations();});

	// Recuperations des Objets :
	getObject(Routing.generate("objet_terrain_list_nearest", {
		position : coordinatesToWKT(viewBounds.getCenter()),
		radius : radius
	}));


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


function show_nearestPerturbations() {
	// On vide les anciennes info :
	$.each(map_perturbations, function(i,p) {map.removeLayer(p);})

	$('#list .element.perturbation').each(function() {
		// Recuperation info :
		var name = $(this).data('name');
		var center = $(this).data('center');
		var idType = $(this).data('idType');
		var nameType = $(this).data('nameType');
		var path = $(this).data('path');

		var regExp = /POINT\((.*) (.*)\)/;
		var result = regExp.exec(center);
		var position = [result[2], result[1]];

		// Ajout à la carte :
		var icon = L.icon({
			iconUrl: Routing.generate("logo_type_perturbation", {id : idType}),

			iconSize:     [20, 20], // size of the icon
			iconAnchor:   [10, 10], // point of the icon which will correspond to marker's location
			popupAnchor:  [0, -10] // point from which the popup should open relative to the iconAnchor
		});

		var html = html_popup_perturbation(name, nameType, path);

		map_perturbations.push(L.marker(position, {icon: icon}).addTo(map).bindPopup(html));
	
	});
}

function show_nearestObjetsTerrains(objets) {
	// On vide les anciennes info :
	$.each(map_objects, function(i,o) {map.removeLayer(o);})

	$.each(objets, function(i, o) {
		// Recuperation info :
		var name = o.name;

		var regExp = /POINT\((.*) (.*)\)/;
		var result = regExp.exec(o.geometry);
		var position = [result[2], result[1]];

		// Ajout à la carte :
		var srcIcon = Routing.generate("logo_type_objet_terrain", {id : o.type});
		var icon = L.icon({
			iconUrl: srcIcon,

			iconSize:     [20, 20], // size of the icon
			iconAnchor:   [10, 10], // point of the icon which will correspond to marker's location
			popupAnchor:  [0, -10] // point from which the popup should open relative to the iconAnchor
		});

		var html = html_popup_objet(name, srcIcon);

		map_objects.push(L.marker(position, {icon: icon}).addTo(map).bindPopup(html));
	
	});
}