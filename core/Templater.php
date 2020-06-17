<?php 
namespace core;

use core\DBConnect;
use core\DBDriver;
use models\TextsModel;

class Templater
{
	public function statica()
	{
 //создаем объект для подключения к базе данных
  $db = DBConnect::getPDO();
//создаем новый объект СТАТИКА и через конструктор добавляем к нему передачей через параметр ранее созданный  объект  $db для подключения к базе данных. 
  $mTexts = new TextsModel(new DBDriver($db), new Validator());
//применяем к объекту метод из его класса и полученный массив будем добавлять в рендер страниц сайта
  $texts = $mTexts->getAll(' text_name ');
		// $id работает только отдельно ,  
  // $id = str_replace('$', '', 'text_name');
  //после вставки в array_column в значении  'text_name' не обрезает '$'
	$texts = array_column($texts, 'text_content', (str_replace('$', '', 'text_name')));
	 return $texts;

    // foreach ($texts as $text)
    // {   
    //   // $i[] = '';   
    //   $i = $text['text_name'];      
    //   $i = substr($i,1);
    //   // $t[] = ''; 
    //   $t = $text['text_content'];
    //   //??????после вызова на печать отображается почему-то массив только  с одним ключом-значением. в зависимости от местоположения в  цикле либо после него , показывает либо первый либо последний элемент массива
    //   $texts = array($i => $t);  
    //   // var_dump( $texts) ;
    //   return $texts;
    // } 

    
   }
}