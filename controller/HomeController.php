<?php  
namespace controller;
use models\AllTablesModel;
use core\DBConnect;
use core\Auth;

class HomeController extends BaseController
{
	public function indexAction()
{
// переопределяем title
	$this->title .=': Главная страница';
	    //вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
$isAuth = Auth::isAuth();
//имя пользователя для вывода в приветствии
$login = Auth::isName();
	$msg = '';

//проверка авторизации
if(!$isAuth)
{
//ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : в массив сессии  добавляем элемент указывающий куда перейдет клиент после авторизации в файле login.php, если он заходил после клика на "ДОБАВИТЬ автора"
$_SESSION['returnUrl'] = ROOT . "home";
  // Header('Location: login.php');
}
	//создаем объект для подключения к базе данных
	$db = DBConnect::getPDO();
//создаем новый объект класса ArticleModel и через конструктор добавляем к нему передачей через параметр ранее созданный  объект  $db для подключения к базе данных
	$mAllTables = new AllTablesModel($db);
//применяем к объекту метод из его класса
	$posts = $mAllTables->getAll(' date DESC');
	//выбираем вьюшку для вывода: либо столбиком либо в одну строку. создаем $template  для дальнейшей подстановки при выводе нужного представления через include
switch ($_GET['view'] ?? null) {
	case 'base':
		$template = 'index';
		break;
		case 'inline':
		$template = 'index-inline';
		break;	
	default:
		$template = 'index-inline';
		break;
}
//для вызова
		
	 $this->content = $this->build(__DIR__ . '/../views/'.$template. '.html.php', [
	 	'posts' => $posts,
	  	'isAuth' => $isAuth,
      'login' => $login
	 ]);


}


}
