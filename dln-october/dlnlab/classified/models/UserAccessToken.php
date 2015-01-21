<?php namespace DLNLab\Classified\Models;

use Model;

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
    
    public static function get_app_access_token() {
        return self::$app_id . '|' . self::$app_secret;
    }
    
    public static function valid_access_token($user_id = 0) {
        if (empty($user_id))
            return false;
        
        $record = self::where('user_id', '=', $user_id)->first();
        if (empty($record)) {
            return false;
        } else {
            // Check access token has expire
            $check = self::check_access_token($record->access_token);
            if (! $check) {
                $record->expire = true;
                $record->save();
                return $record;
            } else {
                return $record;
            }
        }
    }
    
    public static function check_access_token($access_token = '') {
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
    
    public static function get_page_infor($page_link = '') {
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

}