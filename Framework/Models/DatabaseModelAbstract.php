<?php

namespace Framework\Cura\Models;
use Framework\Cura\helpers as helpers;
abstract class DatabaseModelAbstract extends ModelAbstract implements iDatabaseModel
{
    protected static
            $_db;
    
    protected function db() {
        if (empty(self::$_db)) {
            self::$_db = helpers\Database::getInstance();
        }
        return self::$_db;
    }

    public static function getAll() {
        return helpers\Database::getInstance()->get(self::getTableName())->results();
    }
    
    public static function getTableName() {
        $classname = get_called_class();

        if (preg_match('@\\\\([\w]+)$@', $classname, $matches)) {
            $classname = $matches[1];
        }
        return strtolower($classname) . 's';
        
    }
    
    public function getParams() {
        // get_defined_vars();
    }

    public function getClass() {
        $classname = get_class($obj);

        if (preg_match('@\\\\([\w]+)$@', $classname, $matches)) {
            $classname = $matches[1];
        }
    }

    public function save() {
        if (isset($this->id)) {
            echo 'updated';
            $this->db()->update(
                    self::getTableName(), array('id', '=', $this->id)
                    );
        } else {
            $result = $this->db()->insert(
                            self::getTableName(), get_object_vars($this));
            return $result;
        }
        
    }
}
