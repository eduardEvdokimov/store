<?php

namespace store;

class App{
    public function __construct()
    {
        new Errors;
        $config = require CONFIG . '/config.php';
        Register::add('config', $config);
        new Router;
    }
}