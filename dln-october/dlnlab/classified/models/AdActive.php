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

    public static function active_ad($data = null, $ad = null, $_user_id = null) {
        if (empty($data))
            return false;
        
        $default = array(
            'ad_id'    => '',
            'day_type' => '',
        );
        $params = array_merge($default, $data);
        extract($params);
        
        // Get Ad
        if (! $ad) {
            $ad = Ad::find($ad_id);
        }
        
        if (empty($ad) || !empty($ad->status)) {
            return 'Ad has activated';
        }
        
        // Get user_id
        $user_id = $ad->user_id;
        
        if ($_user_id != $user_id) {
            return 'Ad now user own';
        }
        
        // Get money and days
        $money = $day = 0;
        self::get_day_type($day_type, $money, $day);
        if (!$money || !$day) {
            return 'Error get day type';
        }
        
        // Check user money
        $user_money = Money::get_user_charge_money($user_id);
        if (($user_money - $money) < 0) {
            // No active ad when user not enough money
            return 'No active ad when user not enough money';
        }
        
        DB::beginTransaction();
        try {
            // Minus money
            $o_money = Money::minus_money_user($user_id, $money);
            
            // Active add
            $ad->status       = 1;
            $ad->published_at = time();
            $ad->save();
            
            // Update add has activated to DB
            $record = new self;
            $record->ad_id = $ad_id;
            $record->money = $money;
            $record->day = $day;
            $record->status = 1;
            $record->save();
        } catch (Exception $ex) {
            DB::rollback();
            return $ex->getMessage();
        }
        DB::commit();
        
        return true;
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