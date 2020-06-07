<?php  
namespace controller;
use models\AllTablesModel;
use models\PostModel;
use models\BaseModel;
use models\CategoriesModel;
use models\UsersModel;
use core\DBConnect;
use core\Auth;
use core\DBDriver;
use core\Request;
use models\Helper;

class AddController extends BaseController
{

	public function indexAction()
	{
		// переопределяем title
		$this->title .=': НОВАЯ СТАТЬЯ';
	    //вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
		$isAuth = Auth::isAuth();
//имя пользователя для вывода в приветствии
		$login = Auth::isName();
		$msg = '';

//проверка авторизации
		if(!$isAuth){
//ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : в массив сессии  добавляем элемент указывающий куда перейдет клиент после авторизации в файле login.php, если он заходил после клика на "ДОБАВИТЬ автора"
			$_SESSION['returnUrl'] = ROOT . "add";
			header("Location: " . ROOT . "login");
		}
//для вызова
	//создаем объект для подключения к базе данных
		$db = DBConnect::getPDO();
//создаем новый объект класса ArticleModel и через конструктор добавляем к нему передачей через параметр ранее созданный  объект  $db для подключения к базе данных
		$mUser = new UsersModel(new DBDriver(DBConnect::getPDO()));
	//задаем массив для дальнейшего вывода фамилий авторов в разметке через опшины селекта, после выбора автора из значения опшина подтянется айдишник автора для дальнейшего добавления в статью
		$names= $mUser->getAll(' name');
	 // $names = $query->fetchAll();	
		$mCategory = new CategoriesModel(new DBDriver(DBConnect::getPDO()));
//задаем массив для дальнейшего вывода категорий новостей в разметке через опшины селекта, после выбора категории из значения опшина подтянется айдишник категории для дальнейшего добавления в статью
		$categories= $mCategory->getAll(' title_category');

		$mPost = new PostModel(new DBDriver(DBConnect::getPDO()));

//создаем массив сканирую директорию img
// $dir_img = $_SERVER['DOCUMENT_ROOT'] . 'assest/img';
// $dir_img =  'f:/OpenServer/OSPanel/domains/blog/images';
		$dir_img =  'd:/open-server/OSPanel/domains/blog-oop/images';

		$img_files = scandir($dir_img);
//создаем пустой массив для картинок
		$images = [];
		$images = $img_files;

//получение параметров с формы методом пост
// if(count($_POST) > 0){
// аналогично  спомощью функции isPost, если использован метод ПОСТ , то данные берутся с формы и ичпользуются дальше
		$method = new Request($_GET, $_POST, $_SERVER, $_COOKIE, $_TITLE, $_SESSION);

		if($method->isPost()){
			$title = trim($_POST['title']);
			$content = trim($_POST['content']);
			$id_category = trim($_POST['id_category']);
			$img = trim($_POST['image']);
	// айдишник получаем из значения value опшина после того как в выпадающем списке был выбран автор 
			$id_user = trim($_POST['name']);	
//проверяем корректность вводимого названия 
			if(!(Helper::newCorrectTitle($title)))			{		
				$msg = Helper::errors();		
			}	
	//проверяем корректность вводимого названия 
			elseif($title == '')			{		
				$msg = 'Заполните название!';
			}	
	// проверка названия на незанятость вводимого названия 
			elseif (!($mPost->correctOrigin('id_article', 'article', 'title', $title))) 			{
				$msg = Helper::errors();
		// $msg = 'Название занято!';
			}
 //проверяем корректность вводимого айдишника автора
			elseif(!($mUser->correctId('name', 'users', 'id_user', $id_user )))			{   
				$msg = 'Неверный код автора';
			}	
//проверяем корректность вводимого айдишника категории новости
			elseif(!$mCategory->correctId('title_category', 'categories', 'id_category', $id_category ))			{   
				$msg = 'Неверный код категории новости';
			}
//проверяем корректность вводимого контента 
			elseif(!(Helper::correctContent($content))){
				$msg = Helper::errors();
			}	
			else{
//подключаемся к базе данных через  функцию db_query_add_article и предаем тело запроса в параметре, которое будет проверяться на ошибку с помощью этой же функции, после 
//добавление данных в базу функция вернет значение последнего введенного айдишника в переменную new_article_id, которую будем использовать для просмотра новой статьи при переходе на страницу post.php
				$new_article_id = $mPost->addPost($title,$content, $id_user, $id_category, $img);	

				header("Location: " . ROOT . "home/$new_article_id");
				exit();
			}
		}
		else{
//если данные в инпуты не вводились, задаем пустые значения инпутов формы для того чтобы через РНР вставки в разметке кода не выскакивали(на странице в полях инпутов для заполнения) нотации об отсутствии данных в переменных $title и $content
			$title = "";
			$id_user = "";
			$name = "";
			$id_category = "";
			$content = "";
			$img = "";
			$msg = '';
		} 
		$this->content = $this->build('add', [
			'names' => $names,
			'categories' => $categories,
			'images' => $images,
			'msg' => $msg,
			'isAuth' => $isAuth,
			'login' => $login
		]);
	}

	public function oneAction()
	{
		$db = DBConnect::getPDO();
		$mAllTables = new AllTablesModel(new DBDriver(DBConnect::getPDO()));
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
		$err404 = false;

		$id = $this->request->get('id');
		$posts = $mAllTables->getById($id); 
		// переопределяем title
		foreach ($posts as  $post) {
			$title_post = $post['title'];
		}
		$this->title .=': ' . $title_post;

		$this->content = $this->build('post', [
			'posts' => $posts,
			'isAuth' => $isAuth,
			// 'title' => $title,
			'login' => $login
		]);
	}

}