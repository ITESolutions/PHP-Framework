<?php

/**
 * ITE Framework abstract class containing hashing functions.
 * 
 * @author Corey Ray <coreyaray@gmail,com>
 */

namespace Framework\Helpers;

abstract class Hash
{
    public static function HMAC($string, $salt = '') {
        return hash_hmac("sha256", $string, $salt);
    }
    
    public static function SHA($string) {
        return hash('sha256', $string);
    }

    public static function salt($size) {
        return mcrypt_create_iv($size);
    }
    
    public static function unique() {
        return self::make(uniqid());
    }
}