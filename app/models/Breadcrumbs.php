<?php

namespace app\models;

use \store\Register;

class Breadcrumbs
{
    private $path;
    private $product_category;
    private $lastItem;

    public function __construct($currentCategory, $lastItem)
    {
        $category = \widgets\category\Category::get();
        
        
        $this->lastItem = $lastItem;
        $this->product_category = $currentCategory;
        $this->path = $this->getCategories($category, $this->product_category);
            
    }

    private function getCategories($cats, $id)
    {
        if(!$id) return false;

        foreach ($cats as $key => $value) {   
            if(isset($cats[$id])){
                $result[] = ['title' => $cats[$id]['title'], 'alias' => $cats[$id]['alias']];
                $id = $cats[$id]['parent_id'];      
            }else break;   
        }
        
        return array_reverse($result);
    }  

    public function getHtml()
    {
        $html = '';
        $first = '<li><a href='.HOST.'>Главная</a></li>';
        $last = '<li class=\'active\'>'.$this->lastItem.'</li>';
        $html .= $first;
        foreach ($this->path as $item) {

            $html .= '<li><a href='.HOST.'/category/'.$item['alias'].'>'.$item['title'].'</a></li>'; 
        }
        $html .= $last;

        return $html;
            
    }
}