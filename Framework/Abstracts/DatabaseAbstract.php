<?php

/*
 * Cura Database Class
 * @author Corey Ray
 */

namespace Framework\Cura\abstracts;

abstract class DatabaseAbstract implements \Framework\Cura\interfaces\iDatabase {
    
    protected $_host, $_user, $_pass, $_db;
    protected static $_instance = false;
    
    public function connection() {
        if (!static::$_instance) {
            static::$_instance = new $this;
        }
        return static::$_instance;
    }
    
    private function buildSQLQuery($params) {
        if (!count($params) || !isset($params['action'])) return false;
        switch ($params['action']) {
            case 'select':
                $sql = 'SELECT ' . (isset($params['columns'])) ? \implode(', ', $params['columns']): '*';
        }
        if (isset($params['where'])) { $sql .= ' WHERE ' . $params['where']; }
        if (isset($params['limit'])) { $sql .= ' LIMIT ' . $params['limit']; }
    }
}
