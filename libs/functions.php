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