<?php namespace DLNLab\Features\Models;

use Model;
use RainLab\User\Models\User;

/**
 * Money Model
 */
class Money extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'dlnlab_features_money';

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
		'user' => ['RainLab\User\Models\User', 'foreignKey' => 'user_id']
	];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
	
	public function getUserOptions() {
		$user = User::find($this->user_id);
		return array(
			$user->id => $user->name
		);
	}
	
	public function getTypeOptions() {
        return array(
            'charge_admin' => 'Admin Charse',
        );
	}
	
	public function getTypeAttribute() {
		$arr_type = array(
            'charge' => 'Charge',
            'spent' => 'Spent',
            'charge_admin' => 'Admin Charse'
        );
		return isset($this->attributes['type']) ? $arr_type[$this->attributes['type']] : 0;
	}
    
    public function getMoneyAttribute() {
        setlocale(LC_MONETARY,"vi_VN");
        $money = money_format('%i ', (double) $this->getAttribute('money'));
        $money = str_replace('VND', ' VND', $money);
        return $money;
    }
    
    public function afterCreate() {
        // plus money for user
        $type    = $this->getAttribute('type');
        $user_id = $this->getAttribute('user_id');
        $money   = $this->getAttribute('money');
        
        if (empty($type) || empty($user_id))
            return;
        
        switch ($type) {
            case 'charge':
                User::find($user_id)->increment('money_charge', $money);
                break;
            
            case 'spent':
                User::find($user_id)->increment('money_spent', $money);
                break;
        }
    }
    
    public static function get_user_charge_money($user_id = 0) {
        if (! $user_id)
            return 0;
        
        $user          = User::find($user_id);
        $money_account = $user->money_charge - $user->money_spent;
        if ($money_account > 0) {
            return $money_account;
        } else {
            return 0;
        }
    }
    
    public static function minus_money_user($user_id = 0, $money = 0) {
        if (! $user_id || $money < 0)
            return false;
        
        $record = new self;
        $record->user_id = $user_id;
        $record->type    = 'spent';
        $record->money   = $money;
        $record->save();
        
        return $record;
    }
}