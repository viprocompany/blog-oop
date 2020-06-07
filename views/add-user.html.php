<?php
 if($isAuth) 
 	{ ?>
	<h3>ДОБАВИТЬ АВТОРА</h3>
	<hr>
	<form method="post">
		ФИО  автора<br>
		<input type="text" name="name" value="<?php  echo $name; ?>"><br>
		<input class="btn btn-success" type="submit" value="Добавить">
	</form>	
<?php }?>
<p><?php echo $msg; ?></p>