<?php

namespace DLNLab\Classified\Classes;

use Auth;
use DB;
use Input;
use Response;
use Validator;
use Controller as BaseController;
use October\Rain\Support\ValidationException;
use DLNLab\Classified\Components\Account;

require('HelperResponse.php');

class RestAccount extends BaseController {
    
    public function postLogin() {
        try {
            Account::onSignin();
        } catch(Exception $e) {
            throw $e;
        }
        
        return false;
    }
}