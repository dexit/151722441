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
    public static $api_url    = 'https://graph.facebook.com/v2.2/debug_token?';
    
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
            . 'input_token=' . $access_token
            . '&access_token=' . self::$app_id . '|' . self::$app_secret));
        
        if (! empty($obj->data->error)) {
            return false;
        } else {
            return $obj->data;
        }
    }

}