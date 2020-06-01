<?php
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
	elseif(isset($_COOKIE['login']) && isset($_COOKIE['password']))
	{
		if(($_COOKIE['login'] == 'admin') &&  ($_COOKIE['password'] == myhash('admin')))
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
	return hash('sha256', $str . 'salt777');
}

