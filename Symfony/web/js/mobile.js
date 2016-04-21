document.addEventListener("DOMContentLoaded", function() {
	$('nav>div.selected').each(loadSection);

	// Init eve open other section
	$('nav>div').click(loadSection);
});

function loadSection() {
		var section = $(this).attr('id');
		$('nav>div.selected').removeClass('selected');
		$('#' + section).addClass('selected');
		$('section#screen').attr("class", 'loading').html(HTML_AJAX_LOADING);
		$.ajax({
			url : Routing.generate("mobile_section", {section : section}),
			type : 'GET',
			success : function(json) {
				$('section#screen').attr("class", json.section).html(json.html);
				document.title = json.title;
				$('#title').html(json.title);
				initSection[json.section]();
			}
		})
	}

var initSection = {
	'mapNearest' : function() {
		mapNearest.initMap('map');
		if (navigator.geolocation) {
			navigator.geolocation.watchPosition(mapNearest.newPosition);
		}
		mapNearest.newPosition({coords:{latitude:48.841277, longitude:2.587187}});
	},
	'listNearest' : function() {
		listNearest.position = L.latLng(0,0);
		if (navigator.geolocation) {
			navigator.geolocation.watchPosition(listNearest.newPosition);
		}
		listNearest.newPosition({coords:{latitude:48.841277, longitude:2.587187}});
	}
}




// Map nearest function :
var mapNearest = {
	position : L.latLng(48.856578, 2.351828),
	positionMaker : false,
	updatePosition : true,
	map : false,
	viewBounds : false,
	zoomBounds : 15,
	listPertu : Array(),
	listObject : Array(),

	initMap : function(mapId) {
		// OpenStreet Map Layer
		var OSM	= L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a>'});

		mapNearest.map = L.map(mapId, {
			center: mapNearest.position,
			zoom: 15,
			layers: [OSM]
		});

		var baseMap = {"OpenStreetMap":OSM};
		L.control.layers(baseMap).addTo(mapNearest.map);

		$(window).resize(function() {
			mapNearest.map.invalidateSize();
		});

		mapNearest.map.on('dragstart', mapNearest.dragStart);
		mapNearest.map.on('moveend', mapNearest.moveEnd);
		mapNearest.map.on('zoomstart', mapNearest.zoomStart);
		mapNearest.map.on('zoom', mapNearest.zoom);
		mapNearest.map.on('zoomend', mapNearest.zoomEnd);
		
		mapNearest.getElements(mapNearest.map.getBounds());
	},

	dragStart : function(e) {
		mapNearest.updatePosition = false;
	},

	moveEnd : function(e) {
		var currentBounds = mapNearest.map.getBounds();

		if (!mapNearest.dataBounds.contains(currentBounds)) {
			mapNearest.getElements(currentBounds);
		}
	},

	zoomStart : function(e) {
		mapNearest.updatePosition = false;
		mapNearest.zoomBounds = mapNearest.map.getZoom();
	},

	zoomEnd : function(e) {
		mapNearest.updatePosition = false;
		if (mapNearest.zoomBounds < mapNearest.map.getZoom()) {
			// Zoomin : reload !
			mapNearest.getElements(mapNearest.map.getBounds());
		}
	},

	newPosition : function(position) {
		mapNearest.position = L.latLng(position.coords.latitude, position.coords.longitude);
		if (mapNearest.positionMaker === false) {
			mapNearest.positionMarker = L.marker(mapNearest.position).addTo(mapNearest.map);
		} else {
			mapNearest.positionMarker.setLatLng(mapNearest.position);
		}
		if (mapNearest.updatePosition) {
			mapNearest.map.panTo(mapNearest.position);
		}
	},

	getElements : function(viewBounds) {
		// Request
		var radius = parseInt(viewBounds.getSouthWest().distanceTo(viewBounds.getNorthEast()));

		// Recuperations des Perturbations :
		$.ajax({
			url : Routing.generate("ajax_perturbation_list_nearest", {
				position : coordinatesToWKT(listNearest.position),
				radius : listNearest.radius
			}),
			type : 'GET',
			success : function(objets) {
				show_nearestPerturbations(mapNearest.map, mapNearest.listPertu, objets);
			}
		});

		// Recuperations des Objets :
		$.ajax({
			url : Routing.generate("objet_terrain_list_nearest", {
				position : coordinatesToWKT(viewBounds.getCenter()),
				radius : radius
			}),
			type : 'GET',
			success : function(objets) {
				show_nearestObjetsTerrains(mapNearest.map, mapNearest.listObject, objets);
			}
		});

		mapNearest.dataBounds = viewBounds.pad(1);
	}
};

function show_nearestPerturbations(map, oldObjects, newObjects) {
	// On vide les anciennes info :
	$.each(oldObjects, function(i,o) {map.removeLayer(o);})

	$.each(newObjects, function(i, o) {
		// Recuperation info :
		var regExp = /POINT\((.*) (.*)\)/;
		var result = regExp.exec(o.geometry);
		var position = [result[2], result[1]];

		// Ajout à la carte :
		var srcIcon = Routing.generate("logo_type_perturbation", {id : o.type});
		var icon = L.icon({
			iconUrl: srcIcon,

			iconSize:     [20, 20], // size of the icon
			iconAnchor:   [10, 10], // point of the icon which will correspond to marker's location
			popupAnchor:  [0, -10] // point from which the popup should open relative to the iconAnchor
		});

		var html = html_popup_perturbation_mobile(name, o.type_name);

		oldObjects.push(L.marker(position, {icon: icon}).addTo(map).bindPopup(html));
	});
}

function show_nearestObjetsTerrains(map, oldObjects, newObjects) {
	// On vide les anciennes info :
	$.each(oldObjects, function(i,o) {map.removeLayer(o);})

	$.each(newObjects, function(i, o) {
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

		oldObjects.push(L.marker(position, {icon: icon}).addTo(map).bindPopup(html));
	});
}

// List (nearest) function :
var listNearest = {
	radius : 10000,
	position : L.latLng(0,0),

	newPosition : function(position) {
		var position = L.latLng(position.coords.latitude, position.coords.longitude);
		var radius = listNearest.position.distanceTo(position);
		listNearest.position = position;
		if (radius > listNearest.radius) {listNearest.getElements();}
	},

	getElements : function() {
		// Recuperations des Perturbations :
		$.ajax({
			url : Routing.generate("ajax_perturbation_list_nearest", {
				position : coordinatesToWKT(listNearest.position),
				radius : listNearest.radius
			}),
			type : 'GET',
			success : function(objets) {
				show_nearestPerturbationsList(objets);
			}
		});
	}
};

function show_nearestPerturbationsList(newObjects) {
	var html = '';
	$.each(newObjects, function(i, o) {
		html += html_list_perturbation(o);
	});
	$('#list').html(html);
}

var HTML_AJAX_LOADING = '<div class="ajax loading" />';

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