<?php if($isAuth) { ?>
  <h3>РЕДАКТИРОВАТЬ ТЕКСТ</h3>
  <hr>
  <form method="post" class="form form_add_text">
      <div class="line">
      <label class="label" >
        <span class="title" for="name">Название</span>      <input type="text" name="text_name" class="inp" value="<?php  echo $text_name; ?>">
      </label><br>
    </div>
      <div class="line">
        <label class="label" >
          <span class="title" for="name">Текст</span>   
    <input type="text" name="text_content" class="inp" value="<?php  echo $text_content; ?>"><br>
    </label><br>
    </div>
<div class="line">
      <label class="label" >
        <span class="title" for="name">(просмотр папки с файлами изображений)</span>  
        <select name="img_content" class="img inp" >
          <?php foreach ($images as $f) {   
            $images[] = $f;?>
            <option value="<?php echo $f ?>">
              <?php  echo $f?>        
            </option>
          <?php } ?> 
        </select>
      </label><br>
    </div>
<!--     <input type="text" name="img_content" value="<?php  echo $img_content; ?>"><br> -->
        <div class="line">
      <label class="label" >
        <span class="title" for="name">Описание</span>     
        <textarea  name="description" class="inp" ><?php  echo $description; ?></textarea>
      </label><br>
    </div>
    <input class="btn btn-success" type="submit" id="btn" value="Применить">

  </form> 
<?php }?>
<p><?php echo $msg; ?></p>