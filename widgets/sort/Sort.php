<?php

namespace widgets\sort;

class Sort
{
    public static function getTerm($key)
    {
        switch ($key) {
            case 'min_max_price':
                $sort = 'product.price';
                break;
            case 'max_min_price':
                $sort = 'product.price DESC';
                break;
            case 'pop':
                $sort = 'product.hit DESC';
                break;
            case 'new':
                $sort = 'product.new DESC';
                break;
            case 'rating':
                $sort = 'product_info.rating DESC';
                break;
            default:
                $sort = 'product_info.rating DESC';
                break;
        }
        return $sort;
    }

    public static function run($key)
    {
        $key = !empty($key) ? $key : 'rating';
        $view = self::getHtml($key);
        include WIDGET . '\sort\layouts\default.php';
    }

    public static function getHtml($key)
    {
        $li = file(WIDGET . '\sort\layouts\view.html');
        $html = '';
        
        foreach ($li as $value) {
            if(strpos($value, $key)){
                $active = "class='active'";
            }else{
                $active = '';
            }
            $html .= sprintf($value, $active);
        }
        return $html;
    }
}