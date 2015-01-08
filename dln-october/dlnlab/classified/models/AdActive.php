<?php namespace DLNLab\Classified\Models;

use Model;

/**
 * Ad_Active Model
 */
class AdActive extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'dlnlab_classified_ad_actives';

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

    public static function active_ad($data = null) {
        if (empty($data))
            return false;
        
        $default = array(
            'ad_id'    => '',
            'day_type' => '',
        );
        $params = array_merge($default, $data);
        extract($params);
        
        // Get Ad
        $ad = Ad::find($ad_id);
        
        if (empty($ad) || empty($ad->status)) {
            return false;
        }
        
        // Get money and days
        $money = $day = 0;
        self::get_day_type($day_type, $money, $day);
        if (!$money || !$day) {
            return false;
        }
        
        // Check ad money
        $ad_money = Money::get_basic_money($ad_id);
        
    }
    
    private static function get_day_type($type, &$money, &$day) {
        switch($type) {
            case '1':
                // 7 days
                $money = 15 * 1000;
                $day   = 7;
                break;
            
            case '2':
                // 15 days
                $money = 30 * 1000;
                $day   = 15;
                break;
            
            case '3':
                // a month
                $money = 50 * 1000;
                $day   = 30;
                break;
            
            case '3':
                // three months
                $money = 120 * 1000;
                $day   = 90;
                break;
            
            case '4':
                // six months
                $money = 200 * 1000;
                $day   = 180;
                break;
        }
    }
}