<?php 
error_reporting(E_ALL);
ini_set('display_errors', 'On');

if (isset($_GET['action']) && $_GET['action'] == 'new' && $_SERVER['REQUEST_METHOD'] == 'POST') {
	$node = array('title' => $_POST['title'], 'body' => $_POST['body'], 'created' => time());
	node_insert($node);
}

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['_id'])) {
	node_delete($_GET['_id']);
}

// find everything in the collection
$nodes = getMyDB()->nodes->find();

if (isset($_GET['action']) && $_GET['action'] == 'sync') {
	foreach ($nodes as $node) {
		node_sync('insert', $node);
	}
}

?>

<style>
	ul				{ margin: 0px; padding: 0px; }
	ul li			{ margin: 0px; padding: 0px; position: relative; }
	ul li .admin	{ position: absolute; top: 5px; right: 5px; }
</style>

<ul>
	<?php foreach ($nodes as $node): ?>
    	<li>
    		<h3><?php echo $node['title'] ?></h3>
    		<p>
    			<?php echo $node['body'] ?>
	    		<?php if (count($node) > 3): ?>
	    			<ul>
		    			<?php foreach ($node as $k => $v): ?>
		    				<?php if (!in_array($k, array('_id', 'title', 'body'))): ?>
		    					<li>[<?php echo $k ?>] <?php echo $v ?></li>
		    				<?php endif; ?>
		    			<?php endforeach; ?>
	    			</ul>
	    		<?php endif; ?>	
    		</p>
    		<div class="admin">
    			<a href="?action=delete&_id=<?php echo $node['_id'] ?>">[delete]</a>
    		</div>
    	</li>
	<?php endforeach; ?>
</ul>

<hr />

<form method="POST" action="?action=new">
	<input type="text" name="title" /> <br />
	<textarea name="body"></textarea> <br />
	<input type="submit" /> <br />
</form>


<?php 

function node_insert(array $node)
{
	getMyDB()->nodes->insert($node);
	node_sync('insert', $node);
}

function node_delete($objectId)
{
	$node = array('_id' => new MongoId($objectId));
	
	getMyDB()->nodes->remove($node);
	node_sync('delete', $node);
}

function node_sync($action, array $node)
{
	mycurl_post("node/sync/{$action}", $node);
}

function mycurl_post($url, $data)
{
	$post = (is_array($data)) ? http_build_query($data) : $data; 
	// create a new cURL resource
	$ch = curl_init();
	
	// set URL and other appropriate options
	curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1/{$url}");
	curl_setopt($ch, CURLOPT_PORT, 3001);
	curl_setopt($ch, CURLOPT_HEADER, 0);	
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	
	// grab URL and pass it to the browser
	var_dump (curl_exec($ch));
	
	// close cURL resource, and free up system resources
	curl_close($ch);
}
