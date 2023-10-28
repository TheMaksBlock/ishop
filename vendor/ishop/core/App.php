<?php

namespace ishop;

class App
{
    public static  $app;

    public function __construct()
    {
        $query = trim($_SERVER['QUERY_STRING'], '/');
        session_start();
        static::$app = Registry::instance();
        $this->getParams();
        new ErrorHandler();
    }

    protected function getParams(){
        $params = require_once CONF.'/params.php';
        if(!empty($params)){
            foreach ($params as $k => $v)
                static::$app->setProperty($k, $v);
        }
    }

}