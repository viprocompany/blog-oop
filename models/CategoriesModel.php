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

		// 	'id_user' => [
		// 	'require' => true
		// ],

		// 	'id_category' => [
		// 	'require' => true
		// ],

		// 	'img' => [
		
		// ]


	];

	public function __construct(DBDriver $db, Validator $validator)
	{
		parent::__construct($db,$validator, 'categories','id_category');
	}
	
	public  function addCategory($title_category)
	{		
  $sql = sprintf("INSERT INTO %s ( `%s`) VALUES (:n)", $this->table ,  $this->title_category);
		self::dbQuery($sql, ['n'=>$title_category]);
		\core\DBConnect::getPDO();
		return $this->db->lastInsertId();
	}

	public  function updateCategory($title_category,$id)
	{	
		// $query =	self::dbQuery($sql, $params);
		$sql = sprintf('UPDATE  %s  SET %s= :n  WHERE %s= :i  ', $this->table ,  $this->title_category, $this->id_param );
		$query = self::dbQuery($sql,[
      'n'=>$title_category,
      'i'=>$id
    ]);
		$query = $query->fetchAll();
			\core\DBConnect::getPDO();
		return $id;
	}
}