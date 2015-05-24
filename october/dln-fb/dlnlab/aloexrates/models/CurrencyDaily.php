<?php namespace DLNLab\AloExrates\Models;

use DLNLab\ALoExrates\Helpers\EXRHelper;
use Model;
use DB;

/**
 * CurrencyDaily Model
 */
class CurrencyDaily extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'dlnlab_aloexrates_currency_dailies';

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
    public $belongsTo = [
        'currency' => array('DLNLab\AloExrates\Models\Currency')
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    /**
     * Currency join table.
     *
     * @return mixed
     */
    public function currency()
    {
        return $this->belongsTo('DLNLab\AloExrates\Models\Currency');
    }

    /**
     * Function for crawl price data daily using google finance url.
     *
     * @param int $cId
     * @param string $cCode
     * @param string $type
     * @return mixed
     */
    public static function updatePriceDaily($cId = 0, $cCode = '', $type = '')
    {
        if (! $cId || ! $cCode || ! $type) {
            return false;
        }

        // Get currency using google finance url
        $url = sprintf(EXR_URL, $cCode, EXR_BASE);

        // Get html content
        //$content = EXRHelper::curl($url);
        $content = file_get_contents($url);
        if (! $content) {
            return false;
        }

        $doc = new \DOMDocument;
        @$doc->loadHTML($content);
        $xpath = new \DOMXpath($doc);

        $result = $xpath->query('//*[@id="currency_converter_result"]/span')->item(0)->nodeValue;
        $buy = (int) round($result);

        $today = self::whereRaw('currency_id = ? AND type = ? AND DATE(created_at) = CURDATE()', array($cId, $type))->first();
        $yesterday = self::whereRaw('currency_id = ? AND type = ? AND DATE(created_at) = CURDATE() - INTERVAL ? DAY', array($cId, $type, 1))->first();

        if (! $today) {
            $record = new self;
            $record->type        = $type;
            $record->currency_id = $cId;
            $record->min_buy     = $buy;
            $record->max_buy     = $buy;
            $record->buy         = $buy;
            if ($yesterday) {
                $record->buy_change  = $buy - $yesterday->buy;
            }
            $record->save();
        } else {
            $record = $today;
            if ($record->buy != $buy) {
                if ($record->min_buy > $buy) {
                    $record->min_buy = $buy;
                }
                if ($record->max_buy < $buy) {
                    $record->max_buy = $buy;
                }
            }
            $record->buy = $buy;
            if ($yesterday) {
                $record->buy_change = $buy - $record->buy;
            }

            $record->save();
        }

        return $record;
    }

    /**
     * Update new exchange rates using crawl.
     *
     * @param number $cId
     * @param number $buy
     * @param number $transfer
     * @param number $sell
     * @param string $type
     * @return boolean|\DLNLab\AloExrates\Models\CurrencyDaily
     */
    public static function updateExratesDaily($cId = 0, $buy = 0, $transfer = 0, $sell = 0, $type = 'bank')
    {
        if (! $cId || ! $buy || ! $transfer || ! $sell || ! $type) {
            return false;
        }

        $today = self::whereRaw('currency_id = ? AND type = ? AND DATE(created_at) = CURDATE()', array($cId, $type))->first();
        $yesterday = self::whereRaw('currency_id = ? AND type = ? AND DATE(created_at) = CURDATE() - INTERVAL ? DAY', array($cId, $type, 1))->first();

        if (! $today) {
            $record = new self;
            $record->currency_id = $cId;
            $record->type        = $type;
            $record->buy         = $buy;
            $record->transfer    = $transfer;
            $record->sell        = $sell;
            $record->min_buy     = $buy;
            $record->max_buy     = $buy;
            $record->min_sell    = $sell;
            $record->max_sell    = $sell;
            if ($yesterday) {
                $record->buy_change  = $buy - $yesterday->buy;
                $record->sell_change = $sell - $yesterday->sell;
            }

            $record->save();
        } else {
            $record = $today;
            if ($record->buy != $buy || $record->transfer != $transfer || $record->sell != $sell) {
                if ($record->min_buy > $buy)
                {
                    $record->min_buy = $buy;
                }
                if ($record->max_buy < $buy)
                {
                    $record->max_buy = $buy;
                }
                if ($record->min_sell > $sell)
                {
                    $record->min_sell = $sell;
                }
                if ($record->max_sell < $sell)
                {
                    $record->max_sell = $sell;
                }
                $record->buy         = $buy;
                $record->transfer    = $transfer;
                $record->sell        = $sell;
                if ($yesterday) {
                    $record->buy_change  = $buy - $yesterday->buy;
                    $record->sell_change = $sell - $yesterday->sell;
                }

                $record->save();
            }
        }

        return $record;
    }

    /**
     * Update new golds using crawl.
     *
     * @param number $cId
     * @param number $buy
     * @param number $sell
     * @param string $type
     * @return boolean|\DLNLab\AloExrates\Models\CurrencyDaily
     */
    public static function updateGoldsDaily($cId = 0, $buy = 0, $sell = 0, $type = 'gold')
    {
        if (! $cId || ! $buy || ! $sell || ! $type) {
            return false;
        }

        $today = self::whereRaw('currency_id = ? AND type = ? AND DATE(created_at) = CURDATE()', array($cId, $type))->first();
        $yesterday = self::whereRaw('currency_id = ? AND type = ? AND DATE(created_at) = CURDATE() - INTERVAL ? DAY', array($cId, $type, 1))->first();

        if (! $today) {
            $record = new self;
            $record->currency_id = $cId;
            $record->type        = $type;
            $record->buy         = $buy;
            $record->sell        = $sell;
            $record->min_buy     = $buy;
            $record->max_buy     = $buy;
            $record->min_sell    = $sell;
            $record->max_sell    = $sell;
            if ($yesterday) {
                $record->buy_change  = $buy - $yesterday->buy;
                $record->sell_change = $sell - $yesterday->sell;
            }

            $record->save();
        } else {
            $record = $today;
            if ($record->buy != $buy || $record->sell != $sell) {
                if ($record->min_buy > $buy)
                {
                    $record->min_buy = $buy;
                }
                if ($record->max_buy < $buy)
                {
                    $record->max_buy = $buy;
                }
                if ($record->min_sell > $sell)
                {
                    $record->min_sell = $sell;
                }
                if ($record->max_sell < $sell)
                {
                    $record->max_sell = $sell;
                }
                $record->buy         = $buy;
                $record->sell        = $sell;
                if ($yesterday) {
                    $record->buy_change  = $buy - $yesterday->buy;
                    $record->sell_change = $sell - $yesterday->sell;
                }
                $record->save();
            }
        }

        return $record;
    }
    
    /**
     * Function for get currency today compare it with yesterday.
     * 
     * @param number $currencyId
     * @param number $price
     * @return boolean|string
     */
    public static function getCurrencyToday($currencyId = 0, $buy = 0)
    {
        if (! $currencyId || ! $buy)
        {
            return false;
        }
        
        $record = self::whereRaw('currency_id = ? AND DATE(created_at) != CURDATE()')
            ->orderBy('created_at', 'DESC')
            ->first();
        
        $templatePrice = "{$buy} (%s)";
        
        $newPrice = '';
        if (! $record)
        {
            $newPrice = sprintf($templatePrice, $buy);
        }
        
        if ($record->buy > $buy)
        {
            $newPrice = sprintf($templatePrice, '-' . ($record->buy - $buy));
        } else
        {
            $newPrice = sprintf($templatePrice, '+' . ($buy - $record->buy));
        }
        
        return $newPrice;
    }
}