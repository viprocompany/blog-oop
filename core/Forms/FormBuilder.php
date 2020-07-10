<?php
namespace core\Forms;

//надстройка над классом  Form из  core\Forms, для того чтобы генерировать HTML код
class FormBuilder{

  public $form;

  //принимает форму по ссылке 
  public function __construct(Form &$form)
  {
    $this->form = $form;
  }

  //перегон в HTML
  public function method()
  {
    $method = $this->form->getMethod();

    if(null === $method){
      $method ='GET';
    }

    return sprintf('method="%s"', $method);
  }

  public function fields()
  {
    foreach($this->form->getFields() as $field){
      $attributes = [];

      $inputs[] = $this->input($field);
    }
    return $inputs;
  }

  public function input(array $attributes)
  {
  
    if($attributes['class'] == ' inp input '){
       if($attributes['name'] == 'login'){
              $span = '<span class="title" for="login">Логин</span>';
       }

        if($attributes['name'] == 'password'){
              $span = '<span class="title" for="password">Пароль</span>';
       }
         if($attributes['name'] == 'password-reply'){
              $span = '<span class="title" for="password-reply">Повтор</span>';
       }
    }

    $errors = '' ;
//данное условие нужно для того чтобы к инпутам, которые попали в массив с ошибками errors добавить дивы, в котрых будет выходить текст ошибки из класса ВАЛИДАТОР. Данная ошибка в виде переменной $msg будет передана в параметре для подстановки в  return sprintf ('<input %s>%s', $this->buildAttributes($attributes),$msg);  Если в данной функции sprintf не установить вторую маску и не передать под нее параметр , то и вывода на печать дивов с сообщением после  непровалидированных значений инпутов на соответсвте  логина и пароля правилам  (после инпутов ) НЕ будет. 

    if (isset($attributes['errors'])) {

      $class = $attributes['class'] ?? '';
      $attributes['class'] = trim(sprintf('%s error', $class));
      // echo  $attributes['class'];
      $errors = $attributes['errors'];  

      unset($attributes['errors']);

      $msg = '<div class="msg">' . $errors . '</div>';
      // echo 'FormBuilder.php  line 51 :' . ($msg);      
    }   

    return sprintf('%s<input %s>%s', $span, $this->buildAttributes($attributes),$msg);
  }


  public function inputSign()
  {
    return $this->input([
      'type' => 'hidden',
      'name' => 'sign',
      'value' => $this->form->getSign()
    ]);
  }

  public function buildAttributes(array $attributes)
  {
   
   //если при добавлении атрибутов к инпутам на каком либо инпуте есть ошибка валидации этого поля(передается массивом $errors из метода addErrors класса Form из core\Forms ) то в атрибут класса этого инпута добавляем класс error и в файле CSS соответсвенно делаем визуальный эффект с красным бордером поля инпута с ошибкой валидации. Работает только с формой , которая сгенерирована с помощью абстрактного класса Form из core\Forms\Form, например форма sign-up класса SignUp extends Form

    if(isset($attributes['errors'])){
      $attributes['class'] .= ' error';   
    }  
//формирование аттрибутов со значениями для инпутов
    $arr = [];
    foreach($attributes as $attribut => $value){
      $arr[] = sprintf('%s="%s"',$attribut , $value );
    }
    return implode(' ', $arr);
  }

}

  // public function fieldsSpan()
  // {
  //   foreach($this->form->getFields() as $field){
  //     $attributes = [];

  //     $spans[] = $this->span($field);
  //   }
  //   return $spans;
  // }

  // public function span(array $attributes)
  // {
  //   return sprintf('<span %s></span>', $this->buildAttributes($attributes));
  // }