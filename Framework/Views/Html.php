<?php

/**
 * ITE Framework View class for HTML output
 * @author Corey Ray <coreyaray@gmail.com>
 * @package ITE Framework
 * @copyright Copyright (C) 2015 ITE Solutions. All rights reserved.
 * @license GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Framework\Views;
use Framework\Helpers;

class Html extends \Framework\Abstracts\ViewAbstract
{
    const SECTION_EXPRESSION = '<!--(.*?)-->';
    const MODIFIER_EXPRESSION = '/\[([^\]]*)\]/';
    const DEFAULT_TEMPLATE = 'default';
    const TEMPLATE_EXTENSION = '.html';
    
    private $_component, $_template, $_templateData = array();


    /**
     * Construct
     */
    
    public function __construct() {
        $this->_initialize();
    }
    
    /**
     * 
     */

    private function _initialize() {
        $this->setTemplate(Helpers\Config::get('template'));      
    }
    
    /**
     * 
     */
    
    private function _loadTemplate() {
        ob_start();
        include $this->_template;
        $this->_output = ob_get_contents();
        ob_end_clean();
    }
    
    /**
     * 
     */
    
    private function _templateFolder() {
        return APP_ROOT . Helpers\Config::get('templates_folder');
    }

    /**
     * Getter method for the view data that will be rendered into the template
     * @param type $name
     * @return type
     */
    
    public function get($name) {
        if (is_array($name)) {
            return array_intersect_key($this->_templateData, $name);
        }
        return $this->_templateData[$name];
    }
    
    /**
     * 
     * @param type $values
     */

    public function set($values) {
        if (is_array($values)) {
            foreach ($values as $key => $value) {
                $this->_templateData[$key] = $value;
            }
        }
    }
    
    /**
     * 
     * @param type $template
     */

    public function setTemplate($template) {
        $this->_template = $this->_templateFolder() . $template . DS . 'template' . self::TEMPLATE_EXTENSION;
    }
    
    private function _setComponent() {
        $this->_component = __DIR__ . DS . Helpers\Router::ControllerName() . DS . Helpers\Router::Action() . '.php';
        
        $this->set(array(
            'component' => function() {
                if (file_exists ($this->_component)) {
                    ob_start();
                    include $this->_component;
                    $buffer = ob_get_flush();
                    ob_end_clean();
                    return $buffer;
                }
                return 'Component not found: ' . $this->_component;
            }
        ));
    }
    
    public function render() {
        $this->_loadTemplate();
        $this->_setComponent();
        foreach ($this->_templateData as $key => $value) {
            if (is_callable($value)) {
                $value = $value();
            }
            $this->_output = str_replace('<!--' . strtoupper($key) . '-->', $value, $this->_output);
            
        }
        
        $this->_output = str_ireplace(array(
            '{b}',
            '{/b}',
            '{i}',
            '{/i}'
        ), array(
            '<strong>',
            '</strong>',
            '<em>',
            '</em>'
        ), $this->_output);
        
        parent::render();
    }
}
