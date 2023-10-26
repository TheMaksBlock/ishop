<?php

require_once dirname(__DIR__) . '/config/init.php';

new ishop\App();
\ishop\App::$app->setProperty('test','TEST');
var_dump(\ishop\App::$app->getProperties());
