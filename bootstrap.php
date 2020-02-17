<?php
//use App\Core\Router;
//
//require_once (APPPATH . DS . 'config' . DS . 'config.php');
//require_once (APPPATH . DS . 'libraries' . DS . 'functions.php');

// Autoload Classes
//function autoload($className) {
//    if(file_exists(APPPATH . DS . 'core' . DS . $className . '.php')) {
//        require_once (APPPATH . DS . 'core' . DS . $className . '.php');
//    } elseif (file_exists(APPPATH . DS . 'controllers' . DS . ucwords($className) . '.php')) {
//        require_once (APPPATH . DS . 'controllers' . DS . ucwords($className). '.php');
//    } elseif (file_exists(APPPATH . DS . 'models' . DS . $className . '.php')) {
//        require_once (APPPATH . DS . 'models' . DS . $className . '.php');
//    }
//}
//function autoload($className) {
//    $classArray = explode('\\',$className);
//    $class = array_pop($classArray);
//    $subPath = strtolower(implode(DS,$classArray));
//    $path = APPPATH . DS . $subPath . DS . $class . '.php';
//    if(file_exists($path)) {
//        require_once ($path);
//    }
//}
//
//spl_autoload_register('autoload');
//
////Route the request
//Router::route($url);