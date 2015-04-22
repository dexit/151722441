<?php
namespace DLNLab\SNSContacts\Classes;

use Illuminate\Routing\Controller as BaseController;
use DLNLab\SNSContacts\Helpers\SNSContactsHelper;

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
        $token = SNSContactsHelper::getToken();
        
        return $token;
    }
}
