<?php

namespace app\controllers;


class MainController extends App {
    public function __construct($route){
        parent::__construct($route);
        debug($this->view);
    }
    public function indexAction(){
        echo "ааааа";
    }
}