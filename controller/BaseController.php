<?php  
namespace controller;
use core\Auth;
 class BaseController
 {
 	protected $title;
 	protected $content;

 	 	public function __construct()
 	 	{
 	 		$this->title = 'PHP 2';
 	 		$this->content = '';
 	 	}

protected function  build($template, $params =[])
  {
    ob_start();

    //после приема переменной в буфер вытаскиваем данные из массива
    extract($params);
    //указываем путь к файлу разметки
    include_once $template;
    //порлучаем вытянутые данные и очищаем буфер
    return ob_get_clean();
  }

  public function render()
  {
    //вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
$isAuth = Auth::isAuth();
//имя пользователя для вывода в приветствии
$login = Auth::isName();
    // <!-- проверка авторизации на сессию либо куки
// подтверждаем авторизацию с помощью сессии -->
// include('v/v_auth.php');
//передаем переменные в виде шаблонов из кода разметки и прередаем в выбранные вьюшки значения  isAuth,login,msg. v_auth  для вывода представления авторизации
    $inner_auth =  $this->build(
      __DIR__ . '/../views/auth.html.php',
      [
      'isAuth' => $isAuth,
      'login' => $login
        // ,        'msg' => $msg
    ]); 
    echo $this->build(
      __DIR__ . '/../views/main.html.php',
      [
        'title' => $this->title,
        'content' => $this->content,
        'auth'=> $inner_auth,
        'isAuth' => $isAuth,
        'login' => $login

      ]
    );
  }

// //вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
// $isAuth = isAuth();
// if(!$isAuth)
// {
// //ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : в массив сессии  добавляем элемент указывающий куда перейдет клиент после авторизации в файле login.php, если он заходил после клика на "ДОБАВИТЬ автора"
// 	$_SESSION['returnUrl'] = ROOT;
// 		// $_SESSION['returnUrl'] = "/blog/index.php";
// 	// Header('Location: login.php');
// }
// //имя пользователя для вывода в приветствии
// $login = isName();
// //подключаемся к базе данных и предаем составляющие тело запроса в параметре, которое будет проверяться на ошибку с помощью этой же функции
// $query = getAll(' date DESK');
// //создаем массив из cтатей нашего блога
// $posts = $query->fetchAll();

// //выбираем вьюшку для вывода: либо столбиком либо в одну строку. создаем $template  для дальнейшей подстановки при выводе нужного представления через include
// switch ($_GET['view'] ?? null) {
// 	case 'base':
// 		$template = 'v_index';
// 		break;
// 		case 'inline':
// 		$template = 'v_index-inline';
// 		break;	
// 	default:
// 		$template = 'v_index-inline';
// 		break;
// }
// //include_once('v/v_post.php');
// 			$inner = template( $template, [
// 				'my_articles' => $my_articles,
// 				'isAuth' => $isAuth
// 					]);
// 	$title = 'ГЛАВНАЯ';
	 }

