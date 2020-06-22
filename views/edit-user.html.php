<?php
if($isAuth)
{  ?>
<h4>РЕДАКТИРОВАНИЕ ДАННЫХ АВТОРА</h4>
	<hr>
<form method="post" class="form form_edit_user">  
  <p><span>Код автора: </span><?php  echo $id_user;?></p> 
			<div class="line">
				<label class="label" >
					<span class="title" for="name">ФИО  автора</span>
					<input type="text" name="name" class="inp" value="<?php  echo $name; ?>">
				</label><br>
			</div>
  <input class="btn btn-success" type="submit" value="Применить">
</form>
<?php }?>
<div>
<?php 
if($msg){
	foreach ($msg  as $one_error) 
	{
		echo "<span style='color: red;'>$one_error</span><br/>";
	}	
}	
?>
</div>