<?php

namespace Framework\Cura\helpers;

/**
 * Cura PDO MySQL Database handler
 * @author Corey Ray
 */

class PDO extends \Framework\Cura\abstracts\DatabaseAbstract {
    
    private function __construct() {
        try {
            self::$_instance = new \PDO("mysql:host={$this->_host};dbname={$this->_dbname}",
                    $this->_user, $this->_password);
            if (defined("DEVELOPMENT_MODE")) {
                self::$_instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    
    public function query($sql, $params = array())
    {
        $this->_error = false;
        if ($this->_query = $this->_pdo->prepare($sql)) {
            $x = 1;
            if (count($params)) {
                foreach ($params as $param) {
                    $this->_query->bindValue($x, $param);
                    $x++;
                }
            }
            
            if ($this->_query->execute()) {
                $this->_results = @$this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
            } else {
                $this->_error = true;
            }
        }
        
        return $this;
    }

    private function action($action, $table, $where = array())
    {
        if (count($where) === 3) {
            $operators = array('=', '<', '>', '<=', '>=');
            
            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];
            
            if (in_array($operator, $operators)) {
                $sql = "{$action} FROM `{$table}` WHERE {$field} {$operator} ?";
                if (!$this->query($sql, array($value))->error()) {
                    return $this;
                }
            }
        } else {
            $sql = "{$action} FROM `{$table}`"; 
            if (!$this->query($sql)->error()) {
                return $this;
            }
        }
        return false;
    }
    
    public function get($table, $where = array())
    {
        return $this->action("SELECT *", $table, $where);
    }
    
    public function delete($table, $where = array())
    {
        return $this->action("DELETE", $table, $where);
    }
    
    public function insert($table, $fields = array())
    {
        if (count($fields)) {
            $keys = array_keys($fields); $values = ''; $x = 1;
            
            foreach ($fields as $field) {
                $values .= "?";
                if ($x < count($fields)) {
                    $values .= ', ';
                }
                $x++;
            }
            
            $sql = "INSERT INTO {$table} (`" . implode('`, `', $keys) . "`) VALUES ({$values})";
            
            if (!$this->query($sql, $fields)->error()) {
                return true;
            }
        }
        
        return false;
    }
    
    public function update($table, $id, $fields)
    {
        $set = ''; $x = 1;
        
        foreach ($fields as $name => $value) {
            $set .= "{$name} = ?";
            if ($x < count($fields)) {
                $set .= ',';
            }
            $x++;
        }
        
        $sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";
        
        if (!$this->query($sql, $fields)->error()) {
            return true;
        }
        
        return false;
    }

    public function getCount() {
        
    }

    public function getError() {
        
    }

    public function getFirst() {
        
    }

    public function getLast() {
        
    }

    public function getResults() {
        
    }

    public function put($values, $params) {
        
    }

}
