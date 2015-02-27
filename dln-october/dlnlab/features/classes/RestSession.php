<?php

namespace DLNLab\Features\Classes;

use Auth;
use Input;
use Response;
use Validator;
use Illuminate\Routing\Controller as BaseController;
use RainLab\User\Models\Settings as UserSettings;

require('HelperResponse.php');

class RestSession extends BaseController {
	
	public function deleteSession() {
		Auth::logout();
		return Response::json( response_message( 200 ));
	}
	
	public function postSession() {
		$data = post();
        $rules = [
            'password' => 'required|min:2'
        ];

        $loginAttribute = UserSettings::get('login_attribute', UserSettings::LOGIN_EMAIL);

        if ($loginAttribute == UserSettings::LOGIN_USERNAME)
            $rules['login'] = 'required|between:2,64';
        else
            $rules['login'] = 'required|email|between:2,64';

        if (!in_array('login', $data))
            $data['login'] = post('username', post('email'));

        $validation = Validator::make($data, $rules);
        if ($validation->fails())
            throw new ValidationException($validation);

        /*
         * Authenticate user
         */
        $user = Auth::authenticate([
            'login' => array_get($data, 'login'),
            'password' => array_get($data, 'password')
        ], true);
		
		return Response::json( response_message( 200, $user ));
	}
	
}