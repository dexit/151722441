<?php

namespace DLNLab\Features\Classes;

use Auth;
use Input;
use Response;
use Validator;
use Controller as BaseController;
use DLNLab\Features\Models\Pincode;
use RainLab\User\Models\User;

require('HelperResponse.php');

class RestPincode extends BaseController {
	
	public function postGetPincode() {
		if (!Auth::check()) {
			return Response::json(array('status' => 'error', 'message' => trans(CLF_LANG_MESSAGE . 'require_signin')), 500);
		}
		
		if ( !Input::has('phone_number') )
			return;
		
		$user = Auth::getUser();
		if ($user->is_validated) {
			return Response::json( response_message(200, 'User has activated'));
		}
		
		$rules = array(
		    'phone_number' => 'numeric'
		);
		if ($response = self::valid($rules))
	        return Response::json($response);
		
		$phone_number = Input::get('phone_number');
		$user_id      = $user->id;
		
		// Check last code has completed?
		$last_pincode = Pincode::getLastPincode($phone_number);
		if ( empty($last_pincode) ) {
			// Not exists code send complete then create new code
		    $code   = strtolower(self::generate_password());
		    $result = self::send_sms($phone_number, $code);
		    
			if ($result) {
				// Insert pincode
				$pincode = new Pincode();
				$pincode->status       = '0';
				$pincode->code         = $code;
				$pincode->phone_number = $phone_number;
				$pincode->user_id      = $user_id;
				$pincode->error        = $result->error_message;
				$pincode->save();
			}
		} else if($last_pincode->status == '1') {
			return Response::json( response_message(400, 'Phone Number has activated'));
		} else {
		    // Has exist last code not validate then use current code
		    $code                = $last_pincode->code;
		    $result              = self::send_sms($phone_number, $code);
		    $last_pincode->error = $result->error_message;
		    $last_pincode->update();
		}
		
		return Response::json( response_message(200));
	}
	
	public function postValidPincode() {
		if (!Auth::check()) {
			return Response::json(array('status' => 'error', 'message' => trans(CLF_LANG_MESSAGE . 'require_signin')), 500);
		}
		
	    if (!Input::has('pincode'))
	        return;
	    
	    $rules = array(
	        'pincode'      => 'required|alpha_num|size:4'
	    );
	    if ($response = self::valid($rules))
	        return Response::json($response);
	    
	    //$phone_number = Input::get('phone_number');
		$user_id = Auth::getUser()->id;
	    $pincode = Input::get('pincode');
	    
		// Get pincode inactive
	    $check = Pincode::getLastPincodeInActive($user_id, $pincode);
	    if ($check && !empty($check->phone_number)) {
			// Exists pincode inactive in db
	        if (Pincode::ActivePincode($check->phone_number)) {
				// Update user has actived
				$user = User::where('id', $user_id)->update(array('is_validated' => 1, 'phone_number' => $check->phone_number));
				if (isset($user->errors)) {
					return Response::json( response_message( 400, $user->errors()->first() ), 400 );
				}
			}
            
            return Response::json( response_message( 200 ) );
	    } else {
	        return Response::json( response_message( 1006 ) );
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
	        $response = response_message(1006, $valid->messages()->first());
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
