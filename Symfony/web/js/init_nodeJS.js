var functions_nodeJS = {
	listNearest : function(message) {

        var result = getLatLon(message[0]);
        var data = {'position' : result, 'html': message[1]};

        var newPosition = L.latLng([data.position[1], data.position[0]]);

		if(dataBounds.contains(newPosition)) {
			// We do not have any data
			//console.log('La perturbation est dans le champ de vision!');
			//on remet à jour les perturbations
			listNearest(map.getBounds());
			showMessages(data.html);
		}
	}
}

document.addEventListener("DOMContentLoaded", function() {
	//appel de la fonction nodeJS
	var nomSocket = $('#ajax_loader').data('node-js');
	//console.log(nomSocket);

	if (nomSocket != false) {

		// Connection au socket
		var socket = io.connect('http://localhost:8080');

        socket.on('perturbation', functions_nodeJS[nomSocket]);

	}

});

function getLatLon(chaine){
    var regExp = /POINT\((.*) (.*)\)/;
    var result = regExp.exec(chaine);
    return [result[1], result[2]];
};


