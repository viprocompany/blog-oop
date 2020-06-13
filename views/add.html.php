<?php 
if($isAuth)
 { ?>
<h3>ДОБАВЛЕНИЕ НОВОЙ СТАТЬИ</h3>
<hr>
<form method="post">
	Название<br>
	<input type="text" name="title" value="<?php  echo $title; ?>"><br>
	ФИО автора<br>
	<select name="name" class="name inp" >
<!-- 		<option value="">
				Выбор автора		
		</option> -->
		<?php foreach ($names as $n) { ?>
			<option value="<?php echo $n['id_user'] ?>">
				<?php  echo $n['name']?> 				
			</option>
		<?php } ?>
	</select><br>
	Kатегория новости<br>
		<select name="id_category" class="id_category inp" >
	<!-- 		<option value="">
				Выбор категории новости		
		</option> -->
		<?php foreach ($categories as $n) { ?>
			<option value="<?php echo $n['id_category'] ?>">
				<?php  echo $n['title_category']?> 				
			</option>
		<?php } ?>
	</select><br>
	Изображение<br>
		<select name="image" class="img inp" >
			<option value="">
				Выбор изображения	
		</option>
		<?php foreach ($images as $f) { 	
			$images[] = $f;?>
			<option value="<?php echo $f ?>">
				<?php  echo $f?> 				
			</option>
	<?php } ?> 
	</select><br>
	Контент<br>
	<textarea name="content"><?php echo $content; ?></textarea><br>
	<input class="btn btn-success" type="submit" value="Добавить">
</form>
<?php } ?>
<p><?php echo $msg; ?></p>