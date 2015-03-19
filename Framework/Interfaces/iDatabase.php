<?php

/**
 * Cura Database Class Interface
 * @author Corey Ray
 */

namespace Framework\Cura\interfaces;

interface iDatabase {
    public function query($sql, $params);
    public function get($params);
    public function put($values, $params);
    public function update($values, $params);
    public function delete($id);
    public function getCount();
    public function getResults();
    public function getFirst();
    public function getLast();
    public function getError();
}
