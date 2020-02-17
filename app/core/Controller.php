<?php

class Controller extends Application
{
    protected $_controller, $_method;
    public $view;

    public function __construct($controller, $method) {
        parent::__construct();
        $this->_controller = $controller;
        $this->_method = $method;
        $this->view = new View();
    }
}