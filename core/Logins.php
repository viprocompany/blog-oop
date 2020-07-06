<?php 
namespace core;
 
use models\LoginsModel;
use models\SessionModel;
use core\Request;
use core\Validator;
use core\Exception\IncorrectDataException;

//в классе собираем объект для регистрации и авторизации пользователя  используя модели пользователя LoginsModel и модель наших сессий SessionModel
 class Logins 
 {

//модель пользователя
   private $mLogins;
//модель сессии пользователя
   private $mSession;
//для авторизации 
   // public $current = null;

  public function __construct(LoginsModel $mLogins, SessionModel $mSession)
  {
//делаем по умолчанию что авторизавция пройденa
// $_SESSION['is_auth'] = true;
    $this->mLogins = $mLogins;
    $this->mSession = $mSession;
  }
  public function signIn(array $fields)
  {
//валидируем - вызываем signIp и передаем туда  $fields - поля для логин, пароль
    $this->mLogins->signIn($fields);
//можно перехватиь ошибку валидации из модели LoginsModel здесь, но сделано  в контроллере LoginsController
//поле формы авторизации ЛОГИН
    $login = $fields['login'];
//объект пользователь, получаемый из базы по логину. если в базе нет то фальш
    $user = $this->mLogins->getByLogin($login);
//проверяем есть такой логин в базе
    if(!$user){
//бросаем исключение
      throw new IncorrectDataException(sprintf('Логин: %s не существует!', $login));  
      $e->getErrors();
    }     
//поле формы авторизации ПАРОЛЬ 
    $password = $fields['password'];
//объект ПАРОЛЯ пользователя, получаемый из базы по логину. если в базе нет то фальш
    $matched = $this->mLogins->getHash($password) === $user['password'];
//проверяем соответсвует ли пароль введенный в форме паролю , который привязан к этому логину в базе данных
    if(!$matched){
//бросаем исключение
      throw new IncorrectDataException('Пароль не действителен!');  
      $e->getErrors();
    }  
//задаем значение авторизации как действительное
          $_SESSION['is_auth'] = true;
// при выставлении галочки "запомнить" 
          $remember =   $fields['remember'];
          if(isset($remember)  ?? true){
        //при удачной авторизации задаем куку с логином пользователя
            setcookie('login',$login, time()+3600*24*365 , '/');
            setcookie('password', LoginsModel::getHash($password), time()+3600*24*365 , '/');  
          }
        //открыть две сессии: пхп и базы
  //создаем объект для подключения к базе данных
    $db = DBConnect::getPDO();
//создаем новый объект класса Auth и через конструктор добавляем к нему передачей через параметр ранее созданный  объект  $db для подключения к базе данных
    $mAuth = new Auth($db);
    // $mAuth = true;    
        return true;
  }

  public function isAuth()
  {
   	if(isset($_COOKIE['login']) && isset($_COOKIE['password']))
  	{
  		$_SESSION['sid'] && $this->mSession->getBySid($login) === true;
  		$sid = $_SESSION['sid'];
  		$login = $_COOKIE['login'];
  	//происходит двойной вызов
  	// var_dump($sid,$login ) ;
  	// die;
  	// $login = $this->request->cookie('login');
  		
  	// $_SESSION['sid'] && $this->mSession->getBySid('sid') === true;
//why error? Uncaught Error: Using $this when not in object context in 
 		// $user = $this->mLogins->getBySid('sid');
  			
  			$_SESSION['is_auth'] = true;
  			$isAuth = true;  
  			
  	}
  	return  $isAuth; 


  // public function isAuth(Request $request)
  // {
  // 	if ($this->current) {
  // 		return true;
  // 	}

  // 	if ($sid = $this->session->collection()->get('sid')) {
  // 		$this->current = $this->mUser->getBySid($sid);
  // 	}

  // 	if ($this->current) {
  // 		$this->mSession->update($sid);
  // 		return true;
  // 	}

  // 	if ($sid = $request->cookie()->get('sid')) {
  // 		$this->mSession->set($sid);
  // 		$this->session->collection()->set('sid', $sid);
  // 		return true;
  // 	}

  // 	return false;
  }
  public function signUp(array $fields)
  {
  //можно перехватиь ошибку валидации здесь, а  можно попробовать споймать ошибку в контроллере LoginsController, что и сделано в данном случае( try catch установлен в контроллере LoginsController)

//можно сделать проверку на правильность повторно введенного пароля при регистрации , в случае если используем для пароля второе поле для дублирования ввода пароля
    // if(!$this->comparePass($fields)){
    //  return false;
    // }

//вызываем signUp и передаем туда  $fields - поля для логин, пароль , куки и др.
    $this->mLogins->signUp($fields);
  }

  private function comparePass($fields)
  {
    // сделать сравнение на правильность пароля при повторном вводе
  }
 }