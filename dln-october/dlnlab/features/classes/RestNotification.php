<?php

namespace DLNLab\Features\Classes;

use Auth;
use Response;
use Validator;
use Illuminate\Routing\Controller as BaseController;
use DLNLab\Features\Components\ReportForm;
use DLNLab\Features\Models\Notification;

require('HelperResponse.php');

class RestNotification extends BaseController {
	
	public function postRead() {
		if (!Auth::check())
            return Response::json(array('status' => 'error', 'message' => trans(CLF_LANG_MESSAGE . 'require_signin')), 500);
		
		$data = post();
		$valid['ids'] = (isset($data['ids'])) ? str_replace(',', '', $data['ids']) : '';
		$rules = [
			'ids' => 'required|numeric'
		];
		$validation = Validator::make($valid, $rules);
		if ($validation->fails()) {
			return Response::json(response_message(400, $validation->messages()->first()), 400);
		}
		$user = Auth::getUser();
		$ntfs = Notification::has_read($user, $data['ids']);
		
		return Response::json(response_message(200, $ntfs));
	}
	
}