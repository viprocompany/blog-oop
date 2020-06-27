<?php  
namespace controller;

use models\BaseModel;
use models\LoginsModel;
use core\DBConnect;
use core\Auth;
use core\Request;
use core\DBDriver;
use core\Logins;
use models\Helper;
use core\Validator;
use core\Exception\IncorrectDataException;

class LoginsController extends BaseController
{
	public function signUpAction()
	{
		// переопределяем title
		$this->title .=': РЕГИСТРАЦИЯ';

		if($this->request->isPost()){
  //для вызова при наличии данных в форме методом POST
	//создаем объект для подключения к базе данных
			$db = DBConnect::getPDO();
//создаем новый объект класса LoginsModel и через конструктор добавляем к нему передачей через параметр ранее созданный  объект  $db для подключения к базе данных
			$mLogins = new LoginsModel(new DBDriver($db),new Validator()
		);
			$msg = [];		
				// проверка названия на незанятость вводимого названия 
			$login = trim($_POST['login']);
		// $password = trim($_POST['password']);	
			if (!($mLogins->correctOrigin('id_login', 'logins', 'login', $login))) {
				$msg = ['Логин занят!'];
			}
			else{
				//создаем объект класса logins , используя модель подключения к базе данных через LoginsModel
				$logins = new logins($mLogins); 
				try{
					$logins->signUp($this->request->post());	
//после того как данные валидированы и помещены в базу данных переходим на страницу авторизации
					header("Location: " . ROOT . "login");
					exit();
				} catch (IncorrectDataException $e) {
					$msg = ($e->getErrors());
				}
			}
		}
		$this->content = $this->build('sign-up', [
			'msg'=>$msg,
			'login'=>$login
      // ,'password'=>$password
		]);
	}
	public function signInAction()
	{
		// переопределяем title
		$this->title .=': АВТОРИЗАЦИЯ';
		$this->content = $this->build('sign-in', []);
	}
}

// 	//вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
//    $isAuth = Auth::isAuth();
// //имя пользователя для вывода в приветствии
//    $login = Auth::isName();
//    $msg = '';

// //проверка авторизации
//    if(!$isAuth)
//    {
// //ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : в массив сессии  добавляем элемент указывающий куда перейдет клиент после авторизации в файле login.php, если он заходил после клика на "ДОБАВИТЬ автора"
//     $_SESSION['returnUrl'] = ROOT . "logins";
//     header("Location: " . ROOT . "sign-in");
//   }

// //применяем к объекту метод из его класса
//   $logins = $mLogins->add(' login ', 'pasword');
// var_dump($logins);