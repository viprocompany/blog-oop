<?php  
namespace controller;
use models\BaseModel;
use models\CategoriesModel;
use core\DBConnect;
use core\Auth;
use core\DBDriver;
use models\Helper;

class AddCategoryController extends BaseController
{
	public function indexAction()
{
		// переопределяем title
	$this->title .=': НОВАЯ КАТЕГОРИЯ';
	    //вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
$isAuth = Auth::isAuth();
//имя пользователя для вывода в приветствии
$login = Auth::isName();
	$msg = '';

//проверка авторизации
if(!$isAuth)
{
//ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : в массив сессии  добавляем элемент указывающий куда перейдет клиент после авторизации в файле login.php, если он заходил после клика на "ДОБАВИТЬ автора"
$_SESSION['returnUrl'] = ROOT . "addCategory";
 header("Location: " . ROOT . "login");
}
//для вызова
	//создаем объект для подключения к базе данных
	$db = DBConnect::getPDO();

	$mCategory = new CategoriesModel(new DBDriver(DBConnect::getPDO()));
//получение параметров с формы методом пост
if(count($_POST) > 0){
 $title_category = trim($_POST['title_category']);
//проверяем корректность вводимого названия 
	if(!(Helper::newCorrectTitle($title_category)))
	{		
		$msg = Helper::errors();		
	}	
	// проверка названия на незанятость вводимого названия 
	elseif (!($mCategory->correctOrigin( 'id_category', 'categories', 'title_category', $title_category))) 
	{
		$msg = Helper::errors();
		// $msg = 'Название занято!';
	}

	else
	{
//подключаемся к базе данных через  функцию db_query_add_article и предаем тело запроса в параметре, которое будет проверяться на ошибку с помощью этой же функции, после 
//добавление данных в базу функция вернет значение последнего введенного айдишника в переменную new_article_id, которую будем использовать для просмотра новой статьи при переходе на страницу post.php
		$new_id_category = $mCategory->addCategory($title_category);	

			header("Location: " . ROOT . "category/$new_id_category");
		exit();
	}
}
else{
//если данные в инпуты не вводились, задаем пустые значения инпутов формы для того чтобы через РНР вставки в разметке кода не выскакивали(на странице в полях инпутов для заполнения) нотации об отсутствии данных в переменных $title и $content
	$title = "";
	$id_category = "";
	$msg = '';
} 
	  $this->content = $this->build('add-category', [	  	
	  	'title_category' => $title_category,	  	
	  	'msg' => $msg,
	  	'isAuth' => $isAuth,
      'login' => $login
	  ]);


}



}