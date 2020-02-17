<?php

Route::get('/', function () {
    return ci()->blade->view('welcome');
});
