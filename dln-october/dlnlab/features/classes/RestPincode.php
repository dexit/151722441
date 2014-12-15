<?php

namespace DLNLab\Features\Classes;

use Auth;
use Input;
use Response;
use Validator;
use Controller as BaseController;
use DLNLab\Features\Models\Pincode;

require('HelperResponse.php');

class RestPincode extends BaseController {
	
	public function postGetPincode() {
		if (!Auth::check()) {
			return Response::json( response_message( 403 ), 403 );
		}
		
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
		
		return Response::json( response_message(200));
	}
	
	public function postValidPincode() {
		if (!Auth::check()) {
			return Response::json( response_message( 403 ), 403 );
		}
		
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
