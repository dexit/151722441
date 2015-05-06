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
     * @return mixed
     */
    public static function updatePriceDaily($cId = 0, $cCode = '')
    {
        if (! $cId || ! $cCode) {
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
        $price = (int) round($result);

        $record = self::whereRaw('currency_id = ? AND DATE(created_at) = CURDATE()', array($cId))->first();
        if ($record) {
            // Only update if not same price
            if ($record->price != $price) {
                $record->price = $price;
                $record->save();
            }
        } else {
            $record = new self;
            $record->currency_id = $cId;
            $record->price = $price;
            $record->save();
        }

        return $record;
    }
    
    /**
     * get price attribute
     * 
     * @return string
     */
    public function getPriceAttribute() {
        $price = $this->attributes['price'];
        $price = EXRHelper::numberToMoney($price, ' VND', 0);
        return $price;
    }
}