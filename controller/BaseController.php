<?php  
namespace controller;

use core\Exception\ErrorNotFoundException;
use core\Auth;
use core\Request;
use core\Logins;
// use core\DBDriver;
use core\Templater;
use models\TextsModel;

class BaseController
{
  protected $title;
  protected $content;
  protected $request;

  public function __construct(Request $request)
  {
    $this->request = $request;
    $this->title = 'PHP 2 :';
    $this->content = '';
    // $this->statica = '';
  }
//метод используется для вызова несуществующего метода у существующего объекта
public function __call($name, $arguments)
{
  //делаем проверку на несоответствие
  try{
    // бросаем исключение
  throw new \core\Exception\ErrorNotFoundException(); 
   //ловим исключение и
    }catch (\core\Exception\ErrorNotFoundException $e){
    //обрабатываем исключение и выводим в разметку сообщение об 404
    $this->title .=' 404';
    $this->content = $this->build('errors', [
    ]);
  }
}
  protected function  build($template, $params =[])
  {
    ob_start();

    //после приема переменной в буфер вытаскиваем данные из массива
    extract($params);
    //указываем путь к файлу разметки
    include_once 
      __DIR__ . '/../views/'.$template.'.html.php';
    //порлучаем вытянутые данные и очищаем буфер
    return ob_get_clean();
  }
//метод используется для обработки исключений в сформированном контроллере индексного файла, собирает исключения как $message и дерево файлов $trace, по которму поднимется исключение из метода execute класса Validator
  public function errorHandler($message,$trace){
    $this->content = $message;
  }

  public function render()
  {
    //вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
    $isAuth = Logins::isAuth();
    // echo('isAuth:  ' . $isAuth);
    // echo('isAuth_session:  ' . $_SESSION['is_auth']);
    // die;
//имя пользователя для вывода в приветствии
    $login = Auth::isName();
  
    // <!-- проверка авторизации на сессию либо куки
// подтверждаем авторизацию с помощью сессии -->
// include('v/v_auth.php');
//передаем переменные в виде шаблонов из кода разметки и прередаем в выбранные вьюшки значения  isAuth,login,msg. v_auth  для вывода представления авторизации
    $inner_auth =  $this->build( 'auth',
      [
        'isAuth' => $isAuth,
        'login' => $login
        // ,        'msg' => $msg
      ]);      
     //рпринимаем массив статических значений для графики разметки из kласса ТЕКСТ. аналог админки по выбору картинок и заголовков
  $statica = Templater::statica();
 
    echo $this->build('main',
      [
        'title' => $this->title,
        'content' => $this->content,
        'new_row' => $this->new_row,
        'auth'=> $inner_auth,
        'error' => $error,
         'login' => $login,        
        'isAuth' => $isAuth,        
        'image_footer' => $statica['$image_footer'],
        'image_header' => $statica['$image_header'],
        'image_mail' => $statica['$image_mail'],
        'instagram' => $statica['$instagram'],
        'vk' => $statica['$vk'],
        'fb' => $statica['$fb'],
        'title_1' => $statica['$title_1'],
        'title_2' => $statica['$title_2']       
    
      ]);
  }
  //функция переадресации с указанием статуса 302-найдено, для роботов
    protected function redirect($uri)
  {
    header('Status: 302 Found');
    header(sprintf('Location: %s', $uri));
    exit();
  }

}

