<?php
if($isAuth)
{  ?>
<h4>РЕДАКТИРОВАНИЕ ДАННЫХ АВТОРА</h4>
	<hr>
<form method="post">  
  <p><span>Код автора: </span><?php  echo $id_user;?></p> 
  НОВОЕ ФИО автора<br>
  <input type="text" name="name" value="<?php  echo $name; ?>"><br>
  <input class="btn btn-success" type="submit" value="Применить">
</form>
<?php }?>
<p><?php echo $msg; ?></p>