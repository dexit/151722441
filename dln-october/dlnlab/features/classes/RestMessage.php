<?php

namespace DLNLab\Features\Classes;

use Auth;
use Cache;
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
		MessageRecipients::getInboxCount(2);
		//MessageThreads::userIsSender(1);
        
        return Response::json( response_message( 200, $result ));
    }
	
	public function getTest() {
        //if (!Auth::check())
            //return null;
		
        $result = null;
		
		var_dump(Cache::get('messages_unread_count2'));die();
        return Response::json( response_message( 200, $result ));
    }
    
}