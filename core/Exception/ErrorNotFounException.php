<?php 
namespace core\Exception;
//нужен для формирования исключений, котрые будут отправляться как 404
class ErrorNotFounException extends \Exception
{
	public function __construct($message = 'Такой страницы нет!!!!!', $code = 404){
 
		parent::__construct($message,$code);
	}
}