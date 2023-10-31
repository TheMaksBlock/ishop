<?php

namespace app\controllers;


use RedBeanPHP\R;

class MainController extends App {

    public function __construct($route){
        parent::__construct($route);
    }

    public function indexAction(){
        $posts = R::findAll('test');
        $this->setMeta(\ishop\App::$app->getPropertie('shop_name'), 'Описание', 'Ключи');
        $this->set(compact('posts'));
    }

}