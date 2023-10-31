<?php

namespace app\controllers;


class MainController extends App {

    public function __construct($route){
        parent::__construct($route);
    }

    public function indexAction(){
        $this->setMeta(\ishop\App::$app->getPropertie('shop_name'), 'Описание', 'Ключи');

        $this->set(['name'=>"Maks", 'age'=>19]);
    }

    public function viewAction(){
        $this->setMeta(\ishop\App::$app->getPropertie('shop_name'), 'Описание', 'Ключи');

        $this->set(['name'=>"Maks", 'age'=>19]);
    }
}