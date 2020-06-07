<?php  
namespace controller;

use core\Auth;
use core\Request;

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
    $inner_auth =  $this->build( 'auth',
      [
        'isAuth' => $isAuth,
        'login' => $login
        // ,        'msg' => $msg
      ]); 
    echo $this->build('main',
      [
        'title' => $this->title,
        'content' => $this->content,
        'new_row' => $this->new_row,
        'auth'=> $inner_auth,
        'error' => $error,
        'title_1' => $title_1,
        'isAuth' => $isAuth,
        'image_footer' => $image_footer,
        'login' => $login
      ]);
  }

}

