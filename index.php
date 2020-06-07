<?php
// use controller\BaseController;
use core\Auth;
use core\DBConnect;
use core\Helper;
use core\Templater;
use models\BaseModel;
use models\AllTablesModel;
use models\CategoriesModel;
use models\PostModel;
use models\TextsModel;
use models\UsersModel;
use models\VerificationModel;
//объявляем константу для переменной корня сайта для подстановки на ссылках сайта после перехода на человекочитаемые урлы
define('ROOT','http://blog-oop/');
session_start();
$title = '';
$err404 = false;

function __autoload($classname) {
	include_once __DIR__ . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $classname) . '.php';
}
// var_dump($_SERVER);
//достаем из массива СЕРВЕР значение REQUEST_URI, то есть URI, который был предоставлен для доступа к этой странице. Например, '/'
$uri = $_SERVER['REQUEST_URI'];

$uriParts = explode('/', $uri);

unset($uriParts[0]);
$uriParts = array_values($uriParts);

$controller = isset($uriParts[0]) && $uriParts[0] !== '' ? $uriParts[0] : 'home';
// var_dump(($uriParts) );

$id = false;
if(isset($uriParts[1]) && is_numeric($uriParts[1])){
	$id = $uriParts[1];
	$uriParts[1] = 'one';
}

$action = isset($uriParts[1]) && $uriParts[1] !== '' && is_string($uriParts[1]) ? $uriParts[1] : 'index';
$action = sprintf('%sAction', $action);
// var_dump($action);

if(!$id){
  $id = (isset($uriParts[2]) && is_numeric($uriParts[2]))  ? ($uriParts[2]): false ;
}
if($id){
  $_GET['id'] = $id;
}
// var_dump($id);
$request = new core\Request( $_GET, $_POST, $_SERVER, $_COOKIE, $_TITLE, $_SESSION);

if (strpos($controller,'?' )) {
  //обрезаем полученный гет параметр до  знака ? ЕСЛИ ОН СУЩЕСТВУЕТ, за которым может задаваться очередная пара параметр-значение , например для вьюшек на домашней странице base  или inline
$controller = stristr($controller, '?', true);
// echo $controller;
}
$filename = "controller/". sprintf('%sController', $controller).".php";
//прорверку контроллера на название  и ошибку
if($controller === '' || !file_exists($filename) || !preg_match("/^[a-zA-Z0-9_-]+$/", $controller))
{	$err404 = true;
	// echo '404 нет такого контроллера:  '.$filename;
	//если контролеера нет , значит присваиваем ему значение Error , в результате чего сработает контроллер Error и выведет в разметку сообщение об ошибке
		$controller = 'Error';
}

//создаем объект для подключения к базе данных
$db = DBConnect::getPDO();
$controller = sprintf('controller\%sController', $controller);
$controller = new $controller($request);
$controller->$action();
$controller->render();

