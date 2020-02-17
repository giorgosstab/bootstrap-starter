<?php

class HomeController extends Controller
{
    public function __construct($controller, $method) {
        parent::__construct($controller, $method);
    }

    public function index() {
        $username = 'mitsos';
        $this->view->render('home/index',compact('username'));
    }

    public function edit($request) {
        dd($request);
    }

}