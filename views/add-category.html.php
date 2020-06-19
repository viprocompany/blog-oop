<?php if($isAuth) { ?>
<h3>ДОБАВИТЬ КАТЕГОРИЮ НОВОСТИ</h3>
<hr>
<form method="post" class="form form_add_category">
	<div class="line">
	<label class="label" >
		<span class="title" for="name">Название категории</span>	  
  <input type="text" name="title_category" class="inp"  value="<?php  echo $title_category; ?>">
  	</label><br>
</div>
  <input class="btn btn-success" type="submit" value="Добавить">
</form>
<?php } ?>
<div class="msg"><?php echo $msg; ?></div>