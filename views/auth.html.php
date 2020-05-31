<?php 
if(!$isAuth){?>
		<!-- ссылка для добавления статьи авторизованным пользователем -->
<!-- <p><a class="btn btn-success" href="index.php?c=login">Вход </a></p> -->
<p><a class="btn btn-success" href="<?php echo ROOT?>login">Вход </a></p>
<?php }
elseif($isAuth)
{ ?><!-- приветствие аутентифицированного пользователя  -->
	<h4>Добро пожаловать, <?php echo $login;?> !</h4>
	<!-- ссылка для выхода авторизованного пользователя -->

<p><a class="btn btn-outline-danger" href="<?php echo ROOT?>login">Выход</a></p><br>
					<!-- после подключения правил перезаписи в файле .htaccess делаем урлы человекочитаемыми    , так как теперь в индексном файле страницы при получении из строки(массив гет) значение элемента home , будет происходить соответственно вызов контролера home 
								<?php echo ROOT?> используем для указания корня сайта , задаем с индексной страницы-->
						<p><a class="btn btn-outline-primary" href="<?php echo ROOT?>home">Статьи</a></p>
		
						<p><a class="btn btn-outline-primary" href="<?php echo ROOT?>user">Авторы  </a></p>
		
						<p><a  class="btn btn-outline-primary" href="<?php echo ROOT?>category">Категории</a></p>
		
						<p><a  class="btn btn-outline-primary" href="<?php echo ROOT?>text">Тексты</a>	</p>
				<hr>
	<!-- ссылка для добавления статьи авторизованным пользователем -->

<a class=" btn btn-outline-info" href="<?php echo ROOT?>add">Добавить  статью</a>

		<a class=" btn btn-outline-info"  href="<?php echo ROOT?>add-user">Добавить автора</a>
				<a class=" btn btn-outline-info" href="<?php echo ROOT?>add-category">Добавить категорию</a>
		
	
		<a class=" btn btn-outline-info" href="<?php echo ROOT?>add-text
			">Добавить текст</a>
<?php } ?>
<!-- <p><?php echo $msg?></p> -->

