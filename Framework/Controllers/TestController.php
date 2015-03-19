<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Framework\Cura\Controllers;

use Framework\Cura\helpers as helpers;

class TestController extends ControllerAbstract
{
    public function defaultAction() {
        new helpers\Notification('test');
        new helpers\Notification('test 2');
        new helpers\Notification('test 3');
        new helpers\Notification('test 4');
        $this->view = new \Framework\Cura\Views\View();
    }
}
