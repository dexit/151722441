<?php namespace DLNLab\Classified\Models;

use Model;

/**
 * AdInfor Model
 */
class AdInfor extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'dlnlab_classified_ad_infors';

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

    public static function getBedRoomOptions() {
		return array(
            '0' => 'Không chọn',
            '1' => '1 Phòng',
            '2' => '2 Phòng',
            '3' => '3 Phòng',
            '4' => '4+ Phòng',
        );
	}
    
    public static function getBathRoomOptions() {
		return array(
            '0' => 'Không chọn',
            '1' => '1 Phòng',
            '2' => '2 Phòng',
            '3' => '3 Phòng',
            '4' => '4+ Phòng',
        );
	}
    
    public static function getDirectionOptions() {
		return array(
            '0' => 'Không chọn',
            '1' => 'Đông',
            '2' => 'Tây',
            '3' => 'Nam',
            '4' => 'Bắc',
            '5' => 'Đông - Bắc',
            '6' => 'Tây - Bắc',
            '7' => 'Tây - Nam',
            '8' => 'Đông - Nam',
        );
	}
    
}