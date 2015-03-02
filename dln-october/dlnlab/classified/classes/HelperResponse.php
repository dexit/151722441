<?php

function response_message($error_code, $text = null, $res = null) {
	switch ($error_code) {
		case 200:
			$error_text = 'Success';
			break;
		case 201:
			$error_text = 'Create success';
			break;
		case 202:
			$error_text = 'Request friend success';
			break;
		case 203:
			$error_text = 'Phone number confirm success';
			break;
		case 204:
			$error_text = 'Send Message Success';
			break;
		case 205:
			$error_text = 'Delete Message Failed';
			break;
		case 400:
			$error_text = 'Bad Request';
			break;
		case 401:
			$error_text = 'Unauthorixed';
			break;
		case 403:
			$error_text = 'Forbidden';
			break;
		case 404:
			$error_text = 'Not Found';
			break;
		case 500:
			$error_text = 'Internal Server Error';
			break;
		case 900:
			$error_text = 'Add Successfully';
			break;
		case 901:
			$error_text = 'Block Friend Failed';
			break;
		case 902:
			$error_text = 'Block Friend Successfully';
			break;
		case 903:
			$error_text = 'Code is wrong';
			break;
		case 904:
			$error_text = 'Facebook was registed for this device';
			break;
		case 905:
			$error_text = 'Google was registed for this device';
			break;
		case 906:
			$error_text = 'No request add friend';
			break;
		case 1001:
			$error_text = 'Exists same phone number';
			break;
		case 1002:
			$error_text = 'Wrong ID or Password';
			break;
		case 1003:
			$error_text = 'This user not exists';
			break;
		case 1004:
			$error_text = 'wrong token or not exists';
			break;
		case 1005:
			$error_text = 'wrong app key';
			break;
		case 1010:
			$error_text = 'Invalid Parameters';
			break;
		case 1011:
			$error_text = 'Can not update data';
			break;
		case 1006:
			$error_text = 'Can not send message to this phone';
			break;
		case 1050:
			$error_text = 'Token is expired';
			break;
		case 1500:
			$error_text = 'Same group name exists';
			break;
		case 1600:
			$error_text = 'The user is not available';
			break;
		case 1601:
			$error_text = 'Upload failed';
			break;
		case 1003:
			$error_text = 'This user not exists';
			break;
		case 1110:
			$error_text = 'You dont own this avatar';
			break;
		default:
			$error_text = 'Unknown Error';
			break;
	}
	$arrvalue['code'] = $error_code;
	$arrvalue['data'] = $error_text;
	if ( $text ) {
		$arrvalue['data'] = $text;
	}
	return $arrvalue;
}
