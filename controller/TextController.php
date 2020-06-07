<?php  
namespace controller;
use models\TextsModel;
use core\DBConnect;
use core\Auth;
use core\DBDriver;

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
  $dir_img =  'd:/open-server/OSPanel/domains/blog-oop/assest/img/';
  $img_files = scandir($dir_img);
//создаем пустой массив для картинок
  $images = [];
  $images = $img_files;

//для вызова
	//создаем объект для подключения к базе данных
  $db = DBConnect::getPDO();
//создаем новый объект класса ArticleModel и через конструктор добавляем к нему передачей через параметр ранее созданный  объект  $db для подключения к базе данных
  $mTexts = new TextsModel(new DBDriver($db));
//применяем к объекту метод из его класса
  $texts = $mTexts->getAll(' text_name ');
// var_dump($users);
  $this->content = $this->build('texts', [
    'texts' => $texts,
    'images' => $images,
    'isAuth' => $isAuth,
    'login' => $login
  ]);
}

public function oneAction()
{ 
  $db = DBConnect::getPDO();
  $mTexts = new TextsModel(new DBDriver($db));

//вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
  $isAuth = Auth::isAuth();
//имя пользователя для вывода в приветствии
  $login = Auth::isName();
  $msg = '';
//проверка авторизации
  if(!$isAuth)
  {
//ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : в массив сессии  добавляем элемент указывающий куда перейдет клиент после авторизации в файле login.php, если он заходил после клика на "ДОБАВИТЬ автора"
    $_SESSION['returnUrl'] = ROOT . "text/$id_text";
  // Header('Location: login.php');
  }

  $err404 = false;

  $id = $this->request->get('id');
  $texts = $mTexts->getById($id); 
    // переопределяем title
  
    $text_name = $texts['text_name'];
    $text_content = $texts['text_content'];
        //    проверяем корректность вводимого айдишника
  
  $this->title .=': ' . $text_name;
    //при добавлении нового категории будет создаваться переменная шаблона для вывода данных о новом авторе , которая далее будет добавлена в массив переменных шаблона v_main
  if(!($mTexts->correctId('text_name', 'texts', 'id_text', $id )))
  { 
    $err404 = true;  
    $this->content = $this->build('errors', [
    ]);
  }
  else{
      $this->new_row = $this->build('text-new', [
        'text_name' => $text_name,
        'text_content' => $text_content,
        'id_text' => $id

      ]);
    //создаем массив сканирую директорию img
// $dir_img = $_SERVER['DOCUMENT_ROOT'] . 'assest/img';
// $dir_img =  'f:/OpenServer/OSPanel/domains/blog/assest/img/';
  $dir_img =  'd:/open-server/OSPanel/domains/blog-oop/assest/img/';
  $img_files = scandir($dir_img);
//создаем пустой массив для картинок
  $images = [];
  $images = $img_files;

//применяем к объекту метод из его класса
    $texts = $mTexts->getAll('id_text DESC ');
// var_dump($users);
    $this->content = $this->build('texts', [
      'texts' => $texts,
      'images' => $images,
      'isAuth' => $isAuth,
      'login' => $login
    ]);
  }

}
}