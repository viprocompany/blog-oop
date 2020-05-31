<?php 
if($isAuth){?>
<h2>СТАТИЧЕСКИЕ ТЕКСТЫ И НАЗВАНИЯ ФАЙЛОВ ИЗОБРАЖЕНИЙ ДЛЯ ВСТАВКИ В РАЗМЕТКУ САЙТА</h2>
<hr>
<?php  
  //проходим циклом по массиву чтоб достать нужные нам поля таблицы
foreach ($texts as $t) {
  $id_text = $t['id_text'];
  $text_name = $t['text_name'];
  $text_content = $t['text_content'];
  // $img_content = $t['img_content'];
  $description = $t['description'];
  $text_image = array_search($t['text_content'], $images);
  ?>
  <span>ИМЯ:  </span><STRONG><?=$text_name?></STRONG><br>
  <?php if(($text_content)){?> 
    <span>ТЕКСТ:  </span><?=$text_content?><br>
  <?php }?> 
  <span>ОПИСАНИЕ:  </span><?=$description?><br>

  <a class="btn  btn-outline-warning" href="<?php echo ROOT?>edit-text/<?=$id_text?>">Изменить</a> <br>
   <?php  
     // foreach($images as $f)
     // {
     
     if($text_image){?> 
     <span>ИМЯ КАРТИНКИ:  </span><?=$text_content?><br> 
       <img src="<?php echo ROOT?>assest/img/<?=$text_content?>"  class="rounded img-fluid float-center">
     <!-- } -->  
 <?php }?>  
   <hr>

<?php } 
}