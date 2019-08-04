<?php

namespace store;

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
}