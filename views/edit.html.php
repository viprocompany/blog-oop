
<?php 
if($isAuth) { ?>
<h4>РЕДАКТИРОВАНИЕ СТАТЬИ</h4>
<form method="post">	
	<p><span>Номер статьи: </span><?php  echo $id_article; ?></p>	
	Название статьи: <br>
	<input type="text" name="title" value="<?php  echo $title; ?>"><br>
	АВТОР : <br>
	<select name="name" class="name inp" >
		<option  value="<?php echo $id_user ?>"><?php echo $name?></option>
		<?php foreach ($names as $n) { ?>
			<option  value="<?php echo $n['id_user'] ?>">
				<?php  echo $n['name']?> 				
			</option>
		<?php } ?>
	</select><br>
	КАТЕГОРИЯ: <br>
	<select name="id_category" class="id_category inp" >
		<option value="<?php echo $id_category ?>">
			<?php echo $title_category ?></option>
		<?php foreach ($categories as $n) { ?>
			<option value="<?php echo $n['id_category'] ?>">
				<?php  echo $n['title_category']?> 				
			</option>
		<?php } ?>
	</select><br>
	ИЗОБРАЖЕНИЕ: <br>
		<select name="image" class="img inp" >
			<option value="<?php echo $img ?>">
				<?php echo $img ?></option>
		<?php foreach ($images as $f) { 	
			$images[] = $f;?>
			<option value="<?php echo $f ?>">
				<?php  echo $f?> 				
			</option>
	<?php } ?> 
	</select><br>
	КОНТЕНТ: <br>
	<textarea name="content"><?php echo $content; ?></textarea><br>
	<input class="btn btn-success" type="submit" value="Применить">
</form>
<p><?php echo $msg; ?></p>
<?php } 