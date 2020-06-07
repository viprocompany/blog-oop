<?php
namespace models;

use core\DBDriver;

abstract class BaseModel
{
	protected $db;
	protected $table;
	protected $id_param;

	public function __construct( DBDriver $db, $table='', $id_param='')
	{
		$this->db = $db;
		$this->table = $table;
		$this->id_param = $id_param;
	}

//проверка запроса на ошибки в теле запроса, используем константу безошибочности PDO::ERR_NONE, которая равна 00000, и будет сравниваться с массивом по разбору возможных ошибок. константу вместо её значения 00000 используем потому, что с обновлением версии PHP её значение может измениться на другое.
	public static function check_error($query){
		$info = $query->errorInfo();
//если данные из массива возможных ошибок не равны константе PDO::ERR_NONE, то есть при наличии ошибки скрипт прекращает свою работу
		if($info[0] != \PDO::ERR_NONE){
			exit($info[2]);
		}
	}

//функция работы с запросом, в параметре передается тело запроса и параметры для подстановки в тело запроса в виде массива(по умолчанию пустой, и поэтому не всегда указывается )
	public	function dbQuery($sql, $params = []){
//подготовка запроса
		$stmt = $this->db->prepare($sql);
//готовый выполненный запрос с параметрами , который можно впоследствии выводить для SELECT с помощью fetch , fetchAll
		$stmt->execute($params);
//проверка тела запроса на ошибки с помощью функции db_check_error
		self::check_error($stmt); 
		return $stmt;
	}

	public function getAll($order)
	{
		$sql= ("SELECT *  FROM " . $this->table . " ORDER BY " . $order
	) ;		
		return $this->db->select($sql);
	}

	public function getById( $id )
	{		
		$sql = sprintf('SELECT * FROM  %s  WHERE  %s= :id '  , $this->table, $this->id_param);		
		// $sql = ("SELECT * FROM " . $this->table . " WHERE  " . $this->id_param . "= :id");
		return  $this->db->select($sql,['id' => $id], DBDriver::FETCH_ONE);
	//пишем $id как написано в передаче параметра, а не как будет отражено в запросе типа $id_article или другое подобное, передаем в третий параметр константу из класса DBDriver для выборки одной строки 
	}



	public function add(array $params)
	{
		
		return $this->db->insert($this->table, $params);
	}


  	public function edit(array $params,  $id)
  	{
  		return $this->db->update($this->table, $this->id_param, $params, $id);
  	}


	public  function deleteById($id)
	{
		$sql = sprintf('DELETE FROM  %s  WHERE  %s= :i '  , $this->table, $this->id_param);
		self::dbQuery($sql,[			
			'i'=>$id
	//пишем $id как написано в передаче параметра, а не как будет отражено в запросе типа $id_article или другое подобное
		]);
		return ;	
	}
//проверка наличия ДОБАВЛЯЕМОГO поля УНИВЕРСАЛЬНАЯ
function correctOrigin($id, $table, $param, $text){
	$sql = ("SELECT  $id FROM $table  WHERE $param = :t");
//переменная айдишника для имени и фамилии автора
	 $id_original = $this->db->select($sql,['t'=>$text], DBDriver::FETCH_ONE);
	//если айдишник не пустой значит такой автор уже есть
	if (!$id_original == "")
	{
			Helper::errors('Название занято!');
		return false;
	}
	return true;
}

//УНИВЕРСАЛЬНАЯ проверка корректности получаемого айдишника сущности, то есть его наличие
function correctId($text, $table, $param, $id ){
	//получаем массив айдишников категории новости
	$sql = ("SELECT $text FROM $table WHERE $param = '$id';");
	//пременаая с названием категории
  $stmt=$this->db->select($sql); 		
//если переданного айдишника нет, значит нет и категории(пустая),  значит пишем ошибку
	if($stmt == "")
	{
		Helper::errors('Неверный выбор, введите корректный параметр !');
		return false;
	}
	return true;
}

}