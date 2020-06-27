<?php
namespace models;

use core\DBDriver;
use core\Validator;
use core\Exception\IncorrectDataException;

class LoginsModel extends BaseModel
{
	protected $validator;
	protected $schema = [
		'id_login' => [
			'primary' => true
		],
		'login' => [
			'type' => 'string',
			'length' => [3, 50],
			'not_blank' => true,
			'require' => true,
			'correct' => 'login'
		],
		'password' => [
			'type' => 'string',
			'length' => [5, 50],
			'require' => true,
			'not_blank' => true				
		]
	];

	public function __construct(DBDriver $db, Validator $validator)
	{
		parent::__construct($db, $validator, 'logins');
		$this->validator->setRules($this->schema);
	}	

	public function  signUp(array $fields)	
	{
//валидируем 
		$this->validator->execute($fields);
		if(!$this->validator->success){
		// бросаем ошибку с полученным массивом errors   из метода execute класса Validator, далее она летит в контроллер индексного файла
				throw new IncorrectDataException($this->validator->errors);
		}
		return $this->add([
			'login'=> $this->validator->clean['login'],
			'password'=> $this->getHash($this->validator->clean['password'])
		]);	
			// var_dump($this->validator->clean);
 
	}
	public function getHash($password)
	{
		return md5($password . '777');
	}

}
