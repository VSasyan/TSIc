var functions_nodeJS = {
	listNearest : function(data) {
		var newPosition = LatLng(data.position);

		if(dataBounds.contains(newPosition)) {
			// We do not have any data
			listNearest(currentBounds);
			showMessages(data.html);
		}
	}
}

document.addEventListener("DOMContentLoaded", function() {
	var nomSocket = $('#ajax_loader').data('nodeJS');
	if (nomSocket != false) {

		// Connexion au socket "nomSocket"
		// fonction de callback = functions_nodeJS[nomSocket](data)
	}

});
