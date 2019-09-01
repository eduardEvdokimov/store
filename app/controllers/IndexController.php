<?php

namespace app\controllers;

use \store\Db;
use \store\Register;
use \widgets\category\Category;

class IndexController extends MainController
{
    public function indexAction()
    {
        $model = new \app\models\ProductModel;

        
        $htmlButtonSlider = $model->createChangedButton();
       
        $productSlider = $model->getProductSlider($htmlButtonSlider);
        $data_id_carusel = Register::get('config')['data_id_carusel_index_page'];
        $this->setParams(['htmlButtonSlider' => $htmlButtonSlider, 'productSlider' => $productSlider, 'data_id_carusel' => $data_id_carusel]);

        
    }   

    public function productsAction()
    {

    }

    public function singleAction(){}
}