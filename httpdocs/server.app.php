<?php 

require dirname(dirname(__FILE__)) . '/inc/app.inc.php';
MongoDBHelper::setName('myserverdb');

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['_id'])) {
	node_delete($_GET['_id']);
}

// find everything in the collection
$nodes = MongoDBHelper::getDb()->nodes->find();

echo tpl_render('demo.tpl.php', array(
	'nodes'		=> $nodes,
	'hideform'	=> true,
));
