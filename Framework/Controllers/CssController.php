<?php

namespace Framework\Controllers;
use Framework\Helpers;

/**
 * Description of CssController
 *
 * @author corey
 */

class CssController extends \Framework\Abstracts\ControllerAbstract
{
    private $_file;
    
    public function __construct() {}
    
    public function defaultAction() {
        $css = APP_ROOT . Helpers\Config::get('templates_folder', 'html') . 
                Helpers\Config::get('template', 'html') . DS . 'css' . DS .
                strtolower(Helpers\Router::Action());
        header('Content-type: text/css');

        if (!file_exists($css)) { 
            header('HTTP/1.0 404 Not Found');
            // readfile('404missing.html');
            exit();
        }
        include $css;
        exit();
    }
    
    public function __call($name, $arguments) {
        $this->defaultAction();
    }
}
