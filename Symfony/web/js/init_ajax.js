// Functions
function getPage(route, after) {
	return $.get(route, function(data, status) {
		document.title = data.title;
		$('#ajax_loader').html(data.content);
		if(after != false) { after(); }
	});
}


function listNearest(pos) {
	getPage(
		Routing.generate("perturbation_list_nearest", { position : coordinatesToWKT(pos.coords), radius : 1000 }),
		function() { initMap(); }
	);
	navigator.geolocation.clearWatch(positionWatchID);
	positionWatchID = false;
}

var functions = {
	listNearest : function() { geolocation(listNearest); },
};

document.addEventListener("DOMContentLoaded", function() {
	//ajout ajax load gif
		//$('#ajax_loader').replaceWith(HTML_AJAX_LOADING);
		$('#ajax_loader').html(HTML_AJAX_LOADING_BIG);
		
		console.log('test: ', HTML_AJAX_LOADING);

		

	functions[$('#ajax_loader').data('function')]();
});
