<?php
namespace models;

use core\DBDriver;
use core\Validator;

class  CategoriesModel extends BaseModel
{
		//эти поля заданы в базовом в классе и задааются через конструктор
	// private $db;
	// private $table = 'categories';
	// private $id_param = 'id_categoriy';

	//задаем поля для запросов, которых нет  в конструкторе
	protected $title_category = 'title_category';
	protected $validator;
	protected $schema = [
		'id_category' => [
			'primary' => true
		],
		'title_category' => [
			'type' => 'string',
			'length' => [2, 50],
			'not_blank' => true,
			'require' => true
		]
	];

	public function __construct(DBDriver $db, Validator $validator)
	{
		parent::__construct($db,$validator, 'categories','id_category');
		$this->validator->setRules($this->schema);
	}
	// //создание статьи путем вставки запроса и массива значений для подстановки в запрос С ПОЛУЧЕНИЕМ ЗНАЧЕНИЯ ПОСЛЕДНЕГО ВВЕДЕННОГО АЙДИШНИКА
	// public  function addCategory($title_category)
	// {		
	// 	$sql = sprintf("INSERT INTO %s ( `%s`) VALUES (:n)", $this->table ,  $this->title_category);
	// 	self::dbQuery($sql, ['n'=>$title_category]);
	// 	\core\DBConnect::getPDO();
	// 	return $this->db->lastInsertId();
	// }

	// public  function updateCategory($title_category,$id)
	// {	
	// 	// $query =	self::dbQuery($sql, $params);
	// 	$sql = sprintf('UPDATE  %s  SET %s= :n  WHERE %s= :i  ', $this->table ,  $this->title_category, $this->id_param );
	// 	$query = self::dbQuery($sql,[
	// 		'n'=>$title_category,
	// 		'i'=>$id
	// 	]);
	// 	$query = $query->fetchAll();
	// 	\core\DBConnect::getPDO();
	// 	return $id;
	// }
}