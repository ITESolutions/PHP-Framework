<?php

namespace Framework\Controllers;

class IndexController extends \Framework\Abstracts\ControllerAbstract
{
    public function __construct() {
        $this->initView("html");
        $this->_view->set(array(
            'title' => 'ITE Framework'
        ));
    }


    public function defaultAction() {
        
    }
    
    public function loginAction() {
        
    }
}
