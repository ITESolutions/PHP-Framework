<?php

/**
 * ITE Framework Controller Abstract
 * @author Corey Ray <coreyaray@gmail.com>
 * @package ITE Framework
 * @copyright Copyright (C) 2015 ITE Solutions. All rights reserved.
 * @license GNU General Public License version 2 or later; see LICENSE.txt
 * @abstract
 */
namespace Framework\Abstracts;
use Framework\Helpers;
use Framework\Views;

abstract class ControllerAbstract implements \Framework\Interfaces\iController
{
    protected $_view, $_db;
    
    /*
     * Database Functions
     */
    private function initDb() {
        
    }
    
    protected function dbConnection() {
        if (is_null($this->_db)) {
            $this->initDb();
        }
        return $this->_db;
    }
    
    /*
     * Call the view factory and order a view of the specified type. The default type is HTML.
     */
    
    protected function initView($type = 'html') {
        $this->_view = Views\ViewFactory::getView($type);
    }
    
    /*
     * Controller Core
     */

    public function dispatch() {
        $action = \Framework\Helpers\Router::Action() . 'Action';
        $this->$action();
    }

    public function __destruct() {
        $this->dispatch();
        if (isset($_GET['benchmark'])) {
            echo 'Compile time: ' . (time() - START_TIME);
        }
    }
    
    public static function getNamespace() {
        return str_replace('Abstracts', 'Controllers', __NAMESPACE__);
    }

    public function __toString() {
        return get_called_class();
    }
}

