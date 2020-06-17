<?php
namespace models;

use core\DBDriver;
use core\Validator;

class PostModel extends BaseModel
{
	//эти поля заданы в базовом в классе и задааются через конструктор
	// private $db;
	// private $table = 'article';
	// private $id_param = 'id_article';
	protected $validator;
	protected $schema = [
		'id_article' => [
			'primary' => true
		],
		'title' => [
			'type' => 'string',
			'length' => [5, 150],
			'not_blank' => true,
			'require' => true
		],
		  'content' => [
			'type' => 'string',
			'length' => 'big',
			'require' => true,
			'not_blank' => true,
			'type' => 'integer'
		],
			'id_user' => [
			'require' => true,
			'type' => 'integer'
		],
			'id_category' => [
			'require' => true,
			'type' => 'integer'
		],
			'img' => [		
		]
	];

	public function __construct(DBDriver $db, Validator $validator)
	{
			parent::__construct($db, $validator, 'article','id_article');
			$this->validator->setRules($this->schema);
	}	
  

	//задаем поля для запросов, которых нет  в конструкторе
	// protected $title = 'title';
	// protected $content = 'content';
	// protected $id_user = 'id_user';
	// protected $id_category = 'id_category';
	// protected $img = 'img';

 //  	public  function addPost($title, $content, $id_user, $id_category, $img)
	// {		
 //  $sql = sprintf("INSERT INTO %s ( `%s`,`%s`,`%s`,`%s`,`%s`) VALUES (:t,:c,:us,:cat, :i)", $this->table, $this->title, $this->content, $this->id_user, $this->id_category, $this->img, $this->img );

	// 	self::dbQuery($sql, [
	// 		't'=>$title,
	// 		'c'=>$content,
	// 		'us'=>$id_user,
	// 		'cat'=>$id_category,
	// 		'i'=>$img
	// 	]);
	// 	\core\DBConnect::getPDO();
	// 	return $this->db->lastInsertId();
	// }

	// public  function updatePost($title, $content, $id_user, $id_category,  $img, $id)
	// {	
	// 	// $query =	self::dbQuery($sql, $params);
	// 	$sql = sprintf('UPDATE  %s  SET %s=:t, %s=:c,   %s=:us, %s=:cat , %s=:i   WHERE %s= :new  ',  $this->table, $this->title, $this->content, $this->id_user, $this->id_category, $this->img,  $this->id_param );
	// 	$query = self::dbQuery($sql,[
 //     't'=>$title,
	// 		'c'=>$content,
	// 		'us'=>$id_user,
	// 		'cat'=>$id_category,
	// 		'i'=>$img,
	// 		'new'=>$id			
 //    ]);
	// 	$query = $query->fetchAll();
	// 		\core\DBConnect::getPDO();
	// 			return $id;
	// }
}