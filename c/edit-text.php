<?php

//проверка авторизации
//вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
$isAuth = isAuth();
//имя пользователя для вывода в приветствии
$login = isName();
// получение данных на форму для изменения 
// из адресной строки берем getпараметр id_user
global $id_text;
// $id_text = $_GET['id_text'];
// Разрешаем указать параметр после заданного контролера в урле .То есть на первом месте всегда располагается название контролера, а после слеша могут добавиться еще параметр как в данном случае  для чего в контроллере , где может добавляться айдишник нужно прописать этот дополнительный параметр как $id = $params[1] ?? null; 
$id_text = $params[1] ?? null; 
//проверка авторизации
if(!$isAuth)
{//ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : в массив сессии  добавляем элемент указывающий куда перейдет клиент после авторизации в файле login.php, если он заходил после клика на "ДОБАВИТЬ автора"
$_SESSION['returnUrl'] = ROOT . "edit-text/$id_text";
Header ("Location: " . ROOT . "login");
}
$err404 = false;
if(!$id_text)
{
  $err404 = true;
 } 
//  //проверяем корректность вводимого айдишника
elseif(!correct_id('text_name', 'texts', 'id_text', $id_text ))
{   
  $err404 = true;

}
else{
//создаем соеденение с базой, делаем запрос на выбор автора по пререданным  параметрам с индексной строки айдишнику, попутно в этой же функции проверяем коррктность тела запроса      
  $query = select_table(' * ', ' texts '," WHERE  id_text = '$id_text' ");
//создаем массив из cтатей нашего блога
  $my_text = $query->fetch(); 
  if(!$my_text)
  {
    $err404 = true;
  } 
  else
  { 
    $id_text = $my_text['id_text'];
    $text_content = $my_text['text_content'];
    $text_name = $my_text['text_name'];
    $description = $my_text['description'];
  }
}
//создаем массив сканирую директорию img
// $dir_img = $_SERVER['DOCUMENT_ROOT'] . 'assest/img';
// $dir_img =  'f:/OpenServer/OSPanel/domains/blog/assest/img/';
$dir_img =  'D:/open-server/OSPanel/domains/blog/assest/img';
$img_files = scandir($dir_img);
//создаем пустой массив для картинок
$images = [];
$images = $img_files;

//сохранение измененных данных
if(count($_POST) > 0 ){
  $text_content_new = '';
  $text_name_new = '';
  $text_name_new = trim($_POST['text_name']);
  $text_content_new = trim($_POST['text_content']);
  $description_new = trim($_POST['description']);
//проверяем корректность вводимого названия 
  // if(!new_correct_title($id_text_new))
  // {      
  //   $msg = errors();
  // } 

//проверяем корректность вводимого айдишника
  if(!correct_id('text_name', 'texts', 'id_text', $id_text ))
  {   
   $msg = errors();
 }
  else{//подключаемся к базе данных и предаем тело запроса в параметре, которое будет проверяться на ошибку с помощью этой же функции
    $query = db_query("UPDATE `texts` SET `text_name` =:n,  `text_content` =:c,  `description`=:d  WHERE `id_text`=:i " ,[
      'n'=>$text_name,
      'c'=>$text_content_new,
      'd'=>$description_new,
      'i'=>$id_text
    ]
  );
//по айдишнику созданной   cтатьи из нашего блога переходим к просмотру
    header("Location:" . ROOT . "texts/$id_text");
    exit();
  }
}
if(!$err404)
{ 
 $inner = template('v_edit-text' , [
  'isAuth' => $isAuth,
  // 'id_text' => $id_text,
  'text_content' => $text_content,
  'text_name' =>$text_name,
  'images' => $images,
  'description' => $description,
  'msg' => $msg
]);
 $title = 'Изменить текст';


}
else{
 // echo $msg;
}
?>