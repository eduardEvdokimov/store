<?php

namespace widgets\pagination;

class Pagination
{
    private $countProduct;
    private $href;

    public function __construct($countProduct, $currentPage = '', $countProductOnePage = 9, $layout = 'default')
    {
        $this->currentPage = $currentPage ?: 1;
        $this->countProduct = $countProduct;
        $this->layout = $layout;
        $this->countProductOnePage = $countProductOnePage;
    }

    public function run()
    {
        $this->reformUri();
        $this->countPage = $this->calcCountPage();
        if($this->countPage < 2) return '';
        return $this->getHtml();
    }

    private function reformUri()
    {
        $url = $_SERVER['REQUEST_URI'];
        preg_match_all("#filter=[\d,&]#", $url, $matches);
        if(count($matches[0]) > 1){
            $url = preg_replace("#filter=[\d,&]+#", "", $url, 1);
        }
        
        
        preg_match_all('#sort=[\d\w_]+#', $url, $matches);
        if(count($matches[0]) > 1){
            $url = preg_replace('#sort=[\d\w_]+&?#', '', $url, 1);  
        }


        $url = explode('?', $url);
        $uri = $url[0] . '?';
        if(isset($url[1]) && $url[1] != ''){
            $params = explode('&', $url[1]);
            foreach($params as $param){
                if(!preg_match("#page=#", $param)) $uri .= "{$param}&amp;";
            }
        }
        $uri .= 'page=';
        $this->href =  urldecode($uri); 
    }

    private function calcCountPage()
    {
        if(!$this->countProduct && !$this->countProductOnePage) return false;
        return ceil($this->countProduct / $this->countProductOnePage);
    }

    public function getHtml()
    {
        $btn_first = '';
        $btn_prev = '';
        $btn_prev_2 = '';
        $btn_prev_1 = '';
        $btn_next_1 = '';
        $btn_next_2 = '';
        $btn_next = '';
        $btn_last = '';

        $file_layout = 'layouts/' . $this->layout . '.php';
        
        $btn_current = "<li class='page-item active'><span class='page-link'>{$this->currentPage}</span></li>";

        if($this->currentPage > 1 ){
            
            $btn_prev_1 = "<li class='page-item'><a class='page-link' href='".$this->href.($this->currentPage - 1)."'>".($this->currentPage - 1)."</a></li>";
        }
        if($this->currentPage > 2){
            
            $btn_prev_2 = "<li class='page-item'><a class='page-link' href='".$this->href.($this->currentPage - 2)."'>".($this->currentPage - 2)."</a></li>";
        }

        if($this->currentPage > 3){
            $btn_prev = "<li class='page-item'><a class='page-link' href='".$this->href . ($this->currentPage - 3) ."'><</a></li>";
        }

        if($this->currentPage > 4){
            $btn_first = "<li class='page-item'><a class='page-link' href='".$this->href . 1 ."'><<</a></li>";
        }

        if(($this->countPage - $this->currentPage) > 3){
            $btn_last = "<li class='page-item'><a class='page-link' href='".$this->href . $this->countPage ."'>>></a></li>";
        }

        if(($this->countPage - $this->currentPage) > 2){
            $btn_next = "<li class='page-item'><a class='page-link' href='".$this->href . ($this->currentPage + 3) ."'>></a></li>";
        }

        if(($this->countPage - $this->currentPage) > 1){
            $btn_next_2 = "<li class='page-item'><a class='page-link' href='".$this->href.($this->currentPage + 2)."'>".($this->currentPage + 2)."</a></li>";
        }

        if(($this->countPage - $this->currentPage) > 0){
            $btn_next_1 = "<li class='page-item'><a class='page-link' href='".$this->href.($this->currentPage + 1)."'>".($this->currentPage + 1)."</a></li>";
        }

        $html = $btn_first . $btn_prev . $btn_prev_2 . $btn_prev_1 . $btn_current . $btn_next_1 . $btn_next_2 . $btn_next . $btn_last;

        ob_start();

        require $file_layout;

        return ob_get_clean();
    }
}