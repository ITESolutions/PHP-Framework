<?php defined('CURA_START') or die();

/**
 * JavaScript handler
 *
 * @author @author Corey Ray <coreyaray@gmail.com>
 */

class JavaScript
{
    private $_script;

    public function __construct($fileName) {
        $this->loadFile($fileName);
    }
    
    private function loadFile($fileName) {
        $path = APP_ROOT . DS;
        $script = $path . $filename . '.js';
        if (!$this->_script = file_get_contents($script, true)) {
            $this->_script = '';
        }
    }
    
    public function __toString() {
        return $this->_script;
    }
}
