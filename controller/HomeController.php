<?php  
namespace controller;

use models\BaseModel;
use models\AllTablesModel;
use models\PostModel;
use models\CategoriesModel;
use models\UsersModel;
use models\Helper;
use core\DBConnect;
use core\Logins;
use core\Auth;
use core\DBDriver;
use core\Request;
use core\Templater;
use core\Validator;
use core\Exception\IncorrectDataException;


class HomeController extends BaseController
{

	public function indexAction()
	{
// переопределяем title
		$this->title .=': Главная страница';
	    //вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
		$isAuth = Logins::isAuth();
//имя пользователя для вывода в приветствии
		$login = Auth::isName();
		$msg = '';
		$title = "";
		$id_user = "";
		$name = "";
		$id_category = "";
		$content = "";
		$img = "";
		$msg = '';
//проверка авторизации
		if(!$isAuth)
		{
//ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : в массив сессии  добавляем элемент указывающий куда перейдет клиент после авторизации в файле login.php, если он заходил после клика на "ДОБАВИТЬ автора"
			$_SESSION['returnUrl'] = ROOT . "home";
  // Header('Location: logins/sign-in.php');
		}
	//создаем объект для подключения к базе данных
		$db = DBConnect::getPDO();
//создаем новый объект класса ArticleModel и через конструктор добавляем к нему передачей через параметр ранее созданный  объект  $db для подключения к базе данных
		$mAllTables = new AllTablesModel(new DBDriver(DBConnect::getPDO()), new Validator());
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
			$_SESSION['returnUrl'] = ROOT . "home/$id";
  // Header('Location: login.php');
		}

		$db = DBConnect::getPDO();
		//создаем объект класса AllTablesModel и в параметре подключаем драйвер(обёртка) DBDriver для запросов к базе данных внутри которой задан параметр-подключение к базе данных $db = DBConnect::getPDO()
		$mAllTables = new AllTablesModel(new DBDriver(DBConnect::getPDO()), new Validator());

		$err404 = false;

		$id = $this->request->get('id');

		$post = $mAllTables->getById($id); 
		// переопределяем title		
		// var_dump($post);
		$title_post = $post['title'];			
		$this->title .=': ' . $title_post;

