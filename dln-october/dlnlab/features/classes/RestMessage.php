<?php

namespace DLNLab\Features\Classes;

use Auth;
use Input;
use Response;
use Controller as BaseController;
use DLNLab\Features\Models\MessageThreads as Message;

require('HelperResponse.php');

class RestMessage extends BaseController {
    
    public function postAddMessage() {
        //if (!Auth::check())
            //return null;
		
        $result = null;
		
		Message::add_thread(1, 2, "Test message");
        
        return Response::json( response_message( 200, $result ));
    }
    
}