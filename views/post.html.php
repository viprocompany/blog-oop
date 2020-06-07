<?php 
$title = $posts['title'];
$date = $posts['date'];
$name = $posts['name'];
$title_category = $posts['title_category'];
$content = $posts['content'];
$img = $posts['img'];
?>
<div><?php echo $msg?></div>
<p><a class="btn btn-outline-secondary" href="<?php echo '/'?>">Назад</a></p>
<!-- выводим название статьи и текст статьи -->
<h1><strong><?=$title?></strong></h1>	
<span>Автор:</span><STRONG><?=$name?></STRONG>	  <br>
<em><span>Дата:</span><?=$date?></em>	
<br>
<em><span>Рубрика:</span><?=$title_category?></em>	
<br>
<?php if(isset($img)){?>
<img src="<?php echo '/'?>images/<?=$img?>"  class="rounded img-fluid float-center">
<br>
<?php }?>
<?php if($isAuth){?>
	<a class="btn  btn-outline-warning" href="<?php echo ROOT?>edit/<?=$id_article?>">Изменить</a>
<?php }  ?>  
<hr>
<div><?php echo $content?></div>

