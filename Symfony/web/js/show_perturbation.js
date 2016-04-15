document.addEventListener("DOMContentLoaded", function() {
	$(document).ready(function() {

		initMap();

		$element = $('#show_perturbation .pertubation:eq(0)');
		//add coordinates of pertubation to leaflet
		//alert($('.formulations .element:eq(0)').data('center'));
		var regExp = /POINT\((.*) (.*)\)/;
		var result = regExp.exec($element.data('center'));
		var position = [result[2], result[1]];

		var icon = L.icon({
			iconUrl: Routing.generate("logo_type_perturbation", {id : $element.data('logo')}),

			iconSize:     [20, 20], // size of the icon
			iconAnchor:   [10, 10], // point of the icon which will correspond to marker's location
			popupAnchor:  [0, -10] // point from which the popup should open relative to the iconAnchor
		});

		var marker = L.marker(position, {icon: icon}).addTo(map);
		map.setView(position, 13, {animate:true});
	});
});
