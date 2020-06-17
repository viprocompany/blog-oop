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
// метод , который проверяет массив $fields согласно переданному массиву правил $rules
	public function execute(array $fields)
	{
		// var_dump($this->rules);
		// die;
		if (!$this->rules) {
			// ошибка			
				
		}

		foreach ($this->rules as $name => $rules) {
     //если обязательного поля нет
		if (!isset($fields[$name]) && (null!==($rules['require'] || !$rules['require']) )) {
				continue;
			}
			//проверка на обязательность поля
			if (!isset($fields[$name]) && isset($rules['require'])) {
			$this->errors[$name] = sprintf('Поле %s обязательно!', $name);	
			}

			if (isset($fields[$name]) && ($fields[$name]=='')) {
			$this->errors[$name] = sprintf('Поле %s обязательно!', $name);	
			}     
			

			// if (isset($rules['type'])) {
			// 	if ($rules['type'] === 'string') {
			// 		$fields[$name] = trim(htmlspecialchars($fields[$name]));
			// 	} elseif ($rules['type'] === 'integer') {
			// 		if (!is_numeric($fields[$name])) {
			// 			$this->errors[$name][] = sprintf('Поле %s должно быть целым числом!',$name);
			// 		}
			// 	}
			// }
			  var_dump($this->errors);
      // die;

			if (empty($this->errors[$name])) {
				$this->clean[$name] = $fields[$name];
				$this->clean[$name] = sprintf(' %s OK!', $name);
			}
			 var_dump($this->clean);
      die;
		}
	}


}