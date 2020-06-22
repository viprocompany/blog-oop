<?php 
namespace core\Exception;
//класс нужен для обработки исключений отправляемых из BaseModel  и отловленных  контроллерами классов home, user,texts,category
class IncorrectDataException extends \Exception 
{
	private $errors;
//добавляем в конструктор массив ошибок из валидатора errors
	public  function __construct($errors)
	{
		parent::__construct('');
		$this->errors = $errors;
	}
//полученный массив ошибок из валидатора ,которые были взяты исключением брошенным в методах add/insert в BaseModel  и отправлены в контроллеры home ,user,text,category , где после перхвата обраблтаны и выведены на печать в представлении экшна add/edit
	public function getErrors()
	{
		return $this->errors;
	}
}