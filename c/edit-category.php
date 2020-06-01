<?php
//вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
$isAuth = isAuth();
//имя пользователя для вывода в приветствии
  $login = isName();

// получение данных на форму для изменения 
// из адресной строки берем getпараметр id_article и принимаем его как значение названия статьи выведенной для изменения
$msg = '';
global $id_category;
// $id_category = $_GET['id_category'];
// Разрешаем указать параметр после заданного контролера в урле .То есть на первом месте всегда располагается название контролера, а после слеша могут добавиться еще параметр как в данном случае  для чего в контроллере , где может добавляться айдишник нужно прописать этот дополнительный параметр как $id = $params[1] ?? null; ПРИМЕНЯЕМ ВМЕСТО $_GET['id_category']
$id_category = $params[1] ?? null; 

//проверка авторизации
if(!$isAuth)
{
//ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : в массив сессии  добавляем элемент указывающий куда перейдет клиент после авторизации в файле login.php, если он заходил после клика на "ДОБАВИТЬ автора"
  // $_SESSION['returnUrl'] = "/blog/add-category.php";
  //старые ссылки c контроллером index.php?c= до введения ЧПУ
  // $_SESSION['returnUrl'] = "/index.php?c=edit-category&id_category=$id_category";
  // Header('Location: index.php?c=login');
    $_SESSION['returnUrl'] = ROOT . "edit-category/$id_category";
  Header("Location: " . ROOT . " login");
}
$err404 = false;
if(!$id_category)
{  
    $err404 = true;
    // $msg = 'Не выбрана категория!';
    // $error = template('v_error',  [
    //     'msg' => $msg
    //   ]);
   
} 
    //проверяем корректность вводимого айдишника
elseif(!correct_id('title_category', 'categories', 'id_category', $id_category ))
{   
   $err404 = true;
  // $msg = 'Такой категории нет!'; 
  //  $error = template('v_error',  [
  //       'msg' => $msg
  //     ]);
}
else{
//создаем соеденение с базой, делаем запрос на выбор категории по пререданному с индексной строки айдишнику, попутно в этой же функции проверяем коррктность тела запроса    
   $query = select_table(' * ', ' categories '," WHERE  id_category = '$id_category' ");
//создаем массив из cтатей нашего блога
  $my_category = $query->fetch();

  if($my_category === null){
    $msg = 'Не выбрана категория!';
    $title_category = "";
  } 
   //задаем переменную для названия
  $title_category = $my_category['title_category'];
// функция correct_title для проверки корректоности названия статьи из файла functions.php
  if(!correct_title($title_category))
  {
    $msg =  'Неверное имя!'; 
  }  
}


//сохранение измененных данных
if(count($_POST) > 0 ){
  $title_category_new = trim($_POST['title_category']);
  // $id_user = trim($_POST['id_user']);
//проверяем корректность вводимого названия 
  if(!new_correct_title($title_category_new))
  {   
    $msg = errors();
  } 
  //   elseif($title_category_new != $title_category)
  // {   
  //   $msg = 'Название менять нельзя';
  // } 
  
//проверяем корректность вводимого айдишника
  elseif(!correct_id('title_category', 'categories', 'id_category', $id_category ))
  {   
    $msg = errors();
  }
  else{
//подключаемся к базе данных и предаем тело запроса в параметре, которое будет проверяться на ошибку с помощью этой же функции
    $query = db_query("UPDATE `categories` SET  `title_category`=:n  WHERE `id_category`=:id" ,[
      'n'=>$title_category_new,
      'id'=>$id_category
    ]
  );
//по айдишнику созданной   cтатьи из нашего блога переходим к просмотру
      // header("Location: /blog/categories.php?id_category=$id_category");
    //старые ссылки c контроллером index.php?c= до введения ЧПУ
    // header("Location: /index.php?c=categories&id_category=$id_category");
      //старые ссылки c контроллером index.php?c= до введения ЧПУ
    // header("Location: /index.php?c=categories&id_category=$id_category");
    header("Location: " . ROOT . "categories/$id_category"); 
    exit();
  }
}
if(!$err404){
   // include('v/v_edit-category.php'); 
   $inner = template('v_edit-category' , [
  'isAuth' => $isAuth,
  'id_category' => $id_category,
  'title_category' => $title_category,
  'msg' => $msg
 ]);
    $title = 'Изменить категорию';
}
else{
 // echo $msg;
}

?>

