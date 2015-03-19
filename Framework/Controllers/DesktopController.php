<?php

namespace Framework\Cura\Controllers;

use Framework\Cura\helpers as helpers;

class DesktopController extends ControllerAbstract
{
    public function defaultAction() {
        new helpers\Desktop('test', uniqid() . 'BLasfdaSfdadfsdfdszdsfdsfzsdfAH' );
        new \Framework\Cura\Views\View();
    }
}
