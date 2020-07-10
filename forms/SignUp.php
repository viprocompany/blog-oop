<?php
namespace forms;

use core\Forms\Form;

class SignUp extends Form
 {
    public function __construct()
 {
        $this->fields = [
            [
                'name' => 'login',
                'type' => 'text',
                'placeholder' => 'Введите логин от 3 до 30 знаков',
                'class' => ' inp input ',
                'value' => trim($_POST['login'])
            ],
            [
                'name' => 'password',
                'type' => 'password',
                'placeholder' => 'Введите пароль от 5 до 50 знаков',
                'class' => ' inp input ',
                'value' => trim($_POST['password'])
            ],
            [
                'name' => 'password-reply',
                'type' => 'password',
                'placeholder' => 'Повторите пароль от 5 до 50 знаков',
                'class' => ' inp input ',
                'value' => trim($_POST['password-reply'])
            ],
            [
                'type' => 'submit',
                'value' => 'Зарегистрировать',
                'class' => ' btn btn-success inp '
            ]
        ];
        $this->formName = 'sign-form';
        $this->method = 'POST';
        $login = trim($_POST['login']);
    }

}