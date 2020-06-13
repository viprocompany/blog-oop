<?php

namespace core;

use models\BaseModel;

class DBDriver
{
		//constants for use in function select, insert and other
	const FETCH_ALL = 'all';
	const FETCH_ONE = 'one';

	private $pdo;

	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
	}

	public function select($sql, array $params = [], $fetch = FETCH_ALL)
	{		
		$stmt = $this->pdo->prepare($sql);	
		$stmt->execute($params);		
		BaseModel::check_error($stmt); 	
// 		 $fetch === self::FETCH_ALL ? $stmt->fetchAll() : $stmt->fetch();
// return $stmt;
		if($fetch === self::FETCH_ONE){
			return $stmt->fetch(); 	
		}
		else{
			$stmt = $stmt->fetchAll();
			return  $stmt;
		}
	}
	public function insert($table, array $params)
	{
		$columns = sprintf('(%s)', implode(', ', array_keys($params)));
		$masks = sprintf('(:%s)', implode(', :', array_keys($params)));
		$sql = sprintf('INSERT INTO %s %s VALUES %s', $table, $columns, $masks);
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute($params);
		BaseModel::check_error($stmt); 	
		return $this->pdo->lastInsertId();
	}

		public function update($table, $id_param, array $params,  $id)
	{
		$param = [];	
		foreach($params as $k => $v) {
            $param[] = "$k = :$k";
        }      
		$names = sprintf('%s', implode(', ', $param));
		$where =   ($id_param ." = " . $id) ;  
		$sql = sprintf('UPDATE %s SET %s WHERE %s', $table, $names , $where);
    	$query = $this->pdo->prepare($sql);
    	$query->execute($params);    	
    	BaseModel::check_error($query); 	
    	//база не хочет выдавать последний введенный айди
    	\core\DBConnect::getPDO();
    	return $this->pdo->LastInsertId();
	}

	

	public function delete($table,$id_param, $id)
	{
			$sql = sprintf('DELETE FROM  %s  WHERE  %s= :id '  , $table, $id_param);
		$stmt = $this->pdo->prepare($sql);	
		$stmt->execute(['id' => $id]);		
		BaseModel::check_error($stmt); 
		return ;
	}
}