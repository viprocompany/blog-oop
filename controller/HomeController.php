<?php  
namespace controller;

use models\AllTablesModel;
use core\DBConnect;
use core\Auth;
use core\DBDriver;
// use core\Request;

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
		$mAllTables = new AllTablesModel(new DBDriver(DBConnect::getPDO()));
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
		
		$this->content = $this->build($template, [
			'posts' => $posts,
			'isAuth' => $isAuth,
			'login' => $login
		]);
	}

	public function oneAction()
	{
		//вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
		$isAuth = Auth::isAuth();
//имя пользователя для вывода в приветствии
		$login = Auth::isName();
		$msg = '';
//проверка авторизации
		if(!$isAuth)
		{
//ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : в массив сессии  добавляем элемент указывающий куда перейдет клиент после авторизации в файле login.php, если он заходил после клика на "ДОБАВИТЬ автора"
			$_SESSION['returnUrl'] = ROOT . "home/$id_article";
  // Header('Location: login.php');
		}

		$db = DBConnect::getPDO();
		//создаем объект класса AllTablesModel и в параметре подключаем драйвер(обёртка) DBDriver для запросов к базе данных внутри которой задан параметр-подключение к базе данных $db = DBConnect::getPDO()
		$mAllTables = new AllTablesModel(new DBDriver(DBConnect::getPDO()));

		$err404 = false;

		$id = $this->request->get('id');

		$post = $mAllTables->getById($id); 
		// переопределяем title		
		// var_dump($post);
		$title_post = $post['title'];		
		$this->title .=': ' . $title_post;

if(!($mAllTables->correctId('title', 'article', 'id_article', $id )))
  	{ 
  		$err404 = true;  
  		$this->content = $this->build('errors', [
  		]);
  	}
  	else{
				$this->content = $this->build('post', [
			'posts' => $post,
			'isAuth' => $isAuth,			
			'login' => $login
		]);
			}
	}
}
