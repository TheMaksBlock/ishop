<?php

namespace app\controllers\admin;

use app\models\AppModel;
use ishop\DB;
use app\models\User;
use ishop\base\Controller;

class AppController extends Controller
{
    public $layout = "admin";

    public function __construct($route)
    {
        parent::__construct($route);
        new AppModel();
        if(!User::isAdmin() && $route['action'] != 'loginAdmin'){
            redirect(ADMIN.'/user/login-admin');
        }
    }
}