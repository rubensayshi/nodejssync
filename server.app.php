<?php 

function getMyDB()
{
	static $db = null;
	
	if (is_null($db)) {
		// connect
		$mongodb = new Mongo();
		
		// select a database
		$db = $mongodb->myserverdb;
	}
	
	return $db;
}

require './app.php';