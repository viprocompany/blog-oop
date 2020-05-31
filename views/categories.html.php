<?php  
   //проходим циклом по массиву чтоб достать нужные нам поля таблицы
  foreach ($categories as $cat) {
    $id_category = $cat['id_category'];
    ?>
    <span>Категория новостей: <strong><?=$cat['title_category']?></strong></span> 
   <!--  <span>код категории: </span><strong> <?=$cat['id_category']?></strong> -->
    <?php if($isAuth) { ?>
          <!-- старые ссылки до приведение к человекочитаемым урлам ЧПУ -->
     <!--  <a class="btn btn-outline-warning" href="index.php?c=edit-category&id_category=<?=$id_category?>">Изменить</a>
 -->    
   <a class="btn btn-outline-warning" href="<?php echo ROOT?>edit-category/<?=$id_category?>">Изменить</a>
    <?php }  ?>    
    <hr>
  <?php }