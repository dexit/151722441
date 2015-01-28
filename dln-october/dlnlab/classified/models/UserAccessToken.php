<?php namespace DLNLab\Classified\Models;

use Auth;
use DB;
use Request;
use Model;
use October\Rain\Auth\Models\User;
use System\Models\File;

require(CLF_ROOT . '/classes/libraries/google-api-php-client/autoload.php');

/**
 * UserAccessToken Model
 */
class UserAccessToken extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'dlnlab_classified_user_access_tokens';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
    
    public static $app_id     = '225132297553705';
    public static $app_secret = '8f00d29717ee8c6a49cd25da80c5aad8';
    public static $api_url    = 'https://graph.facebook.com/v2.2/';
    
    public static $gp_client  = null;
    public static $gp_devkey  = 'AIzaSyDFRf_jI34aqynCKsc0ezVDLfm82A2clqI';
    public static $gp_client_id = '1083535205022-lpst7ahsbam709g1f9enu979mk2c13c6.apps.googleusercontent.com';
    public static $gp_secret    = 'hUZqXvxAMX-DzkBjxQDAsxVz';
    public static $gp_scopes    = array(
        /*'https://www.googleapis.com/auth/plus.login',
        'https://www.googleapis.com/auth/plus.me',
        'https://www.googleapis.com/auth/plus.profiles.read',
        'https://www.googleapis.com/auth/plus.stream.read',
        'https://www.googleapis.com/auth/plus.stream.write',
        'https://www.googleapis.com/auth/plus.circles.read',
        'https://www.googleapis.com/auth/plus.circles.write'*/
        'https://www.googleapis.com/auth/plus.login',
        'https://www.googleapis.com/auth/plus.me',
        'https://www.googleapis.com/auth/userinfo.email',
        'https://www.googleapis.com/auth/plus.login',
        'https://www.googleapis.com/auth/plus.stream.write',
    );
    
    public static function get_app_access_token() {
        return self::$app_id . '|' . self::$app_secret;
    }
    
    public static function valid_access_token($user_id = 0, $type = '') {
        if (empty($user_id))
            return false;
        
        $record = self::whereRaw('user_id = ? AND type = ?', array($user_id, $type))->first();
        if (empty($record)) {
            return false;
        } else {
            // Check access token has expire
            $check = self::check_fb_access_token($record->access_token);
            if (! $check) {
                $record->expire = true;
                $record->save();
                return $record;
            } else {
                return $record;
            }
        }
    }
    
    public static function check_fb_access_token($access_token = '') {
        if (empty($access_token))
            return false;
        
        $obj = json_decode(file_get_contents(self::$api_url
            . 'debug_token?input_token=' . $access_token
            . '&access_token=' . self::$app_id . '|' . self::$app_secret));
        
        if (! empty($obj->data->error)) {
            return false;
        } else {
            return $obj->data;
        }
    }
    
    public static function get_fb_page_infor($page_link = '') {
        if (empty($page_link))
            return false;
        
        $obj = null;
        $url = self::$api_url . '?id=' . $page_link . '&access_token=' . self::get_app_access_token();
        $obj = json_decode(file_get_contents($url));
        
        if (! empty($obj->id)) {
            $record = AdSharePageModel::where('fb_id', '=', $obj->id)->first();
            if (empty($record)) {
                $record = new AdSharePageModel;
            }
            $record->name  = (isset($obj->name)) ? $obj->name : '';
            $record->fb_id = (isset($obj->id)) ? $obj->id : '';
            $record->like  = (isset($obj->likes)) ? $obj->likes : 0;
            $record->talking_about = (isset($obj->talking_about)) ? $obj->talking_about : 0;
            $record->save();
        }

        return $obj;
    }
    
    public static function get_fb_user_infor($fb_uid, $access_token) {
        $url = self::$api_url . $fb_uid . '?access_token=' . $access_token;
        $obj = json_decode(file_get_contents($url));
        return $obj;
    }

    public static function init_gp() {
        if (empty(self::$gp_client))
            self::$gp_client = new \Google_Client();
        self::$gp_client->setApplicationName('DLN Test');
        self::$gp_client->setDeveloperKey(self::$gp_devkey);
        self::$gp_client->setClientId(self::$gp_client_id);
        self::$gp_client->setClientSecret(self::$gp_secret);
        self::$gp_client->setRedirectUri(Request::root() . '/api/v1/callback_gp');
        self::$gp_client->setScopes(self::$gp_scopes);
    }
    
    public static function get_gp_login_url() {
        if (empty(self::$gp_client))
            self::init_gp();
        return self::$gp_client->createAuthUrl();
    }
    
    public static function create_gp_access_token($code = '') {
        if (! $code)
            return false;
        
        if (empty(self::$gp_client))
            self::init_gp();
        
        self::$gp_client->authenticate($code);
    	$access_token = self::$gp_client->getAccessToken();
        
        // Get current user with access token
        $plus = new \Google_Service_Plus(self::$gp_client);
        $me   = $plus->people->get("me");
        try {
            DB::beginTransaction();
            // Create new user with email if not exist in db
            if (! empty($me['emails']) && ! empty($me['emails'][0])) {
                $email  = $me['emails'][0]->getValue();
                $record = User::where('email', '=', $email)->first();
                if (! $record) {
                    $password = str_random(8);

                    $record           = new User;
                    $record->email    = $email;
                    $record->name     = $me['displayName'];
                    $record->password              = $password;
                    $record->password_confirmation = $password;
                    $record->is_activated          = true;
                }
                $record->gp_uid = $me['id'];
                $record->save();

                // Save user avatar
                if (! empty($me['image']) && ! empty($me['image']['url'])) {
                    $image_url = $me['image']['url'];
                    $image_url = str_replace('?sz=50', '?sz=250', $image_url);
                    self::getUserAvatar($record->id, $image_url);
                }
                
                Auth::login($record);
            }
        } catch (Exception $ex) {
            DB::rollback();
        }
        DB::commit();
        
        return $access_token;
    }
    
    public static function getUserAvatar($uid = '', $image_url = '') {
        if (! $image_url || ! $uid)
            return false;
        
        // Save user avatar
        $avatar = File::whereRaw('attachment_type = ? AND attachment_id = ?', array('RainLab\User\Models\User', $uid))->first();
        if (empty($avatar)) {
            $file_name             = $uid . '.jpg';
            $temp_name             = CLF_UPLOAD . $file_name;
            $data                  = @file_get_contents($image_url);
            $success               = @file_put_contents($temp_name, $data);
            $file                  = new File();
            $file->data            = $temp_name;
            $file->field           = 'avatar';
            $file->file_name       = $file_name;
            $file->attachment_id   = $uid;
            $file->attachment_type = 'RainLab\User\Models\User';
            $file->is_public       = true;
            $file->save();
            @unlink($file_name);
        }
    }
    
}