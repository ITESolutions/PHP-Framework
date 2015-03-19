<?php

/**
 * Description of ViewAbstract
 *
 * @author corey
 */

namespace Framework\Abstracts;

abstract class ViewAbstract implements \Framework\Interfaces\iView
{
    /**
     * @var string String containing the output sent to the browser
     */
    protected $_output;

    public function __destruct() {
        $this->render();
    }
    
    public function convertHtmlToSource($input) {
        return "<pre>" . htmlspecialchars($input) . "</pre>";
    }

    public function render() {
        if (isset($_GET['source']) && DEVELOPMENT_MODE) {
            echo $this->convertHtmlToSource($this->_output);
            return;
        }
        echo $this->_output;
    }
    
}
