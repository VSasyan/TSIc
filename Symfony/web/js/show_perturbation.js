document.addEventListener("DOMContentLoaded", function() {
	$(document).ready(function() {
		initMap();
		//add coordinates of pertubation to leaflet
		//alert($('.formulations .element:eq(0)').data('center'));
		var regExp = /POINT\((.*) (.*)\)/;
		var result = regExp.exec($('.formulations .element:eq(0)').data('center'));
		console.log(result[1], result[2]);
		//ajout du marker à la map
		var marker = L.marker([result[2], result[1]]).addTo(map);
		map.setView([result[2], result[1]], 13, {animate:true});
	});
});