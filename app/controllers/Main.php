<?php

namespace app\controllers;

use core\Controller;

class Main extends Controller
{
    public function index()
    {
        $this->view('index');
    }

    public function register()
    {
        $this->view('validation');
    }

    public function action()
    {
        $this->view('action');
    }
}
