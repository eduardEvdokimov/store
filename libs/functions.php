<?php

function d($variable, $stop = 0)
{
    if(!$stop){
        echo "<pre>";
        print_r($variable);
        echo "</pre>";
    }else{
        echo "<pre>";
        print_r($variable);
        echo "</pre>";
        exit();
    }
}

function redirect($http = '')
{
    if($http){
        $redirect = $http;
    }else{
        $redirect = !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : HOST;
    }

    header("Location: $redirect");
    exit();
}
