<?php

/*
 * Cura MySQL Database handler
 * @author Corey Ray
 */

namespace Framework\Cura\helpers;

class MySQL extends \Framework\Cura\abstracts\DatabaseAbstract {
    
    public function getConnection() {
        self::$_instance = \mysql_connect($this->_host, $this->_user, $this->_pass, true);
        \mysql_selectdb($this->_db, self::$_instance);
    }

    public function query($sql, $params) {
        foreach ($params as $key => $param) {
            $params[$key] = mysql_real_escape_string($param[$key], self::$_instance);
        }
        mysql_db_query($sql, $query, self::$_instance);
    }

}
