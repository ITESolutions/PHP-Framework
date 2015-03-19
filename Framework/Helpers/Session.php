<?php
namespace Framework\Cura\helpers;
session_start();
class Session implements \SessionHandlerInterface
{
    public function __construct() {
        // set our custom session functions.
       session_set_save_handler(array($this, 'open'), array($this, 'close'), array($this, 'read'), array($this, 'write'), array($this, 'destroy'), array($this, 'gc'));

       // This line prevents unexpected effects when using objects as save handlers.
       register_shutdown_function('session_write_close');
    }

    public function start_session($session_name, $secure) {
         // Make sure the session cookie is not accessable via javascript.
        $httponly = true;
 
        // Hash algorithm to use for the sessionid. (use hash_algos() to get a list of available hashes.)
        $session_hash = 'sha512';

        // Check if hash is available
        if (in_array($session_hash, hash_algos())) {
            // Set the has function.
            ini_set('session.hash_function', $session_hash);
        }
        // How many bits per character of the hash.
        ini_set('session.hash_bits_per_character', 5);
        // The possible values are '4' (0-9, a-f), '5' (0-9, a-v), and '6' (0-9, a-z, A-Z, "-", ",").
 
   // Force the session to only use cookies, not URL variables.
   ini_set('session.use_only_cookies', 1);
 
   // Get session cookie parameters 
   $cookieParams = session_get_cookie_params(); 
   // Set the parameters
   session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly); 
   // Change the session name 
   session_name($session_name);
   // Now we cat start the session
   session_start();
   // This line regenerates the session and delete the old one. 
   // It also generates a new encryption key in the database. 
   session_regenerate_id(true);
    }

    public static function exists($name)
    {
        return (isset($_SESSION[$name])) ? true : false;
    }
    
    public static function put($name, $value)
    {
        return $_SESSION[$name] = $value;
    }
    
    public static function get($name)
    {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }
        
        return null;
    }
    
    public static function delete($name)
    {
        if (self::exists($name)) {
            unset($_SESSION[$name]);
        }
    }
    
    public static function flash($name, $string = '')
    {
        if (self::exists($name)) {
            $session = self::get($name);
            self::delete($name);
            return $session;
        } else {
            self::put($name, $string);
        }
        return '';
    }

    public function close() {
        
    }

    public function destroy($session_id) {
        
    }

    public function gc($maxlifetime) {
        
    }

    public function open($save_path, $name) {
        
    }

    public function read($session_id) {
        
    }

    public function write($session_id, $session_data) {
        
    }

}

?>