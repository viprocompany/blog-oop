<?php  
namespace controller;

use models\BaseModel;
use models\LoginsModel;
use models\SessionModel;
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
	public function LoginAction()
	{
// сброс  предыдущего входа для новой авторизации, использовано при нажатии кнопки выход функцией notAuth(), для повторной авторизации.
		$notAuth = Auth::notAuth();
// переопределяем title
		$this->title .=': АВТОРИЗАЦИЯ';
		$msg = [];

		if($this->request->isPost()){
// echo $_SESSION['name'] можно использовать на всех страницах сайта и обращаться к нему как к имени авторизованного пользователя
			$_SESSION['name'] =  trim($this->request->post('login'));
 //для вызова при наличии данных в форме методом POST
	//создаем объект для подключения к базе данных
			$db = DBConnect::getPDO();
//создаем новый объект класса LoginsModel и через конструктор добавляем к нему передачей через параметр ранее созданный  объект  $db для подключения к базе данных
			$mLogins = new LoginsModel(new DBDriver($db),new Validator());		
//создаем новый объект класса SessionModel и через конструктор добавляем к нему передачей через параметр ранее созданный  объект  $db для подключения к базе данных
			$mSession = new SessionModel(new DBDriver($db),new Validator());	
// проверка названия на незанятость вводимого названия 
			$login = trim($this->request->post('login'));
			$password = trim($this->request->post('password'));		  
//хешируем введенный пароль для дальнейшего сравнения с тем котрый есть в базе у этого логина
			$password = LoginsModel::getHash($password);
//вытаскиваем из базы ранее хешированный пароль соответствующий этому логину, role,  id
			$logins_match = $mLogins->getByLogin($login);
//пароль ,который есть в базе с этим логином
			$password_match = $logins_match['password'];	
			// var_dump($password_match);
			try{
//создаем объект класса logins , и добавляем туда объект mLogins используя модель класса  LoginsModel и объект mSession через подключение модели класса SessionModel
			$user = new logins($mLogins, $mSession);		
//массив данных из формы для валидации
					// var_dump(($this->request->post()));
				$user->signIn($this->request->post());	
// var_dump($user);
//после того как данные валидированы  переходим к авторизации	
//проверояем есть ли такой логин в базе
				if (($mLogins->correctOrigin('id_login', 'logins', 'login', $login))) {
					$msg = ['Нет такого пользователя!'];
				}
//сравниваем введенный пароль и тот, который есть в базе
				elseif (!($password == $password_match)) {
					$msg = ['Неправильный пароль!' ];			
				}
				else{
//задаем значение авторизации как действительное
					$_SESSION['is_auth'] = true;

// при выставлении галочки "запомнить" 
					$remember = 	$this->request->post('remember');
					if(isset($remember)  ?? true){
				//при удачной авторизации задаем куку с логином пользователя
						setcookie('login',$login, time()+3600*24*365 , '/');
						setcookie('password', LoginsModel::getHash($password), time()+3600*24*365 , '/');					
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
//обрабатываем исключения по валидации значений логина и пароля ,вводимых в форму
			} catch (IncorrectDataException $e) {
				$msg = ($e->getErrors());					
			}		
		}	

		$this->content = $this->build('login', [
			'msg'=>$msg	,
			'login'=>$login
// ,'password'=>$password		
		]);
	}


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
//ловим ошибку валидации брошенную в методе signUp класса LoginsModel
				try{
					$logins->signUp($this->request->post());	
//после того как данные валидированы и помещены в базу данных переходим на страницу авторизации
					header("Location: " . ROOT . "home");
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