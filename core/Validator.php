<?php
namespace core;

use core\Exception\ValidatorException;

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
			//error без перехвата на месте , здесь исключение только бросаем 
			throw new \Exception(' Incorerect type of data in method in method isTypeMatching! Некорректный тип данных !');	
			break;
		}
	}
//метод проверки корректности вводимых данных в  поля
	public function isCorrect($field, $type)
	{
		switch ($type) {
			case 'title':
			return preg_match('/^([а-яА-Яa-zA-ZёЁІіЇїЄєҐґ\&\%\'\$\d\-\s\!?;:.,-])/', $field);
			break;
			case 'text_name':
			return preg_match('/^([а-яА-Яa-zA-ZёЁІіЇїЄєҐґ\&\'\d\-\s\:.,-])/', $field);
			break;

				case 'user_name':
			return preg_match('/^([а-яА-Яa-zA-ZёЁІіЇїЄєҐґ\&\'\d\-\s\:.,-])/', $field);
			break;

				case 'category_name':
			return preg_match('/^([а-яА-Яa-zA-ZёЁІіЇїЄєҐґ\&\'\d\-\s\:.,-])/', $field);
			break;
	   case 'text_content':
			return preg_match('/^([а-яА-Яa-zA-ZёЁІіЇїЄєҐґ\&\%\'\$\d\-\s\!?;:.,-])/', $field);
			break;

			case 'content':
			return preg_match('/^([а-яА-Яa-zA-ZёЁІіЇїЄєҐґ\@\$\%\'\d\-\s\!?;:.,+*-])/', $field);
			break;

		case 'description':
			return preg_match('/^([а-яА-Яa-zA-ZёЁІіЇїЄєҐґ\@\$\%\'\d\-\s\!?;:.,+*-])/', $field);
			break;
			default:	
			return preg_match('/^([а-яА-Яa-zA-ZёЁІіЇїЄєҐґ0-9])/', $field);	
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
//error без перехвата на месте , здесь исключение только бросаем перехватываем его и обрабатываем его в контролеере индексного файла после try в catch
			throw new ValidatorException('Data is not INTEGER in method isLengthMatch! Некорректные данные использованы для расчета размера заполняемого поля!');
	// ЕСЛИ ИСКЛЮЧЕНИЕ НЕ ОТПРАВИТЬ в данном случае будет выскакивать ошибка как будто задано неправильное количество знаков, так как для сравнения из полученного массива будет подставлятся null, если в схеме в массиве значений задали любой тип кроме ineger
			}
		}

		if($isArray && (!$max || !$min)){
//error без перехвата на месте , здесь исключение только бросаем перехватываем его и обрабатываем его в контролеере индексного файла после try в catch
			throw new ValidatorException(' Incorerect data in method isLengthMatch! Некорректные данные использованы для расчета размера заполняемого поля!');	
		}
		if(!$isArray && !$max ){
//error без перехвата на месте , здесь исключение только бросаем перехватываем его и обрабатываем его в контролеере индексного файла после try в catch
			throw new ValidatorException('Not found data in method isLengthMatch! Нет данных  для расчетадлины заполняемого поля!');	
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
	// ПЕАРВЫЙ ВАРИАНТ без перехвата здесь, исключение летит выше по пути выполнения кода
		if (!$this->rules) {
//error без перехвата на месте , здесь исключение только бросаем перехватываем его и обрабатываем его в контролеере индексного файла после try в catch
			throw new ValidatorException(' Rules not found! Правило для этой сущности не найдено!');					
		}

//ДЛЯ ПРИМЕРА
//  ВТОРОЙ ВАРИАНТ перехватывае исключение здесь и обрабатываем его на метсте
		try{
			if (!$this->rules) {
				//бросаем исключение
				throw new ValidatorException(' Rules not found! Правило для этой сущности не найдено!');					
			}
		} //ловим исключение и
		catch (ValidatorException $e){
    //обрабатываем исключение
			var_dump($e-> getMessage());
		}

		
		foreach ($this->rules as $name => $rules) {		
		//все ошибки собираем в массив 		errors ,который будет цепляться к исключениям брошенным в методах add/insert в классе BaseModel , далее они будут пехвачены в соответсвующих контроллерах home в экшнах add/insert  и др. аналогично

	//проверка на обязательность наличие поля
			if (!isset($fields[$name]) && isset($rules['require'])) {
				$this->errors[$name] = sprintf('Поле %s обязательно должно быть!', $name);	
			} 
			    // нет обязательного поля
			if (!isset($fields[$name]) && (null!==($rules['require'] || !$rules['require']))) {
				continue;
			}    	
			//после применения заменителей все методы работают некорректно
		// if($name ==='title'){
		// 		$name = 'Название';
		// 	}
		// 	if($name ==='content'){
		// 		$name = 'Контент';
		// 	}
//проверка типа данных  поля
			if (isset($rules['type']) && !$this-> isTypeMatching($fields[$name],$rules['type'])) {
				$this->errors[$name] = sprintf('Поле %s должно быть типа %s!', $fields[$name], $rules['type']);
			}		

  //проверка поля названия статьи, контента , автора или категории на корректность вводимых знаков с применением функции isCorrect
			if (isset($rules['correct']) && !$this-> isCorrect($fields[$name],$rules['correct'])) {
				$this->errors[$name] = sprintf('Поле %s   заполнено некорректным текстом !', $name);
			} 

			// 				 //проверки количества вводимых символов
			if (isset($rules['length']) && !$this->isLengthMatch($fields[$name], $rules['length'])) {
				$this->errors[$name] = sprintf('Поле %s должно иметь корректное количество знаков!', $name);
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
		if(empty($this->errors)){
			$this->success = true;
		}
		// var_dump($this->errors);
		// var_dump($this->clean);
		// die;
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