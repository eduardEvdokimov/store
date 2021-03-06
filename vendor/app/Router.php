<?php

namespace store;


class Router{

    private static $routes = [];
    private $route = [];
    
    public function __construct()
    {
        $this->dispatch();
    }

    private function matchRoute($uri)
    {
        foreach(self::$routes as $regexp => $path){
            if(preg_match("#$regexp#i", $uri, $m)){
                foreach ($m as $key => $value) {
                    if(is_string($key)){
                        $this->route[$key] = urldecode($value);
                    }
                }
               
                $controller = isset($m['controller']) ? $m['controller'] : $path['controller'];
                $action = isset($m['action']) ? $m['action'] : $path['action'];

                $this->route['controller'] = $this->strToUpper($controller) ?: 'Index';
                $this->route['action'] = $this->strToLower($action) ?: 'index';
                $this->route['prefix'] = isset($path['prefix']) ? '\\' . $path['prefix'] : '';
                
                return true;
            }
        }
        return false;
    }

    private function removeQuery($uri)
    {   
        return explode('?', trim($uri, '/'))[0];
    }

    private function dispatch()
    {   
        $uri = $this->removeQuery($_SERVER['REQUEST_URI']);
        if($this->matchRoute($uri)){

            $controller = $this->route['controller'] . 'Controller';
            $action = $this->route['action'] . 'Action';

            $file_controller = str_replace('/', '\\', APP  . '/controllers' . $this->route['prefix'] . '/'  . $controller . '.php');
            

            if(file_exists($file_controller)){
                include $file_controller;

                $class_name = "\app\controllers{$this->route['prefix']}\\" . $controller;
                
                if(class_exists($class_name)){
                    $class_controller = new $class_name($this->route);
                    
                    if(method_exists($class_controller, $action)){
                        $class_controller->$action();

                        $class_controller->getView();
                    }else{
                        throw new \Exception('Метод ' . $action . ' класса - ' . $class_name . ' не найден', 500);
                    }
                }else{
                    throw new \Exception('Класс не найден - ' . $controller, 500);
                }
            }else{
                throw new \Exception('Файл контроллера не наден - ' . $file_controller, 500);
            }
        }else{
            throw new \Exception('Маршрут не найден', 500);
        }
    }

    public static function add($regexp, $path = [])
    {
        if(!array_key_exists($regexp, self::$routes)){
            self::$routes[$regexp] = $path; 
        }
    }

    private function strToLower($str)
    {
        $action = '';
        $str = strtolower($str);
        $data = explode('-', $str);
        
        if(!empty($data[0])){

            foreach ($data as $key => $value) {
                if($key != 0){
                    $action .= ucfirst($value);
                }
            }
            
            $result = $data[0] . $action;
            return $result;
        }
        return $str;
    }


    private function strToUpper($str)
    {
        return ucfirst($this->strToLower($str));
    }



    public static function getRoutes()
    {
        return self::$routes;
    }
}