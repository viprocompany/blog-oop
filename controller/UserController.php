<?php  
namespace controller;
use models\BaseModel;
use models\UsersModel;
use core\DBConnect;
use core\Auth;
use core\Request;
use core\DBDriver;
use models\Helper;
use core\Validator;
use core\Exception\IncorrectDataException;

class UserController extends BaseController
{
	public function indexAction()
  {
		// переопределяем title
   $this->title .=': АВТОРЫ';
	    //вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
   $isAuth = Auth::isAuth();
//имя пользователя для вывода в приветствии
   $login = Auth::isName();
   $msg = '';

//проверка авторизации
   if(!$isAuth)
   {
//ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : в массив сессии  добавляем элемент указывающий куда перейдет клиент после авторизации в файле login.php, если он заходил после клика на "ДОБАВИТЬ автора"
    $_SESSION['returnUrl'] = ROOT . "user";
    header("Location: " . ROOT . "login");
  }
//для вызова
	//создаем объект для подключения к базе данных
  $db = DBConnect::getPDO();
//создаем новый объект класса ArticleModel и через конструктор добавляем к нему передачей через параметр ранее созданный  объект  $db для подключения к базе данных
  $mUsers = new UsersModel(new DBDriver(DBConnect::getPDO()),new Validator());
//применяем к объекту метод из его класса
  $users = $mUsers->getAll(' name ');
// var_dump($users);
  $this->content = $this->build('users', [
    'users' => $users,
    'isAuth' => $isAuth,
    'login' => $login
  ]);
}


public function oneAction()
{ 
 $db = DBConnect::getPDO();
 $mUser = new UsersModel(new DBDriver(DBConnect::getPDO()),new Validator());
 //вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
 $isAuth = Auth::isAuth();
//имя пользователя для вывода в приветствии
 $login = Auth::isName();
 $msg = '';
//проверка авторизации
 if(!$isAuth)
 {
  //ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : в массив сессии  добавляем элемент указывающий куда перейдет клиент после авторизации в файле login.php, если он заходил после клика на "ДОБАВИТЬ автора"
  $_SESSION['returnUrl'] = ROOT . "user/$id_user";
  // Header('Location: login.php');
}

$id = $this->request->get('id');
$users = $mUser->getById($id); 
    // переопределяем title
$name = $users['name'];
        //    проверяем корректность вводимого айдишника
$this->title .=': ' . $name;
    //при добавлении нового категории будет создаваться переменная шаблона для вывода данных о новом авторе , которая далее будет добавлена в массив переменных шаблона v_main
if(!($users))
{ 
  $err404 = true;  
  $this->content = $this->build('errors', [
  ]);
}
else{
  $this->new_row = $this->build('users-new', [
   'name' => $name,
   'id_user' => $id
 ]);
  $users = $mUser->getAll('id_user DESC');

  $this->content = $this->build('users', [
   'name' => $name,
   'users' => $users,
   'isAuth' => $isAuth,
   'login' => $login
 ]);
}
}

public function addAction()
{
    // переопределяем title
  $this->title .=': НОВЫЙ АВТОР';
//вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
  $isAuth = Auth::isAuth();
//имя пользователя для вывода в приветствии
  $login = Auth::isName();
  $msg = '';
//проверка авторизации
  if(!$isAuth)
  {
//ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : в массив сессии  добавляем элемент указывающий куда перейдет клиент после авторизации в файле login.php, если он заходил после клика на "ДОБАВИТЬ автора"
    $_SESSION['returnUrl'] = ROOT . "user/add";
    header("Location: " . ROOT . "login");
  }
  //если данные в инпуты не вводились, задаем пустые значения инпутов формы для того чтобы через РНР вставки в разметке кода не выскакивали(на странице в полях инпутов для заполнения) нотации об отсутствии данных в переменных $title и $content
    // $title = "";
    $name = "";
    $msg = '';
//для вызова
//создаем объект для подключения к базе данных
  $db = DBConnect::getPDO();
//создаем новый объект класса ArticleModel и через конструктор добавляем к нему передачей через параметр ранее созданный  объект  $db для подключения к базе данных
  $mUser = new UsersModel(new DBDriver(DBConnect::getPDO()),new Validator());
//получение параметров с формы методом пост
  if($this->request->isPost()){
    $name = trim($_POST['name']);
 //проверка названия на незанятость вводимого названия
    if(!($mUser->correctOrigin('id_user', 'users', 'name', $name))) {   
      $msg = ['Название занято'];
    }   
    else    {
  //собираем исключения брошенные в методе add/insert BaseModel
      try{
//подключаемся к базе данных через  функцию db_query_add_article и предаем тело запроса в параметре, которое будет проверяться на ошибку с помощью этой же функции, после 
//добавление данных в базу функция вернет значение последнего введенного айдишника в переменную new_article_id, которую будем использовать для просмотра новой статьи при переходе на страницу post.php
        $new_user_id = $mUser->add(['name'=>$name]);  
        header("Location: " . ROOT . "user/$new_user_id");
        exit();
      } catch (IncorrectDataException $e) {
          //обрабатываем исключения брошенные в методе add/insert BaseModel и выводим ошибку в представлении с помощью метода getErrors класса  IncorrectDataException
        $msg = [];
        $msg = ($e->getErrors());
      }   
    }
  }
  $this->content = $this->build('add-user', [
    'name' => $name,
    'msg' => $msg,
    'isAuth' => $isAuth,
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
  if(!$isAuth){
//ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : в массив сессии  добавляем элемент указывающий куда перейдет клиент после авторизации в файле login.php, если он заходил после клика на "ДОБАВИТЬ автора"
    $_SESSION['returnUrl'] = ROOT . "user/edit/$id_user";
    header("Location: " . ROOT . "login");
  }
//для вызова
  //создаем объект для подключения к базе данных
  $db = DBConnect::getPDO();
//создаем новый объект класса ArticleModel и через конструктор добавляем к нему передачей через параметр ранее созданный  объект  $db для подключения к базе данных
  $mUser = new UsersModel(new DBDriver(DBConnect::getPDO()),new Validator());
  $id = $this->request->get('id');
  //задаем массив для дальнейшего вывода фамилий авторов в разметке через опшины селекта, после выбора автора из значения опшина подтянется айдишник автора для дальнейшего добавления в статью
  $users = $mUser->getById($id);  
  // переопределяем title
  $name = $users['name'];
  $id_user =  $users['id_user'];

//    проверяем корректность вводимого айдишника
  $this->title .=': ИЗМЕНИТЬ  АВТОРА: ' . $name;
  
  if(!$users || !$id_user)  { 
    echo  'no'. $id_user ;
    $err404 = true;  
    $this->content = $this->build ('errors', [
    ]);
  }
  else
  {
          //получение параметров с формы методом пост
  if($this->request->isPost()){
    $name_new = trim($_POST['name']);    
       
   //проверка названия на незанятость вводимого названия
    if(!($mUser->correctOrigin('id_user', 'users', 'name', $name_new))){   
     $msg = ['Название занято'];     
    }   
    else {
      try{
  //подключаемся к базе данных через  функцию db_query_add_article и предаем тело запроса в параметре, которое будет проверяться на ошибку с помощью этой же функции, после 
  //добавление данных в базу функция вернет значение последнего введенного айдишника в переменную new_article_id, которую будем использовать для просмотра новой статьи при переходе на страницу post.php
       $mUser->edit( [ 'name' => $name_new], $id); 
       header("Location: " . ROOT . "user/$id");
       exit();
     } catch (IncorrectDataException $e) {
          //обрабатываем исключения брошенные в методе add/insert BaseModel и выводим ошибку в представлении с помощью метода getErrors класса  IncorrectDataException
      $msg = [];
      $msg = ($e->getErrors());
    } 
  }
}
   $this->content = $this->build('edit-user', [
    'name' => $name,
    'users' => $users,
    'msg' => $msg,
    'isAuth' => $isAuth,
    'login' => $login,
    'id_user' => $id
  ]);
  }

 
}
public function deleteAction()
  { 
    $db = DBConnect::getPDO();
 $mUser = new UsersModel(new DBDriver(DBConnect::getPDO()),new Validator());
//вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 

    $isAuth = Auth::isAuth();
//имя пользователя для вывода в приветствии
    $login = Auth::isName();
    $msg = '';
//проверка авторизации
    if(!$isAuth)
    {
//ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : в массив сессии  добавляем элемент указывающий куда перейдет клиент после авторизации в файле login.php, если он заходил после клика на "ДОБАВИТЬ автора"
    $_SESSION['returnUrl'] = ROOT . "user";
  // Header('Location: login.php');
    }
    $err404 = false;

    $id = $this->request->get('id');
    $users = $mUser->getById($id); 
    // переопределяем title    
    $name = $users['name'];
    $id_user = $users['id_user'];
    //    проверяем корректность вводимого айдишника   
    //при добавлении нового категории будет создаваться переменная шаблона для вывода данных о новом авторе , которая далее будет добавлена в массив переменных шаблона v_main
    if(!$mUser->correctId('name', 'users', 'id_user', $id_user ))
    { 
      $err404 = true;  
      $this->content = $this->build('errors', [
    ]);
    }
    else{      

      $mUser->deleteById($id);
      // header("Location: " . ROOT . "user/$id_category");
      $this->new_row = $this->build('users-delete', [
        'name' => $name,
        'id_user' => $id_user
      ]); 

  $users = $mUser->getAll(' name ');
// var_dump($users);
  $this->content = $this->build('users', [
    'users' => $users,
    'isAuth' => $isAuth,
    'login' => $login
  ]);
    }
  }


}
