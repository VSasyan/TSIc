document.addEventListener("DOMContentLoaded", function() {
	$(document).ready(function() {
		initMap();
		$element = $('#show_perturbation .pertubation:eq(0)');
		//add coordinates of pertubation to leaflet
		//alert($('.formulations .element:eq(0)').data('center'));
		var regExp = /POINT\((.*) (.*)\)/;
		var result = regExp.exec($element.data('center'));
		var position = [result[2], result[1]];

		//récupération des dates
		/*var date_creation = $('#show p:eq(0)').text().split('le ')[1];
		var date_modification = $('.elements p:eq(0)').text().split(': ')[1];
		var date_debut = $('.perturbation-dates').text().split(' ')[1];
		var date_fin = $('.perturbation-dates').text().split(' ')[6];
		
		var popup = "nom" + "</br>" + 
					"<dd>" + $('.formulations .element:eq(0)').data('name') + "</br>" + 
					"<dt>" +  "type" + 
					"<dd>" + $('.formulations h1 .perturbation-type').text() + "</br>" + 
					"<dt>" +  "date création" + 
					"<dd>" + date_creation + "</br>" +
					"<dt>" +  "date dernière modification" + 
					"<dd>" + date_modification + "</br>" +
					"<dt>" + "début perturbation" +
					"<dd>" + date_debut + "</br>" + 
					"<dt>" + "fin perturbation" +
					"<dd>" + date_fin + "</br>" + 		
					"<dt>" +  "description" + 
					"<dd>" + $('.perturbation-description').text();*/

		console.log(Routing.generate("logo_type_perturbation", {id : $element.data('logo')}));

		var icon = L.icon({
			iconUrl: Routing.generate("logo_type_perturbation", {id : $element.data('logo')}),

			iconSize:     [20, 20], // size of the icon
			iconAnchor:   [10, 10], // point of the icon which will correspond to marker's location
			popupAnchor:  [0, -10] // point from which the popup should open relative to the iconAnchor
		});


		var marker = L.marker(position, {icon: icon}).addTo(map);//.bindPopup(popup).openPopup();
		map.setView(position, 13, {animate:true});

		console.log($('.formulations h1 perturbation-type').text());
	});
});
