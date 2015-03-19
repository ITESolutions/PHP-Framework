<?php
namespace Framework\Cura\helpers;
class Input
{
    public static function exists($type = 'post')
    {
        switch ($type) {
            default :
            case 'post':
                return (!empty($_POST)) ? true : false;
                break;
            case 'get':
                return (!empty($_GET)) ? true : false;
                break;
        }
        
        return true;
    }
    
    public static function get($key)
    {
        if ($input = filter_input(INPUT_POST, $key)) return $input;
        return '';
    }
    
    public static function display($key)
    {
        echo escape(self::get($key));
    }
}

?>