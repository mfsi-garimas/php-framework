<?php

namespace core;

require_once(dirname(__DIR__) . "/autoload.php");

class Controller
{
    public $data;
    public function view($view, $data = null)
    {
        $this->data = $data;
        require_once(dirname(__DIR__)  . "/resources/views/" . $view . ".php");
    }
}
