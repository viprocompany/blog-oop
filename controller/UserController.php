<?php  
namespace controller;
use models\UsersModel;
use core\DBConnect;
use core\Auth;

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
	$mUsers = new UsersModel($db);
//применяем к объекту метод из его класса
	$users = $mUsers->getAll(' name ');
// var_dump($users);
	  $this->content = $this->build(__DIR__ . '/../views/users.html.php', [
	  	'users' => $users,
	  	'isAuth' => $isAuth,
      'login' => $login
	  ]);


}

}