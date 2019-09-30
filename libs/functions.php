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
    $result = false;
    foreach ($data as $key => $value) {
        $result[$key] = htmlspecialchars(trim($value));
    }
    return $result;
}

//Формирует относительную дату
function relativeDate($date)
{
    $result; //Строка с финальной датой

    //Массив с русскими эквивалентами анг. месяцев
    $arrDate = [
                    'Jan' => 'января',
                    'Feb' => 'февраля', 
                    'Mar' => 'марта', 
                    'Apr' => 'апреля', 
                    'May' => 'мая',  
                    'Jun' => 'июня', 
                    'Jul' => 'июля', 
                    'Aug' => 'августа', 
                    'Sep' => 'сентября', 
                    'Oct' => 'октября', 
                    'Nov' => 'ноября', 
                    'Dec' => 'декабря'];


    $date = new DateTime($date); //Формируем объект с датой добавления публикации

    $pub_m = $date->format('M'); //Узнаем стоковое представление месяца даты публикации 

    $day_mouth = $date->format('j M'); //Возвращаем день и месяц даты публикации

    $day_mouth_year = $date->format('j M Y г.'); //Возвращаем день, месяц и год даты публикации

    $now = new DateTime(); //Формируем объект с текущей датой

    $diff = $now->diff($date); //Узнаем разницу текущей даты и даты публикации

    $m = $diff->format('%i'); //Сколько минут прошло
    $h = $diff->format('%h'); //Сколько часов прошло
    $d = $diff->format('%d'); //Сколько дней прошло
    $mes = $diff->format('%m'); //Сколько месяцев прошло
    $y = $diff->format('%Y'); //Сколько лет прошло

    //Узнаем в чем показывать (минуты, часы, месяцы, день-месяц, день-месяц-год)
    if($h == 0 && $d == 0 && $mes == 0 && $y == 0){
        //Если прошло меньше часа
        if($m == 0 || $m == 1){
            $result = 'минуту назад'; 
        }elseif( $m == 21 || $m == 31 || $m == 41 || $m == 51){
            $result = $m . ' минута назад'; 
        }elseif(
            ($m >= 2 && $m <= 4) || 
            ($m >= 22 && $m <= 24) || 
            ($m >= 32 && $m <= 34) || 
            ($m >= 42 && $m <= 44) || 
            ($m >= 52 && $m <= 54)){
            $result = $m . ' минуты назад';
        }elseif(
            ($m >= 5 && $m <= 20) ||
            ($m >= 25 && $m <= 30) ||
            ($m >= 35 && $m <= 40) ||
            ($m >= 45 && $m <= 50) ||
            ($m >= 55 && $m <= 60)){
            $result = $m . ' минут назад';
        }

    }elseif($d == 0 && $mes == 0 && $y == 0){
        //Если прошло меньше дня и больше часа
        if($h == 1 || $h == 21){
            $result = $h . ' час назад';
        }elseif(($h >= 2 && $h <= 4) || ($h >= 22 && $h < 24)){
            $result = $h . ' часa назад';
        }elseif($h >= 5 && $h <= 20){
            $result = $h . ' часов назад';
        }

    }elseif($mes == 0 && $y == 0){
        //Если прошло меньше месяца и больше дня, часа
        if($d == 1 || $d == 21 || $d == 31){
            $result = $d . ' день назад';           
        }elseif(($d >= 2 && $d <= 4) || ($d >= 22 && $d <= 24)){
            $result = $d . ' дня назад';            
        }else{
            $result = $d . ' дней назад';           
        }

    }elseif($y == 0){
        //Если прошло больше месяца
        //Заменяем анг. название месяца на русский эквивалент
        $result = str_replace($pub_m, $arrDate[$pub_m], $day_mouth);
    }else{
        //Если прошло больше года
        //Заменяем анг. название месяца на русский эквивалент
        $result = str_replace($pub_m, $arrDate[$pub_m], $day_mouth);
    }

    return $result;
}

function newFormatDate($item){
        $arrDate = [
                    'Jan' => 'января',
                    'Feb' => 'февраля', 
                    'Mar' => 'марта', 
                    'Apr' => 'апреля', 
                    'May' => 'мая',  
                    'Jun' => 'июня', 
                    'Jul' => 'июля', 
                    'Aug' => 'августа', 
                    'Sep' => 'сентября', 
                    'Oct' => 'октября', 
                    'Nov' => 'ноября', 
                    'Dec' => 'декабря'];
        if(!empty($item)){
            if (is_array($item[0])) {
                foreach ($item as $v) {
                    $date = new DateTime($v['pub_date']);
                    $month = $date->format('M');
                    $finalDate = $date->format('j M Y в H:i');
                    $v['pub_date'] = str_replace($month, $arrDate[$month], $finalDate);
                    $items[] = $v; 
                }
                return $items;
            }elseif(is_string($item)){
                $date = new DateTime($item);
                $month = $date->format('M');
                $finalDate = $date->format('j M Y');
                $item = str_replace($month, $arrDate[$month], $finalDate);
                return $item;
            }else{
                $date = new DateTime($item['pub_date']);
                $month = $date->format('M');
                $finalDate = $date->format('j M Y в H:i');
                $item['pub_date'] = str_replace($month, $arrDate[$month], $finalDate);
                return $item;
            }
        }else{
            return false;
        
        }    
    }