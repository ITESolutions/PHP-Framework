<?php

/**
 * Cura Router Class
 * 
 * @author Corey Ray (ITE Solutions)
 */

namespace Framework\Helpers;

abstract class Router
{
    private static
            $_controllerInstance,
            $_controllerName,
            $_controllerClass,
            $_action,
            $_id;
    
    private function __construct() {}
    
    public static function initialize() {
        $request = filter_input(INPUT_SERVER, 'REQUEST_URI');
        
        list( $controller, $action, self::$_id ) = array_pad(
            array_values(
                array_filter(
                    explode('/', parse_url($request, PHP_URL_PATH))
                )
            ), 3, NULL);
        
        self::$_controllerName = is_null($controller) ? 'Index' :
            str_replace( ' ', '', ucwords( str_replace('-', ' ', $controller )));
        
        self::$_action = (is_null($action)) ? 'default' :
            str_replace(' ', '', ucwords( str_replace('-', ' ', $action )));
        
        $namespace = \Framework\Abstracts\ControllerAbstract::getNamespace();
        self::$_controllerClass = $namespace . "\\" . self::$_controllerName . 'Controller';
        self::dispatch();
    }
    
    public static function redirect($location) {
        header('Location: ' . $location);
        exit();
    }

    public static function ControllerName() {
        return self::$_controllerName;
    }
    
    public static function Action() {
        return self::$_action;
    }
    
    public static function Id() {
        return self::$_id;
    }
    
    public static function dispatch() {
        self::$_controllerInstance = new self::$_controllerClass();
    }
}
