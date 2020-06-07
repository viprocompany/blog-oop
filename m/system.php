<?php
//функция для вывода шаблона . в переменной $filename передаем название файла для которого формируем шаблон: add, edit, post или др. В переменной $vars  передаем массив  параметров , значение которых будет выводится в HTML-разметке и которые нужны для вывода этих элементов в разметку(например название переменной которое используется в циклах foreach  и разбивается в дальнейшем на элементы)
function template($filename, $vars = [])
{
  // с помощью extract массив $vars преобразуется в ассоциативный массив типа:   'title' => $title,'date' => $date. В таком же виде он передается в переменной $vars саму функцию  template.
extract($vars);
//открываем буферизацию 
ob_start();
include "v/$filename.php";
//функция возвращает содержимое буфера(include "v/$filename.php";) и затем очищает его
return ob_get_clean();
}