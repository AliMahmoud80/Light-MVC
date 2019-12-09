<?php

use Light\Bootstrap\App;

/**
 * Defining necessary constants
 */

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname('../')));

/**
 * Preparing Composer Autoloader
 */

require_once ROOT . DS . 'vendor' . DS . 'autoload.php';

/**
 * Fire The Application
 */
$app = App::run();