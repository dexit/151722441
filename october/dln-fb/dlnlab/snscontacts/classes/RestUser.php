<?php
namespace DLNLab\SNSContacts\Classes;

use Illuminate\Routing\Controller as BaseController;
use DLNLab\SNSContacts\Helpers\SNSContactsHelper;
use RainLab\User\Models\Settings as UserSettings;
use Validator;
use User;
use Auth;

/**
 * Restful for User api.
 *
 * @author dinhln
 * @since 22/04/2015
 */
class RestUser extends BaseController
{

    /**
     * Api function for get csrf token.
     *
     * @return string
     */
    public function getToken()
    {
        $token = '';
        
        // Get token csrf.
        $token = SNSContactsHelper::getToken();
        
        return $token;
    }

    /**
     * Api function for get user by id.
     * 
     * @param number $user_id
     * @return Response
     */
    public function getUser($user_id = 0)
    {
        /* Validator request params */
        $valids = Validator::make([
            'user_id' => $user_id
        ], [
            'user_id' => 'required|numeric|min:1'
        ], SNSContactsHelper::getMessage());
        
        if ($valids->fails) {
            return SNSContactsHelper::getErrorMsg($valids->messages());
         }
         
         /* Get user by id */
         $user = User::find($user_id);
         
         return SNSContactsHelper::getSuccess($user);
    }
    
    /**
     * Api function for add new user
     * 
     * @return Response
     */
    public function postUser()
    {
        $data = post();
        
        /* Validator request params */
        $valids = Validator::make($data, [
            'name' => 'required',
            'email'    => 'required|email|between:2,64',
            'password' => 'required|min:2',
            'password_confirmation' => 'required|confirmed'
        ]);
        
        if ($valids->fails()) {
            return SNSContactsHelper::getErrorMsg($valids->messages());
        }
        
        $automaticActivation = UserSettings::get('activate_mode') == UserSettings::ACTIVATE_AUTO;
        $user = Auth::register($data, $automaticActivation);
        
        /*
         * Automatically activated or not required, log the user in
         */
        if ($automaticActivation || !$requireActivation) {
            Auth::login($user);
        }
        
        return SNSContactsHelper::getSuccess($user);
    }
}
