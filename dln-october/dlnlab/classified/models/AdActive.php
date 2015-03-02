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
    
    public static function calc_money($day = 0) {
        return $day * CLF_MONEY_AD;
    }
}