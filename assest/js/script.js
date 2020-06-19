window.onload = function() {
//AJAX/ передача через ГЕТ. не ЗАРАБОТАЛА
// document.querySelector('#btn').onclick = function(){
// 	ajaxGet('/home', function(data){
// 		console.log(data);
// 	});	
// 	ajaxGet('/home', function(data){
// 		document.querySelector('.new_row').innerHTML = data;
// 	});	
// };

// function ajaxGet(url,callback){
// 	var f = callback || function(data){};
// 	var request = new XMLHttpRequest();
// 	console.log('start function');
// 	request.onreadystatechange = function(){
// 		if(request.readyState == 4 && request.status == 200){
// 			console.log('job function');
// 			callback(request.responseText);
// 		}  
// 	}
// 	request.open('GET', url); 
//   //отправляем 
//   request.send();  
// }



                    // НЕ РАБОТАЕТ  
//собираем данные с формы	
// 	var inp_title = document.querySelector('input[name=title]');
// 	var inp_user = document.querySelector('select[name=user]');
// 	var inp_category = document.querySelector('select[name=category]');
// 	var inp_image = document.querySelector('select[name=image]');
// 	var inp_content = document.querySelector('textarea[name=content]');

// 	console.log(inp_title.value);
// 	console.log(inp_user.value);
// 	console.log(inp_category.value);
// 	console.log(inp_image.value);
//   console.log(inp_content.value);

// console.log(2);
// document.querySelector('#btn').onclick = function(){
// 	console.log(3);
// 	// собираем данные с формы	
// 	var params = 
// 	'title='+inp_title.value+'&'
//   +'id_user='+inp_user.value+'&'
//   +'id_category='+inp_category.value+'&'
//   +'image='+inp_image.value+'&'
//   +'content='+inp_content.value;
// 	ajaxPost(params);
// 	console.log(params);
// 	console.log(4);			
// };

//  function ajaxPost(params){
//   var request = new XMLHttpRequest();
// console.log(5);
//   request.onreadystatechange = function(){
//   	if(request.readyState == 4 && request.status == 200){
//   		console.log(6);
//   	// состояние отправки сообщения request.readyState == 4
//   	//положительный ответ сервера request.status == 200
//   		if(request.responseText == '1'){ 
//   			console.log(7);
//   			//в файле  HomeController.php после удачной валидации формы переменная  $msg = '1'(значение '1' назначаем от балды)
//   		// приходит в jscript.js как request.responseText == '1'
//   		//в див для сообщений добавляем тексt удачной отправки сообщения
//   		// "<p><span class='success'> Cообщение отправлено успешно!</span></p>"
//   		document.querySelector('.new_row').innerHTML =
//        "<p><span class='success'> Статья создана успешно!</span></p>"; 			
//   		//и очищаем форму
//   		// document.querySelector('.form').reset();
//   		}
//   		else
//   			//в файле  action.php после НЕудачной валидации формы переменная  $msg= содержит массив ошибок,
//   			// передаваемый в request.responseText и в див для сообщений добавляем его
//   		{
//   			console.log(8);
//   			document.querySelector('.msg').innerHTML =
//          request.responseText;
//   		}
//   	}  
//   }
//   request.open('POST', 'HomeController.php');
//   //стандартный заголовок для нормальной передачи на сервер кодированной кирилицы и т.п.
//   request.setRequestHeader('Content-type','application/x-www-form-urlencoded');
//   //отправляем письмо с данными полученными с формы в файл action.php
//   request.send(params);  
//  }



// document.querySelector('#delete').onclick = function(){
// if(confirm("ПОДТВЕРДИТЕ УДАЛЕНИЕ!")){
// 	document.querySelector('#delete').submit();
// 	console.log(3);			
// }
// };

}

jQuery(document).ready(function($) {
	$('.cont').height($(window).height());
//PJAX plagin??????????????????????????????????????????
// $(document).pjax('btn-modal','btn-add','btn-menu','pjax-container',{fragment: 'pjax-container'});
// $('pjax-container').on('pjax:success', function(){
// 	$.pjax({
// 		url: window.location.href,
// 		container: '.box-mnu',
// 		fragment: '.box-mnu'
// 	});
// });
           //НЕ РАБОТАЕТ
// 	$('.btn-success').click(function(){
// 				// собираем данные с формы
// 				var title = $('.title_art').val();
// 				var user = $('.user').val();
// 				var category = $('.category').val();
// 				var image = $('.image').val();
// 				var content = $('.content').val();
// 				console.log(3);			
// 				console.log(title);
// 				console.log(user);
// 				console.log(category);
// 				console.log(image);
// 				console.log(content);
// 				console.log(4);	
// 	// отправляем данные
// 	$.ajax({
// 		url: "HomeController.php", // куда отправляем
// 		type: "post", // метод передачи
// 		dataType: "json", // тип передачи данных
// 		data: { // что отправляем
// 			"title": 	title,
// 			"user": 	user,
// 			"category": 	category,
// 			"image":  image,
// 			"content":  content
// 		},
// // после получения ответа сервера
// success: function(data){
// 	result ='<p>Статья  принята!</p>';
//  	  $('.new_row').html(data.result); // выводим ответ сервера 

//   //очистка форм после успешной отправки письма
//   // var clearForm;
//   // clearForm=$('.messages').html(data.result);
//   // if (clearForm == '<span style='color: green;  	
//   // 	'>Сообщение успешно отправлено!</span>';)
// //              { 
// //               $('input').val("");
// //               $('textarea').val(""); 
// //               }                       
// },
// });
// 	console.log('end function "ajax"');	
// });
	  	 

//            //НЕ РАБОТАЕТ:
// // данные доходят до контроллера и попадают в базу,
// //в ответе POST запроса PHP ругается на ECHO с 
// // цифрой ответа "1" для сервера  .
// //скрипт не принимает ответ с сервера "1"
// $(".form_add").submit(function() {
// var str = $(this).serialize();
 
//  $.ajax({
// type: "POST",
// url: "add",
// data: str,
// success: function(msg) {
 	
// if(msg == '1') { 
// result = '<p>Статья  принята!!</p>';
// } else {
// result ='<p>Статья не принята!</p>';
// }
// $('.new_row').html(result);
// }
// });
// return false;
// });
});