<?php

define('LIB_PATH', realpath(dirname(__FILE__) . '/../lib'));
define('FIXTURES_PATH', dirname(__FILE__) . '/fixtures/');

$autoloader = require_once LIB_PATH . '/../vendor/autoload.php';
