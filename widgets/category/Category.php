<?php

namespace widgets\category;

use \store\Register;
use \store\Db;
use \store\Cache;

class Category
{
    private $tpl = 'view';
    private $layout = 'default';
    private $category = [];
    private $categoryTree;

    public function __construct($view = '', $layout = '')
    {
        if(!empty($view)) $this->tpl = $view;
        if(!empty($layout)) $this->layout = $layout;
        $this->run();
    }

    private function run()
    {
        $this->category = self::get();
        $this->categoryTree = $this->getTree($this->category);
        $this->getHtml();
    }

    private function getHtml()
    {
        $view = '';

        foreach ($this->categoryTree as $key => $value) {
            $view .= $this->loadView($value, $key);
        }
        require 'layouts/' . $this->layout . '.php';
    }

    private function loadView($item, $key = null)
    {
        $parent_keys = [];
        foreach ($this->category as $value){
            if(!in_array($value['parent_id'], $parent_keys))
                $parent_keys[] = $value['parent_id'];
        }
        ob_start();
        include 'layouts/' . $this->tpl . '.php';
        return ob_get_clean();
    }

    public static function get()
    {
        $category = Register::get('category');
        $cache = new Cache;

        if(empty($category)){

            $category = $cache->get('category');

            if(empty($category)){
                $db = Db::getInstance();
                $category = $db->query('SELECT * FROM category');
                Register::add('category', $category);
                $cache->add('category', $category, time() + 60 * 60 * 24 * 30);
            }else{
                Register::add('category', $category);
            }
        }

        foreach ($category as $value) {
            $id = $value['id'];
            unset($value['id']);
            $newCategory[$id] = $value;
        }

        return $newCategory;
    }

    private function getTree($category)
    {
        $tree = [];

        foreach ($category as $key => &$value) {
            if($value['parent_id'] == 0){
                $tree[$key] = &$value;  
            }else{
                $category[$value['parent_id']]['child'][$key] = &$value;
            }
        }
        return $tree;
    }
}