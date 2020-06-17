<?php
namespace models;

use core\DBDriver;
use core\Validator;

class AllTablesModel extends BaseModel
{
	//эти поля заданы в базовом в классе и задааются через конструктор
	// private $db;
	// private $table = 'article INNER JOIN categories ON article.id_category = categories.id_category INNER JOIN users ON  users.id_user = article.id_user';
	// private $id_param = 'id_article'; 

//задаем поля для запросов, которых нет  в конструкторе
	protected $title = 'title';
	protected $content = 'content';
	protected $id_user = 'id_user';
	protected $id_category = 'id_category';
	protected $img = 'img';
	protected $validator;
	protected $schema = [
		'id_article' => [
			'primary' => true
		],
		'title' => [
			'type' => 'string',
			'length' => [2, 150],
			'not_blank' => true,
			'require' => true
		],
		  'content' => [
			'type' => 'string',
			'length' => 'big',
			'require' => true,
			'not_blank' => true,
			'type' => 'integer',
		],
			'id_user' => [
			'require' => true
		],
			'id_category' => [
			'require' => true
		],
			'img' => [		
		]
	];

	public function __construct(DBDriver $db, Validator $validator)
	{
		parent::__construct($db,$validator,'article INNER JOIN categories ON article.id_category = categories.id_category INNER JOIN users ON  users.id_user = article.id_user', 'id_article');
		$this->validator->setRules($this->schema);
	}	
	//создание статьи путем вставки запроса и массива значений для подстановки в запрос С ПОЛУЧЕНИЕМ ЗНАЧЕНИЯ ПОСЛЕДНЕГО ВВЕДЕННОГО АЙДИШНИКА СТАТЬИ
	// public  function addArticle($title, $content, $id_user, $id_category, $img)
	// {		
 //  $sql = sprintf("INSERT INTO `article` ( `%s`,`%s`,`%s`,`%s`,`%s`) VALUES (:t,:c,:us,:cat, :i)",  $this->title, $this->content, $this->id_user, $this->id_category, $this->img, $this->img );
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

	// public  function updateArticle($title, $content, $id_user, $id_category,  $img, $id)
	// {	
	// 	// $query =	self::dbQuery($sql, $params);
	// 	$sql = sprintf('UPDATE  `article`  SET %s=:t, %s=:c,   %s=:us, %s=:cat , %s=:i   WHERE %s= :new  ', $this->title, $this->content, $this->id_user, $this->id_category, $this->img,  $this->id_param );
	// 	$query = self::dbQuery($sql,[
 //     't'=>$title,
	// 		'c'=>$content,
	// 		'us'=>$id_user,
	// 		'cat'=>$id_category,
	// 		'i'=>$img,
	// 		'new'=>$id			
 //    ]);
	// 	$query = $query->fetchAll();
	// 	\core\DBConnect::getPDO();
	// 	return $id;
	// }
}