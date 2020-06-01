<?php if($isAuth) { ?>
<h3>ДОБАВИТЬ КАТЕГОРИЮ НОВОСТИ</h3>
<hr>
<form method="post">
  Название категории: <br>
  <input type="text" name="title_category" value="<?php  echo $title_category; ?>"><br>
  <input class="btn btn-success" type="submit" value="Добавить">
</form>
<?php echo $msg; ?>
<?php }