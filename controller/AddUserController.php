<?php  
namespace controller;
use models\BaseModel;
use models\UsersModel;
use core\DBConnect;
use core\Auth;
use models\Helper;

class AddUserController extends BaseController
{
	public function indexAction()
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
$_SESSION['returnUrl'] = ROOT . "addUser";
 header("Location: " . ROOT . "login");
}
//для вызова
	//создаем объект для подключения к базе данных
	$db = DBConnect::getPDO();
//создаем новый объект класса ArticleModel и через конструктор добавляем к нему передачей через параметр ранее созданный  объект  $db для подключения к базе данных
	$mUser = new UsersModel($db);


//получение параметров с формы методом пост
if(count($_POST) > 0){
$name = trim($_POST['name']);
	//проверяем  название на пустоту
	if($name == '')
	{		
			$msg = 'Заполните имя!';
	}	
//проверяем корректность вводимого названия 
	elseif(!(Helper::correctName($name)))
	{		
		$msg = Helper::errors();		
	}	

 //проверка названия на незанятость вводимого названия
	elseif(!($mUser->correctOrigin('id_user', 'users', 'name', $name)))
	{   
		$msg = 'Название занято';
	}		
	else
	{
//подключаемся к базе данных через  функцию db_query_add_article и предаем тело запроса в параметре, которое будет проверяться на ошибку с помощью этой же функции, после 
//добавление данных в базу функция вернет значение последнего введенного айдишника в переменную new_article_id, которую будем использовать для просмотра новой статьи при переходе на страницу post.php
		$new_user_id = $mUser->addUser($name);	

			header("Location: " . ROOT . "users/$new_user_id");
		exit();
	}
}
else{
//если данные в инпуты не вводились, задаем пустые значения инпутов формы для того чтобы через РНР вставки в разметке кода не выскакивали(на странице в полях инпутов для заполнения) нотации об отсутствии данных в переменных $title и $content
	$title = "";
	$name = "";
	$msg = '';
} 
	  $this->content = $this->build(__DIR__ . '/../views/add-user.html.php', [
	  	'names' => $names,
	  	'msg' => $msg,
	  	'isAuth' => $isAuth,
      'login' => $login
	  ]);


}

}