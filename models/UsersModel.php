<?php
namespace models;

use core\DBDriver;
use core\Validator;

class  UsersModel extends BaseModel
{
	//эти поля заданы в базовом в классе и задааются через конструктор
	// private $db;
	// private $table = 'users';
	// private $id_param = 'id_user';

	//задаем поля для запросов, которых нет  в конструкторе
	protected $name = 'name';
	protected $validator;
	protected $schema = [
		'id_user' => [
			'primary' => true
		],
	  	'name' => [
			'type' => 'string',
			'length' => [2, 50],
			'not_blank' => true,
			'require' => true
		]
	];

	public function __construct(DBDriver $db, Validator $validator)
	{
		parent::__construct($db,$validator, 'users','id_user');
		$this->validator->setRules($this->schema);
	}	

}