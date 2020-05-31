<?php
namespace core;

static $db;

class DBConnect 
{	
	public static function getPDO()
	{
		// static $db;
		if($db === null){
			$dsn = sprintf('%s:host=%s;dbname=%s', 'mysql','localhost', 'blog');
			$db = new \PDO($dsn, 'root', '');
		// $db = new PDO('mysql:host=localhost;dbname=blog', 'root', '');
			$db->exec('SET NAMES UTF8');
		}
		return $db;
	}

}