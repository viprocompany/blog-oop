<?php 
namespace core;
 
 use models\LoginsModel;
 use core\Validator;
 use core\Exception\IncorrectDataException;

 class Logins
 {
 	//модель пользователя
   private $mLogins;

 	public function __construct(LoginsModel $mLogins)
 	{
 		$this->mLogins = $mLogins;
 	}

 	public function signUp(array $fields)
 	{
 	//нужно проверить на наличие ошибки????????????????????????
	// $this->validator->execute($fields);
	// 	if(!$this->validator->success){
	// 	// бросаем ошибку с полученным массивом errors   из метода execute класса Validator, далее она летит в контроллер индексного файла
	// 			throw new IncorrectDataException($this->validator->errors);
	// 	}

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