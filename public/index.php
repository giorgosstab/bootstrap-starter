<?php

use App\Libraries\TranslatorManager;
use Jenssegers\Blade\Blade;

define('FCPATH', dirname(__DIR__));

// Load bootstrap file for env
require_once '../bootstrap/app.php';

// Load app folder
$application_folder = '../app';
define('APPPATH', $application_folder.DIRECTORY_SEPARATOR);

// Default file
$fileName = 'home';

// e.g. index.php?route=home or /home/
if (isset($_GET['route'])) {
    $route = explode('/', $_GET['route']);

    $fileName = count($route) === 2
        ? rtrim($route[1], '/')
        : rtrim($route[0], '/');
}

// Set translation manager
$trans = new TranslatorManager(current_locale());
$trans->setFallback(config('app.fallback_locale'));
$locale = $trans->getLocale();

// Set blade engine
$view_folder = resource_path('views');
$cache = storage_path('framework/views');

$blade = new Blade($view_folder, $cache);

try {
    echo $blade->render($fileName);
} catch (Exception $e) {
    header("HTTP/1.0 404 Not Found");

    echo $blade->render('errors.404');

    die();
}