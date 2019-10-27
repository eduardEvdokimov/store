<?php

namespace store\base;

class View
{

    private $route;
    private $layout;
    private $view;
    private $params;
    protected $meta;

    public function __construct($route, $layout, $view, $meta, $params)
    {
        $this->route = $route;
        $this->layout = $layout;
        $this->view = $view;
        $this->meta = $meta;
        $this->params = $params;
        $this->prefix = !empty($route['prefix']) ? $route['prefix'] . '/' : '';
    }

    public function show()
    {
        extract($this->params);
        
        $file_view = VIEWS . "/{$this->prefix}{$this->route['controller']}/{$this->view}.php";
       
        if(file_exists($file_view)){
            
            ob_start();
            include $file_view;

            $content = ob_get_clean();

            $file_layout = LAYOUTS . "/{$this->layout}.php";
           
            if(file_exists($file_layout)){
                include $file_layout;
            }
        }
    }


    public function getMeta()
    {
        echo "<title>{$this->meta['title']}</title>";
        echo "<meta name='description' content='{$this->meta['description']}'>";
        echo "<meta name='keywords' content='{$this->meta['keywords']}'>";
    }
    


}