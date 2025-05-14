<?php

use App\Libraries\TranslatorManager;

define('FCPATH', dirname(__DIR__));

// Load bootstrap file for env
require_once '../bootstrap/app.php';

// Load app folder
$application_folder = '../app';
define('APPPATH', $application_folder.DIRECTORY_SEPARATOR);

// Set a translation manager
$trans = new TranslatorManager(current_locale());
$trans->setFallback(config('app.fallback_locale'));
$locale = $trans->getLocale();

// Load routes
$routes = require_once '../routes/web.php';

// Determine a route from URL
// (e.g. index.php?route=home or /home)
// (e.g. index.php?route=?route=product/show or /product/show)
$route = $_GET['route'] ?? 'home';
$route = trim($route, '/');

// Check if route matches a controller
if (isset($routes[$route])) {
    $routeAction = $routes[$route];

    if (is_callable($routeAction)) {
        echo call_user_func($routeAction);
    } elseif (is_array($routeAction)) {
        [$controllerClass, $method] = $routeAction;

        if (class_exists($controllerClass) && method_exists($controllerClass, $method)) {
            $controller = new $controllerClass();

            $response = call_user_func([$controller, $method]);

            echo $response;
            exit;
        }
    }
} else {
    header("HTTP/1.0 404 Not Found");
    echo view('errors.404');
    die();
}