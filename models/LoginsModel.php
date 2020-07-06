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
		parent::__construct($db, $validator, 'logins','login');
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


	public function  signIn(array $fields)	
	{
//валидируем 
		$this->validator->execute($fields);
		if(!$this->validator->success){
		// бросаем ошибку с полученным массивом errors   из метода execute класса Validator, далее она летит в контроллер индексного файла
			throw new IncorrectDataException($this->validator->errors);
		}

	}
	//функция хеширования пароля пользователя при передаче в базу данных с помощью функции add 
	// 777 - это соль
	public function getHash($password)
	{
		return md5($password . '777');
	}
	
	public function getByLogin( $Login )
	{		
		$sql = sprintf('SELECT * FROM  %s  WHERE  %s= :login '  , $this->table, $this->id_param);		
		// $sql = ("SELECT * FROM " . $this->table . " WHERE  " . $this->id_param . "= :id");
		return  $this->db->select($sql,['login' => $Login], DBDriver::FETCH_ONE);
	//пишем $id как написано в передаче параметра, а не как будет отражено в запросе типа $id_article или другое подобное, передаем в третий параметр константу из класса DBDriver для выборки одной строки 
	}
	public function getBySid( $sid )
	{		
		$sql = sprintf('SELECT `logins.id_login` as id_login, login  FROM  %s   JOIN sessions ON `sessions.id_login` = `logins.id_login`    WHERE  sid= :sid '  , $this->table);		
	
		return  $this->db->select($sql,['sid' => $sid], DBDriver::FETCH_ONE);
	//пишем $id как написано в передаче параметра, а не как будет отражено в запросе типа $id_article или другое подобное, передаем в третий параметр константу из класса DBDriver для выборки одной строки 
	}

}
