<?php

/**
 * ITE Framework View class
 * @author Corey Ray <coreyaray@gmail.com>
 * @package ITE Framework
 * @copyright Copyright (C) 2015 ITE Solutions. All rights reserved.
 * @license GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Framework\Views;
use Framework\Helpers;

abstract class ViewFactory
{
    /**
     * 
     * @param string $type Case-insensitive type of view to fetch: Defaults to HTML if left blank
     * @return \Framework\Views\Xml|\Framework\Views\Html|\Framework\Views\Output|\Framework\Views\Json
     */
    
    public static function getView($type = 'html') {
        switch (strtoupper($type)) {
            case 'HTML':
                return new \Framework\Views\Html();
            case 'XML':
                return new \Framework\Views\Xml();
            case 'JSON':
                return new \Framework\Views\Json();
            default :
                return new \Framework\Views\Output();
        }
    }
}
