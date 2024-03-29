<?php namespace DLNLab\Classified\Models;

use Model;

/**
 * AdFavorite Model
 */
class AdFavorite extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'dlnlab_classified_ad_favorites';

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

}