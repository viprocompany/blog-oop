<?php  
namespace controller;
use models\TextsModel;
use core\DBConnect;
use core\Auth;

class TextController extends BaseController
{
	public function indexAction()
{
		// переопределяем title
	$this->title .=': СТАТИКА';
    //вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
$isAuth = Auth::isAuth();
//имя пользователя для вывода в приветствии
$login = Auth::isName();
	$msg = '';

//проверка авторизации
if(!$isAuth)
{
//ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : в массив сессии  добавляем элемент указывающий куда перейдет клиент после авторизации в файле login.php, если он заходил после клика на "ДОБАВИТЬ автора"
$_SESSION['returnUrl'] = ROOT . "text";
  // Header('Location: /../views/login.html.php');
  	header("Location: " . ROOT . "login");
}
	  //создаем массив сканирую директорию img
// $dir_img = $_SERVER['DOCUMENT_ROOT'] . 'assest/img';
// $dir_img =  'f:/OpenServer/OSPanel/domains/blog/assest/img/';
$dir_img =  'D:/open-server/OSPanel/domains/blog-oop/assest/img/';
$img_files = scandir($dir_img);
//создаем пустой массив для картинок
$images = [];
$images = $img_files;

//для вызова
	//создаем объект для подключения к базе данных
	$db = DBConnect::getPDO();
//создаем новый объект класса ArticleModel и через конструктор добавляем к нему передачей через параметр ранее созданный  объект  $db для подключения к базе данных
	$mTexts = new TextsModel($db);
//применяем к объекту метод из его класса
	$texts = $mTexts->getAll(' text_name ');
// var_dump($users);
	  $this->content = $this->build(__DIR__ . '/../views/texts.html.php', [
	  	'texts' => $texts,
	  	'images' => $images,
	  	'isAuth' => $isAuth,
      'login' => $login
	  ]);
}

}