<?php

namespace Framework\Controllers;
use Framework\Helpers;

/**
 * Description of JsController
 *
 * @author corey
 */

class JsController extends \Framework\Abstracts\ControllerAbstract
{
    public function defaultAction() {
        $js = APP_ROOT . Helpers\Config::get('templates_folder', 'html') . 
                Helpers\Config::get('template', 'html') . DS . 'JS' . DS .
                strtolower(Helpers\Router::Action());
        header('Content-type: text/javascript');

        if (!file_exists($css)) { 
            header('HTTP/1.0 404 Not Found');
            // readfile('404missing.html');
            exit();
        }
        include $js;
        exit();
    }
    
    public function __call() {
        $this->defaultAction();
    }
}
