<?php  
namespace controller;

class ErrorController extends BaseController
{
	public function indexAction()
	{

		$this->title .=': Ошибка 404';
//для вызова
		$this->content = $this->build('errors', [	]);
		//отправляем загаолвок об ошибке - отсутствие страницы. нужно для поисковых роботов
		header("HTTP/1.0 404 Not Found");
	}

}