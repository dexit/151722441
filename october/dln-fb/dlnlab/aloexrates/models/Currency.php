<?php namespace DLNLab\AloExrates\Models;

use Model;

/**
 * Currency Model
 */
class Currency extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'dlnlab_aloexrates_currencies';

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

    /**
     * Function for get currencies by codes.
     * 
     * @param array $codes
     * @return boolean|objects
     */
    public static function getCurrenciesByCodes($codes = array()) {
        if (! count($codes)) {
            return false;
        }
        
        return self::whereIn('code', $codes)->get();
    }
    
}