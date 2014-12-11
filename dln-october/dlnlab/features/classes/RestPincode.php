<?php

namespace DLNLab\Features\Classes;

use Response;
use Controller as BaseController;

class RestPincode extends BaseController {
	
	public function test() {
		return Response::json(array(
			'error' => false,
			'urls' => '$urls->toArray()'),
			200
		);
	}
	
}