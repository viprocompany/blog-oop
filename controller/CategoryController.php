<?php  
namespace controller;
use models\BaseModel;
use models\CategoriesModel;
use core\DBConnect;
use core\Auth;
use core\Request;
use core\DBDriver;
use models\Helper;
use core\Validator;

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
	$mCat = new CategoriesModel(new DBDriver(DBConnect::getPDO()),new Validator());
//применяем к объекту метод из его класса
	$categories = $mCat->getAll(' title_category ');
	
	  $this->content = $this->build('categories', [
	  	'categories' => $categories,
	  	'isAuth' => $isAuth,
      'login' => $login
	  ]);
     
}

  public function oneAction()
  { 
    $db = DBConnect::getPDO();
    $mCategory = new CategoriesModel(new DBDriver(DBConnect::getPDO()),new Validator());
//вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
    $isAuth = Auth::isAuth();
//имя пользователя для вывода в приветствии
    $login = Auth::isName();
    $msg = '';
//проверка авторизации
    if(!$isAuth)
    {
//ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : в массив сессии  добавляем элемент указывающий куда перейдет клиент после авторизации в файле login.php, если он заходил после клика на "ДОБАВИТЬ автора"
      $_SESSION['returnUrl'] = ROOT . "category/$id_category";
  // Header('Location: login.php');
    }
    $err404 = false;

    $id = $this->request->get('id');
    $cats = $mCategory->getById($id); 
    // переопределяем title    
      $title_category = $cats['title_category'];
        //    проверяем корректность вводимого айдишника
   
    $this->title .=': ' . $title_category;
    //при добавлении нового категории будет создаваться переменная шаблона для вывода данных о новом авторе , которая далее будет добавлена в массив переменных шаблона v_main
    if(!$mCategory->correctId('title_category', 'categories', 'id_category', $id ))
    { 
      $err404 = true;  
      $this->content = $this->build('errors', [
    ]);
    }
    else{
          $this->new_row = $this->build('categories-new', [
      'title_category' => $title_category,
      'id_category' => $id
    ]);

    $categories = $mCategory->getAll(' id_category DESC ');
    $this->content = $this->build('categories', [
      'categories' => $categories,
      'isAuth' => $isAuth,
      'login' => $login
    ]);
    }
  }

  public function addAction()
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
      $_SESSION['returnUrl'] = ROOT . "category/add";
      header("Location: " . ROOT . "login");
    }
    //если данные в инпуты не вводились, задаем пустые значения инпутов формы для того чтобы через РНР вставки в разметке кода не выскакивали(на странице в полях инпутов для заполнения) нотации об отсутствии данных в переменных $title и $content
    $title_category = "";
    $msg = '';
  //для вызова
  //создаем объект для подключения к базе данных
    $db = DBConnect::getPDO();
    //создаем новый объект класса ArticleModel и через конструктор добавляем к нему передачей через параметр ранее созданный  объект  $db для подключения к базе данных
    $mCat = new CategoriesModel(new DBDriver(DBConnect::getPDO()),new Validator());
      //получение параметров с формы методом пост
    if($this->request->isPost()){
      $err404 = false;
      $title_category = trim($_POST['title_category']);
    //проверяем  название на пустоту
      if($title_category == '')    {  
        $err404 = true; 
        $msg = 'Заполните имя!';
      } 
       //проверяем корректность вводимого названия 
      elseif(!(Helper::correctName($title_category)))    { 
        $err404 = true;  
        $msg = Helper::errors();   
      } 
      //проверка названия на незанятость вводимого названия
      elseif(!($mCat->correctOrigin('id_category', 'categories', 'title_category', $title_category))){   
        $err404 = true;
        $msg = 'Название занято';        
      }    
      else
      {
        //подключаемся к базе данных через  функцию db_query_add_article и предаем тело запроса в параметре, которое будет проверяться на ошибку с помощью этой же функции, после 
       //добавление данных в базу функция вернет значение последнего введенного айдишника в переменную new_article_id, которую будем использовать для просмотра новой статьи при переходе на страницу post.php
        $new_id_category = $mCat->add(['title_category'=>$title_category]);  
        header("Location: " . ROOT . "category/$new_id_category");
        exit();
      }
    }
    $this->content = $this->build('add-category', [
      'title_category' => $title_category,
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
    $mCat = new CategoriesModel(new DBDriver(DBConnect::getPDO()),new Validator());
    $id = $this->request->get('id');
    //задаем массив для дальнейшего вывода фамилий авторов в разметке через опшины селекта, после выбора автора из значения опшина подтянется айдишник автора для дальнейшего добавления в статью
    $cat = $mCat->getById($id); 
    // переопределяем title
    $title_category = $cat['title_category'];
    $id_category =  $cat['id_category'];
  //    проверяем корректность вводимого айдишника
    $this->title .=': ИЗМЕНИТЬ КАТЕГОРИЮ: ' . $title_category;
  //проверка авторизации
    if(!$isAuth){
      //ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : в массив сессии  добавляем элемент указывающий куда перейдет клиент после авторизации в файле login.php, если он заходил после клика на "ДОБАВИТЬ автора"
      $_SESSION['returnUrl'] = ROOT . "category/edit/$id_category";
      header("Location: " . ROOT . "login");
    }

    if(!($mCat->correctId('title_category', 'categories', 'id_category', $id )) || !$id_category)  { 
      $err404 = true;  
      $this->content = $this->build ('errors', [
      ]);
    }
    else{
        //получение параметров с формы методом пост
      if($this->request->isPost()){
      // if(count($_POST) > 0){
        $err404 = false;
        $title_category_new = trim($_POST['title_category']);
        // echo   $name_new;
          //проверяем  название на пустоту
        if($title_category_new == '')    {  
          $err404 = true; 
          $msg = 'Заполните имя!';

        } 
         //проверяем корректность вводимого названия 
        elseif(!(Helper::correctName($title_category_new))) { 
          $err404 = true;  
          $msg = Helper::errors();         
        } 
           //проверка названия на незанятость вводимого названия
        elseif(!($mCat->correctOrigin('id_category', 'categories', 'title_category', $title_category_new))){   
          $err404 = true;
          $msg = 'Название занято';
          
        }   
        else {
       //подключаемся к базе данных через  функцию db_query_add_article и предаем тело запроса в параметре, которое будет проверяться на ошибку с помощью этой же функции, после 
        //добавление данных в базу функция вернет значение последнего введенного айдишника в переменную new_article_id, которую будем использовать для просмотра новой статьи при переходе на страницу post.php
         $mCat->edit(  'title_category' , $title_category_new, $id); 
         header("Location: " . ROOT . "category/$id");
         exit();
       }
     }
     $this->content = $this->build('edit-category', [
      'title_category' => $title_category,
          // 'users' => $users,
      'msg' => $msg,
      'isAuth' => $isAuth,
      'login' => $login,
      'id_category' => $id
    ]);
   }

  }
  public function deleteAction()
  { 
    $db = DBConnect::getPDO();
    $mCategory = new CategoriesModel(new DBDriver(DBConnect::getPDO()),new Validator());
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
  // Header('Location: login.php');
    }
    $err404 = false;

    $id = $this->request->get('id');
    $cats = $mCategory->getById($id); 
    // переопределяем title    
    $title_category = $cats['title_category'];
    $id_category = $cats['id_category'];
    //    проверяем корректность вводимого айдишника   
    //при добавлении нового категории будет создаваться переменная шаблона для вывода данных о новом авторе , которая далее будет добавлена в массив переменных шаблона v_main
    if(!$mCategory->correctId('title_category', 'categories', 'id_category', $id_category ))
    { 
      $err404 = true;  
      $this->content = $this->build('errors', [
    ]);
    }
    else{      

      $mCategory->deleteById($id);
      // header("Location: " . ROOT . "category/$id_category");
      $this->new_row = $this->build('categories-delete', [
        'title_category' => $title_category,
        'id_category' => $id_category
      ]); 

    $categories = $mCategory->getAll(' id_category DESC ');
    $this->content = $this->build('categories', [
      'categories' => $categories,
      'isAuth' => $isAuth,
      'login' => $login
    ]);
    }
  }
}