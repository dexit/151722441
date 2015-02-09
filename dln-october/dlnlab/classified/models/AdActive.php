<?php namespace DLNLab\Classified\Models;

use DB;
use Model;
use DLNLab\Features\Models\Money;

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
    
    private static function get_day_type($type, &$money, &$day) {
        switch($type) {
            case '1':
                // 7 days
                $money = 5 * 1000;
                $day   = 7;
                break;
            
            case '2':
                // 15 days
                $money = 10 * 1000;
                $day   = 15;
                break;
            
            case '3':
                // a month
                $money = 15 * 1000;
                $day   = 30;
                break;
        }
    }
}