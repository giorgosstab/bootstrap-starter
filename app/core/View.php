<?php

class View
{
    public function __construct() {

    }

    public function render($viewName, $data = array()) {
        $viewArray = explode('/', $viewName);
        $viewString = implode(DS, $viewArray);
        if(file_exists(FCPATH . DS . 'resources/views' . DS . $viewString . '.php')){
            include  FCPATH . DS . 'resources/views' . DS . $viewString . '.php';
//            include  APPPATH . DS . 'views' . DS .'layouts' . DS . $this->_layout . '.php';
        } else {
            die('The view \"' . $viewName . '\" does not exist!');
        }
    }
}