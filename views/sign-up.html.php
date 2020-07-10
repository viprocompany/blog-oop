РЕГИСТРАЦИЯ 
<hr>
<form <?=$form->method();?> class="form sign-up">
<!-- метод для вывода скрытого поля  с солью inputSign -->
<?=$form->inputSign()?>
<!-- метод для вывода инпутов -->
<?php foreach($form->fields() as $field) : ?>
  <div class="line">
   <label class="label">
    <?=$field?>  
    <br>
    </label>
    <br>
  </div>
<?php endforeach; ?>
</form>

<!-- //ЕСЛИ РАСКОМЕНТИРОВАТЬ УСЛОВИЕ С ВЫВОДОМ ОШИБКИ , ТО ОНИ БУДУТ РАСПЕЧАТАНЫ ПОД КНОПКОЙ "ЗАРЕГИСТРИРОВАТЬ"" -->
<!-- 
<div class="msg">
    <?php 
    if($msg){     
      foreach ($msg  as $one_error) 
      {
        echo "<span style='color: red;'>$one_error</span><br/>";
      } 
    } 
    ?>
  </div> -->