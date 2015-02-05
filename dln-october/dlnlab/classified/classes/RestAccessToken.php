<?php

namespace DLNLab\Classified\Classes;

use Auth;
use Cookie;
use DB;
use Exception;
use Input;
use Request;
use Response;
use Redirect;
use Validator;
use System\Models\File;
use Controller as BaseController;
use DLNLab\Classified\Models\UserAccessToken;
use DLNLab\Classified\Models\AdShare;
use DLNLab\Classified\Models\AdSharePage;
use October\Rain\Auth\Models\User;
use DLNLab\Classified\Classes\HelperClassified;

require('HelperResponse.php');

class RestAccessToken extends BaseController {
    
    public static $graph = 'https://graph.facebook.com/v2.2/';
    
    public function getAuthenticateGPlus() {
        HelperClassified::save_return_url();
        
        return Redirect::to(UserAccessToken::get_gp_login_url());
    }
    
    public function getCallbackGP() {
        $data = get();
        
        if (! empty($data['code'])) {
            $access_token = UserAccessToken::create_gp_access_token($data['code']);
        }
        
        return Redirect::to(HelperClassified::redirect_return_url());
    }
    
    public function getAuthenticateFB() {
        HelperClassified::save_return_url();
        
        $app_id       = UserAccessToken::$app_id;
        $perms        = 'user_about_me,email,manage_pages,publish_actions';
        $redirect_uri = OCT_ROOT . '/api/v1/callback_fb';
        $login_link   = "https://www.facebook.com/dialog/oauth?client_id={$app_id}&redirect_uri={$redirect_uri}&scope={$perms}";
        
        return Redirect::to($login_link);
    }
    
    public function getCallbackFB() {
        $data = get();
        
        if (! empty($data['code'])) {
            $app_id     = UserAccessToken::$app_id;
            $app_secret = UserAccessToken::$app_secret;
            $redirect_uri = OCT_ROOT . '/api/v1/callback_fb';
            
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
                    
                    if (Auth::check()) {
                        $user    = Auth::getUser();
                        $user_id = $user->id;
                        $user->save();
                        
                        $obj = UserAccessToken::check_fb_access_token($access_token);
                        
                        if ($obj->user_id) {
                            $user->fb_uid = $obj->user_id;
                            $fb_uid = $obj->user_id;
                            $user->save();
                            self::saveUserAccessToken($user_id, $access_token, 'facebook');
                        }
                    } else {
                        // Get current facebook user email
                        $obj = UserAccessToken::check_fb_access_token($access_token);
                        if ($obj) {
                            $fb_uid  = $obj->user_id;
                            $fb_user = UserAccessToken::get_fb_user_infor($fb_uid, $access_token);
                            
                            if (! empty($fb_user->email)) {
                                DB::beginTransaction();
                                try {
                                    // Check user exists in DB
                                    $user = User::where('email', '=', $fb_user->email)->first();
                                    if (! $user) {
                                        $password       = str_random(8);
                                        $user           = new User;
                                        $user->password = $password;
                                        $user->password_confirmation = $password;
                                        $user->is_activated          = true;
                                        $user->email    = $fb_user->email;
                                        $user->name     = $fb_user->name;
                                        $user->username = $fb_user->email;
                                    }
                                    $user->fb_uid   = $fb_user->id;
                                    
                                    $user->save();
                                    UserAccessToken::sendEmailAfterRegister($user->name, $user->email);
                                    
                                    self::saveUserAccessToken($user->id, $access_token, 'facebook');
                                    
                                    Auth::login($user);
                                } catch(Exception $e) {
                                    DB::rollback();
                                    throw $e;
                                }
                                DB::commit();
                            }
                        }
                    }
                    
                    // Save user avatar
                    if ( $fb_uid ) {
                        $image_url = "http://graph.facebook.com/v2.2/{$fb_uid}/picture?type=large";
                        UserAccessToken::getUserAvatar($user->id, $image_url);
                    }
                    
                    return Redirect::to(HelperClassified::redirect_return_url());
                }
            } catch (Exception $ex) {
                throw  $ex;
                return Response::json(array('status' => 'Error', 'message' => $ex->getMessage()), 500);
            }
        }
        return Response::json(array('status' => 'Success'), 200);
    }
    
    private static function saveUserAccessToken($user_id, $access_token, $type) {
        try {
            $record = UserAccessToken::whereRaw('user_id = ? AND type = ?', array($user_id, $type))->first();
            if (empty($record)) {
                $record = new UserAccessToken;
                $record->user_id    = $user_id;
            }
            $record->type         = $type;
            $record->access_token = $access_token;
            $record->expire       = false;
            $record->save();
        } catch (Exception $e) {
            throw $e;
        }
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
        
        $merge = array_merge($default, $data);
        $merge = \DLNLab\Classified\Classes\HelperClassified::trim_value($merge);
        extract($merge);
        
        // Get access token
        $user_id = Auth::getUser()->id;
        $record  = UserAccessToken::valid_access_token($user_id, 'facebook');
        
        if (empty($record) || empty($record->access_token)) {
            return Response::json(array('status' => 'Error'), 500);
        }
        $access_token = $record->access_token;
        $check        = UserAccessToken::check_fb_access_token($access_token);
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