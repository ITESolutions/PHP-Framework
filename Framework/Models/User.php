<?php

namespace Framework\Models;

class User extends DatabaseModelAbstract
{
    private static $_dbTable = 'users';

    protected
            $firstName,
            $lastName,
            $street,
            $city,
            $zip,
            $phone,
            $email,
            $joined,
            $password,
            $salt;
    
    public function setAddress($street = null, $city = null, $zip = null) {
        $this->street = $street;
        $this->city = $city;
        $this->zip = $zip;
        
        return $this;
    }
}