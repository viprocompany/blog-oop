<?php  
namespace controller;
use models\CategoriesModel;
use core\DBConnect;
use core\Auth;

class CategoryController extends BaseController
{
	public function indexAction()
{
		// переопределяем title
	$this->title .=': КАТЕГОРИИ НОВОСТЕЙ';
 //вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
$isAuth = Auth::isAuth();
//имя пользователя для вывода в приветствии
$login = Auth::isName();
	$msg = '';
	//проверка авторизации
if(!$isAuth)
{
//ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : в массив сессии  добавляем элемент указывающий куда перейдет клиент после авторизации в файле login.php, если он заходил после клика на "ДОБАВИТЬ автора"
$_SESSION['returnUrl'] = ROOT . "category";
  header("Location: " . ROOT . "login");
}
	//создаем объект для подключения к базе данных
	$db = DBConnect::getPDO();
//создаем новый объект класса ArticleModel и через конструктор добавляем к нему передачей через параметр ранее созданный  объект  $db для подключения к базе данных
	$mCat = new CategoriesModel($db);
//применяем к объекту метод из его класса
	$categories = $mCat->getAll(' title_category ');
	
	  $this->content = $this->build(__DIR__ . '/../views/categories.html.php', [
	  	'categories' => $categories,
	  	'isAuth' => $isAuth,
      'login' => $login
	  ]);

}
}