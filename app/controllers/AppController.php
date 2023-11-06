<?php

namespace app\controllers;

use app\models\AppModel;
use app\widgets\currency\Currency;
use ishop\App;
use ishop\base\Controller;
use ishop\Cash;
use RedBeanPHP\R;

class AppController extends Controller
{
    public function __construct($route)
    {
        parent::__construct($route);
        new AppModel();
        App::$app->setProperty('currencies', Currency::getCurrencies());
        App::$app->setProperty('currency',Currency::getCurrency(App::$app->getProperty('currencies')));
        App::$app->setProperty('cats',self::cashCategory());

    }

    public  static function cashCategory(){
        $cash = Cash::instance();
        $cats = $cash->get('cats');
        if(!$cats){
            $cats = R::getAssoc("SELECT * FROM category");
            $cash->set('cats',$cats);
        }
        return $cats;
    }
}