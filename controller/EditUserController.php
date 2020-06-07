<?php  
namespace controller;
use models\BaseModel;
use models\UsersModel;
use core\DBConnect;
use core\Auth;
use core\Request;
use core\DBDriver;
use models\Helper;

class EditUserController extends BaseController
{

//   public function oneAction()
//   {
//         // переопределяем title
//     // $this->title .=': РЕДАКТИРОВАНИЕ';
//       //вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
//     $isAuth = Auth::isAuth();
// //имя пользователя для вывода в приветствии
//     $login = Auth::isName();
//     $msg = '';

// //проверка авторизации
//     if(!$isAuth){
// //ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : в массив сессии  добавляем элемент указывающий куда перейдет клиент после авторизации в файле login.php, если он заходил после клика на "ДОБАВИТЬ автора"
//       $_SESSION['returnUrl'] = ROOT . "add";
//       header("Location: " . ROOT . "login");
//     }
// //для вызова
//   //создаем объект для подключения к базе данных
//     $db = DBConnect::getPDO();
// //создаем новый объект класса ArticleModel и через конструктор добавляем к нему передачей через параметр ранее созданный  объект  $db для подключения к базе данных
//     $mUser = new UsersModel(new DBDriver($db ));
//   //задаем массив для дальнейшего вывода фамилий авторов в разметке через опшины селекта, после выбора автора из значения опшина подтянется айдишник автора для дальнейшего добавления в статью

//     $id = $this->request->get('id');
//     $users = $mUser->getById($id); 
//     // переопределяем title
    
//       $name = $users['name'];
//         //    проверяем корректность вводимого айдишника
  
//     $this->title .=': ИЗМЕНИТЬ: ' . $name;

//     if(!($mUser->correctId('name', 'users', 'id_user', $id )))
//     { 
//       $err404 = true;  
//       $this->content = $this->build ('errors', [
//       ]);
//     }
//     else{
//       $this->content = $this->build('edit-user', [
//         'name' => $name,
//         'users' => $users,
//         'isAuth' => $isAuth,
//         'login' => $login,
//         'id_user' => $id

//       ]);
//   }
// }


}