<?php 
if($isAuth)
	{ ?>
		<h3>ДОБАВЛЕНИЕ НОВОЙ СТАТЬИ</h3>
		<hr>
		<form method="post" class="form form_add">
			<div class="line">
				<label class="label" >
					<span class="title" for="title">Название</span>	
					<input type="text" name="title" class="inp title_art" value="<?php  echo $title; ?>">
				</label><br>
			</div>

			<div class="line">
				<label class="label" >
					<span class="title" for="user">ФИО автора</span>
					<select name="user" class="user inp" >
<!-- 		<option value="">
				Выбор автора		
			</option> -->
			<?php foreach ($names as $n) { ?>
				<option value="<?php echo $n['id_user'] ?>">
					<?php  echo $n['name']?> 				
				</option>
			<?php } ?>
		</select>
	</label><br>
</div>

<div class="line">
	<label class="label" >
		<span class="title" for="category">Kатегория новости</span>		<select name="category" class="category inp" >
	<!-- 		<option value="">
				Выбор категории новости		
			</option> -->
			<?php foreach ($categories as $n) { ?>
				<option value="<?php echo $n['id_category'] ?>">
					<?php  echo $n['title_category']?> 				
				</option>
			<?php } ?>
		</select>
	</label><br>
</div>

<div class="line">
	<label class="label" >
		<span class="title" for="image">Изображение</span>		<select name="image" class="image inp" >
			<option value="">
				Выбор изображения	
			</option>
			<?php foreach ($images as $f) { 	
				$images[] = $f;?>
				<option value="<?php echo $f ?>">
					<?php  echo $f?> 				
				</option>
			<?php } ?> 
		</select>
	</label><br>
</div>
<div class="line">
	<label class="label" >
		<span class="title" for="content">Контент</span>	
		<textarea name="content" class="content inp"><?php echo $content; ?></textarea>
	</label><br>
</div>
<input class="btn btn-success" type="submit" value="Добавить" id="btn">
</form>
<?php } ?>
<div class="msg"><?php echo $msg; ?></div>