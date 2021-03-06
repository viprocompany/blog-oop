<?php
if (!$isAuth) { ?>
	<!-- <p><a class="btn btn-success btn-menu" href="<?php echo ROOT ?>login">Вход </a></p> -->
	<p><a class="btn btn-success btn-menu" href="<?php echo ROOT ?>logins/sign-up">Регистрация </a></p>
	<p><a class="btn btn-success btn-menu" href="<?php echo ROOT ?>logins/login">Авторизация </a></p>
<?php }
if ($isAuth) { ?>
	<!-- приветствие аутентифицированного пользователя  -->
	<h4>Добро пожаловать, <?php echo $login; ?> !</h4>
	<!-- ссылка для выхода авторизованного пользователя -->
	<p><a class="btn btn-danger btn-menu" href="<?php echo ROOT ?>logins/login">Выход</a></p><br>
	<!-- после подключения правил перезаписи в файле .htaccess делаем урлы человекочитаемыми    , так как теперь в индексном файле страницы при получении из строки(массив гет) значение элемента home , будет происходить соответственно вызов контролера home 
						<?php echo ROOT ?> используем для указания корня сайта , задаем с индексной страницы-->
	<p><a class="btn btn-outline-primary btn-menu" href="<?php echo ROOT ?>home">Статьи</a></p>
	<p><a class="btn btn-outline-primary btn-menu" href="<?php echo ROOT ?>user">Авторы </a></p>
	<p><a class="btn btn-outline-primary btn-menu" href="<?php echo ROOT ?>category">Категории</a></p>
	<p><a class="btn btn-outline-primary btn-menu" href="<?php echo ROOT ?>text">Тексты</a></p>
	<hr>
	<!-- ссылка для добавления статьи авторизованным пользователем -->

	<a class=" btn btn-outline-info btn-add" href="<?php echo ROOT ?>home/add">Добавить статью</a>

	<a class=" btn btn-outline-info btn-add" href="<?php echo ROOT ?>user/add">Добавить автора</a>
	<a class=" btn btn-outline-info btn-add" href="<?php echo ROOT ?>category/add">Добавить категорию</a>
	<a class=" btn btn-outline-info btn-add" href="<?php echo          ROOT ?>text/add
							">Добавить текст</a>
<?php } ?>
<!-- <p><?php echo $msg ?></p> -->