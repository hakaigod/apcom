/**
 * Created by 15110024 on 2017/07/06.
 */
var http = require('http');
var socketio = require('socket.io');
var fs = require('fs');

var server = http.createServer(function(req, res) {
    res.writeHead(200, {'Content-Type' : 'text/html'});
    res.end(fs.readFileSync(__dirname + '/index.html', 'utf-8'));
}).listen(3000);

var io = socketio.listen(server);

io.sockets.on('connection', function(socket) {
    console.log("connection");
    socket.on('message', function(data) {
        console.log('message');
        io.sockets.emit('message', {value: data.value});
    });
    socket.on('disconnect', function() {
        console.log('disconnect');
    });
});

