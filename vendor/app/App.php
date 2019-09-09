<?php

namespace store;

use \widgets\currency\Currency;

class App{
    public function __construct()
    {
        session_start();
        new Errors;
        $config = require CONFIG . '/config.php';
        Register::add('config', $config);
        Register::setCurrency();
        new Router;
    }
}