<?php

namespace DLNLab\Classified\Classes;

use Auth;
use Input;
use Response;
use Redirect;
use Validator;
use Controller as BaseController;
use DLNLab\Classified\Models\UserAccessToken;
use DLNLab\Classified\Models\AdShare;

require('HelperResponse.php');

class RestAccessToken extends BaseController {
    
    public static $graph = 'https://graph.facebook.com/v2.2/';
    public static $host  = 'http://localhost/october/';
    
    public function getAuthenticateFB() {
        if (! Auth::check())
            return Response::json(array('status' => 'error'), 500);
        
        $app_id       = UserAccessToken::$app_id;
        $perms        = 'user_about_me,email,manage_pages,publish_actions';
        $redirect_uri = 'http://localhost/october/api/v1/callback_fb';
        $login_link   = "https://www.facebook.com/dialog/oauth?client_id={$app_id}&redirect_uri={$redirect_uri}&scope={$perms}";
        
        return Redirect::to($login_link);
    }
    
    public function getCallbackFB() {
        if (! Auth::check())
            return Response::json(array('status' => 'Error'), 500);
        
        $data = get();
        
        if (! empty($data['code'])) {
            $app_id     = UserAccessToken::$app_id;
            $app_secret = UserAccessToken::$app_secret;
            $redirect_uri = 'http://localhost/october/api/v1/callback_fb';
            
            try {
                $url  = "https://graph.facebook.com/oauth/access_token?code={$data['code']}&client_id={$app_id}&client_secret={$app_secret}&redirect_uri={$redirect_uri}";
                $data = file_get_contents($url);
                parse_str( $data );

                if ($access_token) {
                    // Grant access_token
                    $url  = "https://graph.facebook.com/oauth/access_token?client_id={$app_id}&client_secret={$app_secret}&grant_type=fb_exchange_token&fb_exchange_token={$access_token}";
                    $data = file_get_contents( $url );
                    parse_str( $data );

                    $user_id = Auth::getUser()->id;
                    if ($user_id) {
                        $record = UserAccessToken::where('user_id', '=', $user_id)->first();
                        if (empty($record)) {
                            $record = new UserAccessToken;
                            $record->user_id      = $user_id;
                        }
                        $record->access_token = $access_token;
                        $record->expire = false;
                        $record->save();
                    }
                }
            } catch (Exception $ex) {
                return Response::json(array('status' => 'Error'), 500);
            }
        }
        return Response::json(array('status' => 'Success'), 200);
    }
    
    public function postFeedFB() {
        if (! Auth::check())
            return Response::json(array('status' => 'Error'), 500);
        
        $data = post();
        
        $default = array(
            'link'    => '',
            'message' => '',
            'access_token' => ''
        );
        extract(array_merge($default, $data));
        
        if (! UserAccessToken::check_access_token($access_token)) {
            return Response::json(array('status' => 'Error'), 500);
        }
        
        $obj = json_decode(file_get_contents($host . 'me/feed'));
    }
    
}