		//перестало работать
//объект однотабличного класса статьи в запрос об удалении из таблицы
    // $mPost = new PostModel(new DBDriver(DBConnect::getPDO()), new Validator());
		 // if(!($mPost->correctId('title', 'article', 'id_article', $id )) || !$id)
		//вместо верхней проверки через функцию работает только эта 
		if(!$post  || !preg_match("/^[a-zA-Z0-9_-]+$/",$id))
		{ 
			// echo 'NO';
			$err404 = true;  			
			$this->content = $this->build('errors', [
			]);
		}
		else{
			// echo 'YES';
			$this->content = $this->build('post', [
				'posts' => $post,
				'isAuth' => $isAuth,			
				'login' => $login
			]);
		}
	}

	public function addAction()
	{
		// переопределяем title
		$this->title .=': ДОБАВИТЬ ПОСТ';
	    //вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
		$isAuth = Auth::isAuth();
//имя пользователя для вывода в приветствии
		$login = Auth::isName();
		$msg = '';
		$title = "";
		$id_user = "";
		$name = "";
		$id_category = "";
		$content = "";
		$img = "";
//проверка авторизации
		if(!$isAuth){
//ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : в массив сессии  добавляем элемент указывающий куда перейдет клиент после авторизации в файле login.php, если он заходил после клика на "ДОБАВИТЬ автора"
			$_SESSION['returnUrl'] = ROOT . "home/add";
			header("Location: " . ROOT . "logins/login");
		}
//для вызова
	//создаем объект для подключения к базе данных
		$db = DBConnect::getPDO();
//создаем новый объект класса ArticleModel и через конструктор добавляем к нему передачей через параметр ранее созданный  объект  $db для подключения к базе данных
 	$mPost = new PostModel(
				new DBDriver(DBConnect::getPDO()),
				new Validator()
			);
 	
		$mUser = new UsersModel(new DBDriver(DBConnect::getPDO()), new Validator());
	//задаем массив для дальнейшего вывода фамилий авторов в разметке через опшины селекта, после выбора автора из значения опшина подтянется айдишник автора для дальнейшего добавления в статью
		$names= $mUser->getAll(' name');
	 // $names = $query->fetchAll();	
		$mCategory = new CategoriesModel(new DBDriver(DBConnect::getPDO()), new Validator());
//задаем массив для дальнейшего вывода категорий новостей в разметке через опшины селекта, после выбора категории из значения опшина подтянется айдишник категории для дальнейшего добавления в статью
		$categories= $mCategory->getAll(' title_category');

//создаем массив сканирую директорию img
// $dir_img = $_SERVER['DOCUMENT_ROOT'] . 'assest/img';
// $dir_img =  'f:/OpenServer/OSPanel/domains/blog-oop/images';
		$dir_img =  'd:/open-server/OSPanel/domains/blog-oop/images';
		$img_files = scandir($dir_img);
//создаем пустой массив для картинок
		$images = [];
		$images = $img_files;
//получение параметров с формы методом пост
// if(count($_POST) > 0){
// аналогично  спомощью функции isPost, если использован метод ПОСТ , то данные берутся с формы и ичпользуются дальше
		$method = new Request($_GET, $_POST, $_SERVER, $_COOKIE, $_TITLE, $_SESSION);
		// if($method->isPost()){
		if($this->request->isPost()){
	// айдишник получаем из значения value опшина после того как в выпадающем списке был выбран автор 
			$title = trim($_POST['title']);
			$id_user = trim($_POST['user']);	
			$content = trim($_POST['content']);
			$id_category = trim($_POST['category']);
			$img = trim($_POST['image']);
	// //проверяем корректность вводимого названия 
	// 		if($title == '')			{		
	// 			$msg = 'Заполните название!';
	// 		}	
// //проверяем корректность вводимого названия 
// 			elseif(!(Helper::newCorrectTitle($title))){		
// 				$msg = Helper::errors();		
// 			}	

// 	// проверка названия на незанятость вводимого названия 
			 if (!($mPost->correctOrigin('id_article', 'article', 'title', $title))) {
				$msg = ['Название занято!'];
			}
//  //проверяем корректность вводимого айдишника автора
// 			elseif(!($mUser->correctId('name', 'users', 'id_user', $id_user )))			{   
// 				$msg = 'Неверный код автора';
// 			}	
// //проверяем корректность вводимого айдишника категории новости
// 			elseif(!$mCategory->correctId('title_category', 'categories', 'id_category', $id_category ))			{   
// 				$msg = 'Неверный код категории новости';
// 			}

// //проверяем корректность вводимого контента 
// 			elseif(!(Helper::correctContent($content))){
// 				$msg = Helper::errors();
// 			}	
			else{
// цифра для JSCRIPT 
			// echo '1';
//подключаемся к базе данных через  функцию db_query_add_article и предаем тело запроса в параметре, которое будет проверяться на ошибку с помощью этой же функции, после 
//добавление данных в базу функция вернет значение последнего введенного айдишника в переменную new_article_id, которую будем использовать для просмотра новой статьи при переходе на страницу post.php
			//собираем исключения брошенные в методе add/insert BaseModel
				try{
					$new_article_id = $mPost->add([
						'title' => $title,
						'content' => $content,
						'id_user' => $id_user,
						'id_category' => $id_category,
						'img' => $img
					]);
				// header("Location: " . ROOT . "home/$new_article_id");
				// exit();
				//переадресация через функцию
					  $this->redirect(sprintf('/home/%s', $new_article_id));
				} catch (IncorrectDataException $e)	{
					//обрабатываем исключения брошенные в методе add/insert BaseModel и выводим ошибку в представлении с помощью метода getErrors класса  IncorrectDataException
						$msg = [];
						$msg = ($e->getErrors());
				}		
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
				'title' => $title,
						'content' => $content,
			'names' => $names,
			'categories' => $categories,
			'images' => $images,
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

//для вызова
  //создаем объект для подключения к базе данных
		$db = DBConnect::getPDO();
//создаем новый объект класса ArticleModel и через конструктор добавляем к нему передачей через параметр ранее созданный  объект  $db для подключения к базе данных
		
		$mPost = new AllTablesModel(new DBDriver(DBConnect::getPDO()), new Validator());
		$id = $this->request->get('id');
  //задаем массив для дальнейшего вывода фамилий авторов в разметке через опшины селекта, после выбора автора из значения опшина подтянется айдишник автора для дальнейшего добавления в статью
		$post = $mPost->getById($id);  
		$id_article =  $post['id_article'];	
		$title_1 = $post['title'];    
		  // переопределяем title
		$this->title .=': ИЗМЕНИТЬ СТАТЬЮ: ' . $title_1;
		//проверка авторизации
		if(!$isAuth){
//ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : в массив сессии  добавляем элемент указывающий куда перейдет клиент после авторизации в файле login.php, если он заходил после клика на "ДОБАВИТЬ автора"
			$_SESSION['returnUrl'] = ROOT . "home/edit/$id_article";
			header("Location: " . ROOT . "logins/login");
		}
//задаем массив для дальнейшего вывода фамилий авторов в разметке через опшины селекта, после выбора автора из значения опшина подтянется айдишник автора для дальнейшего добавления в статью
	$mUser = new UsersModel(new DBDriver(DBConnect::getPDO()), new Validator());
	$names= $mUser->getAll(' name');	
	 //задаем массив для дальнейшего вывода категорий новостей в разметке через опшины селекта, после выбора категории из значения опшина подтянется айдишник категории для дальнейшего добавления в статью
	$mCategory = new CategoriesModel(new DBDriver(DBConnect::getPDO()), new Validator());
	$categories = $mCategory->getAll('title_category ASC');
    //создаем массив сканирую директорию img
// $dir_img = $_SERVER['DOCUMENT_ROOT'] . 'assest/img';
// $dir_img =  'f:/OpenServer/OSPanel/domains/blog-oop/images';
	$dir_img =  'd:/open-server/OSPanel/domains/blog-oop/images';

	$img_files = scandir($dir_img);
//создаем пустой массив для картинок
	$images = [];
	$images = $img_files;
	    //при добавлении новой сущности будет создаваться переменная шаблона для вывода данных о новой статье , которая далее будет добавлена в массив переменных шаблона v_main
	if(!($mPost->correctId('title', 'article', 'id_article', $id_article )) ||  !$id_article)
	{ 
		$err404 = true;  
		$this->title .=' 404';
			$this->content = $this->build('errors', [
		]);
	}	
	else{
      //получение параметров с формы методом пост
	if($this->request->isPost()){
 // $id_article_new = $id_article;
		$title_new = trim($_POST['title']);
		$id_category_new = trim($_POST['id_category']);
		$content_new = trim($_POST['content']);
		$img_new = trim($_POST['image']);
	// айдишник получаем из значения value опшина после того как в выпадающем списке был выбран автор 
		$id_user_new = trim($_POST['name']);
		$msg = "";
//проверяем корректность вводимого названия 
  // if(!(Helper::newCorrectTitle($text_name)))
  // {    
  //  $msg = Helper::errors();    
  // }  
  // //проверяем корректность вводимого названия 
		// if($title_new == '')
		// {   
		// 	$msg = 'Заполните название!';
		// } 
  // проверка названия на незанятость вводимого названия 
  // if (($mPost->correctOrigin( 'id_article ', ' article ', ' title ', $id_article))) 
  // {
  //   // $msg = Helper::errors();
  //   $msg = ['Название не менять!'];
  // }
// //проверяем корректность вводимого контента 
// 		elseif(!(Helper::newCorrectTitle($title_new)))
// 		{
//     // $msg = Helper::errors();
// 			$msg = "Введите текст названия!";
// 		} 
//  //проверяем корректность вводимого айдишника автора
// 		elseif(!($mUser->correctId('name', 'users', 'id_user', $id_user )))			{   
// 			$msg = 'Неверный код автора';
// 		}	
// //проверяем корректность вводимого айдишника категории новости
// 		elseif(!$mCategory->correctId('title_category', 'categories', 'id_category', $id_category ))			{   
// 			$msg = 'Неверный код категории новости';
// 		}
// //проверяем корректность вводимого контента 
// 		elseif(!(Helper::correctContent($content_new))){
// 			$msg = Helper::errors();
// 		}	
		// else
		// {
			$mPost_new = new PostModel(new DBDriver(DBConnect::getPDO()), new Validator());
//собираем исключения брошенные в методе add/insert BaseModel
			try{ 			
  // не работает показ последнего введенного айдишника в функции edit
				$id_new =  $mPost_new->edit(
					[
						'title'=>$title_new,
						'content'=>$content_new,
						'id_user'=>$id_user_new,
						'id_category'=>$id_category_new,
						'img'=> $img_new 
					], 
					$id_article 
				); 

				header("Location: " . ROOT . "home/$id_article  ");
				exit();
			} catch (IncorrectDataException $e) {
 //обрабатываем исключения брошенные в методе add/insert BaseModel и выводим ошибку в представлении с помощью метода getErrors класса  IncorrectDataException
				$msg = [];
				$msg = ($e->getErrors());
			} 
		// }
	}
	$this->content = $this->build('edit', [
		'post' => $post,
		'names' => $names,
		'categories' => $categories,
		'images' => $images,
		'msg' => $msg,
		'isAuth' => $isAuth,
		'login' => $login
	]);
	}
}
public function deleteAction()
  { 
    $db = DBConnect::getPDO();
    $mAllTables = new AllTablesModel(new DBDriver(DBConnect::getPDO()), new Validator());
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
   
    $id = $this->request->get('id');
    //объект и его  данные для удаляемой статьи (через объект выборки  многотабличного класса) , используются для вывода в  new_row в информации об удалении
    $post_old = $mAllTables->getById($id);     
    $title = $post_old['title'];
    $name = $post_old['name'];
//объект однотабличного класса статьи в запрос об удалении из таблицы
    $mPost = new PostModel(new DBDriver(DBConnect::getPDO()), new Validator());
    //    проверяем корректность вводимого айдишника   удаляемой статьи
      if(!($mPost->correctId('title', 'article', 'id_article', $id )) || !$id)
  { 
    $err404 = true;  
     $this->title .=' 404';
    $this->content = $this->build('errors', [
    ]);
  }
      //при удалении статьи будет создаваться переменная шаблона для вывода данныхоб удаленной статье , которая далее будет добавлена в массив переменных шаблона v_main
    else{ 
      $mPost->deleteById($id);
      // header("Location: " . ROOT . "user/$id_category");
      $this->new_row = $this->build('post-delete', [
        'title' => $title,
        'name' => $name
      ]); 


//применяем к объекту метод из его класса для показ списка всех статей с возможностью перебора вьюшек через свитч
  $posts = $mAllTables->getAll(' date DESC');

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
  		$this->content = $this->build($template, [
			'posts' => $posts,
			'isAuth' => $isAuth,
			'login' => $login
		]);
    }
  }

}
