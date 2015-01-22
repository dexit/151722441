<?php namespace DLNLab\Classified\Models;

use Model;

/**
 * AdShareCount Model
 */
class AdShareCount extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'dlnlab_classified_ad_share_counts';

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
    
    public static $share_count_api_key = '366c9d4d712bc1bd60e1301210aafcce14388c71';

    public static function get_obj_share_count($link = '') {
        if (! $link)
            return false;
        
        $json   = file_get_contents("http://free.sharedcount.com/?url=" . rawurlencode($link) . "&apikey=" . self::$share_count_api_key);
        $counts = json_decode($json);   
        
        return $counts;
    }
    
}