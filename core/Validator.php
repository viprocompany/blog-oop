<?php
namespace core;
class Validator
{
	public $clean = [];
	//массив с ошибками , если они  проявятся
	public $errors = [];
	//состояние безошибочности
	public $success = false;
	//правила валидации
	private $rules;

	//метод , который устанавливает правила
	public function setRules(array $rules)
	{
		$this->rules = $rules;
	}
	//метод проверка поля на пустоту
	public function isBlank($field)
	{
		$field = trim($field);
		return $field === null || $field === '';
	}
	
//метод проверки типа поля
	public function isTypeMatching($field, $type)
	{
		switch ($type) {
			case 'string':
			return is_string($field);
			break;

			case 'integer':
			return gettype($field) === 'integer' || ctype_digit($field);
			break;

			default:
		// error
			break;
		}
	}
//метод проверки корректности вводимых данных в  поля
	public function isCorrect($field, $type)
	{
		switch ($type) {
			case 'title':
			return preg_match('/^([а-яА-Яa-zA-ZёЁІіЇїЄєҐґ\'\d\-\s\!?;:.,-])/', $field);
			break;

			case 'content':
			return preg_match('/^([а-яА-Яa-zA-ZёЁІіЇїЄєҐґ\'\d\-\s\!?;:.,-])/', $field);
			break;

			case 'name':
			return preg_match('/^([а-яА-Яa-zA-ZёЁІіЇїЄєҐґ\'\d\-\s\:.,-])/', $field);
			break;
			default:
		// error
			break;
		}
	}

// метод для проверки количества вводимых символов
	public function isLengthMatch($field, $Length)
	{		
			//ищем максимум и минимум массива(если он массив)
		if($isArray = is_array($Length)){
			$max = isset($Length[1]) ? $Length[1] : false;
			$min = isset($Length[0]) ? $Length[0] : false;
		}
		else{
				//сначала проверяем чтобы значения переданные в массиве были целыми числами с помощью метода isTypeMatching
			if($this->isTypeMatching($Length,'integer')){
				$max = $Length;
				$min = false;
			}
			else{
				//error
				//в данном случае будет выскакивать ошибка как будто задано неправильное количество знаков, так как для сравнения из полученного массива будет подставлятся null, если в схеме в массиве значений задали любой тип кроме ineger
			}
		}

		if($isArray && (!$max || !$min)){
//error
		}
		if(!$isArray && !$max ){
//error
		}
		$maxIsMatch = $max ? $this->isLengthMaxMatch($field, $max) : false;
		$minIsMatch = $min ? $this->isLengthMinMatch($field, $min) : false;

		return $isArray ? $maxIsMatch && $minIsMatch : $maxIsMatch;
		
		//error
	}

//сравнеие максимума со значением заданном в массиве количества знаков $Length для применеия в методе isLengthMatch
	public function isLengthMaxMatch($field, $Length)
	{
		return mb_strlen($field) > $Length === false;
	}
//сравнеие минимума со значением заданном в массиве количества знаков $Length для применеия в методе isLengthMatch
	public function isLengthMinMatch($field, $Length)
	{
		return mb_strlen($field) < $Length === false;
	}

// метод , который проверяет массив $fields согласно переданному массиву правил $rules
	public function execute(array $fields)
	{
		// var_dump($this->rules);
		// die;
		if (!$this->rules) {
					// ошибка							
		}
		foreach ($this->rules as $name => $rules) {		
			
	//проверка на обязательность наличие поля
			if (!isset($fields[$name]) && isset($rules['require'])) {
				$this->errors[$name] = sprintf('Поле %s обязательно должно быть!', $name);	
			} 
			    // нет обязательного поля
			if (!isset($fields[$name]) && (null!==($rules['require'] || !$rules['require']))) {
				continue;
			}    	

//проверка типа данных  поля
			if (isset($rules['type']) && !$this-> isTypeMatching($fields[$name],$rules['type'])) {
				$this->errors[$name] = sprintf('Поле %s должно быть типа %s!', $fields[$name], $rules['type']);
			}		

  //проверка поля названия статьи, контента , автора или категории на корректность вводимых знаков с применением функции isCorrect
			if (isset($rules['correct']) && !$this-> isCorrect($fields[$name],$rules['correct'])) {
				$this->errors[$name] = sprintf('Поле %s   заполнено некорректным текстом !', $name);
			} 
							 //проверки количества вводимых символов
			if (isset($rules['length']) && !$this->isLengthMatch($fields[$name], $rules['length'])) {
				// var_dump($fields[$name]);
				$this->errors[$name] = sprintf('Поле %s должно корректное количество знаков!', $name);
			}	 
//проверка поля на пустоту с применением функции isBlank
			if (isset($rules['not_blank']) && $this-> isBlank($fields[$name])) {
				$this->errors[$name] = sprintf('Поле %s  не может быть пустым!', $name);
			}	

			if (empty($this->errors[$name])) {
				if(isset($rules['type']) && $rules['type'] === 'string'){
					$this->clean[$name] = htmlspecialchars(trim($fields[$name]));
				}
				elseif(isset($rules['type']) && $rules['type'] === 'integer'){
					$this->clean[$name] = (int)($fields[$name]);
				}
				else{
					$this->clean[$name] = $fields[$name];
				}
				
				$this->clean[$name] = sprintf(' %s OK!', $name);
			}
		}
		var_dump($this->errors);
		var_dump($this->clean);
		die;
	}	
}

	


// //метод-проверка корректности названия   статьи
// function correctTitle($title){
// 	$title = trim($title);
// 	return preg_match('/^([а-яА-Яa-zA-ZёЁІіЇїЄєҐґ\'\d\-\s\!?;:.,-])/', $title);			
// }

// //метод-проверка корректности имени автора статьи ли категории
// public static function correctName($name)
// 	{
// 	if((!preg_match('/^([а-яА-Яa-zA-ZёЁІіЇїЄєҐґ\'\d\-\s\:.,-])/', $name))){	
// 		return false;
// 	}	
// 	return true;
// 	}  

// //метод-проверка корректности контента текста статьи
// function correctContent($content){
// 	if(!preg_match('/^([а-яА-Яa-zA-ZёЁІіЇїЄєҐґ\'\d\-\s\!?;:.,-])/', $content))
// 	{	
// 		return false;
// 	}
// 	return true;
// }