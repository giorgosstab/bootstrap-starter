<?php

function dd($data) {
    echo '<pre>'; print_r($data);echo '</pre>';
    die();
}

function site_url(){
    return APP_URL . '/';
}

function assets(){
    return APP_URL . '/' . ASSETS_FOLDER . '/';
}