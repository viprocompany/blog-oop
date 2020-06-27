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
use core\Exception\ErrorNotFoundException;
// use models\VerificationModel;
//объявляем константу для переменной корня сайта для подстановки на ссылках сайта после перехода на человекочитаемые урлы
// define('ROOT','http://10.0.7.144/');
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

//если экшн имеет название из нескольких слов то в ссылке мы разделяем их с помощью тире и с маленькой буквы, а экшн именуем в кемел кейсе как обычно, но в результате следующих действий все слова в названии будут возвращены в контроллер с большой буквы
$actionParts = explode('-', $action);
for($i=1; $i<count($actionParts); $i++){
	if (!isset($actionParts[$i])) {
		continue;
	}
	//ucfirst преобразует первую букву в верхний регистр
	$actionParts[$i] = ucfirst($actionParts[$i]);
}
// var_dump($actionParts);

//склеиваем слова полученные из ссылки в название контроллера , который будет начинатсяс маленькой буквы в стиле кемелкейс
$action = implode('',$actionParts );
// var_dump($action);

$action = sprintf('%sAction', $action);


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
try{
	//проверяем контроллер на наличиен ошибок-исключений и если таковые есть обрабатываем их далее в catch 
	$filename = "controller/". sprintf('%sController', $controller).".php";
//прорверку контроллера на название  и ошибку
	if($controller === '' || !file_exists($filename) || !preg_match("/^[a-zA-Z0-9_-]+$/", $controller)){
		$err404 = true;
		//если контролеера нет , значит присваиваем ему значение Error , в результате чего сработает контроллер Error и выведет в разметку сообщение об ошибке
		$controller = 'Error';
		//если в названии контролера после слеша есть буквенные знаки , а не числовые как в ID, такая ошибка будет отловлена через метод  __call класса BaseController и будет также выводится как 404
	}
//создаем объект для подключения к базе данных
	$db = DBConnect::getPDO();
	$controller = sprintf('controller\%sController', $controller);
	$controller = new $controller($request);
	$controller->$action();
} catch (\Exception $e){	
	$controller = new $controller($request);
	//все спойманные исключения , которые дошпи из метода execute класса Validator до этого места обрабатываем здесь используя метод errorHandler  класса BaseController
	$controller->errorHandler($e->getMessage(), $e->getTraceAsString());
}
$controller->render();



