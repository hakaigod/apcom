var app = require('http').createServer(handler);
var io = require('socket.io')(app);

app.listen(3000);

var redis = require('socket.io-redis');
var adapter = io.adapter(redis({ host: '127.0.0.1', port: 6379 }));

function handler (req, res) {
    res.writeHead(200);
    res.end();
}

io.on('connection', function (socket) {
  socket.emit("messageFromPHP","");
});
