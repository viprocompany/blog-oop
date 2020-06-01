<?php 
//функция для подключения соеденения  с базой данных , для постоянного подключения используем СТАТИК для пременной $db
function db_connect(){
	static $db;

	if($db === null){
		$db = new PDO('mysql:host=localhost;dbname=blog', 'root', '');
		$db->exec('SET NAMES UTF8');
	}
	return $db;
}

//проверка запроса на ошибки в теле запроса, используем константу безошибочности PDO::ERR_NONE, которая равна 00000, и будет сравниваться с массивом по разбору возможных ошибок. константу вместо её значения 00000 используем потому, что с обновлением версии PHP её значение может измениться на другое.
function db_check_error($query){
	$info = $query->errorInfo();
//если данные из массива возможных ошибок не равны константе PDO::ERR_NONE, то есть при наличии ошибки скрипт прекращает свою работу
	if($info[0] != PDO::ERR_NONE){
		exit($info[2]);
	}
}

//функция работы с запросом, в параметре передается тело запроса и параметры для подстановки в тело запроса в виде массива(по умолчанию пустой, и поэтому не всегда указывается )
function db_query($sql, $params = []){
//создаем объект для подключения к базе данных  с помощью функции db_connect
	$db = db_connect();
//подготовка запроса
	$query = $db->prepare($sql);
//готовый выполненный запрос с параметрами , который можно впоследствии выводить для SELECT с помощью fetch , fetchAll
	$query->execute($params);
//проверка тела запроса на ошибки с помощью функции db_check_error
	db_check_error($query);
	return $query;
}

//проверка наличия ДОБАВЛЯЕМОГO поля УНИВЕРСАЛЬНАЯ
function correct_origin($id, $table, $param, $text){
	$query = db_query("SELECT  $id FROM $table  WHERE $param = '$text';");
	//переменная айдишника для имени и фамилии автора
	$id_original = $query->fetchColumn();	
	//если айдишник не пустой значит такой автор уже есть
	if (!$id_original == "")
	{
		errors('Название занято!');
		return false;
	}
	return true;
}

//УНИВЕРСАЛЬНАЯ проверка корректности получаемого айдишника сущности, то есть его наличие
function correct_id($text, $table, $param, $id ){
	//получаем массив айдишников категории новости
	$query = db_query("SELECT $text FROM $table WHERE $param = '$id';");
//пременаая с названием категории
	$cat = $query->fetchColumn();
//если переданного айдишника нет, значит нет и категории(пустая),  значит пишем ошибку
	if($cat == "")
	{
		errors('Неверный выбор, введите корректный параметр !');
		return false;
	}
	return true;
}

//создание статьи путем вставки запроса и массива значений для подстановки в запрос С ПОЛУЧЕНИЕМ ЗНАЧЕНИЯ ПОСЛЕДНЕГО ВВЕДЕННОГО АЙДИШНИКА СТАТЬИ
	function db_query_add_article($title, $content, $id_user, $id_category, $img){
//подготовка запроса
		db_query("INSERT INTO `article` (`title`, `content`,  `id_user`,`id_category`, `img`)  VALUES (:t,:c,:us,:cat, :i)", [
			't'=>$title,
			'c'=>$content,
			'us'=>$id_user,
			'cat'=>$id_category,
			'i'=>$img
		]);
		$db = db_connect();
		return $new_article_id = $db->lastInsertId();
	}

//создание статьи путем вставки запроса и массива значений для подстановки в запрос С ПОЛУЧЕНИЕМ ЗНАЧЕНИЯ ПОСЛЕДНЕГО ВВЕДЕННОГО АЙДИШНИКА
	function db_query_add($sql, $params = []){		
		db_query($sql, $params);
		$db = db_connect();
		return $new_article_id = $db->lastInsertId();
	}

//ОБНОВЛЕНИЕ статьи путем вставки запроса и массива значений для подстановки в запрос по выбранному  АЙДИШНИКУ
	function db_query_update_art($title, $content, $id_user, $id_category, $id_article, $img){		
		$query = db_query("UPDATE `article` SET  `title`=:t, `content`=:c,   `id_user`=:us, `id_category`=:cat , `img`=:i  WHERE id_article= :new  ",[
			't'=>$title,
			'c'=>$content,
			'us'=>$id_user,
			'cat'=>$id_category,
			'new'=>$id_article,
			'i'=>$img
		]
	);		
	 return $query;
	}

//функция для выборки данных из трех таблиц одновременно
	function select_tables_all($parametrs, $where="", $order=""){
		$query = db_query("SELECT $parametrs  FROM article INNER JOIN categories ON article.id_category = categories.id_category INNER JOIN users ON  users.id_user = article.id_user  $where  $order;");
		return $query;
	}

//функция для выборки данных из ОДНОЙ  таблицы 
	function select_table($parametrs, $table, $other=""){
		$query = db_query("SELECT $parametrs  FROM $table  $other ;");
		return $query;
	}

	 //выбираем массив имён=значений статических текстов для добавления в разметку
	function textsStatic()
	{				
		$query = select_table(' text_name, text_content ', ' texts '); 
		$texts = $query-> fetchAll();
		 // return $texts;
			// $id работает только отдельно , после вставки в array_column в значении  'id_text' не обрезает '$' 
 //  $id = str_replace('$', '', 'id_text');
	// $texts = array_column($texts, 'text_content', (str_replace('$', '', 'id_text')));
	//  return $texts;
		foreach ($texts as $text)
		{		
		  // $i[] = '';		
			$i = $text['text_name'];			
			$i = substr($i,1);
			// $t[] = '';	
			$t = $text['text_content'];
			//??????после вызова на печать отображается почему-то массив только  с одним ключом-значением. в зависимости от местоположения в  цикле либо после него , показывает либо первый либо последний элемент массива
			$texts = array($i => $t);		
			return $texts;
		}	 	 	 
	}








	// foreach ($texts as $key=>$value)
	// {
	// 	return ('\'' .$key.'\'' .'=>'.'\'' .$value.'\'' .',');
	// }

	// foreach ($texts as list($a, $b)) 
	// 	{// echo $a . "<br>";
	// 	// echo $b . "<br>";
	// 	$id = substr($a,1) ;
	// 	$text = $b;
	// 			$texts = ('\'' . "$id" . '\'' . '=> ' . '\'' . $text .'\'' . ','); 

		//формирует красивую строку по шаблону $texts, но в темплайте как $text она не выводится, при вставлении вручную все работает отлично:
	// 'image_footer'=> 'footer.jpg','image_header'=> 'header.jpg','image_mail'=> 'mail.png','instagram'=> 'instagram.jpg','title_1'=> 'PHP','title_2'=> 'Первый уровень PHP','vk'=> 'vk.jpg',

// 	foreach ($texts as list($a, $b)) 
// 		{// echo $a . "<br>";
// 		// echo $b . "<br>";
// 	$id = substr($a,1) ;
// 	$text = $b;
// 	$texts = ($id.'='.$text); 
	
// 	$temp = explode(',', $texts);
// 	$array = array();
// 	foreach($temp as $item) {
// 		$arr = explode('=', $item);
// 		$array[$arr[0]] = $arr[1];
// 	}
// 	 echo('<pre>');
// 	print_r($array);
// 	 echo('</pre>');
// }


	  // $array1[] = '';
    // $array2 = explode(',', $texts);   
    // foreach($array2 as $str) 
    // {
    // 	list($key, $value) = explode('=>', $str); 
    // 	$array1[$key] = $value; 
    // // echo('<pre>');
    // // print_r($array1);
    // // echo('</pre>');
    // 	return $texts;
    // }	 