<?php namespace DLNLab\FBNews\Models;

use Model;

/**
 * FbVote Model
 */
class FbVote extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'dlnlab_fbnews_fb_votes';

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