<?php

namespace Framework\Cura\Controllers;

/**
 * Cura API Controller
 *
 * @author Corey Ray (ITE Solutions)
 */

class ApiController extends abstracts\ControllerAbstract
{
    private $_data, $_table, $_userId;
    
    private function _initialize() {
        $this->initDb();
        $this->_data = filter_input_array(INPUT_POST);
        $this->_table = $this->_data['table'];
        $this->_userId = $this->_data['user_id'];
        $test = $this->_db->query("SELECT * FROM ver")->results();
    }
    
    
    
    public function defaultAction() {
        die("Cura API: Use administration portal to set up.");
    }
    
    public function getAction() {
        $this->_initialize();
        $where = $this->_data['where'];
        $sql = "SELECT * FROM {$this->_table}";
        if (is_array($where) && count($where) === 3) {
            //$sql .= " WHERE {$where['column']} = {$where['value']}";
            die(json_encode($this->_db->get($this->_table, $where)));
        }
        die(json_encode($this->_db->get($this->_table)));
        
    }
    
    public function putAction() {
        
        die();
    }
    
    public function updateAction() {
        
        die();
    }
    
    public function deleteAction() {
        
        die();
    }
}
