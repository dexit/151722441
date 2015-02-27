<?php

namespace DLNLab\Classified\Classes;

use Auth;
use DB;
use Input;
use Response;
use Request;
use Redirect;
use Validator;
use Illuminate\Routing\Controller as BaseController;
use October\Rain\Support\ValidationException;
use DLNLab\Classified\Components\Account;
use DLNLab\Classified\Classes\HelperClassified;

require('HelperResponse.php');

class RestAccount extends BaseController {
    
    public function postLogin() {
        try {
            Account::onSignin();
        } catch(Exception $e) {
            throw $e;
            return false;
        }
        
        return Response::json(array('status' => 'success', 'data' => 'Login success!'), 200);
    }
    
    public function getLogout() {
        HelperClassified::save_return_url();
        
        try {
            Auth::logout();
        } catch (Exception $e) {
            throw $e;
            return false;
        }
        
        return Redirect::to(HelperClassified::redirect_return_url());
    }
}