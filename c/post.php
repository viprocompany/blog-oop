<?php
//вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
$isAuth = isAuth();
//имя пользователя для вывода в приветствии
$login = isName();
//получаем ГЕТ параметр из адресной строки при переходе из индексного файла
global  $id_article;
// $id_article = $_GET['id_article'] ?? null;

	// Разрешаем указать параметр после заданного контролера в урле .То есть на первом месте всегда располагается название контролера, а после слеша могут добавиться еще параметр как в данном случае  для чего в контроллере , где может добавляться айдишник нужно прописать этот дополнительный параметр как $id = $params[1] ?? null; 
$id_article = $params[1] ?? null; 
// echo $id ;
$err404 = false;
 // и сделать ветвление для проверки :
if(!$id_article)
{
	$err404 = true;
		// $msg = 'Не выбрана статья!';
		// $error = template('v_error',  [
		// 		'msg' => $msg
		// 	]);
}
else{
$err404 = false;
//создаем соеденение с базой, делаем запрос на выбор статьи по пререданному с индексной строки айдишнику, попутно в этой же функции проверяем коррктность тела запроса
 $query = select_tables_all('id_article, title,  name, content, date, title_category , img' ,"WHERE  id_article ='$id_article'");
//создаем массив из cтатей нашего блога
	$my_article = $query->fetchAll();  
	if($my_article){
		$err404 = false;
	}
	elseif(!$my_article)
	{
		$err404 = true;
		// $msg = 'В наличии нет такой страницы!';
		// $error = template('v_error',  [
		// 		'msg' => $msg
		// 	]);
	}
//ВАЛИДАЦИЯ проходим циклом по массиву чтоб достать нужные нам поля таблицы  -->
foreach($my_article as $art)
{ 
 //задаем переменную для названия
  $title = $art['title'];
  $date = $art['date'];
  $name = $art['name'];
  $title_category = $art['title_category'];
  $content = $art['content'];
  $img = $art['img'];
}

				
 // // include('v/v_auth.php');
	// 		$inner_auth =  template('v_auth' , [
	// 			'isAuth' => $isAuth,
	// 			'login' => $login,
	// 			'msg' => $msg
	// 		]);			
					// include_once('v/v_post.php');
			$inner = template('v_post',  [
				'isAuth' => $isAuth,
				'my_article' => $my_article,
				'title' => $title,
				'date' => $date,
				'name' => $name,
				'id_article' => $id_article,
				'title_category' => $title_category,
				'content' => $content,
				'img' => $img
			]);
	}
if(!$isAuth)
{
//ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : в массив сессии  добавляем элемент указывающий куда перейдет клиент после авторизации в файле login.php, если он заходил после клика на "ДОБАВИТЬ СТАТЬЮ"	
//старые ссылки c контроллером index.php?c= до введения ЧПУ
// $_SESSION['returnUrl'] = "/index.php?c=post&id_article=$id_article";	
		$_SESSION['returnUrl'] =  ROOT . "post/$id_article";		// $_SESSION['returnUrl'] = "/blog/add.php";
			// Header('Location: login.php');

}
?>
	