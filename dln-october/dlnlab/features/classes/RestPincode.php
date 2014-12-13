<?php

namespace DLNLab\Features\Classes;

use Input;
use Response;
use Validator;
use Controller as BaseController;
use DLNLab\Features\Models\Pincode;

class RestPincode extends BaseController {
	
	public function postGetPincode() {
		if ( !Input::has('user_id') || !Input::has('phone_number') )
			return;
		
		$rules = array(
		    'phone_number' => 'numeric',
		    'user_id'      => 'numeric'
		);
		if ($response = self::valid($rules))
	        return Response::json($response);
		
		$phone_number = Input::get('phone_number');
		$user_id      = Input::get('user_id');
		
		// Check last code has completed?
		$last_pincode = Pincode::whereRaw( 'user_id = ? AND status = 0', array( $user_id ) )->first();
		if ( $last_pincode ) {
		    // Has exist last code not validate then use current code
		    $code                = $last_pincode->code;
		    $result              = self::send_sms($phone_number, $code);
		    $last_pincode->error = $result->error_message;
		    $last_pincode->update();
		} else {
		    // Not exists code send complete then create new code
		    $code = strtolower(self::generate_password());
		    $result = self::send_sms($phone_number, $code);
		    
		    // Insert pincode
		    $pincode = new Pincode();
		    $pincode->status       = '0';
		    $pincode->code         = $code;
		    $pincode->phone_number = $phone_number;
		    $pincode->user_id      = $user_id;
		    $pincode->error        = $result->error_message;
		    $pincode->save();
		}
		
		return Response::json( self::response_message(200));
	}
	
	public function postValidPincode() {
	    if (!Input::has('phone_number') || !Input::has('pincode'))
	        return;
	    
	    $rules = array(
	        'pincode'      => 'alpha_num|size:4',
	        'phone_number' => 'numeric'
	    );
	    if ($response = self::valid($rules))
	        return Response::json($response);
	    
	    $phone_number = Input::get('phone_number');
	    $pincode      = Input::get('pincode');
	    
	    $check = Pincode::whereRaw('phone_number = ? AND code = ? AND status = 0', array($phone_number, $pincode))->first();
	    if ($check) {
	        // Update user has actived
	        Pincode::where('phone_number', $phone_number)->update(array('status' => 1));
            
            return Response::json( self::response_message( 200 ) );
	    } else {
	        return Response::json( self::response_message( 1006 ) );
	    }
	}
	
	private static function valid($rules) {
	    $response = null;
	    $messages = array(
	        'between'   => ':attribute phải nằm trong khoảng :min - :max số.',
	        'numeric'   => ':attribute phải dùng dạng số',
	        'alpha_num' => ':attribute không được có ký tự đặc biệt',
	        'size'      => ':attribute bị giới hạn :size ký tự'
	    );
	    $valid = Validator::make(Input::all(), $rules, $messages);
	    if ($valid->fails()) {
	        $response = self::response_message(1006, $valid->messages()->first());
	    }
	    
	    return $response;
	}
	
	private static function send_sms( $phone_number, $code ) {
		require('libraries/twilio/Services/Twilio.php');
		
		$http = new \Services_Twilio_TinyHttp(
		    'https://api.twilio.com',
		    array('curlopts' => array(
		        CURLOPT_SSL_VERIFYPEER => false,
		        CURLOPT_SSL_VERIFYHOST => 2,
		    ))
	    );
	    $client = new \Services_Twilio(TWILIO_ACCOUNT, TWILIO_TOKEN, "2010-04-01", $http);

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
        if ( $res ) {
            $arrvalue['text'] = $res;
        }
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