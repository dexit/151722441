<?php

namespace DLNLab\Features\Classes;

use Auth;
use Response;
use Controller as BaseController;
use DLNLab\Features\Components\ReportForm;

require('HelperResponse.php');

class RestReport extends BaseController {
	
	public function postSendReport() {
		$error = ReportForm::onSendReport(true);
		if (! empty($error)) {
			return Response::json(response_message(400, $error), 400);
		}
		return Response::json(response_message(200));
	}
	
}