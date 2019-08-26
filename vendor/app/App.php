<?php

namespace store;

use \widgets\currency\Currency;

class App{
    public function __construct()
    {
        new Errors;
        $config = require CONFIG . '/config.php';
        Register::add('config', $config);
        Register::setCurrency();
        new Router;
    }
}