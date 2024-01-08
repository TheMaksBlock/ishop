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

            } else {
                $user->attributes['password'] = password_hash($user->attributes['password'], PASSWORD_DEFAULT);


                if ($user->save('user')) {
                    $_SESSION['success'] = "Успешная регистрация";
                } else {
                    $_SESSION['error'] = "Ошибка регистрации";
                }

            }
            redirect();
        }

    }


    public function loginAction()
    {

    }

    public function logoutAction()
    {

    }
}