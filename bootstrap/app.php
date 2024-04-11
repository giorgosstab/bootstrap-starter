<?php

require_once '../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(FCPATH);

$dotenv->safeLoad();