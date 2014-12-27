<?php namespace DLNLab\Features\Models;

use Model;

/**
 * message_recipients Model
 */
class MessageRecipients extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'dlnlab_features_message_recipients';

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