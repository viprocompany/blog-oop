<?php
namespace core;

static $db;

class DBConnect 
{	

// 	private static $instance;
// //singletone as example code for connect DB
// 	public static function getConnect()
// 	{
// 		if (self::$instance === null){
// 			self::$instance = self::getPDO();
// 		}
// 		return self::$instance ;
// 	}

	public static function getPDO()
	{
//$opt взято в том числе и для исключения дубляжа запрсов из базы по ссылке с http://phpfaq.ru/pdo
//явно указываем что для ошибок надо использовать ERRMODE_EXCEPTION, чтобы PDO не возвращало объект с ошибками  а возвращало исключение
// по дефолту PDO возвращает FETCH_ASSOC
		$opt = [
			\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
			\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
		];
		// static $db;
		if($db === null){
			$dsn = sprintf('%s:host=%s;dbname=%s', 'mysql','localhost', 'blog');
			$db = new \PDO($dsn, 'root', '', $opt);
		// $db = new PDO('mysql:host=localhost;dbname=blog', 'root', '');
			$db->exec('SET NAMES UTF8');
		}
		return $db;
	}

}