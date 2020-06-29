	АВТОРИЗАЦИЯ<hr>
<form class="form" method="post">
	<div class="line">
		<label class="label" >
			<span class="title" for="name">Логин</span>			
			<input type="text" class="inp"  name="login" placeholder="введите логин"  value="<?php  echo $login; ?>"><br>
		</label><br>
	</div>
	<div class="line">
		<label class="label" >
			<span class="title" for="name">Пароль</span>			
			<input type="password" class="inp" placeholder="введите пароль" name="password" value="">
		</label><br>
	</div>
	<input type="checkbox" class="inp" name="remember" value="">
	Запомнить меня<hr>	
	<input type="submit" class="btn btn-success inp" value="Войти">
</form>
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