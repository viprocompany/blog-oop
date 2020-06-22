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
			'length' => [3, 100],
			'not_blank' => true,
			'require' => true,
			'correct' => 'title'

		],
		  'content' => [
			'type' => 'string',
			'length' => [100, 20000],
			'require' => true,
			'not_blank' => true,
			'correct' => 'content'
			
		],
			'id_user' => [
			'require' => true,
			'not_blank' => true,
			'type' => 'integer'
		],
			'id_category' => [
			'not_blank' => true,
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
  
}