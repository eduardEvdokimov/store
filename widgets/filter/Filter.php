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
        $this->group = self::getGroup($this->category);
        $this->values = self::getValues($this->category);
        
        echo $this->getHtml();
    }

    protected function getHtml()
    {
        $layout = WIDGET . '/filter/layouts/index.php';
        $filter = self::getFilter();
        if(!empty($filter)){
            $filter = explode(',', $filter);
        }
        ob_start();
        require $layout;
        return ob_get_clean();
    }

    public static function getGroup($category)
    {
        $db = Db::getInstance();
        $category_id = $db->query("SELECT parent_id FROM category WHERE alias='{$category}'");
        
        if($category_id[0]['parent_id'] == 6)
            $category = 'notebooks';

        
        $groups = $db->query("SELECT * FROM filter_group WHERE category_id=(SELECT id FROM category WHERE alias='{$category}')");

        return $groups;
    }

    /**
     * @param $category
     * @return mixed
     */
    public static function getValues($category)
    {
        $db = Db::getInstance();
        $category_id = $db->query("SELECT parent_id FROM category WHERE alias='{$category}'");

        if($category_id[0]['parent_id'] == 6)
            $category = 'notebooks';

        $data = $db->query("SELECT * FROM filter_value WHERE group_id IN (SELECT id FROM filter_group WHERE category_id=(SELECT id FROM category WHERE alias='{$category}'))");

        foreach ($data as $key => $value) {
            $result[$value['group_id']][$value['id']] = $value['value']; 
        }

        return isset($result) ? $result : null;
    }

    public static function getFilter(){
        $filter = null;

        if(!empty($_GET['filter'])){
            $filter = preg_replace("#[^\d,]+#", '', $_GET['filter']);
            $filter = trim($filter, ',');
        }
        return $filter;
    }

    public static function getCountGroups($filter, $category){
        $filters = explode(',', $filter);
        $attrs = self::getValues($category);
        $data = [];

        foreach($attrs as $key => $item){
            foreach($item as $k => $v){
                if(in_array($k, $filters)){
                    $data[] = $key;
                    break;
                }
            }
        }
        return count($data);
    }




}