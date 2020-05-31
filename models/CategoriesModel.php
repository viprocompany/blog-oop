<?php
namespace models;

class  CategoriesModel extends BaseModel
{
		//эти поля заданы в базовом в классе и задааются через конструктор
	// private $db;
	// private $table = 'categories';
	// private $id_param = 'id_categoriy';

	//задаем поля для запросов, которых нет  в конструкторе
	protected $title_category = 'title_category';
	
	public function __construct(\PDO $db)
	{
		parent::__construct($db, 'categories','id_category');
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