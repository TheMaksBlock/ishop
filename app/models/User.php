<?php

namespace app\models;

use app\models\AppModel;
use RedBeanPHP\R;

class User extends AppModel
{
    public $attributes = [
        "login" => "",
        "password" => "",
        "name" => "",
        "email" => "",
        "address" => ""
    ];

    public $rules = [
        'required' => [
            'login',
            'password',
            'name',
            'email',
            'address'
        ],

        'email' => [
            ['email']
        ],

        'lengthMin' => [
            ['password', 6]
        ]
    ];

    public function login($isAdmin = false){
        $login = !empty(trim($_POST['login'])) ? trim($_POST['login']) : null;
        $password =!empty(trim($_POST['password']))? trim($_POST['password']) : null;

        if($login && $password){
            $user = R::findOne('user', "login = ?",[$login]);

            if($isAdmin){
                if($user->role != 'admin')
                    $user = null;
            }
            if($user){
                if(password_verify($password, $user->password )){
                    foreach ($user as $k => $v){
                        if($k != 'password'){
                            $_SESSION['user'][$k] = $v;
                        }
                    }
                    return true;
                }
            }
        }

        return false;
    }

    public static function checkAuth(): bool
    {
        return isset($_SESSION['user']);
    }

    public static function isAdmin(): bool
    {
        return (isset($_SESSION['user']) && $_SESSION['user']['role']=='admin');
    }
}