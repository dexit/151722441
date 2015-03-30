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
    
    protected $appends = array('photo', 'link', 'app_link');

    protected static $nameList = null;

    public function category() {
        return $this->belongsTo('DLNLab\FBNews\Models\FbCategory');
    }
    
    public function page() {
        return $this->belongsTo('DLNLab\FBNews\Models\FbPage');
    }
    
    public function getPhotoAttribute() {
        $photo = '';
        if (! empty($this->attributes['object_id'])) {
            $photo = 'http://graph.facebook.com/' . $this->attributes['object_id'] . '/picture?width=250';
        }
        return $photo;
    }
    
    public function getAppLinkAttribute() {
        $url = '';
        if (! empty($this->attributes['fb_id'])) {
            $url = 'fb://post/' . $this->attributes['fb_id'];
        }
        return $url;
    }
    
    public function getLinkAttribute() {
        $url = '';
        if (! empty($this->attributes['fb_id'])) {
            $url = 'https://www.facebook.com/' . str_replace('_', '/posts/', $this->attributes['fb_id']);
        }
        return $url;
    }

    public function getCategoryOptions() {
		return FbCategory::getNameList();
	}

    public function getPageOptions() {
        return FbPage::getNameList();
    }

    public function toArray() {
        $this->load('category');
        return parent::toArray();
    }
}