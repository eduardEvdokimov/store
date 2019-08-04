<?php

namespace store;

class Cache
{
    private $path;

    public function __construct($path = '')
    {
        $this->path = (!empty($path)) ? $path : TMP . '/cache'; 
    }

    public function add($key, $data, $time = 3600)
    {
        $filename = md5($key);
        $filepath = $this->path . "/$filename.txt";

        if(file_exists($filepath))  return false;

        $cache_data['data'] = $data;
        $cache_data['time'] = time() + $time;

        if(file_put_contents($filepath, serialize($cache_data)) !== false)
            return true;

        return false;
    }

    public function get($key)
    {
        $filename = md5($key);
        $filepath = $this->path . "/$filename.txt";


        if(!file_exists($filepath))  return false;

        $data = unserialize(file_get_contents($filepath));

        if(($data['time'] - time()) > 0){
            return $data['data'];
        }

        $this->remove($key);
        return '';
        
    }

    public function remove($key)
    {
        $filename = md5($key);
        $filepath = $this->path . "/$filename.txt";

        if(!file_exists($filepath))  return false;

        return unlink($filepath);
    }

    public function rewrite($key, $data, $time = 0)
    {
        $filename = md5($key);
        $filepath = $this->path . "/$filename.txt";

        if(!file_exists($filepath))  return false;

        $cache_data['data'] = $data;

        $f = fopen($filepath, 'r+b');
        flock($f, LOCK_SH);

        $cache = unserialize(fread($f, filesize($filepath)));
        flock($f, LOCK_UN);

        if(($time == 0) && ($cache['time'] - time() > 0)){
            $cache_data['time'] = $cache['time'];
        }elseif($time > 0){
            $cache_data['time'] = time() + $time;
        }else{
            $cache_data['time'] = time() + 3600;
        }

        flock($f, LOCK_EX);
        ftruncate($f, 0);
        fseek($f, SEEK_SET);
        fwrite($f, serialize($cache_data));
        fclose($f);
        return true;
    }
}