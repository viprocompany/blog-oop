<?php
if($isAuth) 
	{ ?>
		<h3>ДОБАВИТЬ КАТЕГОРИЮ НОВОСТИ</h3>
		<hr>
		<form method="post" class="form form_add_category">
			<div class="line">
				<label class="label" >
					<span class="title" for="title_category">Название категории</span>	  
					<input type="text" name="title_category" class="inp"  value="<?php  echo $title_category; ?>">
				</label><br>
			</div>
			<input class="btn btn-success" type="submit" value="Добавить">
		</form>
	<?php } ?>
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