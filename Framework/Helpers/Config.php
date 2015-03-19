<?php
/**
 * ITE Framework Config class
 * 
 * @author Corey Ray <coreyaray@gmail.com>
 * @package ITE Framework
 */

namespace Framework\Helpers;

abstract class Config {
    
    /**
     * An associative array containing the configuration values
     * @var array
     */
    
    private static  $_config = FALSE;
    
    const           DEFAULT_CONFIG_FILE = 'default.ini',
                    CONFIG_FILE = 'config.ini',
                    PARSE_SECTIONS = TRUE;
    
    /**
     * Function to initiate loading of configuration values from the configuration file.
     * @return boolean
     */
    
    public static function initialize() {
        return self::_loadConfig();
    }
    
    /**
     * Function to grab values from the application configuration. The calling class is used to devide keys by sections.
     * 
     * @param string $name The key of the value to return. Null is returned if no key exists with the same value as $name.
     * @return string
     */
    
    public static function get($key, $section = FALSE) {
        if (!self::$_config) { \trigger_error("edit later in Config.php"); }
        $section = ($section) ?: strtolower (\get_calling_class());
        if (is_array (self::$_config) && array_key_exists ($section, self::$_config)) {
            return self::$_config[$section][$key];
        }
        return null;
    }
    
    /**
     * Function to set config values. If $value is left out, the configuration value with a key of $name is unset.
     * 
     * @param string $name The key of the value to set
     * @param mixed $value
     */
    
    public static function put($name, $value = FALSE) {
        $section = get_calling_class();
        if ($value) {
            self::$_config[][$name] = $value;
        }
        if (isset (self::$_config[$section()][$name])) {
            unset (self::$_config[$section()][$name]);
        }
    }
    
    /**
     * 
     */
    
    private static function _installConfig() {
        $default = self::configPath() . self::DEFAULT_CONFIG_FILE;
        if (!file_exists($default)) trigger_error ("No configuration files found!");
        if (!self::$_config = parse_ini_file(self::configPath() . self::DEFAULT_CONFIG_FILE, self::PARSE_SECTIONS)) {
            trigger_error('Unable to install default config file: ' . $default);
            return FALSE;
        }
        self::writeConfigFile();
    }
    
    /**
     * 
     */
    
    private static function _loadConfig() {
        $config = self::configPath() . self::CONFIG_FILE;
        if (!file_exists($config)) {
            return self::_installConfig();
        }
        self::$_config = parse_ini_file($config, self::PARSE_SECTIONS);
        define('CONFIG_LOADED', 1);
    }
    
    /**
     * 
     * @return type
     */

    public static function configPath() {
        return APP_ROOT . DS;
    }
    
    /**
     * 
     */

    public static function writeConfigFile() {
        $res = array();
        foreach (self::$_config as $key => $val)
        {
            if (is_array ($val))
            {
                $res[] = "[$key]";
                foreach ($val as $skey => $sval) {
                    $res[] = "$skey = ".(is_numeric($sval) ? $sval : "\"{$sval}\"");
                }
            }
            else $res[] = "$key = " . (is_numeric ($val) ? $val : '"'.$val.'"');
        }
        $data = '; <?php exit(); die();' . PHP_EOL . implode(PHP_EOL, $res);
        file_rewrite (self::configPath() . self::CONFIG_FILE, $data);
    }
}