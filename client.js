var http        = require("http"),
    express		= require("express"),
    app         = express.createServer(),
    server		= http.createClient(3000, '127.0.0.1');

app.use(express.bodyParser());

app.get('/hello', function(req, res) {
	console.log('[CLIENT] /hello requested');
	res.send('Hello, I\'m the client!');
});

app.post('/node/sync/:action', function(req, res) {
	console.log('[CLIENT] /node/sync ('+req.params.action+') requested');
	
	node 	= req.body;	
	post	= JSON.stringify(node);
		
	var request = server.request('POST', '/node/sync/' + req.params.action, {
	    'Content-Length':	post.length,
	    'Content-Type': 	'application/json' 
	});
	request.write(post);
	
	request.on('response', function(response) {
		response.on('data', function(chunk) {
			console.log(">> " + chunk.toString());
		});
    });
	
    request.end();
    
    res.send('ok');

});

app.listen(3001);
