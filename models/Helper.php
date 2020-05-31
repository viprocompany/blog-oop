<?php
namespace models;

class Helper 
{	
	
//функция для передачи последней ошибки
function errors($msg = null)
{
	//делаем статику, что бы ошибка могла сохраниться и её описание могло передаться по запросу в место вызова
	static $last_erorr = '';
	if($msg !== null)
	{
		$last_erorr = $msg;
	}	
	else
	{
		return $last_erorr;
	}
}

//проверка корректности названия новой статьи
function newCorrectTitle($title){
	$title = trim($title);
	if($title == '' )
	{		//вызываем функцию и передаем параметром сообщение
		self::errors('Заполните название!');
		return false;
	}
	elseif(!(mb_strlen($title) > 1 && mb_strlen($title) < 31))
	{
		self::errors('Oт двух до тридцати знаков в названии!');
		return false;
	}
	//используем функцию c регулярным выражением на проверку названия  файла 
	elseif(!preg_match('/^([а-яА-Яa-zA-ZёЁІіЇїЄєҐґ\'\d\-\s\!?;:.,-])/', $title))
	{
		self::errors('Введите корректное название !');
		return false;
	}
	else{
		// return preg_match('/^([A-Za-z0-9_!\-\.])+$/', $title);
		return true;
	}	
}

//проверка корректности имени автора статьи ли категории
public static function correctName($name)
	{
		if(mb_strlen($name)<2)
	{
		self::errors('Не менее двух знаков!');
		return false;
	}
	elseif((!preg_match('/^([а-яА-Яa-zA-ZёЁІіЇїЄєҐґ\'\-])/', $name))){
		self::errors('Ввести корректные имя и фамилию !');
		return false;
	}	
	return true;
	}


//проверка корректности названия существующей  статьи
function correctTitle($title){
	$title = trim($title);
	return preg_match('/^([а-яА-Яa-zA-ZёЁІіЇїЄєҐґ\'\d\-\s\!?;:.,-])/', $title);			
}

//проверка корректности контента текста статьи
function correctContent($content){
	if(mb_strlen($content)<100 || (!preg_match('/^([а-яА-Яa-zA-ZёЁІіЇїЄєҐґ\'\d\-\s\!?;:.,-])/', $content)))
	{
		self::errors('Не менее ста знаков  и корректный текст в контенте!');
		return false;
	}
	return true;
}

}