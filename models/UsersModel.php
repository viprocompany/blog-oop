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
		// 'id_article' => [
		// 	'primary' => true
		// ],

		// 'title' => [
		// 	'type' => 'string',
		// 	'length' => [2, 150],
		// 	'not_blank' => true,
		// 	'require' => true
		// ],

		//   'content' => [
		// 	'type' => 'string',
		// 	'length' => 'big',
		// 	'require' => true,
		// 	'not_blank' => true,
		// 	'type' => 'integer',
		// ],

		// 	'name' => [
		// 	'require' => true
		// ],

		// 	'title_category' => [
		// 	'require' => true
		// ],

		// 	'img' => [
		
		// ]


	];

public function __construct(DBDriver $db, Validator $validator)
	{
		parent::__construct($db,$validator, 'users','id_user');
		$this->validator->setRules($this->schema);
	}
	
//создание статьи путем вставки запроса и массива значений для подстановки в запрос С ПОЛУЧЕНИЕМ ЗНАЧЕНИЯ ПОСЛЕДНЕГО ВВЕДЕННОГО АЙДИШНИКА
	public  function addUser($name)
	{		
  $sql = sprintf("INSERT INTO %s ( `%s`) VALUES (:n)", $this->table ,  $this->name);
		self::dbQuery($sql, ['n'=>$name]);
		\core\DBConnect::getPDO();
		return $this->db->lastInsertId();
	}

	public  function updateUser($name,$id)
	{	
		// $query =	self::dbQuery($sql, $params);
		$sql = sprintf('UPDATE  %s  SET %s= :n  WHERE %s= :i  ', $this->table ,  $this->name, $this->id_param );
		$query = self::dbQuery($sql,[
      'n'=>$name,
      'i'=>$id
    ]);
		$query = $query->fetchAll();
		\core\DBConnect::getPDO();
		return $query;
	}


}