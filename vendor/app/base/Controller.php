<?php

namespace store\base;

abstract class Controller
{
    protected $layout = CURRENT_LAYOUT;
    protected $view;
    private $params = [];
    protected $route;
    protected $meta = ['title' => '', 'description' => '', 'keywords' => ''];

    public function __construct($route)
    {
        $this->route = $route;
        $this->view = $route['action'];
    }

    public function getView()
    {
        $view = new View($this->route, $this->layout, $this->view, $this->meta, $this->params);
        $view->show();
    }

    public function setMeta($title, $description, $keywords)
    {
        $this->meta['title'] =  $title;
        $this->meta['description'] = $description;
        $this->meta['keywords'] = $keywords;
    }


    public function loadView($tpl = '')
    {
        extract($this->params);
        $view = !empty($tpl) ? $tpl : $this->view;
        include VIEWS . "/{$this->route['controller']}/{$view}.php";
        die;
    }

    public function setParams(array $arr)
    {
        if(!empty($this->params)){
            $this->params = array_merge($this->params, $arr);
        }else{
            $this->params = $arr;
        }
        
    }
}