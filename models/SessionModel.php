<?php
namespace models;

use core\DBDriver;
use core\Validator;
use core\Exception\IncorrectDataException;

class SessionModel extends BaseModel
{
	protected $validator;
	protected $schema = [
		'id' => [
			'primary' => true
		],
		'id_login' => [
			'type' => 'itneger',
			'length' => [1, 11],
			'not_blank' => true,
			'require' => true
		],
		'sid' => [
			'type' => 'string',
			'length' => [1, 10],
			'require' => true,
			'not_blank' => true				
		],
				'created_at' => [						
		],
				'updated_at' => [			
		]
	];

public function __construct(DBDriver $db, Validator $validator)
	{
		parent::__construct($db, $validator, 'sessions');
		$this->validator->setRules($this->schema);
	}	

		public function getBySid($login)
	{		
		$sql = sprintf('SELECT sid   FROM   %s JOIN  logins ON `sessions.id_login` = `logins.id_login`    WHERE  login= :login '  , $this->table);		
	
		return  $this->db->select($sql,['login' => $login], DBDriver::FETCH_ONE);
	//пишем $id как написано в передаче параметра, а не как будет отражено в запросе типа $id_article или другое подобное, передаем в третий параметр константу из класса DBDriver для выборки одной строки 
	}
}