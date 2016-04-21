var http = require('http');
var fs = require('fs');

// Chargement du fichier index.html affiché au client
var server = http.createServer(function(req, res) {

});

var resultat;
// Chargement de socket.io
var io = require('socket.io').listen(server);

io.sockets.on('connection', function (socket, pseudo) {
        //<script src="http://cdn.socket.io/socket.io-1.4.5.js"></script>

    console.log('Socket.io est connecté');

    //Réception du message envoyé par le controller en php
    socket.on('emitPHP', function (data) {
        resultat = data.message;
        console.log('Reception du message : ' + data.message + ' et aussi des coordonnees: ' + data.coordinates); 
        socket.broadcast.emit('perturbation', [data.coordinates, data.message]);
        //socket.broadcast.emit('message', '<strong>' + data.message + '</strong>');
    });

    //socket.emit('message', 'Vous êtes bien connecté !');
    
    //socket.broadcast.emit('perturbation', 'Une perturbation a été ajoutée ! ');

    socket.on('disconnect', function () {
        //console.log(resultat + 'Socket.io déconnecté');
        console.log('Socket.io déconnecté');
    });

});

server.listen(8080);

console.log(resultat);