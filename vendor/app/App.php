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
        $simbols_currency = require CONFIG . '/simbols_currency.php';
        Register::add('simbols_currency', $simbols_currency);
        Register::setCurrency();
        new Router;
    }
}