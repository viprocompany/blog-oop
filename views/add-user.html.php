<?php
if($isAuth) 
	{ ?>
		<h3>ДОБАВИТЬ АВТОРА</h3>
		<hr>
		<form method="post" class="form form_add_user">
			<div class="line">
				<label class="label" >
					<span class="title" for="name">ФИО  автора</span>			
					<input type="text" name="name" class="inp" value="<?php  echo $name; ?>">
				</label><br>
			</div>
			<input class="btn btn-success" type="submit" value="Добавить">
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