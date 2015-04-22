<?php
namespace DLNLab\SNSContacts\Helpers;

use User;
use Session;
use Input;

/**
 * Helpers class for SNSContacts.
 * 
 * @author dinhln
 * @since  22/04/2015
 */
class SNSContactsHelper extends BaseController
{
    /**
     * Function to check csrf token.
     * 
     * @param string $token
     * @throws Illuminate\Session\TokenMismatchException
     * @return boolean
     */
    public static function checkToken($token = '') {
        if (! $token) {
            return false;
        }
        
        if (Session::token() != $token) {
            throw new Illuminate\Session\TokenMismatchException;
            return false;
        }
        
        return true;
    }
    
    /**
     * Function to get csrf token.
     * 
     * @return string
     */
    public static function getToken() {
        return Session::token();
    }
}
