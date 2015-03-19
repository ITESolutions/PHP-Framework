<?php

namespace Framework\Cura\Models;
use Framework\Cura\helpers as helpers;

abstract class ModelAbstract
{
    protected $id;
    
    public function __construct($params = null) {
        if ($params instanceof \stdClass) { $params = \get_object_vars($params); }
        
        if (is_array($params)) {
            foreach ($params as $param => $value) {
                $this->$param = $value;
            }
        }
    }
    
    public function __toString() {
        return $this->id;
    }
    
    /*
     * Getter/Setter functions
     */
    public function __call($name, $arguments) {
        $prefix = substr($name, 0, 3);
        $property = lcfirst(substr($name, 3));
        
        switch ($prefix) {
            case 'get':
                return $this->$property;
                break;
            case 'set':
                $this->$property = $arguments[0];
                return $this;
                break;
            default :
                throw new \Exception('Undefined method');
        }
    }
    
    public function renderWith($callback) {
        $data = get_object_vars($this);
        return $callback($data);
    }
    
    public static function getFromPost($className) {
        $class = __NAMESPACE__ . '\\' . $className;
        $properties = array_diff_key(
                get_class_vars($class),
                get_class_vars(get_parent_class($class)
            )
        );
        $object = new $class();
        foreach (\array_keys($properties) as $property) {
            $object->$property = helpers\Input::get($property);
        }
        return $object;
    }
    
    public function getParams() {
        return get_object_vars($this);
    }
    
    public static function __callStatic($name, $arguments) {
        ;
    }
}
