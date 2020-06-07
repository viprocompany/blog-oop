<?php  
namespace controller;
use core\Auth;
use core\DBConnect;

class LoginController extends BaseController
{
	public function indexAction()
	{
// сброс  предыдущего входа для новой авторизации, использовано при нажатии кнопки выход функцией notAuth(), для повторной авторизации.
	$notAuth = Auth::notAuth();
//парольный вход для пользователя
	if(count($_POST) > 0) 
	{
		$_SESSION['name'] = $_POST['login'];
// echo $_SESSION['name'] можно использовать на всех страницах сайта и обращаться к нему как к имени авторизованного пользователя
		if($_POST['login'] == 'admin' && $_POST['password'] == 'admin')
		{
//задаем значение авторизации как действительное
			$_SESSION['is_auth'] = true;
//при поставленной галке в поле запомнить в массив ПОСТ добавится 'remember' , что даст возможность повесить куку с хешированным функцией myhash паролем для входа
			if(isset($_POST['remember']))
			{
				setcookie('login', 'admin', time()+3600*24*365 , '/');
				setcookie('password', Auth::myhash('admin'), time()+3600*24*365 , '/');
			}
//!!!!!!!!ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : элемент $_SESSION['returnUrl'] указывающий куда пойдет клиент  после авторизации в файле login.php. НАПРИМЕР: если файл login.php открылся после клика по edit(изменению)  то клиент пойдет на edit.php выбранной статьи, так как на edit.php элемент задан как $_SESSION['returnUrl'] = 'edit.php?fname=$fname' .  соответственно добавление  и так далее !!!!!
			if(isset($_SESSION['returnUrl']))
			{
//затирает старый адрес для перехода, что бы при разных страницах входа на сайт не происходил переход на когда-то давно выбранную страницу, а был переход на страницу по последнему сделанному клику			
				
				header('Location:'. $_SESSION['returnUrl']);	
				unset($_SESSION['returnUrl']);		
				exit();
			}
			else{
				header("Location: " . ROOT . "home");
				exit();
			}		
		}
	}
		// переопределяем title
		$this->title .=': ВХОД';
	//для вызова
	//создаем объект для подключения к базе данных
		$db = DBConnect::getPDO();
//создаем новый объект класса ArticleModel и через конструктор добавляем к нему передачей через параметр ранее созданный  объект  $db для подключения к базе данных
		$mAuth = new Auth($db);

		$this->content = $this->build('login', [   	
		]); 
	}

}