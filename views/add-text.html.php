<?php if($isAuth) { ?>
  <h3>ДОБАВИТЬ ТЕКСТ</h3>
  <hr>
  <form method="post">
    ИМЯ<br>
    <input type="text" name="text_name" value="<?php  echo $text_name; ?>"><br>
    ТЕКСТ<br>
    <input type="text" name="text_content" value="<?php  echo $text_content; ?>"><br>
    (просмотр папки с файлами изображений)<br>
      <select name="img_content" class="img inp" >
    <?php foreach ($images as $f) {   
      $images[] = $f;?>
      <option value="<?php echo $f ?>">
        <?php  echo $f?>        
      </option>
    <?php } ?> 
  </select><br>
    ОПИСАНИЕ <br>
    <textarea  name="description" ><?php  echo $description; ?></textarea><br>
    <input class="btn btn-success" type="submit" value="Добавить">

  </form> 
<?php }?>
<p><?php echo $msg; ?></p>