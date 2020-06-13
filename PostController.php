<?php  
namespace controller;
use models\AllTablesModel;
use core\DBConnect;
use core\Auth;

class PostController extends BaseController
{
	public function indexAction()
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
			$_SESSION['returnUrl'] = ROOT . "post/$id_article";
  // Header('Location: login.php');
		}
global  $id_article;
// Разрешаем указать параметр после заданного контролера в урле .То есть на первом месте всегда располагается название контролера, а после слеша могут добавиться еще параметр как в данном случае  для чего в контроллере , где может добавляться айдишник нужно прописать этот дополнительный параметр как $id = $params[1] ?? null; 
$id_article = $params[1] ?? null; 
// echo $id ;
$err404 = false;
	//создаем объект для подключения к базе данных
		$db = DBConnect::getPDO();
//создаем новый объект класса ArticleModel и через конструктор добавляем к нему передачей через параметр ранее созданный  объект  $db для подключения к базе данных
		$mAllTables = new AllTablesModel($db);
//применяем к объекту метод из его класса
		$posts = $mAllTables->getById($id);
		// var_dump($posts);
	// переопределяем title
		$this->title .=': ' . $posts['title'];


//для вызова
		$this->content = $this->build(__DIR__ . '/../views/post.html.php', 
			[
			'posts' => $posts,
			'isAuth' => $isAuth,
			'id_article'=> $id_article
		]);
	}

	public function oneAction()
	{


	}

}