<?php
namespace models;

use core\DBDriver;
use core\Validator;

class TextsModel extends BaseModel
{		//эти поля заданы в базовом в классе и задааются через конструктор
	// private $db;
	// private $table = 'texts';
	// private $id_param = 'id_text';

	//задаем поля для запросов, которых нет  в конструкторе
	protected $text_name = 'text_name';	
	protected $text_content = 'text_content';
	protected $description = 'description';
protected $validator;
	protected $schema = [
		'id_text' => [
			'primary' => true
		],

		'text_name' => [
			'type' => 'string',
			'length' => [3, 30],
			'not_blank' => true,
			'require' => true
		],

		  'text_content' => [
			'type' => 'string',
			'length' => [3, 150],
			'require' => true,
			'not_blank' => true
			
		],

			'description' => [
				'require' => true,
			'length' => [3, 500],
			'not_blank' => true
		]	


	];

	public function __construct(DBDriver $db, Validator $validator)
	{
		parent::__construct($db,$validator, 'texts','id_text');
		$this->validator->setRules($this->schema);
	}	

		public  function addText($text_name, $text_content, $description)
	{		
  $sql = sprintf("INSERT INTO %s ( `%s`, `%s`,  `%s`) VALUES (:n ,:c, :d)", $this->table , $this->text_name , $this->text_content,  $this->description);
		self::dbQuery($sql, [
			'n'=>$text_name,
			'c'=>$text_content,
			'd'=>$description
		]);
		\core\DBConnect::getPDO();
		return $this->db->lastInsertId();
	}

	public  function updateText($id,$text_name,$text_content,$description)
	{	
		// $query =	self::dbQuery($sql, $params);
		$sql = sprintf('UPDATE  %s  SET %s= :n ,%s= :c , %s= :d  WHERE %s= :i  ', $this->table , $this->text_name ,  $this->text_content, $this->description, $this->id_param );
		$query = self::dbQuery($sql,[
			'n'=>$text_name,
      'c'=>$text_content,
      'i'=>$id,
			'd'=>$description
    ]);
		$query = $query->fetchAll();
			\core\DBConnect::getPDO();
		return $id;
	}
}