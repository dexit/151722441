<?php namespace DLNLab\Features\Models;

use Model;

/**
 * Report Model
 */
class Report extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'dlnlab_features_reports';

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
		'user' => ['RainLab\User\Models\User', 'foreignKey' => 'user_id']
	];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

	public function getStatusOptions() {
        return array(
			'0' => 'UnPublished',
			'1' => 'Published'
		);
    }
	
	
}