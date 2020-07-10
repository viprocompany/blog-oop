<?php  
namespace controller;

use models\BaseModel;
use models\TextsModel;
use core\DBConnect;
use core\Auth;
use core\Request;
use core\DBDriver;
use models\Helper;
use core\Validator;
use core\Exception\IncorrectDataException;

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
    header("Location: " . ROOT . "logins/login");
  }
	  //создаем массив сканирую директорию img
// $dir_img = $_SERVER['DOCUMENT_ROOT'] . 'assest/img';
$dir_img =  'f:/OpenServer/OSPanel/domains/blog-oop/assest/img/';
  // $dir_img =  'd:/open-server/OSPanel/domains/blog-oop/assest/img/';
  $img_files = scandir($dir_img);
//создаем пустой массив для картинок
  $images = [];
  $images = $img_files;
//для вызова
	//создаем объект для подключения к базе данных
  $db = DBConnect::getPDO();
//создаем новый объект класса ArticleModel и через конструктор добавляем к нему передачей через параметр ранее созданный  объект  $db для подключения к базе данных
  $mTexts = new TextsModel(new DBDriver($db),new Validator());
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
  $mText = new TextsModel(new DBDriver($db),new Validator());

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
  // Header('Location: logins/sign-in.php');
  }

  $id = $this->request->get('id');
  $text = $mText->getById($id); 
    // переопределяем title
  
  $text_name = $text['text_name'];
  $text_content = $text['text_content'];
  $id_text = $text['id_text'];
        //    проверяем корректность вводимого айдишника
  
  $this->title .=': ' . $text_name;
    //при добавлении нового категории будет создаваться переменная шаблона для вывода данных о новом авторе , которая далее будет добавлена в массив переменных шаблона v_main
  if(!($mText->correctId('text_name', 'texts', 'id_text', $id )) || !$id_text)
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
$dir_img =  'f:/OpenServer/OSPanel/domains/blog-oop/assest/img/';
    // $dir_img =  'd:/open-server/OSPanel/domains/blog-oop/assest/img/';
    $img_files = scandir($dir_img);
//создаем пустой массив для картинок
    $images = [];
    $images = $img_files;

//применяем к объекту метод из его класса
    $text = $mText->getAll('id_text DESC ');
// var_dump($users);
    $this->content = $this->build('texts', [
      'texts' => $text,
      'images' => $images,
      'isAuth' => $isAuth,
      'login' => $login
    ]);
  }
}

public function addAction()
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
    $_SESSION['returnUrl'] = ROOT . "text/add";
    header("Location: " . ROOT . "logins/login");
  }
  //если данные в инпуты не вводились, задаем пустые значения инпутов формы для того чтобы через РНР вставки в разметке кода не выскакивали(на странице в полях инпутов для заполнения) нотации об отсутствии данных в переменных $title и $content
    // $title = "";
  $text_name = "";
  $text_content = '';
  $description = '';
  $msg = '';
//для вызова
//создаем объект для подключения к базе данных
  $db = DBConnect::getPDO();
//создаем новый объект класса ArticleModel и через конструктор добавляем к нему передачей через параметр ранее созданный  объект  $db для подключения к базе данных
  $mText = new TextsModel(new DBDriver(DBConnect::getPDO()),new Validator());

  //создаем массив сканирую директорию img
// $dir_img = $_SERVER['DOCUMENT_ROOT'] . 'assest/img';
$dir_img =  'f:/OpenServer/OSPanel/domains/blog-oop/assest/img/';
  // $dir_img =  'd:/open-server/OSPanel/domains/blog-oop/assest/img';

  $img_files = scandir($dir_img);
//создаем пустой массив для картинок
  $images = [];
  $images = $img_files;

//получение параметров с формы методом пост
  if($this->request->isPost()){
    $text_name = trim($_POST['text_name']);
    $text_content = trim($_POST['text_content']);
    $description = trim($_POST['description']);
    $msg = [];
  // проверка названия на незанятость вводимого названия 
    if (!($mText->correctOrigin( 'id_text ', ' texts ', ' text_name ', $text_name))) 
    {
    // $msg = Helper::errors();
      $msg = ['Название занято!'];
    } 
    else
  {    //собираем исключения брошенные в методе add/insert BaseModel
    try{
     $this->new_row = $this->build('text-new', [
      'text_name' => $text_name,
      'text_content' => $text_content,
      'id_text' => $id
    ]);
//подключаемся к базе данных через  функцию db_query_add_article и предаем тело запроса в параметре, которое будет проверяться на ошибку с помощью этой же функции, после 
//добавление данных в базу функция вернет значение последнего введенного айдишника в переменную new_article_id, которую будем использовать для просмотра новой статьи при переходе на страницу post.php
     $new_text_id = $mText->add([
      'text_name'=>$text_name,
      'text_content'=>$text_content,
      'description'=> $description 
    ]); 
     header("Location: " . ROOT . "text/$new_text_id");
     exit();
   } catch (IncorrectDataException $e) {
          //обрабатываем исключения брошенные в методе add/insert BaseModel и выводим ошибку в представлении с помощью метода getErrors класса  IncorrectDataException
    $msg = [];
    $msg = ($e->getErrors());
  }   
}
}
$this->content = $this->build('add-text', [
  'isAuth' => $isAuth ,
  'text_name' => $text_name,
  'text_content' => $text_content,
  'images' => $images,
  'description' => $description,
  'msg' => $msg,
  'login' => $login
]);
}

