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

//получаем ГЕТ параметр из адресной строки при переходе из индексного файла
// $id_category = $_GET['id_category'] ?? null;
  // Разрешаем указать параметр после заданного контролера в урле .То есть на первом месте всегда располагается название контролера, а после слеша могут добавиться еще параметр как в данном случае  для чего в контроллере , где может добавляться айдишник нужно прописать этот дополнительный параметр как $id = $params[1] ?? null; 
$id_category = $params[1] ?? null; 
// echo $id ;
$err404 = false;
if(isset($id_category ) && $mCat->correctId('title_category', 'categories', 'id_category', $id_category ))
{//создаем соеденение с базой, делаем запрос на выбор статьи по пререданному с индексной строки айдишнику, попутно в этой же функции проверяем коррктность тела запроса  
$query = $mCat->getById($id_category);    
//задаем переменную для названия  
  $category = $query->fetch();
  $title_category = $category['title_category'];
      //проверяем корректность вводимого айдишника
    // if(!correct_id('title_category', 'categories', 'id_category', $id_category ))
    // {   
    //   $msg = errors();
    // }
// функция correct_name для проверки корректоности имени автора проверяем корректность вводимого имени 
    if(!$mCat->correctName($title_category))
    {   
      $msg = errors();
    } 
// include('v/v_categories_new.php');
//при добавлении нового категории будет создаваться переменная шаблона для вывода данных о новом авторе , которая далее будет добавлена в массив переменных шаблона v_main
    
        $inner_categories_new = $this->build(__DIR__ . '/../views/categories-new.html.php',  [
        'id_category' => $id_category,
        'title_category' => $title_category
      ]);     
  
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
$new_row = $inner_categories_new;
}
}