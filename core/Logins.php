<?php 
namespace core;
 
use models\LoginsModel;
use models\SessionModel;
use core\Request;
use core\Validator;
use core\Exception\IncorrectDataException;

//в классе собираем объект для регистрации и авторизации пользователя  используя модели пользователя LoginsModel и модель наших сессий SessionModel
 class Logins 
 {
 	//модель пользователя
   private $mLogins;
   	//модель сессии пользователя
   private $mSession;

 	public function __construct(LoginsModel $mLogins, SessionModel $mSession)
 	{
 		//делаем по умолчанию что авторизавция пройден
 		$_SESSION['is_auth'] = true;
 		$this->mLogins = $mLogins;
 		$this->mSession = $mSession;
 	}
 	public function signIn(array $fields)
 	{


//валидируем - вызываем signIp и передаем туда  $fields - поля для логин, пароль
 		 $this->mLogins->signIn($fields);
 	//можно перехватиь ошибку валидации из модели LoginsModel здесь, но сделано  в контроллере LoginsController 

 // 		$login = $fields['login'];
	// 	 var_dump($fields, $login);
 // // die;
	// 	// $user = $this->$mLogins->getByLogin($login);
	// 	$user = $this->$mLogins->getByLogin(isset($fields['login']) ?? null);

 // var_dump($user);
 // die;

 		 
 		
 	}

 	public function isAuth(Request $request)
 	{

 	}
 	public function signUp(array $fields)
 	{
 	//можно перехватиь ошибку валидации здесь, а  можно попробовать споймать ошибку в контроллере LoginsController, что и сделано в данном случае( try catch установлен в контроллере LoginsController)

 		//можно сделать проверку на правильность повторно введенного пароля при регистрации , в случае если используем для пароля второе поле для дублирования ввода пароля
 		// if(!$this->comparePass($fields)){
 		// 	return false;
 		// }

 		 //вызываем signUp и передаем туда  $fields - поля для логин, пароль , куки и др.
 		$this->mLogins->signUp($fields);
 	}

 	private function comparePass($fields)
 	{
 		// сделать сравнение на правильность пароля при повторном вводе
 	}
 }