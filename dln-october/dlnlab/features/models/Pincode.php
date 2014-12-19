<?php namespace DLNLab\Features\Models;

use Model;

/**
 * Pincode Model
 */
class Pincode extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'dlnlab_features_pincodes';

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
	
	public static function getLastPincode($phone_number) {
		if (!$phone_number) return false;
		return self::whereRaw( 'phone_number = ?', array( $phone_number ) )->first();
	}
	
	public static function getLastPincodeInActive($user_id, $pincode) {
		if (!$user_id || !$pincode) return false;
		return self::whereRaw('user_id = ? AND code = ? AND status = 0', array($user_id, $pincode))->first();
	}
	
	public static function ActivePincode($phone_number) {
		if (!$phone_number) return false;
		return self::where('phone_number', $phone_number)->update(array('status' => 1));
	}

}