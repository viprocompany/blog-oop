<?php
//проверка авторизации
$isAuth = isAuth();
//вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
//имя пользователя для вывода в приветствии
	$login = isName();

// получение данных на форму для изменения 
// из адресной строки берем get-параметр id_article и принимаем его как значение названия статьи выведенной для изменения
global $id_article;
// $id_article = $_GET['id_article'];
// Разрешаем указать параметр после заданного контролера в урле .То есть на первом месте всегда располагается название контролера, а после слеша могут добавиться еще параметр как в данном случае  для чего в контроллере , где может добавляться айдишник нужно прописать этот дополнительный параметр как $id = $params[1] ?? null; 
$id_article = $params[1] ?? null; 
if(!$isAuth)
{//ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : в массив сессии  добавляем элемент указывающий куда перейдет клиент после авторизации в файле login.php, если он заходил после клика на "ДОБАВИТЬ автора"
  // $_SESSION['returnUrl'] = "/blog/edit-user.php?id_user=$id_user";
//старые ссылки c контроллером index.php?c= до введения ЧПУ
// $_SESSION['returnUrl'] = "/index.php?c=edit&id_article=$id_article";
// Header('Location: "index.php?c=login');
$_SESSION['returnUrl'] = ROOT . "edit/$id_article";
Header("Location: " . ROOT . " login");
}
$err404 = false;
if(!$id_article)
{		$err404 = true;
		// $msg = 'Не выбрана статья!';
		// $error = template('v_error',  [
		// 		'msg' => $msg
		// 	]);
}	
else{

//создаем соеденение с базой, делаем запрос на выбор статьи по пререданному с индексной строки айдишнику, попутно в этой же функции проверяем коррктность тела запроса		
	// $query = select_table(' * ', ' article ', " WHERE  id_article = '$id_article'");
	 $query = select_tables_all('*' , " WHERE  id_article = '$id_article'");
//создаем массив из cтатей нашего блога
	$my_article = $query->fetchAll();
  	if(!$my_article){
		$err404 = true;
	}	
	else
	{//проходим циклом по массиву чтоб достать нужные нам поля таблицы
		foreach($my_article as $art)  
		{ 
			$title = $art['title'];			
			$id_user = $art['id_user'];
			$name= $art['name'];
			$id_category = $art['id_category'];
			$title_category = $art['title_category'];
			$content = $art['content'];	
			$img = $art['img'];	
// функция correct_title для проверки корректоности названия статьи из файла functions.php
			if(!correct_title($title))
			{
				$err404 = true;
				echo 'Кривое название !';	
			}
			else
			{
				$err404 = false;
			}
		}		
	}
}
//задаем массив для дальнейшего вывода фамилий авторов в разметке через опшины селекта, после выбора автора из значения опшина подтянется айдишник автора для дальнейшего добавления в статью
	 $query= select_table('*', 'users', "ORDER by name ASC");
	 $names = $query->fetchAll();	
	 //задаем массив для дальнейшего вывода категорий новостей в разметке через опшины селекта, после выбора категории из значения опшина подтянется айдишник категории для дальнейшего добавления в статью
   $query= select_table('*', 'categories', "ORDER by title_category ASC");
   $categories = $query->fetchAll(); 

//создаем массив сканирую директорию img
// $dir_img = $_SERVER['DOCUMENT_ROOT'] . 'assest/img';
// $dir_img =  'f:/OpenServer/OSPanel/domains/blog/images';
$dir_img =  'D:/open-server/OSPanel/domains/blog/images';
$img_files = scandir($dir_img);
//создаем пустой массив для картинок
$images = [];
$images = $img_files;
//сохранение измененных данных
if((count($_POST) > 0) )
{	// $id_article_new = $id_article;
	$title_new = trim($_POST['title']);
	$id_category_new = trim($_POST['id_category']);
	$content_new = trim($_POST['content']);
	$img_new = trim($_POST['image']);
	// айдишник получаем из значения value опшина после того как в выпадающем списке был выбран автор 
	$id_user_new = trim($_POST['name']);
	$msg = "";
//проверяем корректность вводимого названия 
	if(!new_correct_title($title_new))
	{		
		$msg = errors();
	}	
	// elseif($title_new !
	// 	= $title)
	// {		
	// 	$msg = 'Название менять нельзя';
	// }	
    //проверяем корректность вводимого айдишника автора
	elseif(!correct_id('name', 'users', 'id_user', $id_user_new ))
	{   
		$msg = 'Неверный код автора';
	}	
  //проверяем корректность вводимого айдишника категории новости
	elseif(!correct_id('title_category', 'categories', 'id_category', $id_category_new ))
	{   
			$msg = 'Неверный код категории новости';
	}	
	//проверяем корректность вводимого контента 
	elseif(!correct_content($content_new))
	{
		$msg = errors();
	}	
	else{//подключаемся к базе данных и предаем тело запроса в параметрах, которое будет проверяться на ошибку с помощью этой же функции
		$query =  db_query_update_art($title_new, $content_new, $id_user_new, $id_category_new, $id_article,$img_new);
//по айдишнику созданной   cтатьи из нашего блога переходим к просмотру
				// header("Location: /blog/post.php?id_article=$id_article ");
		//старые ссылки c контроллером index.php?c= до введения ЧПУ
		// header("Location: /index.php?c=post&id_article=$id_article ");
		header("Location: " . ROOT . "post/$id_article ");

		exit();
	}
}
if(!$err404)
{
	//  $inner_auth =  template('v_auth' , [
 // 	'isAuth' => $isAuth,
 // 	'login' => $login,
 // 	 'msg' => $msg
 // ]);
	// include('v/v_edit.php');
	 $inner = template('v_edit' , [
 	'isAuth' => $isAuth,
 	'id_article' => $id_article,
 	'title' => $title,
 	'id_user' => $id_user,
 	'name' => $name,
 	'names' => $names,
 	'id_category' => $id_category,
 	'title_category' => $title_category,
 	'categories' => $categories,
 	'content' => $content, 	
 	'images' => $images,
 	'img' => $img,
 	'msg' => $msg
 ]);
	 $title = 'РЕДАКТИРОВАНИЕ';
// 	 echo template('v_main', [
// 'title'=> 'Изменить статью',
// 'content'=> $inner_edit,
// 'auth'=> $inner_auth
// ]);

}

?>


