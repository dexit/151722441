<?php namespace DLNLab\Features\Models;

use Model;

/**
 * Search_User Model
 */
class SearchUser extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'dlnlab_features_search_users';

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