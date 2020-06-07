<?php
namespace core;

class Request
{
  const METHOD_POST = 'POST';
  const METHOD_GET = 'GET';

  private $get;
  private $post;
  private $server;
  private $cookie;
  private $title;
  private $session;

  public function __construct( $get, $post, $server, $cookie, $title, $session)
  {
    $this->get = $get;
    $this->post = $post;
    $this->server = $server;
    $this->cookie = $cookie;
    $this->title = $title;
    $this->session = $session;
  }

// создаем функцию ,которая принимает массив из глобального массива серверных переменных  и при наличии ключей отдает значения по ключам  в функции по выбранным массивам: GET, POST , SERVER, Cookie, SESSION, TITLE
  private function getArr(array $arr, $key = null)
  {
    if(!$key){
      return $arr;
    }
    if(isset($arr[$key])){
      return $arr[$key];
    }
    return null;
  }

  public function get($key = null)
  {
  //запускаем функцию getArr, которая обращается к свойству get как массиву  и при наличии ключа (в данном случае в виде числа ID из запроса ) и возвращает значение этого ключа
    return $this->getArr($this->get,$key);
  }

  public function post($key = null)
  {
     //запускаем функцию getArr, которая обращается к свойству post как массиву  и при наличии ключа (в данном случае в виде значения поля формы ввода данных) и возвращает значение этого ключа
   return $this->getArr($this->post,$key);
  }

 public function server($key = null)
  {
   return $this->getArr($this->server,$key);
  }

   public function cookie($key = null)
  {
   return $this->getArr($this->cookie,$key);
  }

   public function title($key = null)
  {
   return $this->getArr($this->title,$key);
  }

   public function session($key = null)
  {
   return $this->getArr($this->session,$key);
  }

//функция позволяет определить каким методом пришел человек на страницу ГЕТ или ПОСТ
  public function isPost()
  {
//если метод ГЕТ - значит вернет ложь, если метод ПОСТ(используем константу) значит вернет правду
    return $this->server['REQUEST_METHOD'] === self::METHOD_POST;
  }

//функция позволяет определить каким методом пришел человек на страницу ГЕТ или ПОСТ
  public function isGet()
  {
//если метод POST - значит вернет ложь, если метод GET(используем константу) значит вернет правду
    return $this->server['REQUEST_METHOD'] === self::METHOD_GET;
  }

}  