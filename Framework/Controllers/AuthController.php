<?php

namespace Framework\Controllers;

/**
 * Description of AuthController
 *
 * @author corey
 */
class AuthController extends \Framework\Abstracts\ControllerAbstract
{
    public function __construct() {
        session_start();
    }
    
    public function defaultAction() {
        
    }
    
    public function loginAction() {
        
        if (Helpers\Input::exists() && Helpers\Token::check(Helpers\Input::get('token'))) {
            $valid = helpers\Validation::check(array(
                'username' => array(
                    'required' => true,
                    'name' => 'Username'
                ),
                'password' => array(
                    'required' => true,
                    'name' => 'Password'
                )
            ));
            
            if (empty($valid->errors())) {
                
            } else {
                $_SESSION['errors']['login'] = $valid->errors;
            }
        }
    }
    
    public function logoutAction() {
        
    }
}
