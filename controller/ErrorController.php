<?php  
namespace controller;

class ErrorController extends BaseController
{
	public function indexAction()
	{

		$this->title .=': Ошибка 404';
//для вызова
		$this->content = $this->build(__DIR__ . '/../views/errors.html.php', [	]);
	}

}