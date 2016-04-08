document.addEventListener("DOMContentLoaded", function() {
	$(document).ready(function() {
		initMap();
		//add coordinates of pertubation to leaflet
		//alert($('.formulations .element:eq(0)').data('center'));
		var regExp = /POINT\((.*) (.*)\)/;
		var result = regExp.exec($('.formulations .element:eq(0)').data('center'));
		console.log(result[1], result[2]);
		
		//ajout du marker à la map

		//récupération des dates
		var date_creation = $('#show p:eq(0)').text().split('le ')[1];
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
					"<dd>" + $('.perturbation-description').text();


		var marker = L.marker([result[2], result[1]]).addTo(map).bindPopup(popup).openPopup();
		map.setView([result[2], result[1]], 13, {animate:true});

		console.log($('.formulations h1 perturbation-type').text());
	});
});