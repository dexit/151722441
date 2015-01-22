<?php

namespace DLNLab\Classified\Classes;

use Auth;
use Input;
use Response;
use Redirect;
use Cookie;
use Validator;
use Controller as BaseController;
use DLNLab\Classified\Models\UserAccessToken;
use DLNLab\Classified\Models\AdShare;
use DLNLab\Classified\Models\AdSharePage;

require('HelperResponse.php');

class RestAccessToken extends BaseController {
    
    public static $graph = 'https://graph.facebook.com/v2.2/';
    public static $host  = 'http://localhost/october/';
    
    public function getAuthenticateFB() {
        if (! Auth::check())
            return Response::json(array('status' => 'error'), 500);
        
        $get = get();
        if (!empty($get['return_url'])) {
            Cookie::queue('dln_return_url', $get['return_url'], 10);
        }
        
        $app_id       = UserAccessToken::$app_id;
        $perms        = 'user_about_me,email,manage_pages,publish_actions';
        $redirect_uri = self::$host . 'api/v1/callback_fb';
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
            $redirect_uri = self::$host . 'api/v1/callback_fb';
            
            try {
                $url  = self::$graph . "oauth/access_token?code={$data['code']}&client_id={$app_id}&client_secret={$app_secret}&redirect_uri={$redirect_uri}";
                $data = @file_get_contents($url);
                parse_str( $data );
                
                if ($access_token) {
                    $access_token = trim($access_token);
                    // Grant access_token
                    $url  = self::$graph . "oauth/access_token?client_id={$app_id}&client_secret={$app_secret}&grant_type=fb_exchange_token&fb_exchange_token={$access_token}";
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
                        if (Cookie::get('dln_return_url')) {
                            Cookie::queue('dln_access_token', $access_token, 10);
                            return Redirect::to(Cookie::get('dln_return_url'));
                        }
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
            'ad_id'   => '',
            'type'    => '',
            'link'    => '',
            'message' => ''
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
                $user_id = Auth::getUser()->id;
                $record  = new AdShare;
                $record->ad_id    = $ad_id;
                $record->user_id  = $user_id;
                $record->link     = $link;
                $record->md5      = md5($link);
                $record->share_id = $obj->id;
                $record->save();
            }
        }
        return Response::json($record);
    }
    
    public function getUpdatePageAccessTokenFB() {
        if (! Auth::check()) {
            return Response::json(array('status' => 'Error'), 500);
        }
        
        $access_token = Cookie::get('dln_access_token');
        if (empty($access_token)) {
            return Response::json(array('status' => 'Error'), 500);
        }
        
        $obj = json_decode(file_get_contents(UserAccessToken::$api_url . 'me/accounts?access_token=' . $access_token));
        if (! empty($obj->data)) {
            $pages = $obj->data;
            
            foreach ($pages as $page) {
                if ($page->access_token) {
                    $record = AdSharePage::where('fb_id', '=', $page->id)->first();
                    if (empty($record)) {
                        $record = new AdSharePage;
                    }
                    $record->name  = (isset($page->name)) ? $page->name : '';
                    $record->fb_id = (isset($page->id)) ? $page->id : '';
                    $record->like  = (isset($page->likes)) ? $page->likes : 0;
                    $record->crawl = false;
                    $record->access_token = $access_token;
                    $record->save();
                }
            }
        }
    }
}