<?php

class User
{
    private $_db,
            $_data,
            $_isLoggedIn;
    
    public function __construct($user = null)
    {
        $this->_db = Database::getInstance();
        
        if (!$user) {
            if (Session::exists('user')) {
                $user = Session::get('user');
                
                if ($this->find($user)) {
                    $this->_isLoggedIn = true;
                } else {
                    // logout
                }
                
            }
        } else {
            $this->find($user);
        }
    }
    
    public function create($fields = array())
    {
        if (!$this->_db->insert('users', $fields)) {
            throw new Exception('There was an error creating your account');
        }
    }
    
    public function update($fields = array(), $id = false)
    {
        if (!$id && $this->isLoggedIn()) {
            $id = $this->data()->id;
        }
        
        if (!$this->_db->update('users', $id, $fields)) {
            throw new Exception("There was a problem updating your account");
        }
    }
    
    public function find($user)
    {
        $field = (is_numeric($user)) ? 'id' : 'username';
        $data = $this->_db->get('users', array($field, '=', $user));
        
        if ($data->count()) {
            $this->_data = $data->first();
            return true;
        }
        
        return false;
    }

    public function login($username = false, $password = false, $remember = false)
    {
        if (!$username && !$password && $this->exists()) {
            Session::put('user', $this->data()->id);
        } else {
            
            $user = $this->find($username);

            if ($user) {
                if ($this->data()->password === Hash::make($password, $this->data()->salt)) {
                    Session::put('user', $this->data()->id);

                    if ($remember) {

                        $hashCheck = $this->_db->get('session', array('user_id', '=', $this->data()->id));
                        
                        if (!$hashCheck->count()) {
                            $hash = Hash::unique();
                            $this->_db->insert('session', array(
                                'user_id' => $this->data()->id,
                                'hash' => $hash
                            ));
                        } else {
                            $hash = $hashCheck->first()->hash;
                        }

                        Cookie::put('remember', $hash, Config::get('remember/cookie_expire'));
                    }
                    return true;
                }
            }
        }
        return false;
    }
    
    public function logout()
    {
        $this->_db->delete('session', array('user_id', '=', $this->_data->id));
        Session::delete('user');
        Cookie::delete('remember');
    }
    
    public function isLoggedIn()
    {
        return $this->_isLoggedIn;
    }
    
    public function data()
    {
        return $this->_data;
    }
    
    public function exists()
    {
        return (!empty($this->_data)) ? true : false;
    }
    
    public function hasPermission($perm)
    {
        $group = $this->_db->get('group', array('id', '=', $this->data()->group));
        
        if ($group->count()) {
            $permissions = json_decode($group->first()->permissions, true);
            
            if (isset($permissions[$perm])) {
                return true;
            }
        }
        
        return false;
    }
}

