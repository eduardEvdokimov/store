<?php

namespace store\base;

use \store\Db;

abstract class Model
{
    public $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

    public function getAll($table)
    {
        $sql = "SELECT * FROM $table";
        return $this->db->query($sql);
    }

    public function fetchAll($table)
    {
        $sql = "SELECT * FROM $table";
        $data = $this->db->query($sql);
        
        if(!empty($data) && isset($data[0]['id'])){
            foreach ($data as $value) {
                $id = $value['id'];
                unset($value['id']);
                $result[$id] = $value;
            }
        }
        return !empty($result) ? $result : '';
    }

    public function getOne($table, $where)
    {
        $sql = sprintf("SELECT * FROM %s WHERE %s LIMIT 1", $table, $where);
        return $this->db->query($sql);
    }

    public function add($table, $columns, $values)
    {
        if(
            empty($table) && 
            empty($where) && 
            empty($values) && 
            !is_array($columns) && 
            !is_array($values) &&
            count($columns) != count($value)
        ) return false;

        $keysStr = rtrim(str_repeat('?,', count($values)), ',');
        $columnsStr = implode(',', $columns);
        $sql = "INSERT INTO $table ($columnsStr) VALUES ($keysStr)";
        return $this->db->execute($sql, $values);
    }
}