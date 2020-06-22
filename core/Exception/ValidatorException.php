<?php 
namespace core\Exception;
//нужен для формирования исключений, котрые будут отправляться методами isLengthMatch, execute класса Validator для дальнейшей  отправки в индексный файл
class ValidatorException extends \Exception {

}