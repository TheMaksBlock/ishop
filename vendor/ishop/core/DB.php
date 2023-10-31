<?php

namespace ishop;

use Exception;
use \RedBeanPHP\R as R;

class DB
{
    use  TSingletone;

    protected function __construct() {
        $db = require CONF . '/config_db.php';
        R::setup($db['dsn'], $db['user'], $db['pass']);
        if (!R::testConnection()) {
            throw new Exception("Нет соединения с БД", 500);
        }
        R::freeze(true);
        if(DEBUG) {
            R::debug(true, 1);
        }
    }
}