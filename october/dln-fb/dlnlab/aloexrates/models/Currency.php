<?php namespace DLNLab\AloExrates\Models;

use Model;
use Cache;

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
     * @param string $type
     * @return boolean|objects
     */
	public static function getCurrenciesByCodes($codes = array(), $type = '') {
        if (! count($codes) || ! $type) {
            return false;
        }
        
        return self::where('type', $type)
            ->whereIn('code', $codes)
            ->get();
    }
    
    /**
     * Function for get list currencies details.
     * 
     * @param array $currencyIds
     * @param string $type
     * @return boolean|Ambigous <NULL, mixed, unknown>
     */
    public static function getCurrenciesDetails($currencyIds = array())
    {
        if (! count($currencyIds))
        {
            return false;
        }
        
        // Create cache id
        $cacheCurrency = 'exr_currency';
        
        // For currencies
        if (Cache::has($cacheCurrency))
        {
            $currencies = json_decode(Cache::get($cacheCurrency));
        }
        else
        {
            $currencies = CurrencyDaily::whereRaw('created_at > NOW() - INTERVAL ? DAY', array(1))
                ->orderBy('created_at', 'DESC')
                ->get()
                ->toArray();
        
            if (count($currencies))
            {
                Cache::put($cacheCurrency, json_encode($currencies), EXR_CACHE_MINUTE);
            }
        }
        
        $newRecords = array();

        foreach ($currencies as $item)
        {
            $currencyId = intval($item->currency_id);
            if (in_array($currencyId, $currencyIds))
            {
                $newRecords[] = $item;
                unset($currencyIds[$currencyId]);
            }
        }

        return $newRecords;
    }
    
}