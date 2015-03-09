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
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
    
    public function category() {
        return $this->belongsTo('DLNLab\FBNews\Models\FbCategory');
    }

}