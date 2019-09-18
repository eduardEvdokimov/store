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


function isAjax()
{
    if(
        isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
        !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        return true;
    }else{
        return false;
    }
}

function filterData($data)
{
    foreach ($data as $key => $value) {
        $result[$key] = htmlspecialchars(trim($value));
    }
    return $result;
}



