<?php  
if($isAuth) {
	//проходим циклом по массиву чтоб достать нужные нам поля таблицы
	foreach ($users as $user) {
		$id_user = $user['id_user'];
		?>
		<span>ФИО: <strong><?=$user['name']?></strong></span> 
	<!-- 	<span>порядковый нормер: </span><strong> <?=$user['id_user']?></strong> -->
		
				<!-- старые ссылки до приведение к человекочитаемым урлам ЧПУ -->
		<!-- 		<a class="btn btn-outline-warning" href="index.php?c=edit-user&id_user=<?=$id_user?>">Изменить</a> -->
				<a class="btn btn-outline-warning" href="<?php echo ROOT?>user/edit/<?=$id_user?>">Изменить</a>
				
	   <a class="btn btn-outline-danger"  id="delete" onclick="if (!confirm('Удалить автора:  <?=$user['name']?> ?')) return false  " href="<?php echo ROOT?>user/delete/<?=$id_user?>"   >Удалить</a>
		<hr>
	<?php	}
	 } 