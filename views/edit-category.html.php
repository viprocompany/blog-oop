<?php
if($isAuth)
{  ?>
  <h4>РЕДАКТИРОВАТЬ КАТЕГОРИЮ</h4>
  <form method="post" class="form form_add_category">  
    <p><span>Номер категории: </span><?php  echo $id_category; ?></p> 
	<div class="line">
	<label class="label" >
		<span class="title" for="name">Название категории</span>	  
  <input type="text" name="title_category" class="inp"  value="<?php  echo $title_category; ?>">
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