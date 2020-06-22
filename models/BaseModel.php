<?php
namespace models;

use core\DBDriver;
use core\Validator;
use core\Exception\IncorrectDataException;

abstract class BaseModel
{
	protected $db;
	protected $table;
	protected $id_param;
	protected $validator;

	public function __construct( DBDriver $db, Validator $validator, $table='', $id_param='')
	{
		$this->db = $db;
		$this->validator = $validator;
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
		//обращаемся к валидатору через функцию его класса  execute, которая проверяет соответствие полей заданной СХЕМЕ
			$this->validator->execute($params);
//если валидация прошла неуспешно выводим ошибку 
			if (!$this->validator->success) {
			// бросаем ошибку с полученным массивом errors   из метода execute класса Validator, далее она летит в контроллер индексного файла
				throw new IncorrectDataException($this->validator->errors);
				$this->validator->errors;
			}

		return $this->db->insert($this->table, $params);
	}

  	public function edit(array $params,  $id)
  	{
  				//обращаемся к валидатору через функцию его класса  execute, которая проверяет соответствие полей заданной СХЕМЕ
			$this->validator->execute($params);
//если валидация прошла неуспешно выводим ошибку 
			if (!$this->validator->success) {
			// бросаем ошибку с полученным массивом errors   из метода execute класса Validator, далее она летит в контроллер индексного файла
				throw new IncorrectDataException($this->validator->errors);
				$this->validator->errors;
			}
  		return $this->db->update($this->table, $this->id_param, $params, $id);
  	}

	public  function deleteById($id)
	{	
		return  $this->db->delete($this->table, $this->id_param, $id);
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