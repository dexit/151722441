<?php

namespace DLNLab\Features\Classes;

use Auth;
use Input;
use Response;
use Controller as BaseController;
use DLNLab\Features\Models\MessageThreads;
use DLNLab\Features\Models\MessageRecipients;

require('HelperResponse.php');

class RestMessage extends BaseController {
    
    public function postAddMessage() {
        //if (!Auth::check())
            //return null;
		
        $result = null;
		
		//MessageThreads::addThread(1, 2, "Test message");
		//MessageRecipients::getInboxCount(2);
		MessageThreads::userIsSender(1);
        
        return Response::json( response_message( 200, $result ));
    }
    
}