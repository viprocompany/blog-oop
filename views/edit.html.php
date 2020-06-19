<?php 

if($isAuth) {
	$id_article =  $post['id_article'];
	$title= $post['title'];			
	$id_user = $post['id_user'];
	$name= $post['name'];
	$id_category = $post['id_category'];
	$title_category = $post['title_category'];
	$content = $post['content'];	
	$img = $post['img'];	 ?>
	<h4>РЕДАКТИРОВАНИЕ СТАТЬИ</h4>
	<form method="post" class="form form_edit">	
		<p><span>Номер статьи: </span><?php  echo $id_article; ?></p>	
		<div class="line">
			<label class="label" >
				<span class="title" for="name">Название</span>	
				<input type="text" name="title" class="inp" value="<?php  echo $title; ?>"><br>
			</label><br>
		</div>
		<div class="line">
			<label class="label" >
				<span class="title" for="name">ФИО автора</span>	
				<select name="name" class="name inp" >
					<option  value="<?php echo $id_user ?>"><?php echo $name?></option>
					<?php foreach ($names as $n) { ?>
						<option  value="<?php echo $n['id_user'] ?>">
							<?php  echo $n['name']?> 				
						</option>
					<?php } ?>
				</select>
			</label><br>
		</div>
		<div class="line">
			<label class="label" >
				<span class="title" for="name">Kатегория новости</span>		
				<select name="id_category" class="id_category inp" >
					<option value="<?php echo $id_category ?>">
						<?php echo $title_category ?></option>
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
					<span class="title" for="name">Изображение</span>	
					<select name="image" class="img inp" >
						<option value="<?php echo $img ?>">
							<?php echo $img ?></option>
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
						<span class="title" for="name">Контент</span>	
						<textarea name="content" class="inp"><?php echo $content; ?></textarea>
					</label><br>
				</div>

				<input class="btn btn-success" type="submit" value="Применить">
			</form>
			<p><?php echo $msg; ?></p>
		<?php } 