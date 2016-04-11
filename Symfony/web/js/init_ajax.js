// Functions
function getPage(route, after) {
	var after = after || false;
	return $.get(route, function(data, status) {
		document.title = data.title;
		$('#ajax_loader').html(data.content);
		if(after != false) { after(); }
	});
}

var functions = {
	listNearest : function() {
		geoloc.init();
		initMap();
		geoloc.callback = function() {
			updateMarker();
			updateView();
		}
		geoloc.callbackError = function(err) {
			geoloc.position = { latitude: 48.8410544, longitude: 2.5873005 };
			geoloc.callback();
		}
	},
};

document.addEventListener("DOMContentLoaded", function() {
	//ajout ajax load gif
		//$('#ajax_loader').replaceWith(HTML_AJAX_LOADING);
		$('#ajax_loader').html(HTML_AJAX_LOADING_BIG);
		
		console.log('test: ', HTML_AJAX_LOADING);

		

	functions[$('#ajax_loader').data('function')]();
});
