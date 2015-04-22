<?php namespace DLNLab\SNSContacts\Models;

use Model;

/**
 * Contact Model
 */
class Contact extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'dlnlab_snscontacts_contacts';

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