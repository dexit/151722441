<?php namespace DLNLab\Classified\Models;

use Model;

/**
 * AdSharePage Model
 */
class AdSharePage extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'dlnlab_classified_ad_share_pages';

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

    public function getLikeAttribute() {
        $like = number_format((float) $this->attributes['like']);
        return $like;
    }
    
    public function getFBIDAttribute() {
        $fb_id = $this->attributes['fb_id'];
        return "<a href='https://www.facebook.com/{$fb_id}' target='_blank' onclick='javascript:void(0)'>https://www.facebook.com/{$fb_id}</a>";
    }
}