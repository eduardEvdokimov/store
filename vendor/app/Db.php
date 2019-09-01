<?php

namespace store;

require 'TSingleton.php';

class Db
{
    use TSingleton;

    public $conn;
    private $dbRequests = [];
    private $lastRequest = '';

    private function __construct()
    {
        $config = require CONFIG . '/db.php';
        $connect = sprintf("mysql:host=%s;dbname=%s", $config['host'], $config['dbname']);
        $db = new \PDO($connect, $config['login'], $config['password'], $config['attr']);
        if($db instanceof \PDO){
            $this->conn = $db;
        }else{
            new \Exception('Не удалось подключиться к БД', 500);
        }
    }
    
    public function query($sql)
    {
        if(empty($sql)) return false;
        $this->dbRequests[] = ['sql' => $sql];
        $this->lastRequest = $sql;
        $result = $this->conn->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
        return !empty($result) ? $result : '';
    }

    public function execute($sql, $values)
    {
        if(empty($sql) && empty($values)) return false;
        $this->dbRequests[] = ['sql' => $sql, 'params' => $values];
        $this->lastRequest = $sql;
        $prepare = $this->conn->prepare($sql);
        if(strpos($sql, 'ELECT')){
            if($prepare->execute($values)){
                $result = $prepare->fetchAll(\PDO::FETCH_ASSOC);
            }
            return !empty($result) ? $result : '';
        }
        return $prepare->execute($values);
    }

    public function exec($sql)
    {
        if(empty($sql)) return false;
        $this->dbRequests[] = ['sql' => $sql];
        $this->lastRequest = $sql;
        return $this->conn->exec($sql);
    }

    public function getLastSql()
    {
        return '<b>' . $this->lastRequest . '</b>';
    }

    public function getSqlRequests()
    {
        $str = '';
        foreach ($this->dbRequests as $value) {
            $params = '';
            if(isset($value['params']))
                $params = "<span>Параметры: " . implode(',', $value['params']) . "</span>";

            $str .= "<b>Запрос: " . $value['sql'] . "</b>" . $params . "<br>";
        }
        return $str;
    }

    public function getInsertId()
    {
        return $this->conn->lastInsertId();
    }
}