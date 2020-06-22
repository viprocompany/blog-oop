<!DOCTYPE html>
<html lang="en" >
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">  
	<link rel="stylesheet" href="<?php echo ROOT?>assest/css/style.css">
	<title><?php echo $title; ?></title>
</head>
<body> 
	<div class="cont">
		<!--БЛОК ПРИВЕТСТВИЕ-->
		<div class="row " >
			<div class="col-12 border border rounded" id="hello">
				<h1  style="font-weight:900;">PHP этап №1</h1>
			</div>
		</div>
		<!--БЛОК ХЕДЕР-->
		<div class="row" id="header">
			<img src="<?php echo ROOT?>assest/img/header.jpg" alt="" class="rounded img-fluid float-center img-big"> <!-- с закругленными углами  ,float-center выравнивание по центру-->
		</div>
		<!-- БЛОК ЛЕГЕНДА -->		
		<div class="row border border rounded" id="legend">
			<div class="col-12">
				<?php echo $title_1; ?>			
			</div>
		</div>
		<!--БЛОК КОНТЕНТ-->
		<div class="row "  id="content">	
				<!--КОНТЕНТ левая часть глючат скобки-->
				<div class="col-6 col-md-2 order-md-1 border border-warning  rounded " id="sideLeft">
					<div class="col-12">		
						<div class="p-2 d-flex flex-column justify-content-center" id="info">   
							<div class="" id="instagram"></div>
							<div class="row" id="insta">
								<p><a href="#">torgovy_object</a></p>
							</div>
							<div class="" id="vkontakte"></div>
							<div class="row" id="vk">
								<p><a href="#">torgovy_object</a></p>
							</div> 
							<div class="" id="facebook"></div>
							<div class="row" id="face">
								<p><a href="#">torgovy_object</a></p>
							</div>
									<img src="<?php echo ROOT?>assest/img/<?php echo $fb;?>" alt="<?php echo $fb;?>" >
							<!-- <?php echo $fb;?> -->
						</div>	
					</div>			
					<div class="row" id="reklama">
						<p>Рекламный блок</p>
					</div>
				</div>
						
				<!--КОНТЕНТ правая часть-->
				<div class="col-6 col-md-2 p-1 order-md-3 border-warning border  rounded " id="sideRight">
						<h4 class="text-center"><?php echo $auth?></h4>	             
				</div> 	
		
			<!--КОНТЕНТ центр глючат скобки-->
			<div class="col-12 col-md-8 order-md-2 d-flex flex-column  border-info border  rounded" id="center" >
				<div class="column">
					
				<!-- 	<p>
						<a class="btn btn-outline-primary" href="index.php?c=home">Главная</a>
						<a class="btn btn-outline-primary" href="index.php?c=users">Авторы  </a><a  class="btn btn-outline-primary" href="index.php?c=categories">  Категории новостей</a>						
					</p> -->
				</div>
				<div class="column">   
					<?php echo $title_2; ?><br>
					<?php echo $error; ?>
					<?php echo $new_row;?><hr>
					<?php echo $content;?>
				</div>	
			</div>	
				</div>
		<!--ФУТЕР-->
		<div class="row" id="footer">
			<img src="<?php echo ROOT?>assest/img/footer.jpg" alt="" class="rounded img-fluid float-center img-big">
			<img src="<?php echo ROOT?>assest/img/<?php echo $image_footer;?>" alt="" class="rounded img-fluid float-center">
		</div>
	<!--БЛОК АВТОР-->
	<div class="row " id="copyright"></div>
</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" type="text/javascript"></script> 
<script src="<?php echo ROOT?>assest/js/script.js ?>"></script>
<script src="<?php echo ROOT?>assest/js/jquery.pjax.js ?>"></script>
<!-- 	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>  -->
</body>
</html>




			<!--КОНТЕНТ левая часть глючат скобки-->
<!-- 			<div class="col-6 col-md-2 order-md-1 border border-warning  rounded " id="sideLeft">
				<div class="col-12">

					<div class="p-2 d-flex flex-column justify-content-center" id="info">   
						<div class="" id="instagram"></div>
						<div class="row" id="insta">
							<p><a href="#">torgovy_object</a></p>
						</div>
						<div class="" id="vkontakte"></div>
						<div class="row" id="vk">
							<p><a href="#">torgovy_object</a></p>
						</div> 
						<div class="" id="facebook"></div>
						<div class="row" id="face">
							<p><a href="#">torgovy_object</a></p>
						</div>
						<img src="<?php echo ROOT?>assest/img/<?php echo $fb;?>" alt="<?php echo $fb;?>" > -->
						<!-- <?php echo $fb;?> -->
			<!-- 		</div>	
				</div>
				<div class="col-12"> 
					<div class="row"  id="contact"> -->
						<!-- Button trigger modal -->
			<!-- 			<div class="col-12">
							<button type="button" class="btn btn-primary btn-modal" data-toggle="modal" data-target="#ModalF">
							написать автору</button>  -->
							<!-- data-toggle="modal"  запрограммированное в Bootstrap по умолчанию модальное окно с ID нашего окна data-target="#Modal"-->
							<!-- Modal -->
					<!-- 	</div>
						<div class="modal fade" id="ModalF">  -->
						 <!-- fade окно изначально скрыто -->
						<!-- 	<div class="modal-dialog modal-dialog-center modal-dialog-lg"> -->
							 <!-- диалоговое окно можно добавить позиционирование modal-dialog-center и размер modal-dialog-lg или sm -->
							<!-- 	<div class="modal-content"> 
									задает размеры окна
									<div class="modal-header">
										<h5 class="modal-title">Заполните форму и отправьте сообщение</h5>				
									</div>
									<div class="modal-body"> 
										<form  id="formValidation">
											<div class="form-group row">
												<label  class="col-3" for="exampleInputEmail">Email адрес</label>
												<input type="email" class="form-control col-9" id="exampleInputEmail" required placeholder="Email адрес" >
											</div>
											<div class="form-group row">
												<label class="question col-3" for="name">введите  имя</label>
												<input class="form-control col-9" type="text" name="name" id="name" maxlength="30" size="35" placeholder="имя" required pattern="^[a-zA-Zа-яА-ЯёЁІіЇїЄєҐґ']+$" >
											</div>
											<div class="form-group row">
												<label class="question col-3 tp" for="text"><span class="ask">Задайте вопрос :</span></label>
												<p><textarea name="text" id="text" cols="70" rows="5" required placeholder="введите текст ..." ></textarea></p> 
											</div>
											<button type="submit" class="btn btn-primary">Отправить сообщение</button>
										</form>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-danger btn-modal" data-dismiss="modal">Закрыть</button>							
									</div>
								</div>
							</div>
						</div>
					</div>	   			    	      		
				</div>
				<div class="row" id="reklama">
					<p>Рекламный блок</p>
				</div>
			</div> -->