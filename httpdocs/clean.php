<?php 

require dirname(dirname(__FILE__)) . '/inc/app.inc.php';
MongoDBHelper::setName('myclientdb');

$nodes = MongoDBHelper::getDb()->nodes->find();

foreach ($nodes as $node) {
	node_delete($node['_id']);
}
