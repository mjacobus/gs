<?php

define('LIB_PATH', realpath(dirname(__FILE__) . '/../lib'));

set_include_path(
    implode(PATH_SEPARATOR, array( LIB_PATH, get_include_path()))
);


define('FIXTURES_PATH', dirname(__FILE__) . '/fixtures/');

$loader = require_once LIB_PATH . '/../vendor/autoload.php';

require_once 'Gs/QueryBuilder.php';
