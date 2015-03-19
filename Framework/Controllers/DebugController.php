<?php

/**
 * Description of DebugController
 *
 * @author corey
 */

namespace Framework\Controllers;
use Framework\Abstracts;
use Framework\Helpers;

class DebugController extends Abstracts\ControllerAbstract
{
    public function defaultAction() {
        
    }

    public function phpinfoAction() {
        phpinfo();
    }
}