public function editAction()
{
//вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
  $isAuth = Auth::isAuth();
//имя пользователя для вывода в приветствии
  $login = Auth::isName();
  $msg = '';
//проверка авторизации

//для вызова
  //создаем объект для подключения к базе данных
  $db = DBConnect::getPDO();
//создаем новый объект класса ArticleModel и через конструктор добавляем к нему передачей через параметр ранее созданный  объект  $db для подключения к базе данных
  $mText = new TextsModel(new DBDriver(DBConnect::getPDO()),new Validator());
  $id = $this->request->get('id');
  //задаем массив для дальнейшего вывода фамилий авторов в разметке через опшины селекта, после выбора автора из значения опшина подтянется айдишник автора для дальнейшего добавления в статью
  $text = $mText->getById($id); 
    // переопределяем title
  
  $text_name = $text['text_name'];
  $text_content = $text['text_content'];
  $id_text = $text['id_text'];
  $description = $text['description'];
        //    проверяем корректность вводимого айдишника
  
  $this->title .=': ИЗМЕНИТЬ СТАТИКУ:' . $text_name;
  if(!$isAuth){
//ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : в массив сессии  добавляем элемент указывающий куда перейдет клиент после авторизации в файле login.php, если он заходил после клика на "ДОБАВИТЬ автора"
    $_SESSION['returnUrl'] = ROOT . "text/edit/$id_text";
    header("Location: " . ROOT . "logins/login");
  }
    //создаем массив сканирую директорию img
// $dir_img = $_SERVER['DOCUMENT_ROOT'] . 'assest/img';
$dir_img =  'f:/OpenServer/OSPanel/domains/blog-oop/assest/img/';
  // $dir_img =  'd:/open-server/OSPanel/domains/blog-oop/assest/img';

  $img_files = scandir($dir_img);
//создаем пустой массив для картинок
  $images = [];
  $images = $img_files;
    //при добавлении нового категории будет создаваться переменная шаблона для вывода данных о новом авторе , которая далее будет добавлена в массив переменных шаблона v_main
  if(!($mText->correctId('text_name', 'texts', 'id_text', $id_text )) || !$id_text)
  { 
    $err404 = true;  
    $this->title .=' 404';
    $this->content = $this->build('errors', [
    ]);
  }
  else{
      //получение параметров с формы методом пост
    if($this->request->isPost()){
      $text_name_new = trim($_POST['text_name']);
      $text_content_new = trim($_POST['text_content']);
      $description_new = trim($_POST['description']);
  // проверка названия на незанятость вводимого названия 
      if (($mText->correctOrigin( 'id_text ', ' texts ', ' text_name ', $text_name_new))) 
      {
       $msg = ['Название не менять!'];
     }
     else
     {
    //собираем исключения брошенные в методе add/insert BaseModel
       try{ 
  // не работает показ последнего введенного айдишника в функции edit
        $id_new =  $mText->edit(
          [
            'text_name'=>$text_name_new,
            'text_content'=>$text_content_new,
            'description'=> $description_new 
          ], 
          $id_text 
        );     
        header("Location: " . ROOT . "text/$id_text  ");
        exit();
      } catch (IncorrectDataException $e) {
 //обрабатываем исключения брошенные в методе add/insert BaseModel и выводим ошибку в представлении с помощью метода getErrors класса  IncorrectDataException
        $msg = [];
        $msg = ($e->getErrors());
      } 
    }
  }
  $this->content = $this->build('edit-text', [
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

public function deleteAction()
{ 
  $db = DBConnect::getPDO();
  $mTexts = new TextsModel(new DBDriver($db),new Validator());
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
  // Header('Location: logins/sign-in.php');
  }
        //создаем массив сканирую директорию img
// $dir_img = $_SERVER['DOCUMENT_ROOT'] . 'assest/img';
$dir_img =  'f:/OpenServer/OSPanel/domains/blog-oop/assest/img/';
  // $dir_img =  'd:/open-server/OSPanel/domains/blog-oop/assest/img/';
  $img_files = scandir($dir_img);
//создаем пустой массив для картинок
  $images = [];
  $images = $img_files;
  $err404 = false;

  $id = $this->request->get('id');
  $texts = $mTexts->getById($id); 
    // переопределяем title    
  $text_name = $texts['text_name'];
  $text_content = $texts['text_content'];
    //    проверяем корректность вводимого айдишника   
    //при добавлении нового категории будет создаваться переменная шаблона для вывода данных о новом авторе , которая далее будет добавлена в массив переменных шаблона v_main
  if(!($mTexts->correctId('text_name', 'texts', 'id_text', $id )) || !$id)
  { 
    $err404 = true;  
    $this->title .=' 404';
    $this->content = $this->build('errors', [
    ]);
  }
  else{      
    $mTexts->deleteById($id);
      // header("Location: " . ROOT . "user/$id_category");
    $this->new_row = $this->build('text-delete', [
      'text_name' => $text_name,
      'text_content' => $text_content
    ]); 

    $mTexts = new TextsModel(new DBDriver($db),new Validator());
//применяем к объекту метод из его класса
    $texts = $mTexts->getAll(' text_name ');
// var_dump($texts);
    $this->content = $this->build('texts', [
      'texts' => $texts,
      'images' => $images,
      'isAuth' => $isAuth,
      'login' => $login
    ]);
  }
}

}