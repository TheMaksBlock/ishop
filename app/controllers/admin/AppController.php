<?php

namespace app\controllers\admin;

use app\models\AppModel;
use Exception;
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

    public function getID($get = true, $id ='id')
    {
        if($get){
            $data = $_GET;
        } else {
            $data = $_POST;
        }

        $id = !empty($data[$id]) ? $data[$id] :null;
        if(!$id){
            throw new Exception('Страница не найдена', 404);
        }

        return $id;
    }
}