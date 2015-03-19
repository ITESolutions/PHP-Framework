<?php

/**
 * Description of DOMFactory
 *
 * @author Corey Ray <coreyaray@gmail.com>
 */

namespace Framework\Helpers;

class DOMFactory
{
    const LIST_NUMBERED = 'ol';
    const LIST_BULLETED = 'ul';
    private static $_buffer;

    /**
     * Generates an HTML list from an the values of an array
     * @param array $array The array of values to use in the list
     * @param string $id The id to assign to the list
     * @param string $class The class to assign to the list
     * @param flag $type select numbered list (LIST_NUMBERED) or defaults to bulleted list (LIST_BULLETED)
     */

    public static function listFromArray($array, $id = NULL, $class = NULL, $type = self::LIST_BULLETED) {
        self::$_buffer = "<{$type} id=\'{$id}\' class=\'{$class}\' >" . PHP_EOL;
        foreach ($array as $value) {
            self::$_buffer .= "    <li>{$value}</li>" . PHP_EOL;
        }
        self::$_buffer .= "<\{$type}>" . PHP_EOL;
        return self::$_buffer;
    }
    
    
    public static function tableFromArray($array, $id = NULL, $class = NULL) {
        self::$_buffer = "<table id=\'{$id}\' class=\'{$class}\' >" . PHP_EOL;
        if (!is_indexed($array)) {
            $keys = array_keys($array);
            
        }
    }
}
