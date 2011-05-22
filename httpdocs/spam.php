<?php 

require dirname(dirname(__FILE__)) . '/inc/app.inc.php';
MongoDBHelper::setName('myclientdb');

for($i = 0; $i < 1000; $i++) {
	$node = array('title' => 'g3n3r@t3d #'.$i, 'body' => 'g3n3r@t3d #'.$i, 'created' => time());
	node_insert($node);
}
