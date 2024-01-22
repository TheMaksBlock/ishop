<?php

namespace app\controllers\admin;

use RedBeanPHP\R;

class MainController extends AppController
{
    public function indexAction(){
        $countOrders = R::count("order", "status = '0'");
        $countUsers = R::count("user", "role = 'user'");
        $countProducts = R::count("product", "status = '1'");
        $countCategories = R::count("category");
        $this->set(compact('countOrders', 'countUsers', 'countProducts', 'countCategories'));
        $this->setMeta("Панель управления ");

    }
}