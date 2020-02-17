<?php

/**
 * BootstrapStarter - A PHP Framework For Static Web Sites
 *
 * @package  Bootstrap Starter
 * @author   George Tsachrelias <gat@silktech.gr>
 */

define('DS', DIRECTORY_SEPARATOR);
define('FCPATH', dirname(__FILE__));
define('APPPATH', FCPATH . DS . 'app');
$url = isset($_SERVER['PATH_INFO']) ? explode('/', ltrim($_SERVER['PATH_INFO'], '/')) : array();

session_start();

require_once (APPPATH . DS . 'config' . DS . 'config.php');
require_once (APPPATH . DS . 'libraries' . DS . 'functions.php');

function autoload($className) {
    if(file_exists(APPPATH . DS . 'core' . DS . $className . '.php')) {
        require_once (APPPATH . DS . 'core' . DS . $className . '.php');
    } elseif (file_exists(APPPATH . DS . 'controllers' . DS . ucwords($className) . '.php')) {
        require_once (APPPATH . DS . 'controllers' . DS . ucwords($className). '.php');
    } elseif (file_exists(APPPATH . DS . 'models' . DS . $className . '.php')) {
        require_once (APPPATH . DS . 'models' . DS . $className . '.php');
    }
}

spl_autoload_register('autoload');

//Route the request
Router::route($url);