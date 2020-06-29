<?php
namespace core;

class Auth
{
// К У К И    И     С Е С С И Я
//функция для проверки наличия кук и сессий для авторизации
function isAuth(){
	//задаем флаг авторизации 
	$isAuth = false;	
	if((isset($_SESSION['is_auth']))  && ($_SESSION['is_auth']))
	{ 
//подтверждаем авторизацию с помощью сессии
		$isAuth = true;	
	}
		 // ВЫДАЕТ ОШИБКУ В ВИДЕ ПОВТОРНОГО ВЫВОДА ЗНАЧЕНИЙ ЛОГИНА И ПАРОЛЯ ,ХОТЯ ПО ДЕФОЛТУ УСТАНОВЛЕНО В DBConnect СВОЙСТВО \PDO::FETCH_ASSOC ПРИ КОТОРОМ НЕ ДОЛЖНО БЫТЬ ДУБЛЕЙ 

//  //для вызова при наличии данных в форме методом POST
// 	//создаем объект для подключения к базе данных
// 			$db = DBConnect::getPDO();
// //создаем новый объект класса LoginsModel и через конструктор добавляем к нему передачей через параметр ранее созданный  объект  $db для подключения к базе данных
// 			$mLogins = new LoginsModel(new DBDriver($db),new Validator());
// //вытаскиваем из базы ранее хешированный пароль соответствующий этому логину, role,  id
// 			$logins = $mLogins->getByLogin($_COOKIE['login']);
// //пароль ,который есть в базе с этим логином
// 			$password = $logins['password'];	
// 			$login = $logins['login'];
//      var_dump($login);



	//временно отключал так как сейчас идет сверка с базой а не одиночно вручную прописанные значения логина и пароля, $_SESSION['is_auth'] задается во время авторизации и помещение записей логина в базу данных в конструкторе класса Logins

	elseif(isset($_COOKIE['login']) && isset($_COOKIE['password']))
	{

		if(($_COOKIE['login'] == 'admin') &&  ($_COOKIE['password'] == self::myhash('admin')))
		{
			$_SESSION['is_auth'] = true;
			$isAuth = true;
		}
	}
	return $isAuth;
}

// сброс  предыдущего входа для новой авторизации, использовано при нажатии кнопки выход, для повторной авторизации.
function notAuth(){
	if(isset($_SESSION['is_auth']))
{	
	unset($_SESSION['is_auth']);
}
//c чисткой кук логина и пароля путем установки их жизней на 1 января 1970 года (1)
if(isset($_COOKIE['login'])){
	setcookie('login', '', time()-3600, '/');
}
if(isset($_COOKIE['password'])){
	setcookie('password', '', time()-3600, '/');
}
return $notAuth;
}

//функция возвращает имя пользователя полученное из куки или сессии , которое можно использовать для приветствия после авторизации или входа
function isName(){		
	if($_COOKIE['login'])
	{
		$login = $_COOKIE['login'];	
	}	
	else
	{ 
		$login = $_SESSION['name'];	
	}
	return $login;
}
//хеширование пароля для отправки в куку, 'salt777' это так называемая соль (для дополнительного шифрования алгоритма), которая задается от балды
function myhash($str){
	// return hash('sha256', $str . 'salt777');
	return md5($password . '777');
}

}