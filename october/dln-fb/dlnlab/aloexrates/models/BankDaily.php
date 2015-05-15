<?php namespace DLNLab\AloExrates\Models;

use Model;

/**
 * BankDaily Model
 */
class BankDaily extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'dlnlab_aloexrates_bank_dailies';

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
     * Update new exchange rates using crawl.
     * 
     * @param number $cId
     * @param number $buy
     * @param number $transfer
     * @param number $sell
     * @param string $type
     * @return boolean|\DLNLab\AloExrates\Models\BankDaily
     */
    public static function updateExratesDaily($cId = 0, $buy = 0, $transfer = 0, $sell = 0, $type = 'VCB')
    {
        if (! $cId || ! $buy || ! $transfer || ! $sell || ! $type) {
            return false;
        }
        
        $records = self::whereRaw('currency_id = ? AND type = ? AND created_at < NOW() - INTERVAL ? DAY', array($cId, $type, 1))
            ->orderBy('created_at', 'DESC')
            ->get();
        
        $beforeRecord = $records[0];
        
        if (count($records) == 2) {
            $record = $records[0];
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
                $record->buy_change  = $buy - $beforeRecord->buy;
                $record->sell_change = $sell - $beforeRecord->sell;
                
                $record->save();
            }
        } else {
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
            $record->buy_change  = $buy - $beforeRecord->buy;
            $record->sell_change = $sell - $beforeRecord->sell;
            
            $record->save();
        }
        
        return $record;
    }
    
}