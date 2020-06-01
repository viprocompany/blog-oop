<?php  
namespace controller;
use models\BaseModel;
use models\TextsModel;
use core\DBConnect;
use core\Auth;
use models\Helper;

class AddTextController extends BaseController
{
	public function indexAction()
{
		// переопределяем title
	$this->title .=': НОВАЯ СТАТИКА';
	    //вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
$isAuth = Auth::isAuth();
//имя пользователя для вывода в приветствии
$login = Auth::isName();
	$msg = '';

//проверка авторизации
if(!$isAuth)
{
//ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : в массив сессии  добавляем элемент указывающий куда перейдет клиент после авторизации в файле login.php, если он заходил после клика на "ДОБАВИТЬ автора"
$_SESSION['returnUrl'] = ROOT . "addText";
 header("Location: " . ROOT . "login");
}
//для вызова
	//создаем объект для подключения к базе данных
	$db = DBConnect::getPDO();


$mText = new TextsModel($db);

//создаем массив сканирую директорию img
// $dir_img = $_SERVER['DOCUMENT_ROOT'] . 'assest/img';
// $dir_img =  'f:/OpenServer/OSPanel/domains/blog/images';
$dir_img =  'D:/open-server/OSPanel/domains/blog-oop/images';
   
$img_files = scandir($dir_img);
//создаем пустой массив для картинок
$images = [];
$images = $img_files;

//получение параметров с формы методом пост
if(count($_POST) > 0){
  $text_name = trim($_POST['text_name']);
  $text_content = trim($_POST['text_content']);
  $description = trim($_POST['description']);
//проверяем корректность вводимого названия 
  // if(!correct_name($text_content))
  // {   
  //   $msg = errors();
  // } 
//проверяем корректность вводимого названия 
	// if(!(Helper::newCorrectTitle($text_name)))
	// {		
	// 	$msg = Helper::errors();		
	// }	
	//проверяем корректность вводимого названия 
	if($text_name == '')
	{		
			$msg = 'Заполните название!';
	}	
	// проверка названия на незанятость вводимого названия 
	elseif (!($mText->correctOrigin( 'id_text ', ' texts ', ' text_name ', $text_name))) 
	{
		// $msg = Helper::errors();
		$msg = 'Название занято!';
	}
//проверяем корректность вводимого контента 
	elseif(!(Helper::newCorrectTitle($text_content)))
	{
		// $msg = Helper::errors();
		$msg = "Введите текст статической вставки!";
	}	
	else
	{
//подключаемся к базе данных через  функцию db_query_add_article и предаем тело запроса в параметре, которое будет проверяться на ошибку с помощью этой же функции, после 
//добавление данных в базу функция вернет значение последнего введенного айдишника в переменную new_article_id, которую будем использовать для просмотра новой статьи при переходе на страницу post.php
		$new_article_id = $mText->addText($text_name, $text_content, $description);	

			header("Location: " . ROOT . "text/$new_text_id");
		exit();
	}
}
else{
//если данные в инпуты не вводились, задаем пустые значения инпутов формы для того чтобы через РНР вставки в разметке кода не выскакивали(на странице в полях инпутов для заполнения) нотации об отсутствии данных в переменных $title и $content
  $text_name = "";
  $text_content = '';
  $description = '';
  $msg = '';
} 
	  $this->content = $this->build(__DIR__ . '/../views/add-text.html.php', [
	  	'isAuth' => $isAuth ,
	  	'text_name' => $text_name,
	  	'text_content' => $text_content,
	  	'images' => $images,
	  	'description' => $description,
	  	'msg' => $msg,
	  	'login' => $login
	  ]);


}

}