<?php

namespace app\controllers;

use app\models\User;

class UserController extends AppController
{
    public function signUpAction()
    {
        $this->setMeta('Регистрация');
        if (!empty($_POST)) {
            $user = new User();
            $data = $_POST;
            $user->load($data);
            if (!$user->validate() || !$user->checkUnique([
                    "login" => $user->attributes['login'],
                    "email" => $user->attributes['email']
                ], "user")) {
                $_SESSION['form_data'] = $data;
                $user->getErrors();
                redirect();
            } else {
                $user->attributes['password'] = password_hash($user->attributes['password'], PASSWORD_DEFAULT);

                if ($user->save('user')) {
                    $_SESSION['success'] = "Успешная регистрация";
                } else {
                    $_SESSION['error'] = "Ошибка регистрации";
                    redirect();
                }
            }
            redirect();
        }

    }


    public function loginAction()
    {
        if(isset($_SESSION['user'])){
            header("Location: /");
            die();
        }

        $this->setMeta('Login');

        if(!empty($_POST))
        {
            $user = new User();
            if($user->login())
            {
                $_SESSION['success'] = "Успешная авторизация";
            }
            else{
                $_SESSION['error'] = "Неверное имя пользователя и/или пароль";
            }
            redirect();
        }
    }

    public function logoutAction()
    {
        if(isset($_SESSION['user'])) unset($_SESSION['user']);
        redirect();
    }
}