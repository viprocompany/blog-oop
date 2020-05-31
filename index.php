<?php
// use controller\BaseController;
use core\Auth;
use core\DBConnect;
use core\Helper;
use core\Templater;
use models\BaseModel;
use models\AllTablesModel;
use models\ArticleModel;
use models\CategoriesModel;
use models\TextsModel;
use models\UsersModel;
use models\VerificationModel;
//объявляем константу для переменной корня сайта для подстановки на ссылках сайта после перехода на человекочитаемые урлы
define('ROOT','http://blog-oop/');
session_start();
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
// var_dump(($uriParts[0]) );

$action = isset($uriParts[1]) && $uriParts[1] !== '' && is_string($uriParts[1]) ? $uriParts[1] : 'index';
$action = sprintf('%sAction', $action);

if (strpos($controller,'?' )) {
  //обрезаем полученный гет параметр до  знака ? ЕСЛИ ОН СУЩЕСТВУЕТ, за которым может задаваться очередная пара параметр-значение , например для вьюшек на домашней странице base  или inline
$controller = stristr($controller, '?', true);
echo $controller;
}

$filename = "controller/". sprintf('%sController', $controller).".php";

//прорверку контроллера на название  и ошибку
if($controller === '' || !file_exists($filename) || !preg_match("/^[a-zA-Z0-9_-]+$/", $controller))
{
	$err404 = true;
	echo '404 нет такого контроллера:  '.$filename;
		$controller = 'Error';
}
//создаем объект для подключения к базе данных
$db = DBConnect::getPDO();
$controller = sprintf('controller\%sController', $controller);
$controller = new $controller();
$controller->$action();
$controller->render();
// $base = self::build(__DIR__ . '/views/main.html.php', ['content' => $content]);

//ЭТОТ КОД ДООЛЖЕН БЫТЬ ДО ЭКШНОВ по гет параметру выбираем контроллер и его значение присваиваем переменной controller , которая далее будет подставлятся как первая часть в названии класса контроллера, при выборе экшна и рендеризации разметки
// switch ($controller) {
// 	case 'home':
// 		$controller = 'Home';
// 		break;
// 	case 'home?view=base':
// 		$controller = 'Home';
// 		break;
// 	case 'home?view=inline':
// 		$controller = 'Home';
// 		break;
// 	case 'user':
// 		$controller = 'User';
// 		break;
// 	case 'post':
// 		$controller = 'Post';
// 		break;
// 	case 'category':
// 		$controller = 'Category';
// 		break;
// 	case 'text':
// 		$controller = 'Text';
// 		break;
// 	case 'login':
// 		$controller = 'Login';
// 		break;
// 	default:
// 	$controller = 'Error';
// 		// die('error 404: нет так');
// 		break;
// }



$mPost = new ArticleModel($db);
$postOne = $mPost->getById(1) ;
// $posts = $mPost->correctOrigin('id_article', 'article', 'title', 555);

// echo($posts);

// echo '<br>';
//добавление объекта с выдачей айдишника
// echo $mPost->addArticle('test', 'content','3','3','image');
// запуск обновления объекта
// echo $mPost->updateArticle('test_5', 'content_3','3','3','image',16);
// echo '<br>';
 //удалениеобъекта
// echo $mPost->deleteById(17);


$mCategories = new CategoriesModel($db);
// echo  $catOne = $mCategories->updateCategory('PHP 2',5) ;
// $catAll = $mCategories->getAll( 'title_name ASC' );
// echo '<pre>';
// var_dump($catAll);
// echo '</pre>';
$mTextsModel = new TextsModel($db);
$textOne = $mTextsModel->getById('$vk') ;
$textsAll = $mTextsModel->getAll( 'id_text ASC' );
// echo $mTextsModel->addText('$fbook_4', 'Faccbook 4', 'image') ;
// echo $mTextsModel->updateText(13,'$fbook_EDIT', 'мордокниг','Faccbook!!!!!!!!!!!!!' ) ;
// var_dump($textOne);


//рабочий  , но не нужный метод 
 // echo  $mUsers->addRow("INSERT INTO `users`( `name`) VALUES (:n);",['n'=>'Новый автор']);

