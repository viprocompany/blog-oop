<?php

//проверка авторизации
//вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
$isAuth = isAuth();
//имя пользователя для вывода в приветствии
$login = isName();

// получение данных на форму для изменения 
// из адресной строки берем getпараметр id_user
global $id_user;
// $id_user = $_GET['id_user'];
// Разрешаем указать параметр после заданного контролера в урле .То есть на первом месте всегда располагается название контролера, а после слеша могут добавиться еще параметр как в данном случае  для чего в контроллере , где может добавляться айдишник нужно прописать этот дополнительный параметр как $id = $params[1] ?? null; 
$id_user = $params[1] ?? null; 
//проверка авторизации
if(!$isAuth)
{//ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : в массив сессии  добавляем элемент указывающий куда перейдет клиент после авторизации в файле login.php, если он заходил после клика на "ДОБАВИТЬ автора"
  // $_SESSION['returnUrl'] = "/blog/edit-user.php?id_user=$id_user";
// старые ссылки c контроллером index.php?c=  до введения ЧПУ
// $_SESSION['returnUrl'] = "/index.php?c=edit-user&id_user=$id_user";
// Header('Location: index.php?c=login');
$_SESSION['returnUrl'] = ROOT . "edit-user/$id_user";
Header ("Location: " . ROOT . "login");
}
$err404 = false;
if(!$id_user)
{
    $err404 = true;
    // $msg = 'Не  выбран автор!';
    // $error = template('v_error',  [
    //     'msg' => $msg
    //   ]); 
  $name = "";
} 
 //проверяем корректность вводимого айдишника
elseif(!correct_id('name', 'users', 'id_user', $id_user ))
{   
  $err404 = true;
  // $msg = 'Такого автора нет!';  
  // $error = template('v_error',  [
  //       'msg' => $msg
  //     ]); 
  $name = "";  
}
else{//создаем соеденение с базой, делаем запрос на выбор автора по пререданным  параметрам с индексной строки айдишнику, попутно в этой же функции проверяем коррктность тела запроса      
  $query = select_table(' * ', ' users '," WHERE  id_user = '$id_user' ");
//создаем массив из cтатей нашего блога
  $my_user = $query->fetch(); 
  if(!$my_user)
  {
    $err404 = true;
    // $msg = 'Не  выбран автор!';
    // $error = template('v_error',  [
    //     'msg' => $msg
    //   ]); 
    $name = "";
  } 
  else
  {
    $name = $my_user['name'];
// функция correct_title для проверки корректоности названия статьи из файла functions.php
    if(!correct_title($name))
    {
      $err404 = true;
    // $msg = 'Неверное имя!';
    // $error = template('v_error',  [
    //     'msg' => $msg
    //   ]); 
          }  
    else
    {
      $err404 = false;
    }
  }
}

//сохранение измененных данных
if(count($_POST) > 0 ){
  $name_new = trim($_POST['name']);
//проверяем корректность вводимого названия 
  if(!new_correct_title($name))
  {      
    $msg = errors();
  } 
  //   elseif($title_new != $name)
  // {   
  //   $msg = 'Название менять нельзя';
  // } 
//проверяем корректность вводимого айдишника
  elseif(!correct_id('name', 'users', 'id_user', $id_user ))
  {   
     $msg = errors();
  }
  else{//подключаемся к базе данных и предаем тело запроса в параметре, которое будет проверяться на ошибку с помощью этой же функции
    $query = db_query("UPDATE `users` SET  `name`=:n  WHERE `id_user`=:id" ,[
      'n'=>$name_new,
      'id'=>$id_user
    ]
  );
//по айдишнику созданной   cтатьи из нашего блога переходим к просмотру
   
  // header("Location: /blog/users.php?id_user=$id_user");
      //старые ссылки c контроллером index.php?c= до введения ЧПУ
     // header("Location: /index.php?c=users&id_user=$id_user");
     header("Location:" . ROOT . "users/$id_user");
    exit();
  }
}
if(!$err404)
{ 
 //   $inner_auth =  template('v_auth' , [
 //  'isAuth' => $isAuth,
 //  'login' => $login,
 //   'msg' => $msg
 // ]);
   // include('v/v_edit-user.php');
   $inner = template('v_edit-user' , [
  'isAuth' => $isAuth,
  'id_user' => $id_user,
  'name' => $name,
  'msg' => $msg
 ]);
   $title = 'Изменить автора';
//    echo template('v_main', [
// 'title'=> 'Изменить автора',
// 'content'=> $inner_edit_user,
// 'auth'=> $inner_auth
// ]);

}
else{
 // echo $msg;
}
?>

