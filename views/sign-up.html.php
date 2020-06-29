РЕГИСТРАЦИЯ
<hr>
<form class="form" method="post">
  <div class="line">
    <label class="label">
      <span class="title" for="name">Логин</span>
      <input type="text" class="inp" name="login" placeholder="введите логин" value="<?php  echo $login; ?>"><br>
    </label><br>
  </div>
  <div class="line">
    <label class="label">
      <span class="title" for="password">Пароль</span>
      <input type="password" class="inp" name="password" placeholder="введите пароль" value="">
    </label><br>
  </div>
  <!-- <input type="checkbox" class="inp" name="remember" value="">
	Запомнить меня<hr>	 -->

  <input type="submit" class="btn btn-success inp" value="Войти">
</form>
<!-- <span style='color: green;'><?php  echo $msg_2 ?></span><br/> -->
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