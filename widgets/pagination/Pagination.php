<?php

namespace widgets\pagination;

class Pagination
{
    private $countProduct;
    private $href;

    public function __construct($countProduct, $countProductOnePage = 9, $layout = 'default')
    {
        $this->countProduct = $countProduct;
        $this->layout = $layout;
        $this->countProductOnePage = $countProductOnePage;
    }

    public function run()
    {
        $this->currentPage = !empty($_GET['page']) ? $_GET['page'] : 1;
        $this->reformUri();
        $this->countPage = $this->calcCountPage();
        if($this->countPage < 2) return '';
        return $this->getHtml();
    }

    private function reformUri()
    {
        $queryString = explode('?', $_SERVER['REQUEST_URI']);
        $href = '?page=';
        if(isset($queryString[1])){
            $reqs = explode('&', $queryString[1]);
        
            foreach ($reqs as $key => $value) {
                if(strpos($value, 'page') !== false){
                    unset($reqs[$key]);
                }
            }

            $reqs[] = 'page=';

            $href = '?' . implode('&', $reqs);
        }
        
        
        $this->href = HOST . $queryString[0] . $href;
       
        
    }

    private function calcCountPage()
    {
        if(!$this->countProduct && !$this->countProductOnePage) return false;
        return round($this->countProduct / $this->countProductOnePage, 0, PHP_ROUND_HALF_UP);
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