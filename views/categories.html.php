<?php  
   //проходим циклом по массиву чтоб достать нужные нам поля таблицы
  foreach ($categories as $cat) {
    $id_category = $cat['id_category'];
    ?>
    <span>Категория новостей: <strong><?=$cat['title_category']?></strong></span> 
   <!--  <span>код категории: </span><strong> <?=$cat['id_category']?></strong> -->
    <?php if($isAuth) { ?>
      <a class="btn btn-outline-warning" href="<?php echo ROOT?>category/edit/<?=$id_category?>">Изменить</a>

   <a class="btn btn-outline-danger"  id="delete" onclick="if (!confirm('Удалить категорию:  <?=$cat['title_category']?> ?')) return false  " href="<?php echo ROOT?>category/delete/<?=$id_category?>"   >Удалить</a>
    <?php }  ?>    
    <hr>
  <?php }