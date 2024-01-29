<?php

namespace app\controllers\admin;

use app\controllers\admin\AppController;
use app\models\User;

class UserController extends AppController
{
    public function loginAdminAction()
    {
        $this->layout = "login";
        if(!empty($_POST)){
            $user = new User();
            if(!$user->login(true)){
                $_SESSION['error'] = "Ошибка авторизации";
            }

            if(User::isAdmin()){
                redirect(ADMIN);
            }else{
                redirect();
            }
        }
    }
}