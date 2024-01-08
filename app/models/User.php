<?php

namespace app\models;

use app\models\AppModel;

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
}