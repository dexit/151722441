<?php namespace DLNLab\FBNews\Models;

use Model;

/**
 * FbFeed Model
 */
class FbFeed extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'dlnlab_fbnews_fb_feeds';

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
        'category' => ['DLNLab\FBNews\Models\FbCategory'],
        'page' => ['DLNLab\FBNews\Models\FbPage']
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
    
    protected $appends = array('photo');
    
    public function category() {
        return $this->belongsTo('DLNLab\FBNews\Models\FbCategory');
    }
    
    public function page() {
        return $this->belongsTo('DLNLab\FBNews\Models\FbPage');
    }
    
    public function getPhotoAttribute() {
        $full_url = '';
        if (! empty($this->attributes['object_id'])) {
            $full_url = 'http://graph.facebook.com/' . $this->attributes['object_id'] . '/picture?type=normal';
        }
        return $full_url;
    }

    public function getCategoryOptions() {
		return FbCategory::getNameList();
	}
    
    public function toArray() {
        $this->load('category', 'page');
        return parent::toArray();
    }
    
}