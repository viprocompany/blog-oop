<?php
namespace models;

class TextsModel extends BaseModel
{		//эти поля заданы в базовом в классе и задааются через конструктор
	// private $db;
	// private $table = 'texts';
	// private $id_param = 'id_text';

	//задаем поля для запросов, которых нет  в конструкторе
	protected $text_name = 'text_name';	
	protected $text_content = 'text_content';
	protected $description = 'description';

	public function __construct(\PDO $db)
	{
		parent::__construct($db, 'texts','id_text');
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