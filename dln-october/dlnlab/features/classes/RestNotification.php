<?php

namespace DLNLab\Features\Classes;

use Auth;
use Response;
use Validator;
use Controller as BaseController;
use DLNLab\Features\Components\ReportForm;
use DLNLab\Features\Models\Notification;

require('HelperResponse.php');

class RestReport extends BaseController {
	
	public function postRead() {
		if (!Auth::check())
            return Response::json(response_message(403, $error), 403);
		
		$data = post();
		$rules = [
			'ids' => 'required|array'
		];
		$validation = Validator::make($data, $rules);
		if ($validation->fails()) {
			return Response::json(response_message(400, $validation->messages()->first()), 400);
		}
		$user = Auth::getUser()->id;
		$ntfs = Notification::has_read($user, $data['ids']);
		
		return Response::json(response_message(200, $ntfs));
	}
	
}