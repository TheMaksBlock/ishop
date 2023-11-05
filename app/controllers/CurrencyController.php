<?php

namespace app\controllers;

use ishop\App;
use RedBeanPHP\R;

class CurrencyController extends AppController {

    public function changeAction(){
        $currency = !empty($_GET['curr']) ? $_GET['curr'] : null;
        if($currency){
            $curr = App::$app->getProperty('currencies');
            if(!empty($curr[$currency])){
                setcookie('currency', $currency, time() + 3600*24*7, '/');
            }
        }
        redirect();
    }

}