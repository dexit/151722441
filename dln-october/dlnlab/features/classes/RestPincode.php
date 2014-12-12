<?php

namespace DLNLab\Features\Classes;

use Input;
use Response;
use Controller as BaseController;
use DLNLab\Features\Models\Pincode;

class RestPincode extends BaseController {
	
	public function getPincode() {
		if ( !Input::has('user_id') || !Input::has('phone_number') )
			return;
		
		if (empty(Input::get('user_id')))
			return;
		
		$phone_number = Input::get('phone_number');
		$user_id      = Input::get('user_id');
		$code         = strtolower( self::generate_password(5) );
		
		// Insert pincode
		$pincode = new Pincode();
		$pincode->status       = '0';
		$pincode->code         = $code;
		$pincode->phone_number = $phone_number;
		$pincode->user_id      = $user_id;
		$pincode->save();
		
		$result = self::send_sms($phone_number, $code);
		
		return Response::json( self::response_message( 200 ) );
	}
	
	private static function send_sms( $phone_number, $code ) {
		require('libraries/twilio/Services/Twilio.php');
		$client = new \Services_Twilio(TWILIO_ACCOUNT, TWILIO_TOKEN); 

		$result = $client->account->messages->create(array( 
			'To' => COUNTRY_CODE . $phone_number,
			'From' => TWILIO_NUMBER,
			'Body' => str_replace( '__code__', $code, SMS_TEMPLATE )
		));
		
		return $result;
	}
	
	private static function response_message($error_code, $res = null) {
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
        $arrvalue['text'] = $error_text;
        return $arrvalue;
    }
	
	private static function generate_password($length = 4) {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $count = mb_strlen($chars);
        for ($i = 0, $result = ''; $i < $length; $i++) {
            $index = rand(0, $count - 1);
            $result .= mb_substr($chars, $index, 1);
        }

        return $result;
    }
}