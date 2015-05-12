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
    public static function getCurrenciesDetails($currencyIds = array(), $type = '')
    {
        if (! count($currencyIds))
        {
            return false;
        }
        
        // Create cache id
        $cacheId = implode('_', $currencyIds) . '_' . $type;
        
        $newRecords = null;
        if (Cache::has($cacheId))
        {
            $newRecords = json_decode(Cache::get($cacheId, null));
        }
        else
        {
            switch ($type)
            {
                case 'VCB':
                    $records = BankDaily::whereIn('currency_id', $currencyIds)
                        ->orderBy('updated_at', 'DESC')
                        ->get();

                    // Get minus values.
                    $cdIds = $records->lists('id');
                    $beforeRecords = BankDaily::whereIn('currency_id', $currencyIds)
                        ->whereNotIn('id', $cdIds)
                        ->orderBy('updated_at', 'DESC')
                        ->get();
                    break;
                case 'CURRENCY':
                    $records = CurrencyDaily::whereIn('currency_id', $currencyIds)
                    ->orderBy('updated_at', 'DESC')
                    ->get();

                    // Get minus values.
                    $cdIds = $records->lists('id');
                    $beforeRecords = CurrencyDaily::whereIn('currency_id', $currencyIds)
                    ->whereNotIn('id', $cdIds)
                    ->orderBy('updated_at', 'DESC')
                    ->get();
                    break;
                case 'GOLD':
                    $records = GoldDaily::whereIn('currency_id', $currencyIds)
                    ->orderBy('updated_at', 'DESC')
                    ->get();
                    
                    // Get minus values.
                    $cdIds = $records->lists('id');
                    $beforeRecords = GoldDaily::whereIn('currency_id', $currencyIds)
                    ->whereNotIn('id', $cdIds)
                    ->orderBy('updated_at', 'DESC')
                    ->get();
                    break;
            }
        
            if (count($records))
            {
                foreach ($records as $item)
                {
                    $newRecord = $item;
                    if (count($beforeRecords))
                    {
                        foreach ($beforeRecords as $_item)
                        {
                            if ($_item->currency_id == $item->currency_id)
                            {
                                $newRecord->before_currency = $_item;
                            }
                        }
                    }
                    else
                    {
                        $newRecord->before_currency = null;
                    }
                    $newRecords[] = $newRecord;
                }
            }
        
            if (count($newRecords))
            {
                Cache::put($cacheId, json_encode($newRecords), EXR_CACHE_MINUTE);
            }
        }
        
        return $newRecords;
    }
    
}