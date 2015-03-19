<?php

/*
 * @author Corey Ray <coreyaray@gmail.com>
 */
namespace Framework\Cura\helpers;
class Validation
{
    private $_passed = false,
            $_errors = array(),
            $_db = null;
    
    private function __construct()
    {
        if ($this->_db) {
            $this->_db = Database::getInstance();
        }
    }
    
    public static function check($items = array())
    {
        $source = filter_input_array(INPUT_POST);
        $instance = new Validation();
        
        foreach ($items as $item => $rules) {
            $itemName = (isset($rules['name'])) ? $rules['name'] : 'No Name';
            foreach ($rules as $rule => $ruleValue) {
                
                $value = trim($source[$item]);
                if ($rule === 'required' && empty($value)) {
                    $instance->addError("{$itemName} is required");
                } else if(!empty ($value)) {
                    switch ($rule) {
                        case 'min':
                            if (strlen($value) < $ruleValue) {
                                $instance->addError("{$itemName} must be at least {$ruleValue} characters long");
                            }
                            break;
                        case 'max':
                            if (strlen($value) > $ruleValue) {
                                $instance->addError("{$itemName} cannot be longer than {$ruleValue} characters");
                            }
                            break;
                        case 'matches':
                            if ($value != $source[$ruleValue]) {
                                $instance->addError("{$ruleValue} must match {$item} ");
                            }
                            break;
                        case 'unique':
                            $check = $instance->_db->get($ruleValue, array($item, '=', $value));
                            
                            if ($check->count()) {
                                $instance->addError("{$itemName} must be unique");
                            }
                            break;
                        case 'phone':
                            break;
                        case 'email':
                            break;
                        case 'website':
                            $preg = "/^(https?:\/\/)([\da-z\.-]+)\.([a-z\.]{2,6})(\/([\da-z\.-]+))*\/?(([\w\.-]+)\.([\da-z]{2,6}))?((\#[\w\.-]+)|(\?([\da-z]+(=[\da-z]+)?)(&([\da-z]+(=[\da-z]+)?))*))?/i";
                            if (!preg_match($preg, $value)) {
                                $instance->addError("{$itemName} must be  a valid website");
                            }
                    }
                }
            }
        }
        
        if (empty($instance->errors())) {
            $instance->confirm();
        }
        
        return $instance;
    }
    
    private function confirm() {
        $this->_passed = true;
    }
    
    public function passed()
    {
        return $this->_passed;
    }
    
    public function __toString() {
        return $this->passed();
    }

    private function addError($error)
    {
        $this->_errors[] = $error;
    }
    
    public function errors()
    {
        return $this->_errors;
    }
}