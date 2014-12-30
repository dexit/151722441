<?php namespace DLNLab\Features\Models;

use Model;

/**
 * Crawl_Emails Model
 */
class CrawlEmails extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'dlnlab_features_crawl_emails';

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