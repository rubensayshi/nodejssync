<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');
define('APPROOT', dirname(dirname(__FILE__)));

abstract class MongoDBHelper
{
	static $name 	= null;
	static $db 		= null;
	static $mongo	= null;
	
	static function init()
	{
		if (is_null(self::$mongo)) {	
			self::$mongo = new Mongo();
		}
	}

	static function setName($name)
	{
		self::$name = $name;
	}
	
	static function getDb($name = null)
	{
		self::init();
		
		if (is_null($name))
			$name = self::$name;
			
		return self::$mongo->selectDB($name);
	}
}

function tpl_render($tpl, array $vars = array())
{
	extract($vars);
	
	ob_start();	
	include APPROOT . '/tpls/'.$tpl;
	
	return ob_get_clean();
}

function node_insert(array $node)
{
	MongoDBHelper::getDb()->nodes->insert($node);
	node_sync('insert', $node);
}

function node_delete($objectId)
{
	$node = array('_id' => new MongoId($objectId));
	
	MongoDBHelper::getDb()->nodes->remove($node);
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