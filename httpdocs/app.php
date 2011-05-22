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