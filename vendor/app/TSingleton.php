<?php

namespace store;

trait TSingleton
{
    private static $instance;

    public static function getInstance()
    {
        if(empty(self::$instance)){
            self::$instance = new self;
        }

        return self::$instance;
    }

    private function __construct(){}

    private function __clone(){}

    private function __sleep(){}

    private function __wakeup(){}

}