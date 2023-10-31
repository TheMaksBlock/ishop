<?php

namespace app\controllers;


use ishop\Cash;
use RedBeanPHP\R;

class MainController extends App {

    public function __construct($route){
        parent::__construct($route);
    }

    public function indexAction(){
        $posts = R::findAll('test');
        $this->setMeta(\ishop\App::$app->getPropertie('shop_name'), 'Описание', 'Ключи');
        $this->set(compact('posts'));
        $cash = Cash::instance();
        $cash->set('test', $posts);
        $cash->delete('test');
        $posts = R::findOne('test', 'id=?',[1]);
        $data = $cash->get('test');
        if(!$data){
            $cash->set('test', $posts);
        }
        $data = $cash->get('test');
        debug($data);
    }

}