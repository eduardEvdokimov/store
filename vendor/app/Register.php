<?php

namespace store;

use \widgets\currency\Currency;

class Register
{
    private static $data = [];

    public static function add($key, $value)
    {
        if(!array_key_exists($key, self::$data)){
            self::$data[$key] = $value;
            return true;
        }
        return false;
    }

    public static function get($key)
    {
        if(array_key_exists($key, self::$data)){
            return self::$data[$key];
        }
        return '';
    }

    public static function gets()
    {
        return self::$data;
    }

    public static function setCurrency()
    {
        self::add('currencies', Currency::getCurrencies());
        if(empty($_COOKIE['currency'])){
            setcookie('currency', Currency::getCurrentCurrency(self::get('currencies')), time() + 60 * 60 * 24 * 2, '/');
        }
        
        self::add('currentCurrency', Currency::getCurrentCurrency(self::get('currencies')));
        self::add('simbolCurrency', Currency::getSimbol());
    }
}