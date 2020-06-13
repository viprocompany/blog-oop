<p><a class="btn btn-outline-secondary" href="<?php echo ROOT?>home?view=base">Отобразить нормально</a></p>
<!-- старые ссылки до приведение к человекочитаемым урлам ЧПУ -->
<!-- <p><a class="btn btn-outline-secondary" href="index.php?c=home&view=base">Отобразить нормально</a></p> -->
<?php  foreach($posts as $message)  { 
 $id_article = $message['id_article']; 
  ?>
<div>	
	<strong><a href="<?php echo ROOT?>home/<?=$id_article;?>"><?=$message['title']?></a></strong>
<!-- старые ссылки до приведение к человекочитаемым урлам ЧПУ -->
		<!-- <strong><a href="index.php?c=post&id_article=<?=$id_article;?>"><?=$message['title']?></a></strong> -->
	<em><?=$message['date']?></em>         
	<!-- <em>автор: </em> -->
	<em><?=$message['name']?></em>         
<!-- 	<em>рубрика: </em>
	<em><?=$message['title_category']?></em>  -->
	<!-- <div><?=$message['content']?></div> -->	 
<!-- <button class="btn btn-outline-success">	<a href="post.php?id_article=<?=$id_article;?>">ЧИТАТЬ</a></button> -->
	<?php if($isAuth) { ?>
		<a class="btn  btn-outline-warning" href="<?php echo ROOT?>home/edit/<?=$id_article?>">Изменить</a>

		 <a class="btn btn-outline-danger"  id="delete" onclick="if (!confirm('Удалить статью:  <?=$message['title'] ?> ?')) return false  " href="<?php echo ROOT?>home/delete/<?=$id_article?>"   >Удалить</a><br>
	<?php }  ?>   
	<hr>     
</div>
<?php } ?>