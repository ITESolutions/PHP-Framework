<?php

/*
 * 
 */

namespace Framework\Helpers;

class Database {
    private static $_connection = false;
    protected $_query, $_error = false, $_results, $_count = 0;
    
    public function __construct($type) {
        switch (strtoupper($type)) {
            case "PDO":
                $class = "\\Framework\\Cura\\helpers\\PDO";
                break;
            case "MYSQLI":
                $class = "\\Framework\\Cura\\helpers\\MySQLi";
                break;
            case "SQLITE":
                $class = "\\Framework\\Cura\\helpers\\SQLite";
                break;
            case 'CSV':
                $class = "\\Framework\\Cura\\helpers\\CSV";
                break;
            default:
            case "MYSQL":
                $class = "\\Framework\\Cura\\helpers\\MySQL";
        }
        
        self::$_connection = call_user_func($class::getConnection());
    }
    
    public function query($sql, $params = array())
    {
        return static::$_connection->query($sql, $params);
    }
    
    public function get($params) {
        return static::$_connection->get($params);
    }
    
    public function put($values, $params) {
        return static::$_connection->put($values, $params);
    }
    
    public function update($values, $params) {
        return static::$_connection->update($values, $params);
    }
    
    public function delete($id) {
        return static::$_connection->delete($id);
    }
    
    public function getCount()
    {
        return static::$_connection->getCount();
    }
    
    public function getResults()
    {
        return static::$_connection->getResults();
    }
    
    public function getFirst()
    {
        return static::$_connection->getFirst();
    }
    
    public function getLast() {
        return static::$_connection->getLast();
    }
    
    public function getError()
    {
        return static::$_connection->getError();
    }
}
?>