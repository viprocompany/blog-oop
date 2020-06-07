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
		return $this->pdo->lastInsertId();
	}

	public function update($table, $id_param, $name, $name_new, $where)
	{
			$params = ([
		 	'p' => $name_new,
		 	'w' => $where
		 ]);
		$sql = sprintf('UPDATE  %s  SET %s= :p  WHERE %s= :w  ', $table ,  $name, $id_param );
		$stmt = $this->pdo->prepare($sql);
		return $stmt->execute( $params);
		// $this->pdo->lastInsertId()
	}

	public function delete($table, $where)
	{

	}
}