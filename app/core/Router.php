<?php

class Router
{
    public static function route($url) {
        $controller = (isset($url[0]) && $url[0] != '' ? ucwords($url[0]).'Controller' : DEFAULT_CONTROLLER);
        $controller_name = $controller;
        array_shift($url);

        $method = (isset($url[0]) && $url[0] != '' ? $url[0] : 'index');
        $method_name = $method;
        array_shift($url);

        $queryParams = $url;
//        $controller = 'App\Controllers\\' . $controller;
        $dispatch = new $controller($controller_name, $method_name);

        if(method_exists($controller, $method)){
//            call_user_func_array(array($dispatch, $method),$queryParams);
            $dispatch->$method($queryParams);
        } else {
            die('That method does not exist in the controller \"'.$controller_name.'\"');
        }
    }
}