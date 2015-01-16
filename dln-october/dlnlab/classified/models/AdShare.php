<?php namespace DLNLab\Classified\Models;

use Model;

/**
 * AdShare Model
 */
class AdShare extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'dlnlab_classified_ad_shares';

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

    private static $api_url = 'https://graph.facebook.com/v2.2/';
    
    public static function get_like_count($fb_id = '', $access_token = '') {
        if (! $fb_id || ! $access_token)
            return false;
        
        $count = 0;
        $obj = json_decode(@file_get_contents(self::$api_url . $fb_id . '/likes?summary=1'));
        if (! empty($obj->summary)) {
            $count = $obj->summary->total_count;
        }
        
        return $count;
    }
    
    public static function get_comment_count($fb_id = '', $access_token = '') {
        if (! $fb_id || ! $access_token)
            return false;
        
        $count = 0;
        $obj = json_decode(@file_get_contents(self::$api_url . $fb_id . '/comments?summary=1'));
        if (! empty($obj->summary)) {
            $count = $obj->summary->total_count;
        }
        
        return $count;
    }
}