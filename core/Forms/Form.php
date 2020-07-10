<?php
namespace core\Forms;

use core\Request;
use core\Exception\IncorrectDataException;

abstract class Form
 {
  protected $formName;
  protected $action;
  protected $method;
  protected $fields;

  public function getName()
  {
      return $this->formName;
  }
    
  public function getAction()
  {
    return $this->action;
  }

  public function getMethod()
  {
    return $this->method;
  }
   
    // возвращает итератор , то есть один  прогон цикла. нужно просто для ускорения работы, экономии памяти, так как если просто перебирать массив  только с помощью foreach создается копия , которая потом перебирается, а при пользовании ArrayIterator происходит переборка первоначального массива  , а не созддаваемой от него копии.
  public function getFields()
  {
    return new \ArrayIterator($this->fields);
  }
//проверяем соответствие полей формы , полям заданным в массиве класса SignUp
    public function handleRequest(Request $request)
    {
        $fields =[];
        $string = '';

        foreach($this->getFields() as $field){
            if(!isset($field['name'])) {
                continue;
            }
            $name = $field['name'];
            if (null !== $request->post($name)) {              
                $fields[$name] = $request->post($name);
            }
        }
//проверка сгенерированной подписи в поле sign формы, если хеш полученный при генерации формы совпадает с хешем отправляемой формы то все хорошо
        if(null !== $request->post('sign') && $this->getSign() !== $request->post('sign')){
        throw new IncorrectDataException('Формы не совпадают');  
        $e->addErrors($errors);
            // die('Формы не совпадают');
        }
        //выбираются только нужные ключи        
        return  $fields;
    }
//получить подпись, проверив существует ли там такой атрибут как name, и если он существует то через разделитель приклеиваем его к строке '/#@=@/'. После чего от этой строки получаем md5($string); Этот разделитель нужен как соль
    public function getSign()
    {
        $string ='';
        foreach($this->getFields() as $field){
            if(isset($field['name'])) {
                $string ='/#@=@/'. $field['name'];
            }
        }
        return md5($string);
    }

    public function addErrors(array $errors)
    {           

        foreach($this->fields as $key =>$field){
            $name = $field['name'] ?? null;
            if(isset($errors[$name])) {
                $this->fields[$key]['errors'] = $errors[$name];
            }
        }
      


    }


}