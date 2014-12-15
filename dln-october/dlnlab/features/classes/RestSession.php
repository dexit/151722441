<?php

namespace DLNLab\Features\Classes;

use Auth;
use Input;
use Response;
use Controller as BaseController;

require('HelperResponse.php');

class RestSession extends BaseController {
	
	public function deleteSession() {
		Auth::logout();
		return Response::json( response_message( 403 ), 403 );
	}
	
	public function postSession() {
		
	}
	
}