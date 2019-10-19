<?php

namespace widgets\filter;

use \store\{Cache, Db};

class Filter
{
    private $category;

    public function __construct($category)
    {
        $this->category = $category;
        $this->run();
    }

    protected function run()
    {
        $this->group = $this->getGroup();
        $this->values = $this->getValues();
        
        echo $this->getHtml();
    }

    protected function getHtml()
    {
        $layout = WIDGET . '/filter/layouts/index.php';

        ob_start();
        require $layout;
        return ob_get_clean();
    }

    protected function getGroup()
    {
        $db = Db::getInstance();
        $category_id = $db->query("SELECT parent_id FROM category WHERE alias='{$this->category}'");
        
        if($category_id[0]['parent_id'] == 6)
            $this->category = 'notebooks';

        
        $groups = $db->query("SELECT * FROM filter_group WHERE category_id=(SELECT id FROM category WHERE alias='{$this->category}')");

        return $groups;
    }

    protected function getValues()
    {
        $db = Db::getInstance();
        $category_id = $db->query("SELECT parent_id FROM category WHERE alias='{$this->category}'");

        if($category_id[0]['parent_id'] == 6)
            $this->category = 'notebooks';

        $data = $db->query("SELECT * FROM filter_value WHERE group_id IN (SELECT id FROM filter_group WHERE category_id=(SELECT id FROM category WHERE alias='{$this->category}'))");

        foreach ($data as $key => $value) {
            $result[$value['group_id']][] = $value['value']; 
        }

        return $result;
    }




}