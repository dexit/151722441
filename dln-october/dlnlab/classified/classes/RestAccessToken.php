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
                $data = @file_get_contents($url);
                parse_str( $data );

                if ($access_token) {
                    // Grant access_token
                    $url  = "https://graph.facebook.com/oauth/access_token?client_id={$app_id}&client_secret={$app_secret}&grant_type=fb_exchange_token&fb_exchange_token={$access_token}";
                    $data = @file_get_contents( $url );
                    parse_str( $data );

                    $user_id = Auth::getUser()->id;
                    if ($user_id) {
                        $record = UserAccessToken::where('user_id', '=', $user_id)->first();
                        if (empty($record)) {
                            $record = new UserAccessToken;
                            $record->user_id    = $user_id;
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
            'tags' => ''
        );
        extract(array_merge($default, $data));
        
        // Get access token
        $user_id = Auth::getUser()->id;
        $record  = UserAccessToken::valid_access_token($user_id);
        
        if (empty($record) || empty($record->access_token)) {
            return Response::json(array('status' => 'Error'), 500);
        }
        $access_token = $record->access_token;
        $check        = UserAccessToken::check_access_token($access_token);
        if (! $check) {
            return Response::json(array('status' => 'Error'), 500);
        }
        
        $fb_user_id  = $check->user_id;
        $record      = null;
        if ($fb_user_id) {
            $postdata = http_build_query(
                array(
                    'access_token' => $access_token,
                    'message'      => $message,
                    'link'         => $link,
                    'privacy'      => array('value' => 'EVERYONE')
                )
            );
            $opts = array('http' =>
                array(
                    'method' => 'POST',
                    'header' => 'Content-type: application/x-www-form-urlencoded',
                    'content' => $postdata
                )
            );
            $context = stream_context_create($opts);
            $obj = json_decode(@file_get_contents(self::$graph . $fb_user_id . '/feed', false, $context));
            if (! empty($obj->id)) {
                // Get like & comment count 
                $like_count    = AdShare::get_like_count($obj->id, $access_token);
                $comment_count = AdShare::get_comment_count($obj->id, $access_token);
                
                $user_id = Auth::getUser()->id;
                $record  = new AdShare;
                $record->user_id       = $user_id;
                $record->link          = $link;
                $record->md5           = md5($link);
                $record->fb_id         = $obj->id;
                $record->count_like    = $like_count;
                $record->count_comment = $comment_count;
                $record->save();
            }
        }
        return Response::json($record);
    }
    
}