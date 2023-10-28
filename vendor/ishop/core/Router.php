<?php

namespace ishop;

use Exception;

class Router
{
    public static $routes = [];
    public static $route = [];

    public static function add($regexp, $route = [])
    {
        static::$routes[$regexp] = $route;
    }

    public static function getRoutes(): array
    {
        return static::$routes;
    }

    public static function getRoute(): array
    {
        return static::$route;
    }

    public static function dispatch($url)
    {
        if (static::matchRoute($url)){
            $controller = 'app\controllers\\'.static::$route['prefix'].static::$route['controller'].'Controller';

            if (class_exists($controller)){
                $controllerObject = new $controller(static::$route);
                $action = static::$route['action'].'Action';

                if(method_exists($controllerObject, $action)){
                    $controllerObject->$action();
                }
                else throw new Exception("Метод {$controller}::{$action} не найдена", 404);

            }
            else{
                throw new Exception("Контролеер {$controller} не найдена", 404);
            }
        }
        else
            throw new Exception("Страница не найдена", 404);
    }

    public static function matchRoute($url): bool
    {
        foreach (static::$routes as $pattern => $route) {
            if(preg_match("#{$pattern}#", $url, $matches)){
                foreach ($matches as $k => $v) {
                    if(is_string($k))
                        $route[$k] = $v;
                }

                if(isset($route['action']))
                    $route['action'] = 'index';

                if(!isset($route['prefix']))
                    $route['prefix'] = '';
                else{
                    $route['prefix'] .= '\\';
                }

                $route['controller'] = static::upperCamelCase($route['controller']);


                static::$route = $route;
                return true;
            }
        }
        return false;
    }


    protected static function upperCamelCase($name){
        return str_replace(' ','',ucwords(str_replace('-', ' ', $name)));
    }

    protected static function lowerCamelCase($name){
        return lcfirst(static::upperCamelCase($name));
    }

}