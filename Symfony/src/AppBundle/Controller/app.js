var http = require('http');
var fs = require('fs');

// Chargement du fichier index.html affiché au client
var server = http.createServer(function(req, res) {
    // fs.readFile('./client.html', 'utf-8', function(error, content) {
    //     res.writeHead(200, {"Content-Type": "text/html"});
    //     res.end(content);
    // });
});

var resultat;
// Chargement de socket.io
var io = require('socket.io').listen(server);

io.sockets.on('connection', function (socket, pseudo) {

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