<?php
namespace DLNLab\FBNews\Classes;

use Illuminate\Routing\Controller as BaseController;
use User;
use Session;

/**
 * Restful for User api.
 * 
 * @author dinhln
 * @since  22/04/2015
 */
class RestUser extends BaseController
{
    /**
     * Api function for get csrf token.
     * 
     * @return string
     */
    public function getToken() {
        $token = '';
        
        // Get token csrf.
        $token = Session::token();
        
        return $token;
    }
}
