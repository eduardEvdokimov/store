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

    public function __construct($view = '', $layout = '')
    {
        if(!empty($view)) $this->tpl = $view;
        if(!empty($layout)) $this->layout = $layout;
        $this->run();
    }

    private function run()
    {
        $this->category = $this->getTree();
        $this->getHtml();
    }

    private function getHtml()
    {
        $view = '';
        foreach ($this->category as $key => $value) {
            $view .= $this->loadView($value);
        }
        require 'layouts/' . $this->layout . '.php';
    }

    private function loadView($item)
    {
        ob_start();
        include 'layouts/' . $this->tpl . '.php';
        return ob_get_clean(); 

    }

    public function getTree()
    {
        $category = Register::get('category');
        
        if(empty($category)){
            $cache = new Cache;
            $category = $cache->get('category');

            if(empty($category)){
                $db = Db::getInstance();
                $category = $db->query('SELECT * FROM category');
                return $this->createTree($category);
            }else{
                Register::add('category', $category);
                return $category;
            }
        }else{
            return $category;
        }
    }

    private function createTree($category)
    {
        $tree = [];
        $newCategory = [];
        foreach ($category as $value) {
            $id = $value['id'];
            unset($value['id']);
            $newCategory[$id] = $value;
        }

        foreach ($newCategory as $key => &$value) {
            if($value['parent_id'] == 0){
                $tree[$key] = &$value;  
            }else{
                $newCategory[$value['parent_id']]['child'][$key] = &$value;
            }
        }

        Register::add('category', $tree);
        $cache = new Cache;
        $cache->add('category', $tree, time() + 60 * 60 * 24 * 30);
        return $tree;
    }
}