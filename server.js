var http        = require("http"),
    mongoose    = require("mongoose/")
    db          = mongoose.connect('mongodb://localhost/myserverdb'),
    Schema      = mongoose.Schema,
    ObjectId    = Schema.ObjectId,
    express		= require("express"),
    app         = express.createServer();

var Node = new Schema({
  title     : String,
  body      : String,
  created	: Number
});

mongoose.model('node', Node);
Node = mongoose.model('node');

app.use(express.bodyParser());

app.get('/hello', function(req, res) {
	console.log('[SERVER] /hello requested');
    res.send('Hello from teh server');
});

app.post('/node/sync/:action', function(req, res) {
	console.log('[SERVER] /node/sync ('+req.params.action+') requested');

	switch (req.params.action) {
		case 'insert': 		    
			node = new Node();
			node._id		= req.body._id.$id;
			node.title		= req.body.title;
			node.body		= req.body.body;
			node.created	= req.body.created;

			node.save();
		break;
		
		case 'delete':   
			node = new Node();
			console.log(req.body);
			node._id		= req.body._id.$id;
			
			node.remove();

		break;
	}
	
    res.end();
});

app.listen(3000);
