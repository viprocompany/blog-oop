<?php
if($isAuth)
{  ?>
  <h4>РЕДАКТИРОВАТЬ КАТЕГОРИЮ</h4>
  <form method="post">  
    <p><span>Номер категории: </span><?php  echo $id_category; ?></p> 
    название<br>
    <input type="text" name="title_category" value="<?php  echo $title_category; ?>"><br>
    <input class="btn btn-success" type="submit" value="Применить">
  </form>
<?php }?>
<p><?php echo $msg; ?></p>