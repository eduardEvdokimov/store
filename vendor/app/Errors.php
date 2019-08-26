<?php

namespace store;

class Errors
{
    private $error_file = DIR . '/tmp/errors.log';
    private $notice_file = DIR . '/tmp/notices.log'; 

    public function __construct($error_file = '', $notice_file = '')
    {
        if(!empty($error_file)) $this->error_file = $error_file;
        if(!empty($notice_file)) $this->notice_file = $notice_file;

        (DEBUG) ? error_reporting(-1) : error_reporting(0);

        set_exception_handler([$this, 'handlerException']);
        set_error_handler([$this, 'handlerError']);  
    }

    public function handlerError($errno, $errstr, $errfile, $errline)
    {   
        if($errno == E_NOTICE){
            if(error_reporting() == -1){
                $str = "E_NOTICE: " . $errstr . "<br>";
                $str .= "Строка: " . $errline . "<br>";
                $str .= "Файл: " . $errfile . "<br>";
                echo '<pre>' . $str . '</pre>';
            }
            $this->logError($errstr, $errfile, $errline, 300, 'notice');
        }else{
            return;
        }
    }


    private function logError($msg, $file, $line, $code = 300, $type_error = 'exception')
    {
        $type = 'Произошла ошибка';
        $number_error = 1;
        $data = '';
        $log = $this->error_file;

        if($type_error == 'notice'){
            $type = 'Замечание';
            $log = $this->notice_file;
        }

        $f = fopen($log, 'r+b');
        flock($f, LOCK_SH);

        if(filesize($log) != 0){
            $data = fread($f, filesize($log));
            flock($f, LOCK_UN);
        }

        if(!empty($data)){
            $errors_arr = explode("\r\n\r\n", $data);
            
            if(count($errors_arr) > 1){
                $id_last_error = count($errors_arr) - 2;
                $last_error = $errors_arr[$id_last_error];
                preg_match("#№\s(?<number>\d+)#i", $last_error, $m);
                $number_error = $m['number'] + 1;
            }

            
            
        }

        $str = "$type № $number_error: " . date('d-m-Y в H:i:s') . "\r\n";
        $str .= "Ошибка: " . $msg . "\r\n";
        $str .= "Строка: " . $line . "\r\n";
        $str .= "Файл: " . $file . "\r\n";
        $str .= "Код ошибки: " . $code . "\r\n\r\n";
        $data .= $str;

        flock($f, LOCK_EX);
        ftruncate($f, 0);
        fseek($f, SEEK_SET);
        fwrite($f, $data);
        flock($f, LOCK_UN);
        fclose($f);
    }

    private function displayError($msg, $file, $line, $code)
    {
        $str = "Произошла ошибка: " . date('d-m-Y в H:i:s') . "<br>";
        $str .= "Ошибка: " . $msg . "<br>";
        $str .= "Строка: " . $line . "<br>";
        $str .= "Файл: " . $file . "<br>";
        $str .= "Код ошибки: " . $code . "<br>";
        return $str;
    }

    public function handlerException($e)
    {
        if(DEBUG){
            $this->logError($e->getMessage(), $e->getFile(), $e->getLine(), $e->getCode());
            $error = $this->displayError($e->getMessage(), $e->getFile(), $e->getLine(), $e->getCode());
            include LAYOUTS . '/errors/error_debug.php';
        }else{
            $this->logError($e->getMessage(), $e->getFile(), $e->getLine(), $e->getCode());
            http_response_code($e->getCode());
            include LAYOUTS . '/errors/404.html';
        }
        exit;
    }

}